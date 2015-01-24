<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   AuthClient
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2014 Hendrik Obermayer
 */


/**
 * Namespace
 */
namespace AuthClient;


/**
 * Class AuthProvider
 *
 * @copyright  2014 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
abstract class AuthProvider extends \System
{
    protected $server_address;
    protected $public_id;
    protected $private_key;
    protected $auth_server_id;
    protected $server_key;


    public function __construct() {

    }

    public function setAuthServerId($auth_server_id) {
        $this->auth_server_id = $auth_server_id;
    }

    public function setServerAddress($server_address) {
        $this->server_address = $server_address;
    }

    public function setPublicId($public_id) {
        $this->public_id = $public_id;
    }

    public function setPrivateKey($private_key) {
        $this->private_key = $private_key;
    }

    public function setServerKey($server_key) {
        $this->server_key = $server_key;
    }
    public function getServerKey() {
        return $this->server_key;
    }

    public function run() {
        $this->runRequest();
    }

    public function getReturnUrl() {
        return $this->Environment->url . $this->Environment->requestUri . '?authid=' . $this->auth_server_id;
    }

    public function onSubmitDcForm($dc) {
        return;
    }

    public function getAuthServerInfo($value, $dc) {
        return $value;
    }

}
