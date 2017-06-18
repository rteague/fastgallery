<?php

// by Rashaud Teague

class PHPFileIO {
    public $path;
    protected $fp;
    protected $mode;
    public function __construct($path) {
        $this->path = $path;
        $this->mode = 'w';
        $this->fp = null;
    }
    public function __destruct() {
        $this->close();
    }
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
    protected function open() {
        if (!isset($this->fp)) {
            if (!($this->fp = fopen($this->path, $this->mode))) {
                //error - throw exception
            }
        }
    }
    protected function close() {
        if (isset($this->fp)) {
            fclose($this->fp);
        }
    }
    public function read($flags = 0) {
        return file_get_contents($this->path);
    }
    public function readlines($flags = 0) {
        return file($this->path, $flags);
    }
    public function write($content) {
        $this->open();
        if (!fwrite($this->fp, $content)) {
            //error - throw exception
        }
    }
}


