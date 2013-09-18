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
}
