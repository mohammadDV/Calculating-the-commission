<?php

namespace Tests\Unit;

use App\Services\PaymentHandler\PaymentHandlerService;
use Tests\TestCase;

class CommissionTest extends TestCase
{
    /**
     * testing calculate deposit operation type.
     *
     * @return void
     */

    public function test_calculate_deposit_operation_type()
    {
        $this->withExceptionHandling();
        $data       = array(
            [
                "op_type"   => "deposit",
                "user_id"   => "1",
                "user_type" => "private",
                "amount"    => "200.00",
                "date"      => "2020-12-15",
                "currency"  => "EUR"
            ],
            [
                "op_type"   => "deposit",
                "user_id"   => "1",
                "user_type" => "private",
                "amount"    => "10000.00",
                "date"      => "2020-12-14",
                "currency"  => "EUR"
            ]
        );

        $service    = new PaymentHandlerService($data);
        $result     = $service->run();

        $this->assertEquals($result,[0.06,3.0]);

    }
    /**
     * testing calculate withdraw operation type (private,business).
     *
     * @return void
     */
    public function test_calculate_withdraw_operation()
    {
        $this->withExceptionHandling();
        $data       = array(
            [
                "op_type"   => "withdraw",
                "user_id"   => "1",
                "user_type" => "private",
                "amount"    => "100.00",
                "date"      => "2014-12-31",
                "currency"  => "EUR"
            ],[
                "op_type"   => "withdraw",
                "user_id"   => "1",
                "user_type" => "private",
                "amount"    => "100.00",
                "date"      => "2014-12-31",
                "currency"  => "EUR"
            ],[
                "op_type"   => "withdraw",
                "user_id"   => "1",
                "user_type" => "private",
                "amount"    => "100.00",
                "date"      => "2014-12-31",
                "currency"  => "EUR"
            ],[
                "op_type"   => "withdraw",
                "user_id"   => "1",
                "user_type" => "private",
                "amount"    => "100.00",
                "date"      => "2014-12-31",
                "currency"  => "EUR"
            ],[
                "op_type"   => "withdraw",
                "user_id"   => "1",
                "user_type" => "private",
                "amount"    => "100.00",
                "date"      => "2014-12-31",
                "currency"  => "EUR"
            ]
        );
        $service    = new PaymentHandlerService($data);
        $result     = $service->run();
        $this->assertEquals($result,[0,0,0,0.3,0.3]);

    }

}
