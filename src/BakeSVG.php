<?php

namespace Erebox\BakeBadge;
use Erebox\BakeBadge\SimpleXMLElementCData;

class BakeSVG implements BakeInterface
{
    private $content = "";
    private $xml = false;
    private $ns = [];
	
    private $error = false;
    private $error_msg = "";

    public function __construct($filename) {
        $this->content = $this->load($filename);
        if(!$this->content) {
			$this->error = true;
            $this->error_msg = 'Error loading '.$filename;
        } else {
            $this->xml = new SimpleXMLElementCData($this->content);
            if (!$this->xml) {
                $this->error = true;
                $this->error_msg = 'Error xml on '.$filename;    
            } else {
                $this->ns = $this->xml->getDocNamespaces(true);
            }
        }
    }

    public function isBaked() {
        if (isset($this->ns['openbadges'])) {
            $ns_obj = $this->ns['openbadges'];
            $obj = $this->xml->children($ns_obj);
            if (isset($obj->assertion)) {
                return true;
            }
        }
        return false;
    }

    public function bake($value) {
        if (!$this->isBaked()) {
            $this->xml->addAttribute('xmlns:xmlns:openbadges', 'http://openbadges.org');
            $this->xml->addChildCData("openbadges:openbadges:assertion",$value);
            return $this->xml->asXML();
        } else {
            $this->error = true;
            $this->error_msg = 'SVG already baked';
            return false;
        }
    }
    
    public function bakeShow($value) {
        $img = $this->bake($value);
        if ($img) {
            header('Content-Type: image/svg+xml');
            echo $img;
            exit();        
        }
    }

    private function load($file) {
        if(file_exists($file)) {
            return file_get_contents($file);
        }
        return false;
    }

}