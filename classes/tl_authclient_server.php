<?php
/**
 * Created by PhpStorm.
 * User: hendrik
 * Date: 22.01.15
 * Time: 22:55
 */

namespace AuthClient;


class tl_authclient_server
{
    public function onSubmit($dc) {
        $obj = new $dc->activeRecord->auth_provider();
        $obj->onSubmitDcForm($dc);
    }

    public function doNotSave()
    {
        return null;
    }

    public function getAuthServerInfo($value, $dc)
    {
        if($dc->activeRecord->auth_provider != '')
        {
            $obj = new $dc->activeRecord->auth_provider();
            return $obj->getAuthServerInfo($value, $dc);
        }

        return $value;
    }
}