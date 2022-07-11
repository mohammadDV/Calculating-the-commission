<?php

namespace App\Services\PaymentHandler\Interfaces;

interface PaymentHandler {

    public function setNext(PaymentHandler $handler): PaymentHandler;

    public function handle(array $payments): ?float;
}
