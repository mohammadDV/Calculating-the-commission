<?php

namespace App\Services\PaymentHandler;

use App\Services\PaymentHandler\Classes\DepositHandler;
use App\Services\PaymentHandler\Classes\WithdrawHandler;
use App\Services\PaymentHandler\Interfaces\PaymentHandler;
use App\Services\PaymentHandler\Traits\FileHandler;

class PaymentHandlerService {

    use FileHandler;

    protected $depositHandler   = null;
    protected $withdrawHandler  = null;
    protected $result           = [];
    protected $payments         = [];

    /**
     * Preparing models and set properties.
     *
     * @return void
     */
    public function __construct(array $payments = [])
    {
         $this->depositHandler  = new DepositHandler();
         $this->withdrawHandler = new WithdrawHandler();
         $this->payments        = !empty($payments) ? $payments : $this->read_file(Config("payment.dir_file"));
    }

    /**
     * Preparing data for show response.
     *
     * @return void
     */
    private function process(PaymentHandler $paymentHandler,$payments)
    {
        foreach ($payments as $payment) {
            $this->result[] = $paymentHandler->handle($payment);
        }
    }

    /**
     * Execute chain of Responsibility and run main service.
     *
     * @return array
     */
    public function run() : array
    {
        $this->depositHandler->setNext($this->withdrawHandler);
        $this->process($this->depositHandler,$this->payments);
        return $this->result;
    }
}
