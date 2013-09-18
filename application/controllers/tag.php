<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //Loading models
        $this->load->model('images');
        $this->load->model('images_tags');
        $this->load->model('tags');

        //Loading helpers
        $this->load->helper('url');

        //Parser
        $this->load->library('grubber');

    }

    function index()
    {
        $tags = $this->tags->get();

        $data = array('tags' => $tags);
        $this->_base_template('taglist', $data );
    }

    function images()
    {
        //Check is there correct params in URI
        if($this->uri->total_segments() > 2 || $this->uri->total_segments() < 2){
            redirect('/tag');
        }else{
            $tag = ($this->uri->segment(2)) ? $this->uri->segment(2) : '';
        }
        if($tag == ""){
            redirect('/tag');
        }
        $images = $this->images_tags->getImagesByTag(urldecode($tag));
        if(count($images) != 0){
            foreach($images as $img){
                $tags = $this->images_tags->getByImageId($img['id']);
                $img['tags'] = $tags;
                $data[] = $img;
            }
        }else{
            $data = 'Empty!';
        }
        //Call view with $data
        $data = array('images_data' => $data);
        $this->_base_template('watcher', $data );
    }

    function _base_template($template = null, $data = null)
    {
        $this->load->view('layout/_header');
        $this->load->view('layout/_top_nav');
        if ($template)
        {
            $this->load->view($template, $data );
        }
        $this->load->view('layout/_footer');
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
