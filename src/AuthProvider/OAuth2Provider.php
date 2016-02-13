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
namespace Comolo\SuperLoginClient\ContaoEdition\AuthProvider;

use Comolo\SuperLoginClient\ContaoEdition\Model\SuperLoginServerModel;
use League\OAuth2\Client\Provider\GenericProvider as OAuth2GenericProvider;

/**
 * Class ClcAuthProvider
 *
 * @copyright  2015 Hendrik Obermayer
 * @author     Hendrik Obermayer - Comolo GmbH
 * @package    Devtools
 */
class OAuth2Provider extends AuthProvider
{
    /**
     * called when the backend form was saved
     * check certificate and write it to the database
     *
     * @param $dc
     * @return bool
     * @throws \Exception
     */
    public function onSubmitDcForm($dc)
    {
       /*
            // Request Public id
            $authServer->public_id = $this->requestPublicId(
                $authServer->server_address,
                $arrCert['extensions']['subjectKeyIdentifier'],
                $_SERVER['SERVER_NAME'],
                isset($GLOBALS['TL_CONFIG']['websiteTitle'])
                    ? $GLOBALS['TL_CONFIG']['websiteTitle']
                    : $_SERVER['SERVER_NAME']
            );

            // Save auth server model
            $authServer->save();
            */
    }


    /**
     * request a public id for this client
     *
     * @param $serverUrl string url of the superlogin server
     * @param $certificateHash hash hash of the server certificate
     * @param $domain domain domain of this website
     * @param $websiteTitle title title of this website
     *
     * @return string public id
     * @throws \Exception could not get public id from server
     */
    protected function requestPublicId($serverUrl, $certificateHash, $domain, $websiteTitle) {
        /*
        // add register to server url
        $serverUrl .= '/register';

        // data to post
        $postData = array(
            'name' => $websiteTitle,
            'type' => $GLOBALS['AUTH_CLIENT']['type'], // contao
            'version' => $GLOBALS['AUTH_CLIENT']['version'],
            'certificateHash' => $certificateHash,
            'domain' => $domain
        );

        // send post data curl-less
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($postData),
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($serverUrl, false, $context);

        // Check result
        if(substr($result, 0, 4) == "*ID:"
            && substr($result, -1, 1) == "*"
            && strlen($result) < 40)
        {
            return substr($result, 4, -1);
        }

        throw new \Exception("Could not get public id! Error: " . htmlentities($result));
        */
    }
}