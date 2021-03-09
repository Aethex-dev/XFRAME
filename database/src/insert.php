<?php

namespace xframe\Database;

trait insert {

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