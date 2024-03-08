<?php

namespace App\Enums\RealEstate;

enum Equipment: int
{
    case full = 1;
    case part = 2;
    case none = 3;
}