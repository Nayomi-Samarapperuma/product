<?php

namespace domain\Facades\ProductInventryFacade;

use domain\Services\ProductInventryService\ProductInventryService;
use Illuminate\Support\Facades\Facade;

class ProductInventryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ProductInventryService::class;
    }
}
