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


    public function get() {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->join('tweets', 'tweets.user_id = twitter_users.twitter_id','left');
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

    public function getRand()
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->order_by('RAND()');
        $this->db->limit(32);
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
}
