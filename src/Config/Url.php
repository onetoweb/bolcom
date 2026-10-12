<?php

namespace Onetoweb\Bolcom\Config;

enum Url: string
{
    case BASE = 'https://api.bol.com';
    case LOGIN = 'https://login.bol.com/token';
}
