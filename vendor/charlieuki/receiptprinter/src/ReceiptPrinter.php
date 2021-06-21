<?php

namespace charlieuki\ReceiptPrinter;

use charlieuki\ReceiptPrinter\Item as Item;
use charlieuki\ReceiptPrinter\Store as Store;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class ReceiptPrinter
{
    private $printer;
    private $logo;
    private $store;
    private $items;
    private $currency = '';
    private $subtotal = 0;
    private $tax_percentage = 10;
    private $tax = 0;
    private $grandtotal = 0;
    private $request_amount = 0;
    private $qr_code = [];
    private $transaction_id = '';
    private $type;
    private $address;
    private $code;

    function __construct() {
        $this->printer = null;
        $this->items = [];
    }

    public function close() {
        $this->printer->close();
    }

    public function init($connector_type, $connector_descriptor, $connector_port = 9100) {

        $pc = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        // $connector = new WindowsPrintConnector("smb://LAPTOP-LSIQVUUQ/SGT-88IV");

        $connector = new WindowsPrintConnector("smb://192.168.0.1/SGT-88IV");

        // $connector = new NetworkPrintConnector("192.168.80.114", 9100);
        
        // $connector = new FilePrintConnector("/dev/usb/lp0");

        // $connector = new FilePrintConnector("192.168.80.114");

        // switch (strtolower($connector_type)) {
        //     case 'cups':
        //         $connector = new CupsPrintConnector($connector_descriptor);
        //         break;
        //     case 'windows':
        //         // $ip= $_SERVER['REMOTE_ADDR'];
        //         // $connector = new WindowsPrintConnector("SGT-88IV", $_SERVER["REMOTE_ADDR"]);

        //         $connector = new WindowsPrintConnector($connector_descriptor);
        //         // smb://192.168.0.5/PrinterName
        //         break;
        //     case 'network':
        //         $connector = new NetworkPrintConnector($connector_descriptor);
        //         break;
        //     default:
        //         $connector = new FilePrintConnector("php://stdout");
        //         break;
        // }

        if ($connector) {
            // Load simple printer profile
            $profile = CapabilityProfile::load("default");
            // Connect to printer
            $this->printer = new Printer($connector, $profile);
        } else {
            throw new Exception('Invalid printer connector type. Accepted values are: cups');
        }
    }

    public function setStore($mid, $name, $address, $phone, $email, $website) {
        $this->store = new Store($mid, $name, $address, $phone, $email, $website);
    }

    public function setLogo($logo) {
        $this->logo = $logo;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function printReceiptType($type,$address,$code) {
        $this->type = $type;
        $this->details = $address;
        $this->code = $code;
    }

    public function addItem($name, $qty, $price) {
        $item = new Item($name, $qty, $price);
        $item->setCurrency($this->currency);
        
        $this->items[] = $item;
    }

    public function setRequestAmount($amount) {
        $this->request_amount = $amount;
    }

    public function setTax($tax) {
        $this->tax_percentage = $tax;
        
        if ($this->subtotal == 0) {
            $this->calculateSubtotal();
        }

        if($this->subtotal >= 5)
        {		
			$this->tax = $this->tax_percentage / 100 * $this->subtotal;
            $this->subtotal2 = $this->subtotal - $this->tax;

        }else{
        	$this->tax = 0;
            $this->subtotal2 = $this->subtotal - $this->tax;
        }
    }

    public function calculateSubtotal() {
        $this->subtotal = 0;


        foreach ($this->items as $item) {
            $this->subtotal +=  $item->getPrice() * $item->getQty();
        }
    }

    public function calculateGrandTotal() {
        if ($this->subtotal == 0) {
            $this->calculateSubtotal();
        }

        $this->grandtotal = $this->subtotal;
    }

    public function setTransactionID($transaction_id) {
        $this->transaction_id = $transaction_id;
    }

    public function setQRcode($content) {
        $this->qr_code = $content;
    }

    public function getPrintableQRcode() {
        return json_encode($this->qr_code);
    }

    public function getPrintableHeader($left_text, $right_text, $is_double_width = false) {
        $cols_width = $is_double_width ? 8 : 16;

        return str_pad($left_text, $cols_width) . str_pad($right_text, $cols_width, ' ', STR_PAD_LEFT);
    }

    public function getPrintableSummary($label, $value, $is_double_width = false) {
        $left_cols = $is_double_width ? 6 : 12;
        $right_cols = $is_double_width ? 10 : 20;

        $formatted_value = $this->currency . number_format($value, 2, '.', '.');

        return str_pad($label, $left_cols) . str_pad($formatted_value, $right_cols, ' ', STR_PAD_LEFT);
    }

    public function feed($feed = NULL) {
        $this->printer->feed($feed);
    }

    public function cut() {
        $this->printer->cut();
    }

    public function printDashedLine() {
        $line = '';

        for ($i = 0; $i < 47; $i++) {
            $line .= '=';
        }

        $this->printer->text($line);
    }

     public function printDashedLine1() {
        $line = '';

        for ($i = 0; $i < 47; $i++) {
            $line .= '-';
        }

        $this->printer->text($line);
    }

    public function printLogo() {
        if ($this->logo) {
            $image = EscposImage::load($this->logo, false);

            //$this->printer->feed();
            //$this->printer->bitImage($image);
            //$this->printer->feed();
        }
    }

    public function printQRcode() {
        if (!empty($this->qr_code)) {
            $this->printer->qrCode($this->getPrintableQRcode(), Printer::QR_ECLEVEL_L, 8);
        }
    }

    public function printReceipt($with_items = true) {
        if ($this->printer) {
            // Get total, subtotal, etc
            $subtotal = $this->getPrintableSummary('Subtotal', $this->subtotal2);
            $tax = $this->getPrintableSummary('Tax', $this->tax);
            $total = $this->getPrintableSummary('TOTAL', $this->grandtotal, true);
            $header = $this->getPrintableHeader(
                'TID: ' . $this->transaction_id,
                'MID: ' . $this->store->getMID()
            );
            $footer = "Thank you vist again!\n";
            // Init printer settings
            $this->printer->initialize();
            $this->printer->selectPrintMode();
            // Set margins
            $this->printer->setPrintLeftMargin(1);
            // Print receipt headers
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            // Print logo
            $this->printLogo();
            $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            // $this->printer->feed(2);
            $this->printer->text("{$this->store->getName()}\n");
            $this->printer->selectPrintMode();
            $this->printer->text("{$this->store->getAddress()}\n");
            $this->printer->text("{$this->store->getPhone()}\n");
            $this->printer->text($header . "\n");
            $this->printer->setBarcodeHeight(50);
            $this->printer->setBarcodeWidth(4);
            $this->printer->barcode($this->code, Printer::BARCODE_CODE39);
            $this->printer->text('#'.$this->code);
            // Print receipt title
            $this->printer->feed();
            $this->printer->setEmphasis(true);
            $this->printDashedLine();
            $this->printer->setEmphasis(false);
            // Print receipt title
            $this->printer->feed();
            $this->printer->setEmphasis(true);
            $this->printer->text("RECEIPT\n");
            $this->printer->setEmphasis(false);
            $this->printer->setEmphasis(true);
            $this->printDashedLine();
            $this->printer->feed();

            $this->printer->setEmphasis(false);

            $this->printer->text($this->type);
            $this->printer->feed();
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            if($this->type=='Delivery')
            {
                $this->printer->text('Name :' . $this->details->customer);
                $this->printer->feed();
                $this->printer->text('Address :' . $this->details->address);
                $this->printer->feed();
                $this->printer->text('Phone :' . $this->details->phone);
                $this->printer->feed();
            }
            $this->printer->setEmphasis(true);
            $this->printDashedLine1();
            $this->printer->setEmphasis(false);
            $this->printer->feed();
            // Print items
            if ($with_items) {
                $this->printer->setJustification(Printer::JUSTIFY_LEFT);
                $this->printer->setEmphasis(true);
                $this->printer->text('Item                        Qty          Amount');
                $this->printer->setEmphasis(false);
                $this->printer->feed();
                $this->printer->setEmphasis(true);
            	$this->printDashedLine1();
            	$this->printer->setEmphasis(false);
                $this->printer->feed();
                foreach ($this->items as $item) {
                    $this->printer->text($item);
                }
               
            }
            // Print subtotal
            $this->printer->setEmphasis(true);
            $this->printDashedLine1();
            $this->printer->setEmphasis(false);
            $this->printer->feed();
            $this->printer->setEmphasis(true);
            $this->printer->text($subtotal);
            $this->printer->setEmphasis(false);
            $this->printer->feed();
            // Print tax
            $this->printer->text($tax);
            $this->printer->feed();
            $this->printer->setEmphasis(true);
            $this->printDashedLine();
            $this->printer->setEmphasis(false);
            $this->printer->feed();
            // Print grand total
            $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $this->printer->text($total);
            $this->printer->feed();
            $this->printer->selectPrintMode();
            $this->printer->setEmphasis(true);
            $this->printDashedLine();
            $this->printer->setEmphasis(false);
            // Print qr code
            // Print receipt footer
            $this->printer->feed(2);
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printQRcode();
            $this->printer->feed();
            $this->printer->text($footer);
            $this->printer->feed();
            // Print receipt date
            $this->printer->text(date('j F Y H:i:s'));
            $this->printer->feed(2);
            // Cut the receipt
            $this->printer->cut();
            // $this->printer -> pulse();

            $this->printer->close();
        } else {
            throw new Exception('Printer has not been initialized.');
        }
    }

    public function printRequest() {
        if ($this->printer) {
            // Get request amount
            $total = $this->getPrintableSummary('TOTAL', $this->request_amount, true);
            $header = $this->getPrintableHeader(
                'TID: ' . $this->transaction_id,
                'MID: ' . $this->store->getMID()
            );
            $footer = "This is not a proof of payment.\n";
            // Init printer settings
            $this->printer->initialize();
            $this->printer->feed();
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            // Print logo
            $this->printLogo();
            // Print receipt headers
            //$this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            //$this->printer->text("U L T I P A Y\n");
            //$this->printer->feed();
            $this->printer->selectPrintMode();
            $this->printer->text("{$this->store->getName()}\n");
            $this->printer->text("{$this->store->getAddress()}\n");
            $this->printer->text($header . "\n");
            $this->printer->feed();
            // Print receipt title
            $this->printDashedLine();
            $this->printer->setEmphasis(true);
            $this->printer->text("PAYMENT REQUEST\n");
            $this->printer->setEmphasis(false);
            $this->printDashedLine();
            $this->printer->feed();
            // Print instruction
            $this->printer->text("Please scan the code below\nto make payment\n");
            $this->printer->feed();
            // Print qr code
            $this->printQRcode();
            $this->printer->feed();
            // Print grand total
            $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $this->printer->text($total . "\n");
            $this->printer->feed();
            $this->printer->selectPrintMode();
            // Print receipt footer
            $this->printer->feed();
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text($footer);
            $this->printer->feed();
            // Print receipt date
            $this->printer->text(date('j F Y H:i:s'));
            $this->printer->feed(2);
            // Cut the receipt
            $this->printer->cut();
            $this->printer->close();
        } else {
            throw new Exception('Printer has not been initialized.');
        }
    }
}