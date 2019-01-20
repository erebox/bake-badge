<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Erebox\BakeBadge\BakePNG;

$png_file = "badge_unbaked.png";
$png = new BakePNG($png_file);
if ($png->isBaked()) {
    echo $png_file.": Baked!\n";
} else {
    echo $png_file.": NOT Baked...\n";
}


$png_file = "badge_baked.png";
$png = new BakePNG($png_file);
if ($png->isBaked()) {
    echo $png_file.": Baked!\n";
} else {
    echo $png_file.": NOT Baked...\n";
}

