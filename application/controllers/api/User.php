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
        $this->load->model('role_model');
        $this->load->library('my_generation');
        $this->load->library('user_lib');
        $this->load->library('auth_lib');
        $this->load->library('message');
        $this->load->helper('email');
    }

    /**
     * @api {get} /user/list/(:token) Request User List
     * @apiName GetUserList
     * @apiGroup User
     *
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
    public function list_get(){

        $token = $this->get('token');
        if (!is_null($token)){
            $isToken = $this->authorize_model->ckToken($token);
            if($isToken['status']){
                $user = $this->user_model->get();
                if(!is_null($user)):
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'data' => User_lib::formatArrayUser($user),
                        'message' => Message::SUCCESSFUL
                    ],
                        REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                else :
                    $this->response([
                        'status' => FALSE,
                        'message' => Message::NO_USER_WERE_FOUND
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                endif;
            }
            $this->response([
                'status' => FALSE,
                'message' => $isToken['message'],
                'isExpire' => $isToken['isExpire']
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        $this->response([
            'status' => FALSE,
            'message' => Message::NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }


    /**
     * @api {post} /user Request User Info
     * @apiName GetUserInfo
     * @apiGroup User
     *
     * @apiParam {String} user_id User's id
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
    public function user_post(){
        $id = (int)$this->post('user_id');
        $token = $this->post('token');
        if (!is_null($token)) :
            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken['status']) :
                if(!is_null($id) && ($id > 0)) :
                    $user = $this->user_model->get($id);
                    if(!is_null($user)) :
                        // Set the response and exit
                        $this->response([
                            'status' => TRUE,
                            'data' => array(
                                'info' => User_lib::formatUser($user)
                            ),
                            'message' => Message::SUCCESSFUL
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    else :
                        $this->response([
                            'status' => FALSE,
                            'message' => Message::NO_USER_WERE_FOUND
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                    endif;
                else:
                    $this->response([
                        'status' => FALSE,
                        'message' => Message::NO_USER_WERE_FOUND
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                endif;
            endif;
            $this->response([
                'status' => FALSE,
                'message' => $isToken['message'],
                'isExpire' => $isToken['isExpire']
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        endif;
        $this->response([
            'status' => FALSE,
            'message' => Message::NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

    /**
     * @api {post} /user/delete Request User Delete
     * @apiName PostUserDelete
     * @apiGroup User
     *
     * @apiParam {String} user_id User's id
     * @apiParam {String} token User's token
     *
     * @apiSuccess {Boolean} status Status response.
     * @apiSuccess {String} message Message of response.
     */
    public function user_delete_post(){

        $id = (int)$this->post('user_id');
        $token = $this->post('token');

        if (!is_null($token)) :
            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken['status']) :
                $ckRole = $this->role_model->checkRole($token);
                if(!is_null($ckRole) && ($ckRole->status == 0)):
                    if(!is_null($id) && ($id > 0)):
                        $user = $this->user_model->delete($id);
                        if($user['status']):
                            $this->response([
                                'status' => TRUE,
                                'message' => $user['message']
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                        endif;
                        $this->response([
                            'status' => FALSE,
                            'message' => $user['message']
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    else :
                        $this->response([
                            'status' => FALSE,
                            'message' => Message::NO_USER_WERE_FOUND
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                    endif;
                endif;
                $this->response([
                    'status' => FALSE,
                    'message' => Message::PERMIT_ADMIN
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            endif;
            $this->response([
                'status' => FALSE,
                'message' => $isToken['message']
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        endif;
        $this->response([
            'status' => FALSE,
            'message' => Message::NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

    /**
     * @api {post} /user/login Request User Login
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
    public function user_login_post(){
        $email = $this->post('email');
        $passwd = $this->post('password');
        if(!is_null($email) && !is_null($passwd)) :
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) :
                $passwd = $this->my_generation->generatePasswordSalt($email, $passwd);
                $user = $this->user_model->login($email, $passwd);
                if ($user) :
                    $user = User_lib::formatUser($user);
                    $ckAuthorization = $this->authorize_model->checkAuthorizationNotExpire($user);
                    if ($ckAuthorization) :
                        $this->response([
                            'status' => TRUE,
                            'data' =>
                                array(
                                    'info' => $user,
                                    'authorizationInfo' => Auth_lib::formatAuthor($ckAuthorization)
                                ),
                            'message' => Message::SUCCESSFUL
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                    else :
                        $author = $this->my_generation->generateAuthorizationKey($user);
                        $this->authorize_model->createAuthorization($user, $author);
                        $authorization = $this->authorize_model->getAuthorization($user);
                        if ($authorization) :
                            $this->response([
                                'status' => TRUE,
                                'data' =>
                                    array(
                                        'info' => $user,
                                        'authorizationInfo' => Auth_lib::formatAuthor($authorization)
                                    ),
                                'message' => Message::SUCCESSFUL
                            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                        endif;
                    endif;
                else :
                    $this->response([
                        'status' => FALSE,
                        'message' => Message::NO_USER_WERE_FOUND
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                endif;
            else :
                $this->response([
                    'status' => FALSE,
                    'message' => Message::EMAIL_NOT_VALID
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            endif;
        endif;
        $this->response([
            'status' => FALSE,
            'message' => Message::LOGIN_NULL
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }



    /**
     * @api {post} /user/add Request User Add New
     * @apiName PostNewUser
     * @apiGroup User
     *
     * @apiParam {String} username User name
     * @apiParam {String} email User's email
     * @apiParam {String} password User's password
     * @apiParam {String} fullname User's full name
     * @apiParam {String} token User's token
     *
     * @apiSuccess {Boolean} status Status response.
     * @apiSuccess {String} message Message of response.
     */
    public function user_add_post(){

        $username = $this->post('username');
        $email = $this->post('email');
        $password = $this->post('password');
        $fullname = $this->post('fullname');
        $token = $this->post('token');

        if (!is_null($username) && !is_null($email) && !is_null($password) && !is_null($fullname) && !is_null($token)):

            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken['status']) :
                $ckRole = $this->role_model->checkRole($token);
                if(!is_null($ckRole) && ($ckRole->status == 0)):
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) :
                        $isExistUser = $this->user_model->ckUserExist($email,$username);
                        if(is_null($isExistUser)):
                            $created = date('Y-m-d H:i:s');
                            $passwordSalt = $this->user_model->generatePasswordSalt($email, $password);
                            $password = $this->user_model->generatePasswordEncode($password);
                            $this->user_model->add($username, $password, $passwordSalt, $email, $fullname, $created);
                            $this->response([
                                'status' => TRUE,
                                'message' => Message::ADD_USER_SUCCESS
                            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                        else :
                            $this->response([
                                'status' => FALSE,
                                'message' => $isExistUser['message']
                            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                        endif;
                    else :
                        $this->response([
                            'status' => FALSE,
                            'message' => Message::EMAIL_NOT_VALID
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                    endif;
                endif;
                $this->response([
                    'status' => FALSE,
                    'message' => Message::PERMIT_ADMIN
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            endif;
            $this->response([
                'status' => FALSE,
                'message' => $isToken['message'],
                'isExpire' => $isToken['isExpire']

            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        endif;
        $this->response([
            'status' => FALSE,
            'message' => Message::ADD_USER_FAIL
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

    /**
     * @api {post} /user/refresh-token Request User Refresh Token Key
     * @apiName PostRefreshToken
     * @apiGroup User
     *
     * @apiParam {String} token User's refresh token
     *
     * @apiSuccess {Boolean} status Status response.
     * @apiSuccess {String} message Message of response.
     */
    public function user_refresh_post(){
        
        $token = $this->post('token');
        if (!is_null($token)):
            $isToken = $this->authorize_model->ckRefreshToken($token);
            if($isToken['status']):
                $user = $isToken['user'];
                $author = $this->my_generation->generateAuthorizationKey($user);
                $refresh_token = $this->authorize_model->refreshToken($user,$author);
                $this->response([
                    'status' => FALSE,
                    'message' => $refresh_token['message']
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            endif;
            $this->response([
                'status' => FALSE,
                'message' => $isToken['message']
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        endif;
        $this->response([
            'status' => FALSE,
            'message' => Message::NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }
}