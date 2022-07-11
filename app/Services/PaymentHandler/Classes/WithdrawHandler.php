<?php

namespace App\Services\PaymentHandler\Classes;

use App\Services\PaymentHandler\Traits\PaymentHandler;

class WithdrawHandler extends AbstractPaymentHandler {

    use PaymentHandler;

    protected $privateFee;
    protected $businessFee;
    protected $maxAmount;
    protected $maxCount;
    protected $weeklyAmount     = [];
    protected $weeklyCount      = [];

    public function __construct()
    {
        $this->maxAmount    = Config("payment.max_amount");
        $this->maxCount     = Config("payment.max_count");
        $this->privateFee   = Config("payment.commission.withdraw.private");
        $this->businessFee  = Config("payment.commission.withdraw.business");
        $this->mainCurrency = Config("payment.main_currency");
        $this->currencies   = CurrencyHandler::get();
    }

    /**
     * Handle withdraw in (private,business).
     *
     * @return float
     */
    public function handle(array $payment) : ?float
    {

        if(strtolower($payment['op_type']) != 'withdraw'){ return parent::handle($payment);}

        // withdraw operation type and private user type
        if ($payment["user_type"] == "private") { 
            $amount                     = $this->convert(floatval($payment["amount"]),$payment["currency"]);
            $uniq                       = $payment["user_id"] . "_" . date("oW", strtotime($payment["date"]));
            $this->weeklyAmount[$uniq]   = !empty($this->weeklyAmount[$uniq]) ? $this->weeklyAmount[$uniq] + $amount : $amount;
            $this->weeklyCount[$uniq]    = !empty($this->weeklyCount[$uniq]) ? $this->weeklyCount[$uniq] + 1 : 1;

            if ($this->weeklyAmount[$uniq] <= $this->maxAmount && $this->weeklyCount[$uniq] <= $this->maxCount){
                $commission = 0;
            }elseif($this->weeklyCount[$uniq] <= $this->maxCount){
                $oldWeeklyAmount        = $this->weeklyAmount[$uniq] - $amount;
                $allowedAmount          = $this->maxAmount > $oldWeeklyAmount ? $this->maxAmount - $oldWeeklyAmount : 0;
                $reducedAmount          = $amount - $allowedAmount;
                $commission             = $reducedAmount * $this->privateFee;
            }else{
                $commission = $amount * $this->privateFee;
            }

            $commission = $this->convert(floatval($commission),$payment["currency"],2);

        }else{ 
            // withdraw operation type and business user type
            $commission = $payment["amount"] * $this->businessFee;
        }

        return $this->round_float($commission);
    }

}
