<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';

class User extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('authorize_model');
        $this->load->library('my_generation');
        $this->load->library('user_lib');
        $this->load->library('auth_lib');
        $this->load->library('message');
        $this->load->helper('email');
    }

    /**
     * @api {get} api/user/list/(:token) Request User List
     * @apiName GetUserList
     * @apiGroup User
     *
     * @apiParam {String} token User's token
     *
     * @apiSuccess {String} app_name Application Name.
     * @apiSuccess {String} api_version Api Version.
     * @apiSuccess {String} api_doc Api Document Link.
     */
    public function list_get($token){
        if (!is_null($token)){
            $isToken = $this->authorize_model->ckToken($token);
            if($isToken){
                $user = $this->user_model->get();
                if(!is_null($user)){
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'data' => User_lib::formatArrayUser($user),
                        'message' => $this->message->SUCCESSFUL
                    ],
                        REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $this->response([
                        'status' => FALSE,
                        'message' => $this->message->NO_USER_WERE_FOUND
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
            $this->response([
                'status' => FALSE,
                'message' => $this->message->NO_TOKEN_WERE_FOUND
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        $this->response([
            'status' => FALSE,
            'message' => $this->message->NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }


    /**
     * @api {post} api/user/(:id)/(:token) Request User Infor
     * @apiName GetUserInfo
     * @apiGroup User
     *
     * @apiParam {String} id User's id
     * @apiParam {String} token User's token
     *
     * @apiSuccess {Boolean} status Status response.
     * @apiSuccess {Object[]} data       Data of user.
     * @apiSuccess {Object}   data.info   Users info.
     * @apiSuccess {String}   data.info.user_id User id.
     * @apiSuccess {String}   data.info.username User name.
     * @apiSuccess {String}   data.info.email User email.
     * @apiSuccess {String}   data.info.fullname User full name.
     * @apiSuccess {String}   data.info.created User date created.
     * @apiSuccess {String}   data.info.updated User date updated.
     * @apiSuccess {String} message Message of response.
     */
    public function user_get($id, $token){
        $id = (int)$id;
        if (!is_null($token)) {
            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken) {
                if(!is_null($id) && ($id > 0)){
                    $user = $this->user_model->get($id);
                    if(!is_null($user)){
                        // Set the response and exit
                        $this->response([
                            'status' => TRUE,
                            'data' => array(
                                'info' => User_lib::formatUser($user)
                            ),
                            'message' => $this->message->SUCCESSFUL
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    }else{
                        $this->response([
                            'status' => FALSE,
                            'message' => $this->message->NO_USER_WERE_FOUND
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                    }
                }else{
                    $this->response([
                        'status' => FALSE,
                        'message' => $this->message->NO_USER_WERE_FOUND
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
            $this->response([
                'status' => FALSE,
                'message' => $this->message->NO_TOKEN_WERE_FOUND
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        $this->response([
            'status' => FALSE,
            'message' => $this->message->NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

    /**
     * @api {post} api/user/delete/(:id)/(:token) Request User Delete
     * @apiName PostUserDelete
     * @apiGroup User
     *
     * @apiParam {String} id User's id
     * @apiParam {String} token User's token
     *
     * @apiSuccess {Boolean} status Status response.
     * @apiSuccess {String} message Message of response.
     */
    public function user_delete_get($id, $token){
        $id = (int)$id;

        if (!is_null($token)) {
            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken) {
                if(!is_null($id) && ($id > 0)){
                    $this->user_model->delete($id);
                    $this->response([
                        'status' => TRUE,
                        'message' => $this->message->USER_WERE_DELETED
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                }else{
                    $this->response([
                        'status' => FALSE,
                        'message' => $this->message->NO_USER_WERE_FOUND
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
            $this->response([
                'status' => FALSE,
                'message' => $this->message->NO_TOKEN_WERE_FOUND
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        $this->response([
            'status' => FALSE,
            'message' => $this->message->NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

    /**
     * @api {post} api/user/login/(:email)/(:password) Request User Login
     * @apiName PostUserLogin
     * @apiGroup User
     *
     * @apiParam {String} email User's email
     * @apiParam {String} password User's password
     *
     * @apiSuccess {Boolean} status Status response.
     * @apiSuccess {Object[]} data       Data of user.
     * @apiSuccess {Object}   data.info   Users info.
     * @apiSuccess {String}   data.info.user_id User id.
     * @apiSuccess {String}   data.info.username User name.
     * @apiSuccess {String}   data.info.email User email.
     * @apiSuccess {String}   data.info.fullname User full name.
     * @apiSuccess {String}   data.info.created User date created.
     * @apiSuccess {String}   data.info.updated User date updated.
     * @apiSuccess {Object}   data.authorizationInfo   Authorization info.
     * @apiSuccess {String}   data.authorizationInfo.authorize_key Authorization authorize key.
     * @apiSuccess {String}   data.authorizationInfo.refresh_key Authorization refresh key.
     * @apiSuccess {String}   data.authorizationInfo.key_expire Authorization token expire.
     * @apiSuccess {String}   data.authorizationInfo.status Authorization status.
     * @apiSuccess {String} message Message of response.
     *
     */
    public function user_login_get($email, $passwd){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $passwd = $this->my_generation->generatePasswordSalt($email, $passwd);
            $user = $this->user_model->login($email, $passwd);
            if($user){
                $user = User_lib::formatUser($user);
                $ckAuthorization = $this->authorize_model->checkAuthorizationNotExpire($user);
                if($ckAuthorization){
                    $this->response([
                        'status' => TRUE,
                        'data' =>
                            array(
                                'info' => $user,
                                'authorizationInfo' => Auth_lib::formatAuthor($ckAuthorization)
                            ),
                        'message' => $this->message->SUCCESSFUL
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                }else{
                    $author = $this->my_generation->generateAuthorizationKey($user);
                    $this->authorize_model->createAuthorization($user,$author);
                    $authorization = $this->authorize_model->getAuthorization($user);
                    if($authorization){
                        $this->response([
                            'status' => TRUE,
                            'data' =>
                                array(
                                    'info' => $user,
                                    'authorizationInfo' => Auth_lib::formatAuthor($authorization)
                                ),
                            'message' => $this->message->SUCCESSFUL
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                    }
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => $this->message->NO_USER_WERE_FOUND
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }

        }else{
            $this->response([
                'status' => FALSE,
                'message' => $this->message->EMAIL_NOT_VALID
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }
}