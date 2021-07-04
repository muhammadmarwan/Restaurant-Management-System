<?php

namespace charlieuki\ReceiptPrinter;

class ReportItems
{
    private $name;
    private $qty;
    private $price;

    function __construct($name, $qty, $price) {
        $this->name = $name;
        $this->qty = $qty;
        $this->price = $price;
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
        $left_cols = 5;

        $item_price = number_format($this->price, 2);
    
        $print_name = str_pad($this->name, 31) ;
        $print_priceqty = str_pad($this->qty, $left_cols);
        $print_subtotal = str_pad($item_price, $right_cols, ' ', STR_PAD_LEFT);

        return "$print_name"."$print_priceqty$print_subtotal\n";
    }
}
