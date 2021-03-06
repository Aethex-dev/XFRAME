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

        // dependencies construct
        $this->model = new Model();
        $this->controller = new Controller();
        $this->view = new View();

    }

    function parse_layout($app, $layout = "Index") {

        $template = file_get_contents('internal_data/cache/themes/' . $this->theme . '/templates/' . $app . '/' . $layout . '.html');

        $template = $this->view->parse($template);
        $this->view->execute($template);

    }

    function parse_page($app, $layout = "Index", $pageLayout = "main") {

        $content = $this->view->parse(file_get_contents('internal_data/cache/themes/' . $this->theme . '/templates/' . $app . '/' . $layout . '.html'));

        $page = $this->view->parse(file_get_contents('internal_data/cache/themes/' . $this->theme . '/' . $pageLayout . '_layout.html'));

        $page = str_replace("&&page_content&&", $content, $page);

        $this->view->execute($page);

    }

}