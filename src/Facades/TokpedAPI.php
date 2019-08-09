<?php

namespace Prasudiro\ApiTokoOnline\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Datatables.
 *
 * @package Prasudiro\ApiTokoOnline\Facades
 * @author  Kurniawan Prasetyo <prassaiyan@gmail.com>
 */
class TokpedAPI extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tokpedapi';
    }
}
