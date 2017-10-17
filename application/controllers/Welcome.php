<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';


class Welcome extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->index();
    }    

    public function index(){
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $this->response(
                [
                    'error' => 'ERROR_REQUEST_REJECTED'
                ], REST_Controller::HTTP_OK
            );
        }
    }
}