<?php

class Search extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

       //Parser
        $this->load->library('grubber');

    }

    function index()
    {
        if($this->input->post('search_data') == null){
            redirect('/');
        }
        $data = $this->input->post('search_data');
        $result = $this->tags->search($data);
        if($result){
            foreach($result as $tag){
                foreach($this->images_tags->getImagesByTagId($tag['id']) as $img){
                    $images[] = $img;
                }
            }
            foreach($images as $img){
                $tags = $this->images_tags->getByImageId($img['id']);
                $img['tags'] = $tags;
                $data_img[] = $img;
            }
            $data_img = array('images_data' => $data_img);
        }else{
            $data_img = array('images_data' => null);
        }
        $this->_base_template('watcher', $data_img );
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
