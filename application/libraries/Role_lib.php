<?php

class Role_lib
{
    public $role_id;
    public $status;
    public $role_message;

    public function __construct()
    {}

    public function newRole($status, $role_message){
        $this->setStatus($status);
        $this->setRoleMessage($role_message);
        unset($this->role_id);
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
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

    /**
     * @return mixed
     */
    public function getRoleMessage()
    {
        return $this->role_message;
    }

    /**
     * @param mixed $role_message
     */
    public function setRoleMessage($role_message)
    {
        $this->role_message = $role_message;
    }
}