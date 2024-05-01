<?php

namespace App\Enums;

enum Sort: string
{
    case newest = "newest";
    case oldest = 'oldest';
    case cheapest = 'most cheaper';
    case mostExpensive = 'most expensive';
}