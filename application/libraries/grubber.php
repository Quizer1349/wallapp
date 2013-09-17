<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once('simple_html_dom.php');
include_once('Connection.php');
include_once('Curl.php');
class Grubber {
    public $linksRegex = '';
    public $imageRegex = '';
    public $filenameString = '';
    public $name = 'defaultscraper';
    private $config = array();
    private $source_name = '';
    private $_curl = null;

    public function init($source_name)
    {
        $this->_curl = new Curl();
        $this->source_name = $source_name;
        $CI =& get_instance();
        $CI->config->load('grubber');
        $this->config =$CI->config->item($this->source_name);
    }

    public function parse($html)
    {
        $data_tags = 'data-tags';
        $data_img = 'data-original';
        foreach($html->find('div.thumbnail') as $one){
            $thumb = $one->find('img' , 0);
            $image_data[] = array(
                                  'thumb_url' => $thumb->$data_img,
                                  'src_url'   => str_replace('thumb', 'wallpaper', $thumb->$data_img),
                                  'tags'  => $this->_parseTags($one->$data_tags)
                                 );
        }
        $html->clear;
        unset($html);
        return $image_data;
    }

    public function saveToDb()
    {

    }

    private function _parseTags ($tags = '')
    {
        if(!is_string($tags)){
            throw new Exception('Incoming data is not a string!');
        }
        $parsed_tags = explode('|0', $tags);
            for($i = 0; $i < count($parsed_tags); $i++){
                if($parsed_tags[$i] != '' && $parsed_tags[$i] != null){
                    $pars_item = explode('|', trim($parsed_tags[$i], '||'));
                    if(strlen($pars_item[0]) != 0){
                        $tag_data[] = array($pars_item[0], $pars_item[1] );
                    }
                }
            }
        return $tag_data;
    }

    public function getImage($img_url)
    {
        $this->_curl->create($img_url);
        $this->_curl->option(CURLOPT_REFERER, 'http://wallbase.cc/');
        $this->_curl->option(CURLOPT_FOLLOWLOCATION, 1);
        $this->_curl->option(CURLOPT_RETURNTRANSFER, 1);
        return $this->_curl->execute();
    }

    public function download($image)
    {
        $exploded = explode($this->filenameString, $image['url']);
        $file = file_get_contents($image['src']);
        $filename = $exploded[1] . '.jpg';
        file_put_contents('images/'.$this->name.'/'.$filename, $file);
        echo 'Downloaded: ' . $image['url'] . "\r\n";
    }

    public function getHTMLFromUrl($url)
    {
        $html = file_get_html($url);
        return $html;
    }

    public function run($pagination)
    {
        if($pagination == 0){
            $data = $this->parse($this->getHTMLFromUrl($this->config['url']));
        }else{
            $data = $this->parse($this->getHTMLFromUrl($this->config['url'] . $pagination));
        }
        return $data;
    }
}