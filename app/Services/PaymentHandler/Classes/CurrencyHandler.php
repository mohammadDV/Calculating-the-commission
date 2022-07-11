<?php


namespace App\Services\PaymentHandler\Classes;

use Exception;
use Illuminate\Support\Facades\Http;

class CurrencyHandler {

    public static $currencies   = null;
    private $default            = [
            "EUR"           => 1,
            "USD"           => 1.1497, // 1.018589
            "JPY"           => 129.53, // 138.620145
        ];

    private function __construct()
    {
        self::$currencies = $this->get_data();
    }

    public static function get() {
        if (empty(self::$currencies)){
            new CurrencyHandler();
        }

        return self::$currencies;
    }

     /**
     * Preparing the currencies.
     *
     * @return float
     */

    protected function get_data() : array {
        $currencies = [];
        
        try {
            $response = Http::get("http://api.exchangeratesapi.io/v1/latest?access_key=" . Config("payment.access_key"));
            $result = json_decode($response->getBody(),true);
            if ($result["success"] === true){
                $currencies = !empty($result["rates"]) ? $result["rates"] : [];
            }
        }catch(Exception $e) {
            $currencies = $this->default;
        }

        return $currencies;
    }
}