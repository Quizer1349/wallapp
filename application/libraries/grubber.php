<?php
include_once('wallbase.php');
include_once('simple_html_dom.php');
class Grubber {
    public $linksRegex = '';
    public $imageRegex = '';
    public $filenameString = '';
    public $name = 'defaultscraper';
    private $source = null;
    private $source_name = '';
    private $config_file = '';

    public function init($source_name)
    {
        $this->source_name = $source_name;
        $CI =& get_instance();
        $CI->config->load('grubber');
        $this->source = new Source($CI->config->item($this->source_name));
    }

    public function parse($html){
        $thumb_div = $html->find('.thumbnail');
        foreach($thumb_div as $one_die){
            var_dump($thumb_div->find(''));
        }

        $xpath = new DOMXPath($html);
        $links = $xpath->query($this->source->linksRegex);
        $urls = array();
        echo "\r\n --- Searching for urls --- \r\n";
        foreach($links as $link){
            array_push($urls, $link->getAttribute('href'));
        }
        echo "\r\n --- Going through the urls finding images --- \r\n";
        foreach($urls as $url){
            $html = $this->scraper->getHTMLFromUrl($url);
            $xpath = new DOMXPath($html);
            $result = $xpath->query($this->source->imageRegex);
            foreach($result as $img){
                var_dump(array('url' => $url, 'src' => $img->getAttribute('src')));
            }
        }
    }

    public function download($image){
        $exploded = explode($this->filenameString, $image['url']);
        $file = file_get_contents($image['src']);
        $filename = $exploded[1] . '.jpg';
        file_put_contents('images/'.$this->name.'/'.$filename, $file);
        echo 'Downloaded: ' . $image['url'] . "\r\n";
    }

    public function getHTMLFromUrl($url){
        $html = file_get_html($url);
        return $html;
    }

    public function run()
    {
        $this->parse($this->getHTMLFromUrl($this->source->url));
    }
}