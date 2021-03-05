<?php

// ini set
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor/autoload.php';
include 'src/utils.php';

$router = new  \xframe\Router\App();

$apps = $router->get_all_apps();

dumpf($apps);

foreach($apps as $app) {

    $conf = $router->get_app_config($app);
    $conf = json_decode(json_encode($conf), true);

    $app_found = false;
    $url = $router->get_url();

    if(strcasecmp($conf['url'], $url[0]) == 0) {

        if($url[1] != "") {

            $path = 'src/apps/' . $router->get_request_app() . '/controllers/' . $url[1] .'.php';

            if(file_exists($path)) {

                include $path;

            } else {

                echo "error 404";

            }

        } else {

            $path = 'src/apps/' . $router->get_request_app() . '/App.php';

            include $path;

        }

        $app_found = true;
        break;

    }

}

if($app_found == false) {
    echo "The requested page was not found";

}

$hii = 'hi';

$file = "

<if:2 == 2>

    <if:2 == 2>

        2 is equal to 2 too is

    </if>

    first one

</if>

{hii}

";

$file = preg_replace('~\<if:(.+?)\>~', '<?php if($1) { ?>', $file);
$file = preg_replace('~\</if\>~', '<?php } ?>', $file);

$file = preg_replace('~\{(.+?)\}~', '<?php echo ${\'$1\'} ?>', $file);
$file = preg_replace('~\<set:(.+?) to (.+?)\>~', '<?php ${\'$1\'} = $2; ?>', $file);

eval('?>' . $file . '<?');