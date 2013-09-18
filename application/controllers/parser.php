<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Parser extends CI_Controller
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
        if($this->uri->total_segments() > 2 || $this->uri->total_segments() < 2){
            $page= 0;
        }else{
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        }
        $this->grubber->init('wallbase');
        $data = array('images_data' => $this->grubber->run($page));
        try{
            foreach($data['images_data'] as $image){
                $this->db->trans_begin();
                $image_id = $this->images->insertIfNotExists(array(
                                                                  'src_url'   => $image['src_url'],
                                                                  'thumb_url' => $image['thumb_url'],
                                                             ));
                if ($image_id){
                    if(count($image['tags']) != 0){
                        foreach($image['tags'] as $value){
                            //var_dump($value[0]);
                            $tag_id = $this->tags->insertIfNotExists($value['tag']);
                            $this->images_tags->insert(array(
                                                            'image_id' => $image_id,
                                                            'tag_id'   => $tag_id,
                                                            'value'    => $value['value']
                                                       ));
                        }
                    }
                }
            }
        }catch (Exception $e){
            if($this->db->db_debug){
                $this->db->trans_rollback();
                echo $e->getMessage();
            }
        }
        $this->db->trans_commit();
        //Call view with $data
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
