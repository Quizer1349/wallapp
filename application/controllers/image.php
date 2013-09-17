<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
//		$this->load->model('twitter_users');
//		$this->load->model('tweets');
        $this->load->helper('url');
//		// Loading TwitterOauth library. Delete this line if you choose autoload method.
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
}