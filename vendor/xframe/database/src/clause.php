<?php

namespace xframe\Database;

trait clause {

    /** 
     * from table clause
     * 
     * @param string, name of the table you want to query
     * 
    */

    function table(string $table) {

        $this->table  = $table;
        return $this;

    }

    /** 
     * columns clause
     * 
     * @param array, the column(s) you want to query for
     * 
    */

    function column(string $column) {

        $this->column = $column;
        return $this;

    }

    /** 
     * where clause
     * 
     * @param string, where to select, update or delete data from
     * 
    */

    function where(string $where) {

        $this->where = $where;
        return $this;
        
    }

    /** 
     * input types
     * 
    */

    function types(string $types) {

        $this->types = $types;
        return $this;

    }

    /** 
     * query parameters
     * 
    */

    function param(array $param) {

        $this->param = $param;
        return $this;

    }

    function params(array $param) {

        $this->param = $param;
        return $this;

    }

}