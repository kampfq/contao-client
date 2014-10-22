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

use Comolo\Extra\ClcClient;


/**
 * Class ClcAuthProvider
 *
 * @copyright  2014 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
class ClcAuthProvider extends AuthProvider
{
    protected $client;

    protected function getClcClient()
    {
        $this->client = new ClcClient($this->server_address, $this->public_id, $this->private_key);
        return $this->client;
    }

    public function runRequest()
    {
        $client = $this->getClcClient();
        $client->setClientUrl($this->getReturnUrl());

        $requestUrl = $client->generateRequestUrl();

        // Save timestamp to session
        $genTimestamp = $client->getGenerationTimestamp();
        $_SESSION['clc_gen_timestamp'] = $genTimestamp;

        // Forward
        header("Location: " . $requestUrl);
        exit;
    }

    public function checkResponse()
    {
        $requestHash = \Input::get('rqh');
        $responseHash = \Input::get('rsh');
        $responseData = (\Input::get('rdata')) ? \Input::get('rdata') : urldecode(\Input::post('rdata'));

        $generationTime = (isset($_SESSION['clc_gen_timestamp'])) ? $_SESSION['clc_gen_timestamp'] : false;

        if($requestHash && $responseHash && $generationTime)
        {
            $client = $this->getClcClient();

            if(
                true === $client->checkRequestHash($requestHash, $generationTime) &&
                true === $client->checkResponseHash($responseHash, $requestHash, $responseData)
            ) {
                return unserialize($responseData);
            }
            else {
                throw new \Exception('Invalid response data!');
                return false;
            }
        }
    }
}