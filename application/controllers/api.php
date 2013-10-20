<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller
{

    function images_get()
    {
        //Get params
        $id = $this->get('id') ? $this->get('id') : null;
        $limit = ($this->get('limit')) ? $this->get('limit') : 0;
        $order = ($this->get('order')) ? $this->get('order') : 'ASC';
        if(isset($id) && $id != ''){
           $data =  $this->images->getById($id);
           if(!$data){
               $this->response(array(
                                        'status' => 'false',
                                        'data'   => 'null',
                                        'msg'    => 'cant find image with id - ' . $id
                                    ));
               exit(0);
           }
        }else{
           $data =  $this->images->get($limit, $order);
        }
        $this->response(array(
                             'status' => 'true',
                             'data'   => $data,
                             'msg'    => 'null'
                        ));
    }

    function random_get()
    {
        $limit = ($this->get('limit')) ? $this->get('limit') : $this->images->countImgs();
        $data = $this->images->getRand($limit);
        if(!$data){
            $this->response(array(
                                 'status' => 'false',
                                 'data'   => 'null',
                                 'msg'    => 'Cant find any image!'
                            ));
            exit(0);
        }
        $this->response(array(
                             'status' => 'true',
                             'data'   => $data,
                             'msg'    => 'null'
                        ));
    }
}
?>