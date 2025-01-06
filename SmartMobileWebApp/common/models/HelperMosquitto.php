<?php

namespace common\models;

use Bluerhinos\phpMQTT;

class HelperMosquitto
{
    public static function FazPublishNoMosquitto($canal,$msg, $qos = 0 )
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = "root"; // set your username
        $password = ""; // set your password
        $client_id = "phpMQTT-publisher"; // unique!
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password))
        {
            $mqtt->publish($canal, $msg, $qos);
            $mqtt->close();

        }

    }
}