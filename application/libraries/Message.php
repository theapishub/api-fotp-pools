<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message
{
    public $message_response = [];

    const AM = 'AM';

    const TOKEN_REFRESHED = "Token were refreshed";

    const NO_USER_WERE_FOUND =  "No users were found";

    const SUCCESSFUL = "Successful";

    const USER_WERE_DELETED = "This user were deleted";

    const EMAIL_NOT_VALID = "This email not valid";

    const TOKEN_OK = "The token is ok";

    const TOKEN_EXPIRED = "The token was expired";

    const EMAIL_NOT_EXIST = "Email is already exist";

    const USER_NAME_EXIST = "User name is already exist";

    const LOGIN_NULL = "The email or password can't be null";

    const ADD_USER_FAIL = "The user info can't be null";

    const ADD_USER_SUCCESS = "The user were adding successful";

    const NO_TOKEN_WERE_FOUND = "No token were found";

    const NO_TOKEN = "Token were empty";

    const PERMIT_ADMIN = "You need Admin permission";
}