<?php

namespace App\Enums;

enum Filter: string
{
    case newest = "newest";
    case oldest = 'oldest';
    case cheapest = 'most cheaper';
    case mostExpensive = 'most expensive';
}