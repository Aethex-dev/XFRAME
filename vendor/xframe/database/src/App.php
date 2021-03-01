<?php

namespace xframe\Database;

class App {

    /** 
     * mysqli errors
     * 
    */

    private $errors;

    /** 
     * mysqli query type
     * 
    */

    private $query_type;

    /** 
     * mysqli query query built
     * 
    */

    private $query_built;

    /** 
     * use clause functions
     * 
    */

    use clause;

    /** 
     * use query types
     * 
    */

    use select;

    /** 
     * clean all mysqli query parameters
     * 
    */

    function clean() {

        foreach ($this as $key => $value) {
            
            $this->$key = null;

        }

    }

    /** 
     * connect to a database
     * 
     * @param array, all the connection parameters
     * 
     * @return bool, returns if the connection was successful
     * 
    */

    function connect($params) {

        // input validation
        if(!isset($params['port'])) {

            $params['port'] = 3306;

        }

        if(!isset($params['charset'])) {

            $params['charset'] = 'utf8';

        }

        if(!isset($params['password'])) {

            $params['password'] = '';

        }

        ob_start();

        $this->conn = new \mysqli($params['host'], $params['username'], $params['password'], $params['database'], $params['port']);

        $conn_error = ob_get_clean();

        if(strlen($conn_error) > 1 || $this->conn->connect_error) {

            $database = $params['database'];

            error("MySQLI Database Adapter: Failed to connect to database [ $database ]. Please check your credentials.");

        } else {

            $charset = $params['charset'];

            if(!$this->conn->set_charset ($params['charset'])) {

                error("MySQLI Database Adapter: Failed to set charset. Given charset: [ $charset ]");

            }

        }

    }

    /** 
     * check required query parameters
     * 
     * @param array, list of all the required query parameters 
     * 
    */

    private function required($params) {

        foreach($params as $param) {

            if(!isset($this->$param)) {

                error("MySQLi Database Adapter: Missing parameter. $param parameter is required.");
                $this->errors = true;

            }

        }

    }

    /** 
     * compile query
     * 
    */

    private function compile() {

        $query = $this->query;

        $query = str_replace("{[table]}", $this->table, $query);

        $query = str_replace("{[column]}", $this->column, $query);

        $query = str_replace("{[where]}", $this->where, $query);

        echo $query;

    }

    /** 
     * build query
     * 
    */

    private function build() {

        switch($this->query_type) {

            case "SELECT":

                $final = "SELECT {[column]} FROM {[table]} WHERE {[where]};";

                $this->query = $final;

            break;

            default:

                error("MySQLI Database Adapter: Failed to execute query. Invalid [ query_type ].");

            break;

        }
        
    }

    /** 
     * execute query
     * 
    */

    function execute() {

        $this->required(array(

            'table'

        ));

        if(!isset($this->query_built)) {

            error("MySQLI Database Adapter: Failed to execute query. Please make sure you create a query. Ex: SELECT, DELETE, etc...");
            return false;

        }

        if(isset($this->error)) {

            error("MySQLi Database Adapter: Failed to execute query. There are errors in your query, please fix the errors to execute the query");
            return false;

        }

        switch($this->query_type) {

            case "SELECT":



            break;

            case "INSERT":


            break;

            default:

                error("MySQLI Database Adapter: Failed to execute query. Invalid [ query_type ].");

            break;

        }

    }

}
