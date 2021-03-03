<?php

namespace xframe\Database;

trait Insert {

    /** 
     * select query function
     * 
    */

    function insert() {

        $this->clean();

        $this->query_type = "INSERT";
        return $this;

    }

}