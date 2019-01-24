<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Erebox\BakeBadge\BakeFactory;

$svg_unbaked_file = "badge_unbaked.svg";
$png_unbaked_file = "badge_unbaked.png";
$json = '{"@context": "https://w3id.org/openbadges/v2","id": "https://example.org/assertions/123","type": "Assertion"}';

$b = BakeFactory::create($svg_unbaked_file);
$c = $b->bake($json);    
file_put_contents("badge_baked.svg", $c);

$b = BakeFactory::create($png_unbaked_file);
$c = $b->bake($json);    
file_put_contents("badge_baked.png", $c);
