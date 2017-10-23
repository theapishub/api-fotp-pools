<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Role_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('role_lib');
    }

    public function checkRole($token){
        try{
            $query = $this->db->select('u.user_id,u.status')
                ->from('authorize as a')
                ->where('a.authorize_key', $token)
                ->join('users as u', 'a.user_id = u.user_id', 'LEFT')
                ->get();
            if ($query->num_rows() == 1) {
                return $query->custom_row_object(0, 'User_lib');
            }
            return null;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function addRole($role = null){

    }
}