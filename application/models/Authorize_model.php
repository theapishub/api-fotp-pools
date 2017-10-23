<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authorize_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('my_generation');
        $this->load->library('auth_lib');
        $this->load->helper('email');
    }
    public function createAuthorization($user, $author){
        try{
            $author_key = $author['tokenAuthor'];
            $refresh_key = $author['tokenReFresh'];
            $expire = $author['expireDate'];
            $currentAuth = $this->getAuthorization($user);
            if($currentAuth):
                $this->auth_lib->updateAuth($currentAuth->authorize_id, $user->user_id, $author_key, $currentAuth->refresh_key, $expire);
                $this->db->where('user_id', $user->user_id);
                $this->db->update('authorize', $this->auth_lib);
            else:
                $this->auth_lib->newAuth($user->user_id, $author_key, $refresh_key, $expire);
                $this->db->insert('authorize', $this->auth_lib);
            endif;
            return null;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function checkAuthorizationNotExpire($user_id){
        try{
            $today = strtotime(date('d-m-Y H:i:s'));
            $query = $this->db->select('*')->from('authorize')->where(array(
                'user_id' => $user_id->user_id
            ))->get();
            if ($query->num_rows() == 1) :
                $author = $query->custom_row_object(0, 'Auth_lib');
                if (strtotime($author->key_expire) > $today) :
                    return $author;
                else :
                    return null;
                endif;
            endif;
            return null;
        }catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
    public function getAuthorization($user_id){
        try{
            $query = $this->db->select('*')->from('authorize')->where(array(
                'user_id' => $user_id->user_id,
                'status' => 1
            ))->get();
            if ($query->num_rows() == 1) :
                return $query->custom_row_object(0, 'Auth_lib');
            endif;
            return null;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function ckToken($token){
        try{
            $query = $this->db->select('*')->from('authorize')->where(array(
                'authorize_key' => $token,
            ))->get();
            if ($query->num_rows() == 1) :
                $today = $today = date('d-m-Y H:i:s');
                $author = $query->custom_row_object(0, 'Auth_lib');
                if (strtotime($today) < strtotime($author->key_expire)) :
                    $this->message->message_response = [
                        'message' => Message::TOKEN_OK,
                        'status' => true,
                        'isExpire' => false
                    ];
                    return $this->message->message_response;
                endif;
                $this->message->message_response = [
                    'message' => Message::TOKEN_EXPIRED,
                    'status' => false,
                    'isExpire' => true
                ];
                return $this->message->message_response;
            endif;
            $this->message->message_response = [
                'message' => Message::NO_TOKEN_WERE_FOUND,
                'status' => false,
                'isExpire' => null
            ];
            return $this->message->message_response;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function ckRefreshToken($token){
        try{
            $query = $this->db->select('*')->from('authorize')->where(array(
                'refresh_key' => $token,
            ))->get();
            if ($query->num_rows() == 1) :
                $this->message->message_response = [
                    'message' => Message::TOKEN_OK,
                    'status' => true,
                    'user' => $query->custom_row_object(0, 'Auth_lib')
                ];
                return $this->message->message_response;
            endif;
            $this->message->message_response = [
                'message' => Message::NO_TOKEN_WERE_FOUND,
                'status' => false
            ];
            return $this->message->message_response;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function refreshToken($user, $author){
        try{
            $author_key = $author['tokenAuthor'];
            $refresh_key = $author['tokenReFresh'];
            $expire = $author['expireDate'];
            $currentAuth = $this->getAuthorization($user);
            $this->auth_lib->updateAuth($currentAuth->authorize_id, $user->user_id, $author_key, $refresh_key, $expire);
            $this->db->where('user_id', $user->user_id);
            $this->db->update('authorize', $this->auth_lib);
            $this->message->message_response = [
                'message' => Message::TOKEN_REFRESHED,
                'status' => true
            ];
            return $this->message->message_response;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function checkRoleStatus($token){

    }
}