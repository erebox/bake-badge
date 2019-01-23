<?php

namespace Erebox\BakeBadge;

class BakeSVG implements BakeInterface
{
    private $content = "";
    private $xml = false;
	
    private $error = false;
    private $error_msg = "";

    public function __construct($filename) {
        $this->content = $this->load($filename);
        if(!$this->content) {
			$this->error = true;
            $this->error_msg = 'Error loading '.$filename;
        } else {
            $this->xml = simplexml_load_string($this->content);
            if (!$this->xml) {
                $this->error = true;
                $this->error_msg = 'Error xml on '.$filename;    
            } else {
                $doc = $this->xml->getDocNamespaces(true);
                print_r($doc);
                $ob = $this->xml->children($doc['openbadges']);
                print_r($ob);
                echo $ob->assertion."\n";
                //echo "*".isset($this->xml['xmlns'])."*\n";
            }
        }
    }

    public function isBaked() {
        /*
        if ($this->existPngChunk("tEXt", "openbadges")) {
            return true;
        } else if ($this->existPngChunk("iTXt", "openbadges")) {
            return true;
        } else {
            return false;
        }
        */
        return false;
    }

    public function bake($value) {
        if (!$this->isBaked()) {
            //return $this->addPngChunk("iTXt", "openbadges", $value);
            return "";
        } else {
            $this->error = true;
            $this->error_msg = 'SVG already baked';
            return false;
        }
    }

    private function load($file) {
        if(file_exists($file)) {
            return file_get_contents($file);
        }
        return false;
    }

}