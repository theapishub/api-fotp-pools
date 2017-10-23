<?php

class User_lib
{
    public $user_id;
    public $username;
    public $password;
    public $password_salt;
    public $email;
    public $fullname;
    public $created;
    public $updated;
    public $status;

    public function __construct()
    {

    }

    static function formatUser(User_lib $user){
        $user->getUserId();
        $user -> getUsername();
        $user -> getEmail();
        $user -> getFullname();
        $user -> getCreated();
        $user -> getUpdated();
        unset($user->password);
        unset($user->password_salt);
        return $user;
    }


    static function formatArrayUser(array  $users){
        $arrUser = array();
        foreach($users as $user):
            $user->getUserId();
            $user -> getUsername();
            $user -> getEmail();
            $user -> getFullname();
            $user -> getCreated();
            $user -> getUpdated();
            $user -> getStatus();
            unset($user->password);
            unset($user->password_salt);
            array_push($arrUser, $user);
        endforeach;
        return $arrUser;
    }


    public function newUser($username, $password, $passwordSalt,$email, $fullname, $created, $status = 1){
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setFullname($fullname);
        $this->setPasswordSalt($passwordSalt);
        $this->setCreated($created);
        $this->setUpdated($created);
        $this->setStatus($status);
        unset($this->user_id);
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPasswordSalt()
    {
        return $this->password_salt;
    }

    /**
     * @param mixed $password_salt
     */
    public function setPasswordSalt($password_salt)
    {
        $this->password_salt = $password_salt;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
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
}