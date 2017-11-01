<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';

class Authorization  extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('authorize_model');
        $this->load->library('my_generation');
    }

    /**
     * @api {post} /authorization/refresh-token Request Refresh Token Key
     * @apiName RefreshToken
     * @apiGroup Authorization
     *
     * @apiParam {String} token Authorization's refresh token
     *
     * @apiSuccess {Boolean} status Status response.
     * @apiSuccess {String} message Message of response.
     */
    public function user_refresh_post(){

        $token = $this->post('token');
        if (!is_null($token)):
            $isToken = $this->authorize_model->ckRefreshToken($token);
            if($isToken['status']):
                $this->response(
                    $this->my_generation->generateResponse(
                        ['token' => $isToken['token']]
                    ), REST_Controller::HTTP_OK);
            endif;
            if($isToken['isExpire']):
                $user_author = $isToken['author'];
                $author = $this->my_generation->generateAuthorizationKey($user_author);
                $refresh_token = $this->authorize_model->refreshToken($user_author,$author);
                $this->response(
                    $this->my_generation->generateResponse(
                        ['token' => $refresh_token['token']]
                    ), REST_Controller::HTTP_OK);
            endif;
            $this->response(
                $this->my_generation->generateResponse(
                    ['error' => $isToken['error']]
                ), REST_Controller::HTTP_NOT_FOUND);
        endif;
        $this->response(
            $this->my_generation->generateResponse(
                ['error' => Message::NO_TOKEN]
            ), REST_Controller::HTTP_NOT_FOUND);
    }
}