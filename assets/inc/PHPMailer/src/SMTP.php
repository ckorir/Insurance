<?php

/**
 * PHPMailer SMTP class.
 */

namespace PHPMailer\PHPMailer;

class SMTP
{
    const VERSION = '6.9';
    const LE = "\r\n";

    public $do_debug = 0;
    public $Debugoutput = 'echo';

    protected $smtp_conn;
    protected $error = [];
    protected $server_caps = [];
    protected $timeout = 300;

    public function __construct()
    {
        $this->smtp_conn = null;
    }

    public function connect($host, $port = 25, $timeout = 30, $options = [])
    {
        $this->smtp_conn = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$this->smtp_conn) {
            $this->setError("Failed to connect to server: $errno : $errstr");
            return false;
        }
        return true;
    }

    public function startTLS()
    {
        return true;
    }

    public function authenticate($username, $password)
    {
        return true;
    }

    public function close()
    {
        if ($this->smtp_conn) {
            fclose($this->smtp_conn);
            $this->smtp_conn = null;
        }
    }

    protected function setError($message)
    {
        $this->error[] = $message;
    }

    public function getError()
    {
        return $this->error;
    }
}
