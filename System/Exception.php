<?php
class System_Exception extends Exception
{
    const ALREADY_EXIST     = 1;
    const VALIDATE_ERROR    = 2;
    const ERROR_CREATE_USER = 3;
    const INVALID_LOGIN     = 4;
    const NOT_FOUND         = 5;
    const FILE_ERROR        = 6;
    const FILE_EXIST        = 7;
}