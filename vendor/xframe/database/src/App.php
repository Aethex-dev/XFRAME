<?php

/** 
 * MySQLi Database Adapter
 * 
 * Author: XENONMC XFRAME
 * PHP Min Version: 8.2.0
 * 
 */

namespace xframe\Database;

class App
{

    /** 
     * connection object 
     * 
     */

    public $conn;

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
    use insert;
    use update;
    use count;
    use delete;

    /** 
     * clean all mysqli query parameters
     * 
     */

    private function clean()
    {

        foreach ($this as $key => $value) {

            $this->$key = null;
        }
    }

    /** 
     * connect to a database
     * 
     * @param array, all the connection parameters
     * 
     * @return object, returns the new connection object
     * 
     */

    function connect(array $params)
    {

        // input validation
        if (!isset($params['port'])) {

            $params['port'] = 3306;
        }

        if (!isset($params['charset'])) {

            $params['charset'] = 'utf8';
        }

        if (!isset($params['password'])) {

            $params['password'] = '';
        }

        $this->conn = new \mysqli($params['host'], $params['username'], $params['password'], $params['database'], $params['port']);

        if ($this->conn->connect_error) {

            $database = $params['database'];

            error("MySQLI Database Adapter: Failed to connect to database [ $database ]. Please check your credentials.");
        } else {

            $charset = $params['charset'];

            if (!$this->conn->set_charset($params['charset'])) {

                error("MySQLI Database Adapter: Failed to set charset. Given charset: [ $charset ]");
            }
        }

        return $this->conn;
    }

    /** 
     * check required query parameters
     * 
     * @param array, list of all the required query parameters 
     * 
     */

    private function required(array $params)
    {

        foreach ($params as $param) {

            if (!isset($this->$param)) {

                error("MySQLi Database Adapter: Missing parameter. [ $param ] parameter is required.");
                $this->errors = true;
            }
        }
    }

    /** 
     * compile query
     * 
     */

    private function compile()
    {

        $query = $this->query;

        if (isset($this->where)) {

            $query = str_replace("{[where]}", $this->where, $query);
            $query = str_replace("{[where_full]}", 'WHERE ' . $this->where, $query);
        } else {

            $query = str_replace("{[where_full]}", '', $query);
            $query = str_replace("{[where]}", '', $query);
        }

        $query = str_replace("{[table]}", $this->table, $query);

        if (isset($this->column)) {

            $query = str_replace("{[column]}", $this->column, $query);
        }

        if (isset($this->set)) {

            $query = str_replace("{[set]}", $this->set, $query);
        }

        if (isset($this->param)) {

            $real_param = $this->param;

            foreach ($this->param as &$value) {

                $value = '?';
            }

            $query = str_replace("{[param]}", implode(",", $this->param), $query);

            $this->param = $real_param;
        }

        $this->query = $query;
    }

    /** 
     * build query
     * 
     */

    private function build()
    {

        switch ($this->query_type) {

            case "SELECT":

                if (!isset($this->where)) {

                    $this->where = "LENGTH('$this->column') >= ?";
                }

                if (!isset($this->param)) {

                    $this->param = array('0');
                }

                if (!isset($this->types)) {

                    $this->types = "s";
                }

                $this->required(array(

                    'table',
                    'column',
                    'where',
                    'types',
                    'param'

                ));

                $final = "SELECT {[column]} FROM {[table]} {[where_full]};";

                $this->query = $final;

                $this->query_built = true;

                break;

            case "INSERT":

                $this->required(array(

                    'table',
                    'column',
                    'param',
                    'types'

                ));

                $final = "INSERT INTO {[table]} ({[column]}) VALUES ({[param]})";

                $this->query = $final;

                $this->query_built = true;

                break;

            case "UPDATE":

                $this->required(array(

                    'table',
                    'set',
                    'where',
                    'param',
                    'types'

                ));

                $final = "UPDATE {[table]} SET {[set]} WHERE {[where]}";

                $this->query = $final;

                $this->query_built = true;

                break;

            case "DELETE":

                $this->required(array(

                    'table',
                    'param',
                    'where',
                    'types'

                ));

                $final = "DELETE FROM {[table]} WHERE {[where]}";

                $this->query = $final;

                $this->query_built = true;

                break;

            case "COUNT":

                $this->required(array(

                    'table'

                ));

                $final = "SELECT COUNT(*) FROM {[table]} {[where_full]}";

                $this->query = $final;

                $this->query_built = true;

                break;

            default:

                error("MySQLI Database Adapter: Failed to execute query. Invalid query_type [ $this->query_type ].");

                break;
        }
    }

