<?php

namespace xframe\Database;

trait Update {

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