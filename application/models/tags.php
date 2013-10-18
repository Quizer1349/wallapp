<?php
class Tags extends CI_Model {
    private $_table_name;
    private $_table_fields;

    public function __construct() {
        parent::__construct();

        $this->_table_name   = 'tags';
        $this->_table_fields = array(
                                        'id',
                                        'tag'
                                    );
    }

    /**
     * Return table name
     *
     * @return string table name
     */
    public function get_table_name() {
        return $this->_table_name;
    }

    public function insert($data) {
        $this->db->insert($this->_table_name, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function insertIfNotExists($tag) {
        $insert_id = $this->getByTag($tag);
        if(count($insert_id) == 0){
            $this->db->insert($this->_table_name,array('tag' =>  $tag));
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }else{
            return $insert_id[0]['id'];
        }
    }

    public function get() {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getByTag($tag) {
        $this->db->select('id');
        $this->db->from($this->_table_name);
        $this->db->where('tag', $tag);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function search($data) {
        $result = array();
        if(!is_string($data)){
            throw new ErrorException('Search query should be a string');
        }
        $data = $this->_cleanPostData($data);
        $where = 'MATCH (tag) AGAINST (\'>>"' . $data . '"';
        $data = $this->_sliceSearchData($data);
        if(count($data) > 0){
            $where .= ' >(';
            for ($i=0; $i < count($data); $i++){
                $where .= ' +' .$data[$i] . '* ';
            }
            $where .= ') <(';
            for ($i=0; $i < count($data); $i++){
                if($i == 1){
                    $where .= '> ' . $data[$i] . '* ';
                }else{
                    $where .= $data[$i] . '* ';
                }
            }
            $where .= ')\'';
        }
        $where .= ' IN BOOLEAN MODE)';
        $this->db->select("* , $where  as rel", false);
        $this->db->from($this->_table_name);
        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('rel', 'DESC');
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query(); die;
        if($result != null){
            return $result;
        }else{
            return false;
        }
    }

    private function _cleanPostData($data)
    {
        $data = strip_tags($data);
        $data = trim(strtolower($data));
        $data = preg_replace('~[^a-z0-9 \x80-\xFF]~i', "",$data);
        return $data;
    }

    private function _sliceSearchData($data)
    {
        if(strpos($data, ' ')){
            $data = explode(' ', $data);
            foreach($data as $value){
                $data_res[] = trim($value);
            }
        }elseif(strpos($data, ',')){
            $data = explode(',', $data);
            foreach($data as $value){
                $data_res[] = trim($value);
            }
        }elseif(strpos($data, '.')){
            $data = explode('.', $data);
            foreach($data as $value){
                $data_res[] = trim($value);
            }
        }else{
            $data_res = array($data);
        }
        return $data_res;
    }

}
