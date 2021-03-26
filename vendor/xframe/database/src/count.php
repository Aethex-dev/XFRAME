<?php

namespace xframe\Database;

trait count {

    /** 
     * count query function
     * 
    */

    function count() {

        $this->clean();

        $this->query_type = "COUNT";
        return $this;

    }

}