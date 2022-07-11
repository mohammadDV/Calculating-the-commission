<?php

return [
    "access_key"        => "5aaa9b5908cd8c49d3fb8d361473c09f",
    "dir_file"          => "files/payment.csv",
    "commission"        => array(
        'deposit'       => 0.0003,
        'withdraw'      => array(
            "private"   => 0.003,
            "business"  => 0.005,
        ),
    ),
    "currencies"        => ["EUR", "USD", "JPY"],
    "max_amount"        => 1000,
    "max_count"         => 3,
    "main_currency"     => "EUR",
];
