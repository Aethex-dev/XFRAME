<?php

namespace xframe\Database;

trait delete {

    /** 
     * delete query function
     * 
    */

    function delete() {

        $this->clean();

        $this->query_type = "DELETE";
        return $this;

    }

}