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
        $this->load->library('my_const');
        $this->load->library('user_lib');
        $this->load->library('auth_lib');
        $this->load->library('error');
        $this->load->helper('email');
    }

    /**
     * @api {get} /user/list?page=(:num)&token=(:any) Request User List
     * @apiName GetUserList
     * @apiGroup User
     *
     * @apiParam {String} token User's token
     * @apiParam {String} page of list User
     *
     * @apiSuccess {Number}   page      page of list User.
     * @apiSuccess {Number}   per_page  number of record per page.
     * @apiSuccess {Number}   total  total User.
     * @apiSuccess {Number}   total_pages total page User.
     * @apiSuccess {Object[]} data       Data of user.
     * @apiSuccess {Object}   data.info   Users info.
     * @apiSuccess {String}   data.info.user_id User id.
     * @apiSuccess {String}   data.info.username User name.
     * @apiSuccess {String}   data.info.email User email.
     * @apiSuccess {String}   data.info.fullname User full name.
     * @apiSuccess {String}   data.info.created User date created.
     * @apiSuccess {String}   data.info.updated User date updated.
     *
     */
    public function list_get(){
        $token = $this->get('token');
        $page = $this->get('page')  ? (int)$this->get('page') : 1;
        if (!is_null($token)):
            $isToken = $this->authorize_model->ckToken($token);
            if($isToken['status']):
                $user = $this->user_model->get(null, $page);
                $total = (int)$this->user_model->get_total();
                $total_pages = (int)CEIL($total/My_const::LIMIT_PER_PAGE);
                if(!is_null($user)):
                    // Set the response and exit
                    $this->response([
                        "page" => $page,
                        "per_page" => My_const::LIMIT_PER_PAGE,
                        'total' =>  $total,
                        'total_pages' => $total_pages,
                        'data' => User_lib::formatArrayUser($user),
                    ], REST_Controller::HTTP_OK);
                else :
                    $this->response(
                        json_decode("{}")
                    , REST_Controller::HTTP_NOT_FOUND);
                endif;
            else:
            $this->response([
                'error' => $isToken['message']
            ], REST_Controller::HTTP_NOT_FOUND);
            endif;
        endif;
        $this->response([
            'error' => Message::NO_TOKEN
        ], REST_Controller::HTTP_NOT_FOUND); 
    }


    /**
     * @api {get} /user/user-info?id=(:num)&token=(:any) Request User Info
     * @apiName GetUserInfo
     * @apiGroup User
     *
     * @apiParam {String} id User's id
     * @apiParam {String} token User's token
     *
     * @apiSuccess {Object}   user   Users object.
     * @apiSuccess {String}   user.user_id User id.
     * @apiSuccess {String}   user.username User name.
     * @apiSuccess {String}   user.email User email.
     * @apiSuccess {String}   user.fullname User full name.
     * @apiSuccess {String}   user.created User date created.
     * @apiSuccess {String}   user.updated User date updated.
     */
    public function user_info_get(){

        $id = $this->get('id');
        $token = $this->get('token');

        if (!is_null($token)) :
            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken['status']) :
                if(!is_null($id) && ($id > 0)) :
                    $user = $this->user_model->get($id);
                    if(!is_null($user)) :
                        // Set the response and exit
                        $this->response([
                            "data" => User_lib::formatUser($user)
                        ], REST_Controller::HTTP_OK);
                    else :
                        $this->response(
                            json_decode("{}")
                        , REST_Controller::HTTP_NOT_FOUND);
                    endif;
                else:
                    $this->response(
                        $this->my_generation->generateResponse([
                        'error' => Message::NO_USER_WERE_FOUND
                    ]), REST_Controller::HTTP_NOT_FOUND);
                endif;
            endif;
            $this->response(
                $this->my_generation->generateResponse([
                'error' => $isToken['message']
            ]), REST_Controller::HTTP_NOT_FOUND);
        endif;
        $this->response(
            $this->my_generation->generateResponse([
            'error' => Message::NO_TOKEN
        ]), REST_Controller::HTTP_NOT_FOUND);
    }

    /**
     * @api {delete} /user/delete Request User Delete
     * @apiName DeleteUser
     * @apiGroup User
     *
     * @apiParam {String} user_id User's id
     * @apiParam {String} token User's token
     *
     * @apiSuccess (204).
     */
    public function user_destroy_delete(){

        $id = (int)$this->delete('user_id');
        $token = $this->delete('token');
        if (!is_null($token)) :
            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken['status']) :
                $ckRole = $this->role_model->checkRole($token);
                if(!is_null($ckRole) && ($ckRole->status == 0)):
                    if(!is_null($id) && ($id > 0)):
                        $user = $this->user_model->delete($id);
                        if($user['status']):
                            $this->response(
                                $this->my_generation->generateResponse([])
                            , REST_Controller::HTTP_NO_CONTENT);
                        endif;
                        $this->response($this->my_generation->generateResponse([
                            'error' => $user['error']
                        ]), REST_Controller::HTTP_NO_CONTENT);
                    else :
                        $this->response(
                            $this->my_generation->generateResponse([
                            'error' => Message::NO_USER_WERE_FOUND
                        ]), REST_Controller::HTTP_NOT_FOUND);
                    endif;
                endif;
                $this->response(
                    $this->my_generation->generateResponse([
                    'error' => Message::PERMIT_ADMIN
                ]), REST_Controller::HTTP_NOT_FOUND);
            endif;
            $this->response(
                $this->my_generation->generateResponse([
                'error' => $isToken['message']
            ]), REST_Controller::HTTP_NOT_FOUND);
        endif;
        $this->response(
            $this->my_generation->generateResponse([
            'error' => Message::NO_TOKEN
        ]), REST_Controller::HTTP_NOT_FOUND);
    }

    /**
     * @api {post} /user/login Request User Login
     * @apiName UserLogin
     * @apiGroup User
     *
     * @apiParam {String} email User's email
     * @apiParam {String} password User's password
     *
     * @apiSuccess {Object}   authorization   Authorization object.
     * @apiSuccess {String}   authorization.authorize_key Authorization authorize key.
     * @apiSuccess {String}   authorization.refresh_key Authorization refresh key.
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
                        $this->response(
                            $this->my_generation->generateResponse([
                            'token' => $ckAuthorization->authorize_key,
                            'refresh-token' => $ckAuthorization->refresh_key
                        ]), REST_Controller::HTTP_OK);
                    else :
                        $author = $this->my_generation->generateAuthorizationKey($user);
                        $this->authorize_model->createAuthorization($user, $author);
                        $authorization = $this->authorize_model->getAuthorization($user);
                        if ($authorization) :
                            $this->response($this->my_generation->generateResponse([
                                'token' => $authorization->authorize_key,
                                'refresh-token' => $authorization->refresh_key
                            ]), REST_Controller::HTTP_OK);
                        endif;
                    endif;
                else :
                    $this->response(
                        $this->my_generation->generateResponse([
                        'error' => Message::NO_USER_WERE_FOUND
                    ]), REST_Controller::HTTP_BAD_REQUEST);
                endif;
            else :
                $this->response(
                    $this->my_generation->generateResponse([
                    'error' => Message::EMAIL_NOT_VALID
                ]), REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
        $this->response(
            $this->my_generation->generateResponse([
            'error' => Message::LOGIN_NULL
        ]), REST_Controller::HTTP_BAD_REQUEST);
    }



    /**
     * @api {post} /user/add Request User Add New
     * @apiName AddUser
     * @apiGroup User
     *
     * @apiParam {String} username User name
     * @apiParam {String} email User's email
     * @apiParam {String} password User's password
     * @apiParam {String} fullname User's full name
     * @apiParam {String} token User's token
     *
     * @apiSuccess (201) {String} User were created.
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
                            $user_created = $this->user_model->find_user($email);
                            $this->response(
                                User_lib::formatUser($user_created)
                            , REST_Controller::HTTP_CREATED);
                        else :
                            $this->response(
                                $this->my_generation->generateResponse([
                                'error' => $isExistUser['message']
                            ]), REST_Controller::HTTP_NOT_FOUND);
                        endif;
                    else :
                        $this->response(
                            $this->my_generation->generateResponse([
                            'error' => Message::EMAIL_NOT_VALID
                        ]), REST_Controller::HTTP_NOT_FOUND);
                    endif;
                endif;
                $this->response(
                    $this->my_generation->generateResponse([
                    'error' => Message::PERMIT_ADMIN
                ]), REST_Controller::HTTP_NOT_FOUND);
            endif;
            $this->response(
                $this->my_generation->generateResponse([
                'error' => $isToken['message']
            ]), REST_Controller::HTTP_NOT_FOUND);

        endif;
        $this->response(
            $this->my_generation->generateResponse([
            'error' => Message::ADD_USER_FAIL
        ]), REST_Controller::HTTP_NOT_FOUND);
    }


    /**
     * @api {patch} /user/update Request User Update
     * @apiName UpdateUser
     * @apiGroup User
     *
     * @apiParam {String} username User's name
     * @apiParam {String} email User's email
     * @apiParam {String} password User's password
     * @apiParam {String} fullname User's full name
     * @apiParam {String} token User's token
     *
     * @apiSuccess {Object}   user   Users object.
     * @apiSuccess {String}   user.username User name.
     * @apiSuccess {String}   user.email User email.
     * @apiSuccess {String}   user.fullname User full name.
     * @apiSuccess {String}   user.updated User date updated.
     *
     */
    public function user_update_patch(){

        $username = $this->patch('username');
        $email = $this->patch('email');
        $password = $this->patch('password');
        $fullname = $this->patch('fullname');
        $token = $this->patch('token');

        if (!is_null($username) && !is_null($email) && !is_null($password) && !is_null($fullname) && !is_null($token)):

            $isToken = $this->authorize_model->ckToken($token);
            if ($isToken['status']) :
                $ckRole = $this->role_model->checkRole($token);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) :
                    $isExistUser = $this->user_model->find_user($email);
                    if (!is_null($isExistUser)):
                        if(!is_null($ckRole) && (($ckRole->user_id === $isExistUser->user_id) or ((int)$ckRole->status === 0))) :
                            $update = date('Y-m-d H:i:s');
                            $passwordSalt = $this->user_model->generatePasswordSalt($email, $password);
                            $password = $this->user_model->generatePasswordEncode($password);
                            $user_updated = $this->user_model->update($isExistUser->user_id, $username, $password, $passwordSalt, $email, $fullname, $update);
                            if(!array_key_exists('message',$user_updated)) :
                                $this->response(
                                    User_lib::formatUserUpdate($user_updated)
                                , REST_Controller::HTTP_OK);
                            endif;
                            $this->response(
                                $this->my_generation->generateResponse([
                                'error' => $user_updated['message']
                            ]), REST_Controller::HTTP_NOT_FOUND);
                        endif;
                        $this->response(
                            $this->my_generation->generateResponse([
                            'error' => Message::UPDATE_SELF
                        ]), REST_Controller::HTTP_NOT_FOUND);
                    else :
                        $this->response(
                            $this->my_generation->generateResponse([
                                'error' => Message::NO_USER_WERE_FOUND
                        ]), REST_Controller::HTTP_NOT_FOUND);
                    endif;
                else :
                    $this->response($this->my_generation->generateResponse([
                        'error' => Message::EMAIL_NOT_VALID
                    ]), REST_Controller::HTTP_NOT_FOUND);
                endif;
            endif;
            $this->response(
                $this->my_generation->generateResponse(
                    ['error' => $isToken['message']
            ]), REST_Controller::HTTP_NOT_FOUND);
        endif;
        $this->response(
            $this->my_generation->generateResponse(
                ['error' => Message::ADD_USER_FAIL]
            ), REST_Controller::HTTP_NOT_FOUND);
    }
}
