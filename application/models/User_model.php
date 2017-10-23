<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('User_lib');
        $this->load->library('message');
        $this->load->library('my_generation');
    }

    public function get($id = null)
    {
        try{
            if (!is_null($id)):
                $query = $this->db->select('*')->from('users')->where('user_id',$id)->get();
                if($query->num_rows() == 1):
                    return $query->custom_row_object(0, 'User_lib');
                endif;
                return null;
            endif;
            $query = $this->db->select('*')->from('users')->get();
            if($query->num_rows() > 0):
                return $query->custom_result_object('User_lib');
            endif;
            return null;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try{
            $user = $this->get($id);
            if (!is_null($user)) :
                $this->db->delete('authorize', array('user_id' => $id));
                $this->db->delete('users', array('user_id' => $id));
                $this->message->message_response = [
                    'status' => true,
                    'message' => Message::USER_WERE_DELETED
                ];
                return $this->message->message_response;
            endif;
            $this->message->message_response = [
                'status' => false,
                'message' => Message::NO_USER_WERE_FOUND
            ];
            return $this->message->message_response;
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function login($email,$password)
    {
        try{
            $query = $this->db->select('*')->from('users')->where(array(
                'email' => $email,
                'password_salt' => $password
            ))->get();
            if ($query->num_rows() == 1) :
                return $query->custom_row_object(0, 'User_lib');
            endif;
            return null;
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add($username, $password, $passwordSalt, $email, $fullname, $created){
        try{
            $this->user_lib->newUser($username, $password, $passwordSalt, $email, $fullname, $created);
            $this->db->insert('users', $this->user_lib);
            return null;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }


    public function ckUserExist($email, $username){
        try{
            $queryEmail = $this->db->select('*')->from('users')->where(array(
                'email' => $email
            ))->get();

            $queryUserName = $this->db->select('*')->from('users')->where(array(
                'username' => $username
            ))->get();

            if ($queryEmail->num_rows() == 1) :
                $this->message->message_response = [
                    'message' => Message::EMAIL_NOT_EXIST
                ];
                return $this->message->message_response;
            endif;

            if ($queryUserName->num_rows() == 1) :
                $this->message->message_response = [
                    'message' => Message::USER_NAME_EXIST
                ];
                return $this->message->message_response;
            endif;
            return null;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function generatePasswordSalt($email, $password){
        return $this->my_generation->generatePasswordSalt($email, $password);
    }

    public function generatePasswordEncode($password){
        return $this->my_generation->generatePasswordEncode($password);
    }
}