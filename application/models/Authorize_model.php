<?php

class Authorize_Model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('my_generation');
        $this->load->helper('email');
    }

    public function createAuthorization($user_id, $author){

        try{
            $author_key = $author['tokenAuthor'];
            $refresh_key = $author['tokenReFresh'];
            $expire = $author['expireDate'];
            $authorization = new Authorization_Modal($user_id['user_id'], $author_key, $refresh_key, $expire);
            $this->db->insert('authorize',$authorization);
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
                    'user_id'=> $user_id['user_id']
                ))->get();
                if($query->num_rows() == 1){
                    $authorize = $query->row_array();
                    $expireDate = strtotime($authorize['key_expire']);
                    if($today>$expireDate){
                        return null;
                    }
                    else{
                        return $authorize;
                    }
                }
                else{
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
                    'user_id' => $user_id['user_id']
                ))->get();

            }else{
                return null;
            }
            return null;
        }catch (Exception $e){
            return $e;
        }
    }
}

class Authorization_Modal
{
    public $authorize_id;
    public $user_id;
    public $authorize_key;
    public $refresh_key;
    public $key_expire;

    public function __construct($user_id, $authorize_key, $refresh_key, $expire)
    {
        $this->setUserId($user_id);
        $this->setAuthorizeKey($authorize_key);
        $this->setRefreshKey($refresh_key);
        $this->setExpire($expire);
    }

    public function getAuthorizeId()
    {
        return $this->authorize_id;
    }

    public function setAuthorizeId($authorize_id)
    {
        $this->authorize_id = $authorize_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getAuthorizeKey()
    {
        return $this->authorize_key;
    }

    public function setAuthorizeKey($authorize_key)
    {
        $this->authorize_key = $authorize_key;
    }

    public function getRefreshKey()
    {
        return $this->refresh_key;
    }

    public function setRefreshKey($refresh_key)
    {
        $this->refresh_key = $refresh_key;
    }

    public function getExpire()
    {
        return $this->key_expire;
    }

    public function setExpire($key_expire)
    {
        $this->key_expire = $key_expire;
    }

    static function formatAuthor(Authorization_Modal $author){
        $author -> getAuthorizeKey();
        $author -> getRefreshKey();
        $author -> getExpire();
        unset($author->authorize_id);
        unset($author->user_id);
        return $author;
    }
}