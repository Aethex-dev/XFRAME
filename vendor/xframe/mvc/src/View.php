<?php

namespace xframe\Mvc;

class View {

    /** 
     * construct
     * 
    */

    function __construct($mvc) {

        $this->mvc = $mvc;

    }

    /** 
     * path to website root from url
     * 
    */

    public $server_path;

    /** 
     * configure language packs
     * 
     * @param string, language record
     * 
     * @return array, language data
     * 
    */

    function lang_config($record) {

        $config = $this->mvc->config;

        if($config['fixed-theme'] == true) {

            $lang = $config['lang'];

        } else {

            if(isset($_COOKIE[$config['prefix'] . 'lang'])) {

                if(file_exists('internal_data/cache/themes/' . $_COOKIE[$config['prefix'] . 'lang'])) {

                    $lang = $_COOKIE[$config['prefix'] . 'lang'];

                } else {

                    setcookie($config['prefix'] . 'lang', $config['lang'], time() + (86400 * 30), "/");
                    $lang = $config['lang'];

                }

            } else {

                setcookie($config['prefix'] . 'lang', $config['lang'], time() + (86400 * 30), "/");
                $lang = $config['lang'];

            }

        }

        $lang_data = json_decode($this->mvc->cache->get_record('lang/' . $lang, $record), true);
        $this->lang_data = $lang_data;
        $this->mvc->lang_data = $lang_data;

        $this->lang = $lang;
        unset($config);
        unset($lang);

        return $lang_data;

    }

    /** 
     * parse template string
     * 
     * @param string, file contents of unparsed template file
     * 
     * @param string, theme name
     * 
     * @param object, mvc object
     * 
    */

    function parse($template, $theme, $lang_record) {

        // setup language
        $lang = $this->lang_config($lang_record);

        // parse language
        foreach($lang as $phrase => $value) {

            $template = preg_replace('~\@' . $phrase . ' \@~', $lang[$phrase], $template);

        }

        // magic constant
        $fullurl = $this->mvc->router->get_url();

        foreach($fullurl as $url => $value) {

            $template = str_replace("%%url(" . $url . ")%%", $value, $template);

        }

        // print var
        $template = preg_replace('~\^print\((.+?)\)\^~', "<?php echo $1; ?>", $template);
        $template = preg_replace('~\^dump((.+?))\^~', "<?php dumpf($1); ?>", $template);

        // variables parse
        $template = preg_replace('~\{(.+?)\}~', '<?php echo $$1; ?>', $template);
        $template = preg_replace('~\((.+?)\)~', '$$1', $template);
        $template = preg_replace('~\<set (.+?) to (.+?)\/\>~', '<?php $$1 = $2; ?>', $template);

        // paths
        $template = preg_replace('~\%\%root\%\%~', $this->server_path . '/internal_data/cache/themes/' . $theme . '/', $template);
        $template = preg_replace('~\%\%url_root\%\%~', $this->server_path . '/', $template);

        // text modifiers
        $template = preg_replace('~\!\!caps (.+?) \!\!~',"<?php echo strtoupper($1); ?>", $template);
        $template = preg_replace('~\!\!lower (.+?) \!\!~',"<?php echo strtolower($1); ?>", $template);
        $template = preg_replace('~\!\!date (.+?), (.+?) \!\!~',"<?php echo date($1, $2); ?>", $template);
        $template = preg_replace('~\!\!replace (.+?), (.+?), (.+?) \!\!~',"<?php echo str_replace($1, $2, $3); ?>", $template);
        $template = preg_replace('~\^isset (.+?) \^~',"isset($1)", $template);

        // var modifiers
        $template = preg_replace('~\!\&caps (.+?) \&\!~',"<?php echo strtoupper($1); ?>", $template);

        // if statement parse
        $template = preg_replace('~\<if (.+?)\>~', '<?php if($1) { ?>', $template);
        $template = preg_replace('~\</if\>~', '<?php } ?>', $template);

        // else statement parse
        $template = preg_replace('~\<else\>~', '<?php } else { ?>', $template);
        $template = preg_replace('~\<elseif (.+?)\>~', '<?php } elseif($1) { ?>', $template);

        // foreach statement parse
        $template = preg_replace('~\<foreach (.+?) as (.+?)\>~', '<?php foreach($1 as $2) { ?>', $template);
        $template = preg_replace('~\</foreach\>~', '<?php } ?>', $template);

        // while loop
        $template = preg_replace('~\<while (.+?)\>~', '<?php while($1) { ?>', $template);
        $template = preg_replace('~\</while\>~', '<?php } ?>', $template);

        // comments
        $template = preg_replace('~\/\/c(.+)~', '', $template);

        // include statement
        $template = preg_replace('~\<include (.+?)/\>~', '<?php include $1; ?>', $template);

        // html
        $template = preg_replace('~\#\#link (.+?) \* (.+?) \#\#~', '<a href="$1" target="_blank">$2</a>', $template);
        $template = preg_replace('~\#\#icon (.+?) \#\#~', '<i class="$1"></i>', $template);

        // operations
        $template = preg_replace('~\*greater\*~', ">", $template);

        // return parsed template file contents
        return $template;

    }

    /** 
     * execute parsed template file contents
     * 
     * @var string, parsed template file contents
     * 
    */

    function execute($parsed, array $inputs = []) {

        foreach($inputs as $input => $value) {

            ${$input} = $value;

        }

        // layout controller
        include 'src/apps/layout_controller.php';
        
        // execute
        eval("?> $parsed <?php");

    }

}