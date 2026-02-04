<?php

namespace App\Core;

class FileManager
{
    private string $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function loadFile(): array
    {
        $file = fopen($this->filename, "r");
        $data = json_decode(fread($file,filesize($this->filename)));
        fclose($file);
        return $data;
    }

    public function writeFile(array $data):void
    {
        $file = fopen($this->filename, "w");
        fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
        fclose($file);
    }
}