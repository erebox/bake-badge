<?php

namespace Erebox\BakeBadge;

use \SimpleXMLElement;

class SimpleXMLElementCData extends SimpleXMLElement {

    private function addCData($data) {
        $n = dom_import_simplexml($this);
        $n->appendChild($n->ownerDocument->createCDATASection($data));
    }

    public function addChildCData($name, $data) {
        $this->addChild($name)->addCData($data);
    }

}