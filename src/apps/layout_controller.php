<?php

foreach ($this->mvc->global as $var => $value) {

    ${$var} = $value ?? false;
}

// breadcrumbs
$url = $this->mvc->router->get_url();
$url_loc = '';
$breadcrumbs = [];
$breadcrumb_i = -1;

foreach ($url as $url_segment) {

    if ($url_segment != "") {

        $breadcrumb_i++;

        $url_loc = $url_loc . '/' . $url_segment;
        array_push($breadcrumbs, array('title' => urldecode($url_segment), 'url' => urldecode($url_loc)));
    }
}
