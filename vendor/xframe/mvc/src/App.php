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

        echo $theme;

        // dependencies construct
        $this->model = new Model();
        $this->controller = new Controller();
        $this->view = new View();

        $this->view->execute(
            
            $this->view->parse(

                file_get_contents("internal_data/cache/themes/Default/templates/About/index.html")
        
            ),

            '$yourname = "xfaon";'
    
        );

    }

}