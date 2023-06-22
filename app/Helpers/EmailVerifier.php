<?php

namespace App\Helpers;

class EmailVerifier
{
    public static function isValidEmail($email)
    {
        $result = false;
        //check valid email address by regular expression
        if (!preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/', $email)) {
            return $result;
        }

        //check valid MX record
        list($name, $domain) = explode('@', $email);
        if (!checkdnsrr($domain, 'MX')) {
            return $result;
        }

        //check SMTP query
        $max_conn_time = 3000;
        $sock = '';
        $port = 25;
        $max_read_time = 5;
        $users = $name;
        $hosts = array();
        $mxweights = array();
        getmxrr($domain, $hosts, $mxweights);
        $mxs = array_combine($hosts, $mxweights);
        asort($mxs, SORT_NUMERIC);
        $mxs[$domain] = 100;
        $timeout = $max_conn_time / count($mxs);

        //try to check each host
        foreach (array_keys($mxs) as $host) {
            #connect to SMTP server
            try {
                if ($sock = @fsockopen($host, $port, $errno, $errstr, (float) $timeout)) {
                    stream_set_timeout($sock, $max_read_time);
                    break;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        //get TCP socket
        if ($sock) {
            $reply = fread($sock, 2082);
            preg_match('/^([0-9]{3}) /ims', $reply, $matches);
            $code = isset($matches[1]) ? $matches[1] : '';
            if ($code != '220') {
                return $result;
            }
            //initial SMTP connection
            $msg = "HELO " . $domain;
            fwrite($sock, $msg . "\r\n");
            $reply = fread($sock, 2082);

            //sender call
            $msg = "MAIL FROM: <" . $name . '@' . $domain . ">";
            fwrite($sock, $msg . "\r\n");
            $reply = fread($sock, 2082);

            //ask to receiver
            $msg = "RCPT TO: <" . $name . '@' . $domain . ">";
            fwrite($sock, $msg . "\r\n");
            $reply = fread($sock, 2082);

            //get response
            preg_match('/^([0-9]{3}) /ims', $reply, $matches);
            $code = isset($matches[1]) ? $matches[1] : '';

            if ($code == '250') {
                // email address accepted : 250
                $result = true;
            } elseif ($code == '451' || $code == '452') {
                //email address greylisted : 451
                $result = true;
            } else {
                $result = false;
            }

            //quit SMTP connection
            $msg = "quit";
            fwrite($sock, $msg . "\r\n");
            //close socket
            fclose($sock);
        }
        return $result;
    }
}
