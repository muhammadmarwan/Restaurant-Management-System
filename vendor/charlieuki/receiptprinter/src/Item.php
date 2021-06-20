<?php

namespace charlieuki\ReceiptPrinter;

class Item
{
    private $name;
    private $qty;
    private $price;
    private $currency = 'Rp';

    function __construct($name, $qty, $price) {
        $this->name = $name;
        $this->qty = $qty;
        $this->price = $price;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getQty() {
        return $this->qty;
    }

    public function getPrice() {
        return $this->price;
    }

    public function __toString()
    {
        $right_cols = 10;
        $left_cols = 2;

        $item_price = number_format($this->price, 2, '.', '.');
        $item_subtotal = $item_price * $this->qty;
        $resultSub = number_format($item_subtotal, 2, '.', '.');

        $print_name = str_pad($this->name, 28) ;
        $print_priceqty = str_pad($item_price . ' x ' . $this->qty, $left_cols);
        $print_subtotal = str_pad($resultSub, $right_cols, ' ', STR_PAD_LEFT);

        return "$print_name"."$print_priceqty$print_subtotal\n";
    }
}