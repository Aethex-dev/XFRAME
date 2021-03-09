<?php

namespace xframe\Mvc;

trait syntax {

    function parse_if() {

        $file = preg_replace('~\<if:(.+?)\>~', '<?php if($1) { ?>', $file);
        $file = preg_replace('~\</if\>~', '<?php } ?>', $file);

    }

    function parse_else() {


        
    }

}