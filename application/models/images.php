<?php
class Images extends CI_Model {
    private $_table_name;
    private $_table_fields;

    public function __construct() {
        parent::__construct();

        $this->_table_name   = 'images';
        $this->_table_fields = array(
                                     'id',
                                     'src_url',
                                     'thumb_url'
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

    /*Insert data */
    public function insert($data) {
        $this->db->insert($this->_table_name, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function countImgs() {
        return $this->db->count_all($this->_table_name);
    }

    public function get($limit, $order) {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        if($limit != 0){
            $this->db->limit($limit);
        }
        $this->db->order_by($this->_table_name . '.id', $order);
        $data = $this->db->get()
            ->result_array();
        return $data;
    }

    public function getWithLimit($limit) {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->limit($limit);
        $data = $this->db->get()
            ->result_array();
        return $data;
    }

    public function insertIfNotExists($data) {
        $insert_id = $this->getByUrl($data['src_url']);
        if(count($insert_id) == 0){
            $this->db->insert($this->_table_name, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }else{
            return false;
        }
    }

    public function getRand($limit = 32)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getByUrl($url) {
        $this->db->select('id');
        $this->db->from($this->_table_name);
        $this->db->where('src_url', $url);
        $this->db->limit(1);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getById($id) {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->where($this->_table_name . '.id', $id);
        $data = $this->db->get()->result_array();
        return $data;
    }
}
