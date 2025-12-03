<?php

/**
 * PHPMailer Exception class.
 * PHP Version 5.5.
 */

namespace PHPMailer\PHPMailer;

class Exception extends \Exception
{
    /**
     * Prettify error message output.
     *
     * @return string
     */
    public function errorMessage()
    {
        return '<strong>' . htmlspecialchars($this->getMessage(), ENT_COMPAT, 'UTF-8') . "</strong><br />\n";
    }
}
