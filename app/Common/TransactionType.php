<?php
/**
 * Created by PhpStorm.
 * User: beacon
 * Date: 20/8/19
 * Time: 3:51 PM
 */

namespace App\Common;


class TransactionType
{

    const payment=1;
    const purchase=2;
    const purchaseInventory=3;
    const journalEntry=4;
    const payableAccount=5;
    const purchaseReturn=6;
    const sale=7;

}