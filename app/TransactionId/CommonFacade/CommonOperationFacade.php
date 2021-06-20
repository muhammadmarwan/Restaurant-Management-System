<?php
/**
 * Created by PhpStorm.
 * User: beacon
 * Date: 19/9/19
 * Time: 2:17 PM
 */

namespace App\TransactionId\CommonFacade;
use Illuminate\Support\Facades\Facade;

class CommonOperationFacade  extends Facade
{
    protected static function getFacadeAccessor() {

        return 'CommonFacade';
    }
}