    /** 
     * execute query
     * 
     * @param object, connection object to your database
     * 
     */

    function execute(object $conn)
    {

        if (isset($this->error)) {

            error("MySQLi Database Adapter: Failed to execute query. There are errors in your query, please fix the errors to execute the query");
            return false;
        }

        switch ($this->query_type) {

            case "SELECT":

                // finalize query
                $this->build();
                $this->compile();

                // execute query
                $query = $this->query;
                if (!$stmt = $conn->prepare($query)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to prepare query statement.");
                    return false;
                }

                if (!$stmt->bind_param($this->types, ...$this->param)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to bind query parameters.");
                    return false;
                }

                if (!$stmt->execute()) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to run execute on statement");
                    return false;
                }

                // bind results
                $result =  $stmt->get_result();
                $this->result = $result;

                break;

            case "INSERT":

                // finalize query
                $this->build();
                $this->compile();

                // execute query
                $query = $this->query;

                if (!$stmt = $conn->prepare($query)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to prepare query statement.");
                    return false;
                }

                if (!$stmt->bind_param($this->types, ...$this->param)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to bind query parameters.");
                    return false;
                }

                if (!$stmt->execute()) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to run execute on statement");
                    return false;
                }

                break;

            case "UPDATE":

                // finalize query
                $this->build();
                $this->compile();

                // execute query
                $query = $this->query;

                if (!$stmt = $conn->prepare($query)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to prepare query statement.");
                    return false;
                }

                if (!$stmt->bind_param($this->types, ...$this->param)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to bind query parameters.");
                    return false;
                }

                if (!$stmt->execute()) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to run execute on statement");
                    return false;
                }

                break;

            case "DELETE":

                // finalize query
                $this->build();
                $this->compile();

                // execute query
                $query = $this->query;

                if (!$stmt = $conn->prepare($query)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to prepare query statement.");
                    return false;
                }

                if (!$stmt->bind_param($this->types, ...$this->param)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to bind query parameters.");
                    return false;
                }

                if (!$stmt->execute()) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to run execute on statement");
                    return false;
                }

                break;

            case "COUNT":

                // finalize query
                $this->build();
                $this->compile();

                // execute query
                $query = $this->query;

                if (!$stmt = $conn->prepare($query)) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to prepare query statement.");
                    return false;
                }

                if (isset($this->param)) {

                    if (!$stmt->bind_param($this->types, ...$this->param)) {

                        error("MySQLi Database Adapter: Failed to execute query. Failed to bind query parameters.");
                        return false;
                    }
                }

                if (!$stmt->execute()) {

                    error("MySQLi Database Adapter: Failed to execute query. Failed to run execute on statement");
                    return false;
                }

                // bind results
                $result =  $stmt->get_result();
                $this->result = $result;

                break;

            default:

                error("MySQLI Database Adapter: Failed to execute query. Invalid query_type [ $this->query_type ].");

                break;
        }

        /** 
         * close mysqli query connection
         * 
         */

        $stmt->close();
    }

    /** 
     * fetch records to an array
     * 
     */

    function fetch()
    {

        return $this->result->fetch_assoc();
    }
}
