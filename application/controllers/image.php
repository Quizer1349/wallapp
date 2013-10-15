<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('grubber');

    }

    function get()
    {
        if($this->uri->total_segments() > 3 || $this->uri->total_segments() < 3){
            redirect(base_url());
        }
        $image_url = str_replace('__', '/', $this->uri->segment(3));
        $grubber = new Grubber();
        $grubber->init('wallbase');
        $image = $grubber->getImage($image_url);
        header("Content-type: image/jpeg");
        echo $image; die;
    }

    function wallpaper()
    {
        echo 'sddfsdfsdfsdfsdf';
        $this->get('id');
        var_dump($this->get('id')); die;
        $image_url = str_replace('__', '/', $this->uri->segment(3));
        $grubber = new Grubber();
        $grubber->init('wallbase');
        $image = $grubber->getImage($image_url);
        header("Content-type: image/jpeg");
        echo $image; die;
    }
}