<?php
class Images_tags extends CI_Model {
    private $_table_name;
    private $_table_fields;

    public function __construct() {
        parent::__construct();

        $this->_table_name   = 'images_tags';
        $this->_table_fields = array(
                                        'id',
                                        'image_id',
                                        'tag_id',
                                        'value'
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

    /*Get all users+tweets from database*/
    public function get() {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $data = $this->db->get()
            ->result_array();
        return $data;
    }

    /*Get by id*/
    /*public function get_by_id($id) {
            $this->db->where('id', $id);
            $this->db->join('tweets', 'tweets.user_id = twitter_users.twitter_id','left');
        $data = $this->db->get($this->_table_name)
                     ->result_array();
        return $data;
    }*/
}