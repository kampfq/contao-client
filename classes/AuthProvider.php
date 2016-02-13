<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   SuperLogin
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2016 Hendrik Obermayer
 */


/**
 * Namespace
 */
namespace SuperLogin;


/**
 * Class AuthProvider
 *
 * @copyright  2014 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
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
    protected $serverId;
    protected $server_key;


    public function __construct() {

    }

    public function setServerId($serverId) {
        $this->serverId = $serverId;
    }

    public function setServerAddress($server_address) {
        $this->server_address = $server_address;
    }

    public function setPublicId($public_id) {
        $this->public_id = $public_id;
    }

    public function run() {
        $this->runRequest();
    }

    public function onSubmitDcForm($dc) {
        return;
    }
}
