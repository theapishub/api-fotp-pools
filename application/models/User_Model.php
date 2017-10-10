<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)){
            $query = $this->db->select('*')->from('users')->where('id',$id)->get();
            if($query->num_rows() == 1){
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('users')->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return null;
    }
}