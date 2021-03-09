<?php

/** 
 * Package Name: Cache
 * Authors: XFRAME XENONMC
 * License: MIT
 * 
*/

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

        // create group
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
     * @param string, cache group path
     * 
     * @param string, cache record file name
     * 
     * @return boolean, if the record was created
     * 
    */

    function add_record($location, $record_name) {

        // error handling
        if(file_exists($this->cache_path . $location . '/' . $record_name)) {

            error("Cache Controller: The record [ $record_name ] already exists.");
            return false;

        }

        // create the record
        fopen($this->cache_path . $location . '/' . $record_name, 'w');

        // error handling
        if(file_exists($this->cache_path . $location . '/' . $record_name)) {

            return true;

        }

        return false;

    }

    /** 
     * set cache record
     * 
     * @param string, cache group path
     * 
     * @param string, cache record file name
     * 
     * @param string, record content
     * 
     * @return boolean, if the record was set successfully
     * 
    */

    function set_record($location, $record_name, $content) {

        // error handling
        if(file_exists($this->cache_path . $location . '/' . $record_name)) {

            error("Cache Controller: The record [ $record_name ] does not exist.");
            return false;

        }

        // write to the record
        $record = fopen($this->cache_path . $location . '/' . $record_name, 'w');
        fwrite($record, $content);
        fclose($record);

        // error handling
        if(file_get_contents($this->cache_path . $location . '/' . $record_name) == $content) {

            return true;

        }

        return false;

    }

    /** 
     * get the value of a cache record
     * 
     * @param string, cache group path
     * 
     * @param string, cache record file name
     * 
     * @return string, value of the cache record
     * 
    */

    function get_record($location, $record_name) {

        // error handling
        if(!file_exists($this->cache_path . $location . '/' . $record_name)) {

            error("Cache Controller: The record [ $record_name ] does not exist.");
            return false;

        }

        // get value an return
        $value = file_get_contents($this->cache_path . $location . '/' . $record_name);
        return $value;

    }

    /** 
     * delete a cache record
     * 
     * @param string, cache group path
     * 
     * @param string, cache record file name
     * 
     * @return boolean, if the cache record was deleted
     * 
    */

    function delete_record($location, $record_name) {

        // error handling
        if(!file_exists($this->cache_path . $location . '/' . $record_name)) {

            error("Cache Controller: The record [ $record_name ] does not exist.");
            return false;

        }

        // delete record
        unlink($this->cache_path . $location . '/' . $record_name);

        // error handling
        if(!file_exists($this->cache_path . $location . '/' . $record_name)) {

            return true;

        }

        return false;

    }

}