<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Generation
{
    private $salt = 'f0tp-p00ls-@p1';
    private $author_key = '@uth0-key';
    private $refresh_key = 'refresh_@uth0_key';

    public function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function generatePasswordSalt($email,$password){
        $password = sha1($email.$this->salt).$password;
        return hash('sha256',$password);
    }

    public function generateAuthorizationKey($user_id){
        $today = date('d-m-Y H:i:s');
        $user_id = (int)$user_id['user_id'];
        $time = strtotime($today);;
        $tokenAuthor = sha1($this->salt.$this->author_key.$time);
        $tokenReFresh = sha1($this->salt.$this->refresh_key.$time);
        $dateExpire = date('d-m-Y H:i:s', strtotime(date("d-m-Y H:i:s",strtotime('+ 1 hours'))));

        $token = array(
            'tokenAuthor' => hash('sha256',$user_id.$tokenAuthor),
            'tokenReFresh'=> hash('sha256',$user_id.$tokenReFresh),
            'expireDate' => $dateExpire
        );
        return $token;
    }
}