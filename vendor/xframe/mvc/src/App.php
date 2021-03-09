<?php

namespace xframe\Mvc;

class App {

    /** 
     * model object
     * 
    */

    private Model $model;

    /** 
     * controller object
     * 
    */

    private Controller $controller;

    /** 
     * view object
     * 
    */

    private View $view;

    /** 
     * router object
     * 
    */

    public \xframe\Router\App $router;

    /** 
     * config array
     * 
    */

    public $config = array();

    /** 
     * get set theme
     * 
    */

    public $theme;

    /** 
     * construct dependencies
     * 
    */

    function __construct() {

        // get framework configuration
        $config = json_decode(file_get_contents('config.json'), true);

        // theme controller
        if($config['fixed-theme'] == true) {

            $theme = $config['theme'];

        } else {

            if(isset($_COOKIE[$config['prefix'] . 'theme'])) {

                if(file_exists('internal_data/cache/themes/' . $_COOKIE[$config['prefix'] . 'theme'])) {

                    $theme = $_COOKIE[$config['prefix'] . 'theme'];

                } else {

                    setcookie($config['prefix'] . 'theme', $config['theme']);
                    $theme = $config['theme'];

                }

            } else {

                setcookie($config['prefix'] . 'theme', $config['theme']);
                $theme = $config['theme'];

            }

        }

        // set configuration
        $this->theme = $theme;
        unset($theme);

        $this->config = $config;
        unset($config);

        // dependencies initialize
        $this->model = new Model();
        $this->controller = new Controller();
        $this->view = new View();
        $this->router = new \xframe\Router\App();

        // configure dependencies
        $this->view->server_path = $this->config['url']['root'];

        // start compiling data
        $this->compile();

    }

    /** 
     * compile information from url headers, route data and execute application
     * 
    */

    function compile() {

        $apps = $this->router->get_all_apps();
        $app_found = false;

        foreach($apps as $app) {

            $conf = $this->router->get_app_config($app);
            $conf = json_decode(json_encode($conf), true);

            $url = $this->router->get_url();

            if(strcasecmp($conf['url'], $url[0]) == 0) {

                if($url[1] != "") {

                    $path = 'src/apps/' . $this->router->get_request_app() . '/controllers/' . $url[1] .'.php';

                    if(file_exists($path)) {

                        include $path;

                    } else {

                        echo "error 404";

                    }

                } else {

                    $path = 'src/apps/' . ucfirst($app) . '/App.php';

                    include $path;

                }

                $app_found = true;
                break;

            }

        }

        if($app_found == false) {

            $this->parse_page('Errors', "404", "main");

        }

    }

    /** 
     * parse content only
     * 
     * @param string, name of the application to get layout from
     * 
     * @param string, page template to use before rendering
     * 
     * @return boolean, weather the content was parsed or not
     * 
    */

    function parse_content($app, $template = "Index") {

        // error handling
        if(!file_exists('internal_data/cache/themes/' . $this->theme . '/templates/' . $app)) {

            error("MVC: The template pack for [ $app ] does not exist.", true);

            return false;

        }

        if(!file_exists('internal_data/cache/themes/' . $this->theme . '/templates/' . $app . '/' . $template . '.html')) {

            error("MVC: The template [ $template ] does not exist in the theme [ $this->theme ].", true);

            return false;

        }

        $template = file_get_contents('internal_data/cache/themes/' . $this->theme . '/templates/' . $app . '/' . $template . '.html');

        $template = $this->view->parse($template, $this->theme);
        $this->view->execute($template);

    }

    /** 
     * parse full page with layout and content
     * 
     * @param string, name of the application to get layout from
     * 
     * @param string, name of the content layout
     * 
     * @param string, name of the wrapper page layout
     * 
     * @return boolean, weather the page was parsed and executed or not
     * 
    */

    function parse_page($app, $template = "Index", $layout = "main", $data = []) {

        // error handling
        if(!file_exists('internal_data/cache/themes/' . $this->theme . '/' . $layout . '_layout.html')) {

            error("MVC: The page layout [ $layout ] does not exist in the theme pack [ $this->theme ].", true);

            return false;

        }
        
        if(!file_exists('internal_data/cache/themes/' . $this->theme . '/templates/' . $app)) {

            error("MVC: The template pack for [ $app ] does not exist.", true);

            return false;

        }

        if(!file_exists('internal_data/cache/themes/' . $this->theme . '/templates/' . $app . '/' . $template . '.html')) {

            error("MVC: The template [ $template ] does not exist in the theme [ $this->theme ].", true);

            return false;

        }

        $content = $this->view->parse(file_get_contents('internal_data/cache/themes/' . $this->theme . '/templates/' . $app . '/' . $template . '.html'), $this->theme);

        $page = $this->view->parse(file_get_contents('internal_data/cache/themes/' . $this->theme . '/' . $layout . '_layout.html'), $this->theme);

        $page = str_replace("&&page_content&&", $content, $page);

        $this->view->execute($page, $data);

    }

}