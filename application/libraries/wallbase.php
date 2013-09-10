<?php
class Source{
    public $linksRegex = '';
    public $imageRegex = '';
    public $filenameString = '';
    public $name = '';
    public $url = '';

    function __construct($params)
    {
        $this->linksRegex       = $params['links_regex'];
        $this->imageRegex       = $params['image_regex'];
        $this->filenameString   = $params['filename_string'];
        $this->name             = $params['name'];
        $this->url              = $params['url'];
    }
}