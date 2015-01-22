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
 * @copyright  2015 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
class ClcPlusAuthProvider extends AuthProvider
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

        if ($requestHash && $responseHash && $generationTime)
        {
            $client = $this->getClcClient();

            if (
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

    public function onSubmitDcForm($dc)
    {
        if ($dc->activeRecord->server_key != '')
        {
            $keyPath = $dc->activeRecord->server_key;

            if (!is_array($dc->activeRecord->server_key)) {
                $keyPath = unserialize($keyPath);
            }

            if(empty($keyPath[0])) {
                throw new \Exception('Couldn´t get cert file path!');
            }

            $keyPath = trim(TL_ROOT . '/' . $keyPath[0]);

            $strKey = file_get_contents($keyPath);
            unlink($keyPath);

            $authServer = \AuthClientServerModel::findById($dc->activeRecord->id);
            $authServer->server_key = $strKey;

            // OpenSSL
            $arrCert = @openssl_x509_parse($strKey);
            if(is_array($arrCert)) {
                $certName = $arrCert['subject']['O'];

                if(isset($arrCert['subject']['OU']) &&  $arrCert['subject']['OU'] != '') {
                    $certName .= ' | ' . $arrCert['subject']['OU'];
                }

                $authServer->name = $certName;
                $authServer->validTo = $arrCert['validTo_time_t'];

            }
            else {
                throw new \Exception('Error reading cert file!');
            }

            // Save auth server model
            $authServer->save();
        }
        else {
            throw new \Exception('Certification file is empty!');
        }
    }

    public function getAuthServerInfo($value, $dc) {
        $authServer = \AuthClientServerModel::findById($dc->activeRecord->id);
        $arrInfo = array();

        if($authServer->server_key != '') {
            $arrCert = @openssl_x509_parse($authServer->server_key);
            $arrInfo[] = $arrCert['extensions']['subjectKeyIdentifier'];
            $arrInfo[] = $arrCert['subject']['O'] . ' | '.$arrCert['subject']['OU'];
            $arrInfo[] = $arrCert['subject']['L'].' - '.$arrCert['subject']['ST'].' - '.$arrCert['subject']['C'];
            $arrInfo[] = $arrCert['subject']['CN'];
            $arrInfo[] = 'VALID:'.date('d-m-Y', (int) $authServer->validTo);
        }

        return implode("\n", $arrInfo);
    }
}