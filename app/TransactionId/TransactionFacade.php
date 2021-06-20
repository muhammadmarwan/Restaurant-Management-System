<?php


namespace App\TransactionId;


use Illuminate\Support\Facades\Facade;

class TransactionFacade extends Facade
{

    protected static function getFacadeAccessor() {

        return 'TransactionId';
    }

}