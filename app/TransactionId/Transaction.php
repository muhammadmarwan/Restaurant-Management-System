<?php


namespace App\TransactionId;
use App\Syncronization;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;

class Transaction extends Facade
{


    /**
     * Function test is for checking weather the facade is
     * working or not.
     */
    public function test(){
        echo Config::get('systemConfig.serverUrl');
    }

    /**
     * Funcation name : SyncWithoutNotification
     * @param : $syncData,
     * @return:
     * $syncData will contain all the details for synching the data to the server
     * like table name, type of transaction, notification enabled or not , transaction id etc
     * This function uses curl for get and post data from server. all the data should be send as json.
     * if the server is down data will be saved to Syncronizations table,  which will be synced with server by
     * cron job or any other method.
     * $url is generated from config file (systemConfig)
     *
     */
    public static function SyncWithoutNotification($syncData){



        Log::info("delete");
        $url = Config::get('systemConfig.serverUrl').Config::get('systemConfig.apiUrl.syncWithoutNotification');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($syncData));
        $result = curl_exec($ch);


        if (curl_error($ch)) {

            $error_msg = curl_error($ch);
            Log::info("if(ch)");


        }

        if (isset($error_msg)) {

            Log::info("varuuna vazhi with errors");
            Log::info($error_msg);
            /**
             *
             * This case handles when server is down and local user try to create a new record, edit a record
             * or delete a record. change will reflect in local database, to take change in server the sync table
             * need to be synchronized
             *
             */

            $syncronisation = new Syncronization();
            $syncronisation->type = 222;
            $syncronisation->transaction_id = json_encode(222);
            $syncronisation->table = json_encode(222);
            $syncronisation->data = json_encode(222);
//            $syncronisation->type = json_encode(222);
            $syncronisation->notification_applicable = false;
            $syncronisation->save();

//            $syncronisation = new Syncronization();
//            $syncronisation->type = $syncData['type'];
//            $syncronisation->transaction_id = $syncData['data']['transaction_id'];
//            $syncronisation->table = $syncData['table'];
//            $syncronisation->data = $syncData['data'];
//            $syncronisation->type = $syncData['type'];
//            $syncronisation->notification_applicable = false;
//            $syncronisation->save();

            Log::info("synchranisationsss");
            Log::info($syncData['type']);

            return json_encode(array("status"=>444,
                "message"=>"Server is not available, data will updated once server is available",
                'desc'=>$syncData['data']['transaction_id'].' Entry created successfully for synchronization'));

        }
        else
        {
            Log::info("varuuna vazhi with No  errors");
            return $result;

        }
    }

    /**
     * Funcation name : SyncWithNotification
     * @param : $syncData,
     * @return:
     * $syncData will contain all the details for synching the data to the server
     * like table name, type of transaction, notification enabled or not , transaction id etc
     * This function uses curl for get and post data from server. all the data should be send as json.
     * if the server is down data will be saved to Syncronizations table,  which will be synced with server by
     * cron job or any other method.
     * $url is generated from config file (systemConfig)
     *
     */
       public static function SyncWithNotification($syncData){
        $url = Config::get('systemConfig.serverUrl').Config::get('systemConfig.apiUrl.syncWithNotification');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($syncData));
        $result = curl_exec($ch);

        if (curl_error($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);
        if (isset($error_msg)) {

            /**
             * This case handles when server is down and local user try to create a new record, edit a record
             * or delete a record. change will reflect in local database, to take change in server the sync table
             * need to be synchronized
             *
             */
            $syncronisation = new Syncronization();
            $syncronisation->type = $syncData['type'];
            $syncronisation->transaction_id = $syncData['data']['transaction_id'];
            $syncronisation->table = $syncData['table'];
            $syncronisation->data = $syncData['data'];
            $syncronisation->type = $syncData['type'];
            $syncronisation->notification_applicable = true;
            $syncronisation->notification_type = $syncData['notification_type'];
            $syncronisation->notification_message = \GuzzleHttp\json_encode($syncData['notification_message']);
            $syncronisation->notification_catagory =$syncData['notification_catagory'];
            $syncronisation->save();
            return json_encode(array("status"=>444,
                "message"=>"Server is not available, data will updated once server is available",
                'desc'=>$syncData['data']['transaction_id'].' Entry created successfully for synchronization'));

        }else

        {

            return $result;

        }
    }

    /**
     * This function will generate unique id , which can be used for each transaction
     * @params $transactionPrefix : This is set in systemConfig file in config/systemConfig.php
     * @params $current_timestamp : which will provide epoch of time now
     * @params uniquid : this is generic function in php
     * combination this three will generate a unique id which will not be recreated because it uses epoch
     */
    public static function setTransactionId(){


        $current_timestamp = Carbon::now()->timestamp;
        $uniqid = Config::get('systemConfig.transactionPrefix') .$current_timestamp. uniqid();
        return $uniqid;
    }
}