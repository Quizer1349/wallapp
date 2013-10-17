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


    public function getByImageId($id) {
            $this->db->where('image_id', $id);
            $this->db->join('tags', 'tags.id = images_tags.tag_id','left');
        $data = $this->db->get($this->_table_name)
                     ->result_array();
        return $data;
    }

    public function getImagesByTag($tag) {
        $this->db->where('tag', $tag);
        $this->db->join('tags', 'tags.id = images_tags.tag_id','left');
        $this->db->join('images', 'images.id = images_tags.image_id','left');
        $this->db->order_by('value', 'DESC');
        $data = $this->db->get($this->_table_name)
            ->result_array();
        return $data;
    }

    public function getImagesByTagId($tag_id) {
        $this->db->where('tag_id', $tag_id);
        $this->db->join('images', 'images.id = images_tags.image_id','left');
        $data = $this->db->get($this->_table_name)
                         ->result_array();
        return $data;
    }
}