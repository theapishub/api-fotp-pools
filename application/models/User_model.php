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
        try{
            if (!is_null($id)){
                $query = $this->db->select('*')->from('users')->where('user_id',$id)->get();
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
            return $this->status = 'Successful';

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
                    return $query->row_array();
                }
            }
            return null;

        }catch (Exception $e)
        {
            return $e;
        }
    }
}

class UserModal {
    public $user_id;
    public $username;
    public $password;
    public $password_salt;
    public $email;
    public $fullname;
    public $created;
    public $updated;

    public function __construct()
    {

    }

    static function formatUser(UserModal $user){
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


}