<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
//		$this->load->model('twitter_users');
//		$this->load->model('tweets');
		$this->load->helper('url');
//		// Loading TwitterOauth library. Delete this line if you choose autoload method.
        $this->load->library('grubber');
//		/**
//		* Get ouath config from config/twitterapp.php
//		*/
//		$this->config->load('twitterapp');
	}

	function index()

	{
        $this->grubber->init('wallbase');
        $this->grubber->run();
        $data = array('message' => 'Hello World!');
        //Call view with $data
        $this->_base_template('watcher', $data );
	}
	
	function saver()
	{
		$data['count_rows'] = $this->tweets->count_rows();
		$data['tweets'] = $this->twitter_users->get();
		$this->_base_template('saver', $data );
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
