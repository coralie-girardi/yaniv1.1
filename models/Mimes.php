<?php

namespace Models;

class Mimes {

    // Génère un tableau avec tous les mime_types
    public function getMimeTypes() {

        $url = "http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types";
        $mimeTypes = [];

        foreach(@explode("\n",@file_get_contents($url)) as $x)
            if(isset($x[0]) && $x[0]!=='#' && preg_match_all('#([^\s]+)#',$x,$out) && isset($out[1]) && ($c=count($out[1]))>1)
                for($i=1;$i<$c;$i++)
                    $mimeTypes[$out[1][$i]] = $out[1][0];
        return $mimeTypes;
    }
}