<?php

namespace AldoZumaran\Acl\Facades;

use Illuminate\Support\Facades\Facade;

class Acl extends Facade
{
    protected static function getFacadeAccessor() { return 'Acl'; }
}