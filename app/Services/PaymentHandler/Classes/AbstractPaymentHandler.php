<?php
namespace App\Services\PaymentHandler\Classes;

use App\Services\PaymentHandler\Interfaces\PaymentHandler;

abstract class AbstractPaymentHandler implements PaymentHandler {

    private   $nextHandler;
    protected $mainCurrency;
    protected $currencies = [];

    public function setNext(PaymentHandler $handler): PaymentHandler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(array $payment) : ?float
    {
        if ($this->nextHandler){
            return $this->nextHandler->handle($payment);
        }

        return null;
    }

}
