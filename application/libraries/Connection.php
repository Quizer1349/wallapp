<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Curl.php');
include_once('simple_html_dom.php');
class Connection
{
    private $_username;
    private $_password;
    private $_login_url;
    private $_login_post_url;
    private $_form_protected;
    private $_protected_field;
    private $_is_connect = false;
    private $curl;

    function __construct($params)
    {
        $this->_username = $params['username'];
        $this->_password = $params['password'];
        $this->_form_protected = $params['is_protected_form'];
        $this->_protected_field = $params['protected_field_name'];
        $this->_login_url = $params['login_url'];
        $this->_login_post_url = $params['login_post_url'];

    }

    public function login()
    {
        $this->curl = new Curl();
        $this->curl->option(CURLOPT_HEADER, 0);
        $this->curl->option(CURLOPT_FOLLOWLOCATION, 1);
        $this->curl->option(CURLOPT_RETURNTRANSFER, 1);
        $this->curl->create($this->_login_url);
        if($this->_form_protected){
            $form_token = $this->_get_protected_value($this->curl->execute());
        }
        $post = array(
                        'username' => $this->_username,
                        'password' => $this->_password,
                        'submit' => 'LOGIN'
                     );
        $post = array_merge($form_token, $post);
        $this->curl->create('http://wallbase.cc/user/do_login');
        $this->curl->option(CURLOPT_FOLLOWLOCATION, 1);
        $this->curl->option(CURLOPT_RETURNTRANSFER, 1);
        $this->curl->option(CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
        $this->curl->option(CURLOPT_POST, 1);
        $this->curl->http_header('Content-Type: application/x-www-form-urlencoded');
        $this->curl->http_header('Connection: keep-alive');
        $this->curl->post($post);
        $response = $this->curl->execute();
        $this->curl->create('http://wallbase.cc/wallpaper/2607732');
        $this->curl->execute();
        //$this->curl->;die;
        return $this->curl->debug();


    }

    private function _get_protected_value($page)
    {
        $html = str_get_html($page);
        foreach($html->find('input[name="' . $this->_protected_field . '"]') as $form_input){
            $form_token = $form_input->value;
        }
        foreach($html->find('input[name="ref"]') as $form_input){
            $form_ref = $form_input->value;
        }
        return array('csrf' => $form_token, 'ref' => $form_ref);
    }
}