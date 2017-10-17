<?php

class Auth_lib
{
    public $authorize_id;
    public $user_id;
    public $authorize_key;
    public $refresh_key;
    public $key_expire;
    public $status;



    public function __construct()
    {}

    public function newAuth($user_id, $authorize_key, $refresh_key, $expire, $status){
        $this->setUserId($user_id);
        $this->setAuthorizeKey($authorize_key);
        $this->setRefreshKey($refresh_key);
        $this->setKeyExpire($expire);
        $this->setStatus($status);
    }
    /**
     * @return mixed
     */
    public function getAuthorizeId()
    {
        return $this->authorize_id;
    }

    /**
     * @param mixed $authorize_id
     */
    public function setAuthorizeId($authorize_id)
    {
        $this->authorize_id = $authorize_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getAuthorizeKey()
    {
        return $this->authorize_key;
    }

    /**
     * @param mixed $authorize_key
     */
    public function setAuthorizeKey($authorize_key)
    {
        $this->authorize_key = $authorize_key;
    }

    /**
     * @return mixed
     */
    public function getRefreshKey()
    {
        return $this->refresh_key;
    }

    /**
     * @param mixed $refresh_key
     */
    public function setRefreshKey($refresh_key)
    {
        $this->refresh_key = $refresh_key;
    }

    /**
     * @return mixed
     */
    public function getKeyExpire()
    {
        return $this->key_expire;
    }

    /**
     * @param mixed $key_expire
     */
    public function setKeyExpire($key_expire)
    {
        $this->key_expire = $key_expire;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    static function formatAuthor(Auth_lib $author){
        $author -> getAuthorizeKey();
        $author -> getRefreshKey();
        $author -> getKeyExpire();
        unset($author->authorize_id);
        unset($author->user_id);
        return $author;
    }
}