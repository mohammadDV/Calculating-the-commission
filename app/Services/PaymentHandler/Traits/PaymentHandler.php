<?php

namespace App\Services\PaymentHandler\Traits;

trait PaymentHandler  {
    /**
     * Change and exchange currency.
     *
     * @return float (amount) of currency
     */
    protected function convert(float $amount,string $currency, int $type = 1): float
    {
        if(empty($this->currencies[$currency])) {
            throw new \Exception($currency . ' is not in currency list (exchangeratesapi).',1012);
        }
        if ($type == 1){
            $amount = $amount / $this->currencies[$currency];
        }else{
            $amount = $amount * $this->currencies[$currency];
        }
        return $amount;
    }
    
    /**
     * Rounding the float.
     *
     * @return float 
     */
    protected function round_float($val): float{
        return floatval(round($val + 0.004,2,2));
    }

}
