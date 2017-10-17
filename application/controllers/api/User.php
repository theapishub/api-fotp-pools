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
        $this->load->helper('email');
    }

    public function list_get(){
        $user = $this->user_model->get();
        if(!is_null($user)){
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'data' => $user,
                'message' => 'Successful'
            ],
                REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }


    /**
     * @api {get} /user/:id Request User List
     * @apiName GetUserInfo
     * @apiGroup User
     *
     * @apiParam {String} id User's id
     *
     * @apiSuccess {String} app_name Application Name.
     * @apiSuccess {String} api_version Api Version.
     * @apiSuccess {String} api_doc Api Document Link.
     */
    public function user_get($id){
        $id = (int)$id;
        if(!is_null($id) && ($id > 0)){
            $user = $this->user_model->get($id);
            if(!is_null($user)){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'data' => $user,
                    'message' => 'Successful'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found',
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function user_delete_get($id){
        $id = (int)$id;
        if(!is_null($id) && ($id > 0)){
            $this->user_model->delete($id);
            $this->response([
                'status' => TRUE,
                'message' => 'The user were deleted',
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found',
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function user_login_get($email, $passwd){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $passwd = $this->my_generation->generatePasswordSalt($email, $passwd);
            $user_id = $this->user_model->login($email, $passwd);
            if($user_id){
                $user_id = User_lib::formatUser($user_id);
                $ckAuthorization = $this->authorize_model->checkAuthorizationNotExpire($user_id);
                if($ckAuthorization){
                    $this->response([
                        'status' => TRUE,
                        'data' =>
                            array(
                                'info' => $user_id,
                                'authorizationInfo' => Auth_lib::formatAuthor($ckAuthorization),
                            ),
                        'message' => 'Successful',
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                }else{
                    $author = $this->my_generation->generateAuthorizationKey($user_id);
                    $this->authorize_model->createAuthorization($user_id,$author);
                    $authorization = $this->authorize_model->getAuthorization($user_id);
                    if($authorization){
                        $this->response([
                            'status' => TRUE,
                            'data' =>
                                array(
                                    'info' => $user_id,
                                    'authorizationInfo' => Auth_lib::formatAuthor($ckAuthorization),
                                ),
                            'message' => 'Successful',
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                    }
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No user were found',
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }

        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Email not valid',
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }
}