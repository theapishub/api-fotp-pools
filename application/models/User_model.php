<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('User_lib');
        $this->load->library('my_const');
        $this->load->library('message');
        $this->load->library('my_generation');
    }

    public function get($id = null ,$page = null)
    {
        try{
            if (!is_null($id)):
                $query = $this->db->select('*')->from('users')->where('user_id',$id)->get();
                if($query->num_rows() == 1):
                    return $query->custom_row_object(0, 'User_lib');
                endif;
                return null;
            endif;
            $limit = My_const::LIMIT_PER_PAGE;
            $offset = (!is_null($page) && $page>1) ? ($page - 1) * $limit : 0;
            $this->db->limit($limit, $offset);
            $query = $this->db->select('*')->from('users')->get();
            if($query->num_rows() > 0):
                return $query->custom_result_object('User_lib');
            endif;
            return null;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function find_user($email){
        $query = $this->db->select('*')->from('users')->where('email',$email)->get();
        if($query->num_rows() == 1):
            return $query->custom_row_object(0, 'User_lib');
        endif;
        return null;
    }

    public function get_total()
    {
        return $this->db->count_all("users");
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
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update($user_id, $username, $password, $passwordSalt, $email, $fullname, $updated){
        try{
            $this->user_lib->updateUser($username, $password, $passwordSalt, $email, $fullname, $updated);
            $isUserExist = $this->ckUserExist($email,$username,$user_id);
            if(is_null($isUserExist)):
                $this->db->where('user_id', $user_id);
                $this->db->update('users', $this->user_lib);
                return $this->user_lib;
            endif;
            return $isUserExist;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function ckUserExist($email, $username, $except = null){
        try{

            if(!is_null($except)):
                $this->db->where('user_id !=', $except);
                $queryEmail = $this->db->select('*')->from('users')->where(array(
                    'email' => $email
                ))->get();

                $this->db->where('user_id !=', $except);
                $queryUserName = $this->db->select('*')->from('users')->where(array(
                    'username' => $username
                ))->get();
            else :
                $queryEmail = $this->db->select('*')->from('users')->where(array(
                    'email' => $email
                ))->get();

                $queryUserName = $this->db->select('*')->from('users')->where(array(
                    'username' => $username
                ))->get();
             endif;

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