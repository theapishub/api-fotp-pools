<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model
{
    private $status = 0;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('User_lib');
    }
    public function get($id = null)
    {
        try{
            if (!is_null($id)){
                $query = $this->db->select('*')->from('users')->where('user_id',$id)->get();
                if($query->num_rows() == 1){
                    return $query->custom_row_object(0, 'User_lib');
                }
                return null;
            }
            $query = $this->db->select('*')->from('users')->get();
            if($query->num_rows() > 0){
                return $query->custom_result_object('User_lib');
            }
            return null;
        }catch (Exception $e){
            return $e;
        }
    }
    public function delete($id)
    {
        try{
            if (!is_null($id)){
                $this->db->delete('users', array('user_id' => $id));
            }
            return null;
        }catch (Exception $e)
        {
            return $e;
        }
    }
    public function login($email,$password)
    {
        try{
            if (!is_null($email) && !is_null($password)){
                $query = $this->db->select('*')->from('users')->where(array(
                    'email'=> $email,
                    'password_salt'=>$password
                ))->get();
                if($query->num_rows() == 1){
                    return $query->custom_row_object(0, 'User_lib');
                }
            }
            return null;
        }catch (Exception $e)
        {
            return $e;
        }
    }
}