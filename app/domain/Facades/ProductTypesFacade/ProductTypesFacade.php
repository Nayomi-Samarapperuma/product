<?php

namespace domain\Facades\ProductTypesFacade;

use domain\Services\ProductTypesService\ProductTypesService;
use Illuminate\Support\Facades\Facade;

/**
 * ProductTypes Facade
 * php version 8
 *
 * @category Facade
 * @author   CyberElysium <contact@cyberelysium.com>
 * @license  https://cyberelysium.com Config
 * @link     https://cyberelysium.com
 * */
class ProductTypesFacade extends Facade
{    
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return ProductTypesService::class;
    }
}
