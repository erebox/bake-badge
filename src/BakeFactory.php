<?php

namespace Erebox\BakeBadge;

use Erebox\BakeBadge\BakePNG;
use Erebox\BakeBadge\BakeSVG;

class BakeFactory
{
    public static function create($file_name) {
        $path_parts = pathinfo($file_name);
        $ext = strtolower($path_parts['extension']);
        //echo $ext."\n";
        $b = false;
        switch ($ext) {
            case "svg":
                $b = new BakeSVG($file_name);
                break;
            case "png":
                $b = new BakePNG($file_name);
                break;
        }
        return $b;
    }
}
