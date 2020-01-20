<?php

namespace App;

use Symfony\Component\HttpFoundation\Cookie;

class XfilCookie extends Cookie
{
    public function __construct($uuid)
    {
        parent::__construct('XFIL', $uuid);
        $this->domain='';
        $this->httpOnly = false;
        $this->path = '/';
    }

    private function generateCode()
    {
        return 12345;
    }
}