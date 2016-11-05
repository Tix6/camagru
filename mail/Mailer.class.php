<?php

abstract class Mailer {

    private function __construct() {}

    protected static function _html_headers() {
        $headers   = array();
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: Admin <admin@camagru.com>';
        return implode("\r\n", $headers);
    }

    /* Sending mail using php builtin requires that message in the mail never exceeds 70 chars by lines */
    private static function _wrap($msg) {
        return wordwrap($msg, 70, "\r\n");
    }

    public static function send($dest, $title, $message) {
        mail($dest, $title, self::_wrap($message), self::_html_headers());
    }
}

?>
