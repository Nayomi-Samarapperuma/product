<?php

namespace domain\Facades\ProductFacade;

use domain\Services\ProductService\ProductService;
use Illuminate\Support\Facades\Facade;

/**
 * Product Facade
 * php version 8
 *
 * @category Facade
 * @author   CyberElysium <contact@cyberelysium.com>
 * @license  https://cyberelysium.com Config
 * @link     https://cyberelysium.com
 * */
class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ProductService::class;
    }
}
