<?php

namespace App\Services\PaymentHandler\Classes;

use App\Services\PaymentHandler\Traits\PaymentHandler;

class DepositHandler extends AbstractPaymentHandler {

    use PaymentHandler;

    protected $depositFee;

    public function __construct()
    {
        $this->depositFee   = Config("payment.commission.deposit");
        $this->mainCurrency = Config("payment.main_currency");
        $this->currencies   = CurrencyHandler::get();
    }

    /**
     * Handle deposite .
     *
     * @return float
     */
    public function handle(array $payment) : ?float
    {
      if(strtolower($payment['op_type']) != 'deposit'){ return parent::handle($payment);}

      return $this->round_float($payment["amount"] * $this->depositFee);
    }

}
