<?php
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
    public function createAuthorization($user_id, $author){
        try{
            $author_key = $author['tokenAuthor'];
            $refresh_key = $author['tokenReFresh'];
            $expire = $author['expireDate'];
            $curentAuth = $this->getAuthorization($user_id);
            if($curentAuth):
                $this->auth_lib->updateAuth($curentAuth->authorize_id, $user_id->user_id, $author_key, $curentAuth->refresh_key, $expire, $status = 1);
                $this->db->where('user_id', $user_id->user_id);
                $this->db->update('authorize', $this->auth_lib);
            else:
                $this->auth_lib->newAuth($user_id->user_id, $author_key, $refresh_key, $expire, $status = 1);
                $this->db->insert('authorize', $this->auth_lib);
            endif;
            return null;
        }catch (Exception $e){
            return $e;
        }
    }
    public function checkAuthorizationNotExpire($user_id){
        try{
            $today = strtotime(date('d-m-Y H:i:s'));
            if (!is_null($user_id)){
                $query = $this->db->select('*')->from('authorize')->where(array(
                    'user_id'=> $user_id->user_id
                ))->get();
                if($query->num_rows() == 1){
                    $author = $query->custom_row_object(0,'Auth_lib');
                    if(strtotime($author->key_expire) > $today){
                        return $author;
                    }
                    else{
                        return null;
                    }
                }else{
                    return null;
                }
            }
            return null;
        }catch (Exception $e)
        {
            return $e;
        }
    }
    public function getAuthorization($user_id){
        try{
            if (!is_null($user_id)) {
                $query = $this->db->select('*')->from('authorize')->where(array(
                    'user_id' => $user_id->user_id,
                    'status' => 1
                ))->get();
                if($query->num_rows() == 1) {
                    return $query->custom_row_object(0, 'Auth_lib');
                }
                return null;
            }else{
                return null;
            }
        }catch (Exception $e){
            return $e;
        }
    }

    public function ckToken($token){
        try{
            if (!is_null($token)) {
                $query = $this->db->select('authorize_key')->from('authorize')->where(array(
                    'authorize_key' => $token,
                ))->get();
                if($query->num_rows() == 1) {
                    return true;
                }
                return null;
            }else{
                return null;
            }
        }catch (Exception $e){
            return $e;
        }
    }
}