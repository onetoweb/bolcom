<?php

namespace Onetoweb\Bolcom\Config;

enum AcceptType: string
{
    case JSON = 'json';
    case CSV = 'csv';
    case PDF = 'pdf';
}
