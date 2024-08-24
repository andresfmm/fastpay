<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProccessPaymentFacade extends Facade {

    protected static function getFacadeAccessor()
    {

        return 'ProccessPaymentFacade';

    }

}