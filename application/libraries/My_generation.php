<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_generation
{
    private $salt = 'f0tp-p00ls-@p1';
    private $author_key = '@uth0-key';
    private $refresh_key = 'refresh_@uth0_key';
    private $ramdom_key = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    public function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function generatePasswordSalt($email,$password){
        $hashPassword = sha1($password);
        $password = sha1($email.$this->salt.$hashPassword);
        return hash('sha256',$password);
    }

    public function generateAuthorizationKey($user_id){
        $today = date('d-m-Y H:i:s');
        $user_id = (int)$user_id->user_id;
        $time = strtotime($today);;
        $tokenAuthor = sha1($this->salt.$this->author_key.$time).$this->rand_string(5);
        $tokenReFresh = sha1($this->salt.$this->refresh_key.$time).$this->rand_string(5);
        $dateExpire = date('d-m-Y H:i:s', strtotime(date("d-m-Y H:i:s",strtotime('+ 1 hours'))));

        $token = array(
            'tokenAuthor' => hash('sha256',$user_id.$tokenAuthor),
            'tokenReFresh'=> hash('sha256',$user_id.$tokenReFresh),
            'expireDate' => $dateExpire
        );
        return $token;
    }

    public function generatePasswordEncode($password){
        return sha1($password);
    }

    public function rand_string( $length ) {
        $chars = $this->ramdom_key;
        $size = strlen( $chars );
        $str = '';
        for( $i = 0; $i < $length; $i++ ) {
            $str.= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }

    public function  generateResponse($response){
        return json_decode(json_encode($response, JSON_FORCE_OBJECT));
    }
}