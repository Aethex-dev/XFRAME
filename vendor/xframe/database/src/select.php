<?php

namespace xframe\Database;

trait Select {

    /** 
     * select query function
     * 
     * @param object, connection object for database
     * 
    */

    function select() {

        $this->clean();

        $this->query_type = "SELECT";
        return $this;

    }

}