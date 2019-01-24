<?php

namespace Erebox\BakeBadge;

class BakePNG implements BakeInterface
{
    private $content = "";
    private $size = 0;
    private $chunks = [];
	
    private $error = false;
    private $error_msg = "";

    public function __construct($filename) {
        $this->content = $this->load($filename);
        if(!$this->content) {
			$this->error = true;
            $this->error_msg = 'Error loading '.$filename;
        } else {
            $header = substr($this->content, 0, 8); 
            if ($header != pack("C8", 137, 80, 78, 71, 13, 10, 26, 10)) { //PNG signature
                $this->error = true;
                $this->error_msg = 'PNG image not valid';
            } else {
                $this->size = strlen($this->content);
                $pos = 8;
                do {
                    $chunk = @unpack('Nsize/a4type', substr($this->content, $pos, 8));
                    $this->chunks[$chunk['type']][] = substr($this->content, $pos + 8, $chunk['size']);
                    $pos += $chunk['size'] + 12;
                } while ($pos < $this->size);
            }
        }
    }

    public function isBaked() {
        if ($this->existPngChunk("tEXt", "openbadges")) {
            return true;
        } else if ($this->existPngChunk("iTXt", "openbadges")) {
            return true;
        } else {
            return false;
        }
    }

    public function bake($value) {
        if (!$this->isBaked()) {
            return $this->addPngChunk("iTXt", "openbadges", $value);
        } else {
            $this->error = true;
            $this->error_msg = 'PNG already baked';
            return false;
        }
    }
    
    public function bakeShow($value) {
        $img = $this->bake($value);
        if ($img) {
            header('Content-Type: image/png');
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

    private function existPngChunk($type, $check) {
        if (!$this->error && isset($this->chunks[$type]) && count($this->chunks[$type]) > 0) {
			$curr_arr = $this->chunks[$type];
			foreach ($curr_arr as $cont) {
				$pos2 = stripos($cont, $check);
				if ($pos2 !== false) {
					return true;
				}
			}
        }
        return false;
    }

    private function addPngChunk($type, $key, $value) {
        if (strlen($key) > 79) {
			$this->error = true;
            $this->error_msg = 'Key is too big';
			return "";
        } else {
            if (!$this->error) {
                $data = $key . "\0" . $value;
                $len = pack("N", strlen($data));
                $crc = pack("N", crc32($type . $data));
                $newchunk = $len . $type . $data . $crc;
                $result = substr($this->content, 0, $this->size - 12)
                        . $newchunk
                        . substr($this->content, $this->size - 12, 12);
                return $result;    
            } else {
                return "";
            }
		}
    }


}