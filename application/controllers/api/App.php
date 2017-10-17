<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';

class App extends REST_Controller
{
    const API_VERSION = '0.0.1';
    const APP_NAME = 'FOTP POOL API';    

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @api {get} /app/ Request App Data
     * @apiName GetAppData
     * @apiGroup App
     *
     *
     * @apiSuccess {String} app_name Application Name.
     * @apiSuccess {String} api_version Api Version.
     * @apiSuccess {String} api_doc Api Document Link.
     */
    public function index_get(){
        // setup data
        $api_data = array(
            'app_name' => App::APP_NAME,
            'api_version' => App::API_VERSION,
            'api_doc' => base_url() . 'apidoc'
        );
        // response
        $this->response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code        
    }
}