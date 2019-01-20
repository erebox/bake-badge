<?php

namespace Erebox\BakeBadge;

interface BakeInterface
{
    public function isBaked();
    public function bake($value);
}
