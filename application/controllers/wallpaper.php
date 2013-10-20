<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wallpaper extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('grubber');

    }

    function get()
    {
        if($this->uri->total_segments() > 2 || $this->uri->total_segments() < 2){
            redirect(base_url());
        }
        $image_data = $this->images->getById($this->uri->segment(2));
        $grubber = new Grubber();
        $grubber->init('wallbase');
        $image = $grubber->getImage(str_replace('__', '/', $image_data[0]['src_url']));
        header("Content-type: image/jpeg");
        echo $image; die;
    }
}