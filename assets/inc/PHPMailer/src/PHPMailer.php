<?php

namespace PHPMailer\PHPMailer;

class PHPMailer
{
    const VERSION = '6.9';

    public $isSMTP = false;
    public $Host;
    public $SMTPAuth = false;
    public $Username;
    public $Password;
    public $SMTPSecure;
    public $Port;
    public $From;
    public $FromName;
    public $Subject;
    public $Body;
    public $AltBody = '';
    public $isHTML = false;

    protected $addresses = [];
    protected $replyTo = [];

    protected $smtp;

    public function __construct($exceptions = false)
    {
        $this->smtp = new SMTP();
    }

    public function isSMTP()
    {
        $this->isSMTP = true;
    }

    public function setFrom($address, $name = '')
    {
        $this->From = $address;
        $this->FromName = $name;
    }

    public function addAddress($address, $name = '')
    {
        $this->addresses[] = [$address, $name];
    }

    public function addReplyTo($address, $name = '')
    {
        $this->replyTo[] = [$address, $name];
    }

    public function isHTML($isHtml = true)
    {
        $this->isHTML = $isHtml;
    }

    public function send()
    {
        if ($this->isSMTP) {
            return $this->smtpSend();
        }
        return $this->mailSend();
    }

    protected function smtpSend()
    {
        if (!$this->smtp->connect($this->Host, $this->Port)) {
            throw new Exception('SMTP connection failed: ' . implode(', ', $this->smtp->getError()));
        }

        if ($this->SMTPAuth) {
            if (!$this->smtp->authenticate($this->Username, $this->Password)) {
                throw new Exception('SMTP authentication failed');
            }
        }

        $this->smtp->close();
        return true;
    }

    protected function mailSend()
    {
        $headers = "From: {$this->FromName} <{$this->From}>\r\n";
        if ($this->isHTML) {
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        }
        return mail($this->addresses[0][0], $this->Subject, $this->Body, $headers);
    }
}
