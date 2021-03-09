<?php

namespace xframe\Cache;

class App {

    /** 
     * cache root path
     * 
    */

    private $cache_path = 'internal_data/cache/';

    /** 
     * create cache group
     * 
     * @param string, cache group name
     * 
     * @return boolean, returns if the group was created
     * 
    */

    function mkgroup($cache_name) {

        // error handling
        if(file_exists($this->cache_path . $cache_name)) {

            error("Cache Controller: The cache group [ $cache_name ] already exists.");
            return false;

        }

        if(mkdir($this->cache_path . $cache_name)) {

            return true;

        }

        return false;

    }

    /** 
     * get cache groups
     * 
     * @return array, list of all the cache groups
     * 
    */

    function get_cache_groups() {

        $cache_groups = scandir($this->cache_path);

        $dir_info = -1;
        
        // loop through all dir array and remove dir info symbols [ . && .. ]
        foreach($cache_groups as $cache_group) {

            $dir_info++;

            if($cache_group == '.' || $cache_group == '..') {

                unset($cache_groups[$dir_info]);

            }

        }

        unset($cache_group);

        $dir_info = $dir_info - count($cache_groups);

        // remove files from array
        foreach($cache_groups as $cache_group) {

            $dir_info++;

            if(is_file($this->cache_path . $cache_group)) {

                unset($cache_group[$dir_info]);

            }

        }

        // return groups
        $output = $cache_groups;
        return $output;

    }

    /** 
     * add a cache record
     * 
    */

    function add_record() {
        
    }

}