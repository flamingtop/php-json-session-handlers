<?php

namespace ShawnX\JSONSessionHandlers;

class FileHandler
{
    protected $path;
 
    public function open($path, $name) {
        if (!is_dir($path)) {
            mkdir($path, 0777); // what happens if it fails
        }
        $this->path = $path;
        return true;
    }

    public function read($id) {
        $_SESSION = json_decode(file_get_contents($this->getFilePath($id)));
        return session_encode();
    }

    public function write($id, $data) {
        return file_put_contents($this->getFilePath($id), json_encode($_SESSION)) === false ? false : true;
    }

    public function destroy($id) {
        return unlink($this->getFilePath());
    }

    public function gc() {
        return true;
    }

    public function close() {
        return true;
    }

    private function getFilePath($id) {
        return "{$this->path}/sess_{$id}";
    }
}