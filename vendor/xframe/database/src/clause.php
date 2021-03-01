<?php

namespace xframe\Database;

trait clause {

    /** 
     * from table clause
     * 
     * @param string, name of the table you want to query
     * 
    */

    function table($table) {

        $this->table  = $table;
        return $this;

    }

    /** 
     * columns clause
     * 
     * @param array, the column(s) you want to query for
     * 
    */

    function column($column) {

        if($this->query_type == "SELECT") {

            $this->column = $column;
            return $this;

        }

    }

    /** 
     * where clause
     * 
     * @param string, where to select, update or delete data from
     * 
    */

    function where($where) {

        $this->where = $where;
        return $this;
        
    }

    /** 
     * 
     * 
    */

}