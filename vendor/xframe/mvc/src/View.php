<?php

namespace xframe\Mvc;

class View {

    /** 
     * use syntax components
     * 
    */

    use syntax;

    /** 
     * parse template string
     * 
     * @var string, file contents of unparsed template file
     * 
    */

    function parse($template) {

        // variables parse
        $template = preg_replace('~\[(.+?)\]~', '$$1', $template);
        $template = preg_replace('~\{(.+?)\}~', '<?php echo ${\'$1\'}; ?>', $template);
        $template = preg_replace('~\<set:(.+?) to (.+?)/\>~', '<?php ${\'$1\'} = $2; ?>', $template);

        // if statement parse
        $template = preg_replace('~\<if:(.+?)\>~', '<?php if($1) { ?>', $template);
        $template = preg_replace('~\</if\>~', '<?php } ?>', $template);

        // else statement parse
        $template = preg_replace('~\<else/\>~', '<?php } else { ?>', $template);
        $template = preg_replace('~\<elseif:(.+?)/\>~', '<?php } elseif($1) { ?>', $template);

        // foreach statement parse
        $template = preg_replace('~\<foreach:(.+?) as (.+?)/\>~', '<?php foreach($1 as $2) { ?>', $template);
        $template = preg_replace('~\</foreach/\>~', '<?php } ?>', $template);

        // return parsed template file contents
        return $template;

    }

    /** 
     * execute parsed template file contents
     * 
     * @var string, parsed template file contents
     * 
    */

    function execute($parsed, $input = '') {

        eval($input . "?> $parsed <?php");

    }

}