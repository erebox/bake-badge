<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Erebox\BakeBadge\BakeSVG;

$svg_unbaked_file = "badge_unbaked_test.svg";
$svg_unbaked = new BakeSVG($svg_unbaked_file);
$svg_baked = $svg_unbaked->bake('{"@context": "https://w3id.org/openbadges/v2","id": "https://example.org/assertions/123","type": "Assertion"}');
if ($svg_baked)
    file_put_contents("badge_baked.png", $svg_baked);
else
    echo "xXxXx";
