<?php

namespace xframe\Database;

trait update {

    /** 
     * select query function
     * 
    */

    function update() {

        $this->clean();

        $this->query_type = "UPDATE";
        return $this;

    }

}