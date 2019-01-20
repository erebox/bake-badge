<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Erebox\BakeBadge\BakePNG;

$png_unbaked_file = "badge_unbaked.png";
$png_unbaked = new BakePNG($png_unbaked_file);
$png_baked = $png_unbaked->bake('{"@context": "https://w3id.org/openbadges/v2","id": "https://example.org/assertions/123","type": "Assertion"}');
file_put_contents("badge_baked.png", $png_baked);
