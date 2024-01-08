<?php

namespace FreeThinkerz\LaravelPay\Builder;

use FreeThinkerz\LaravelPay\Operation\Payment\Deposit;
use FreeThinkerz\LaravelPay\Helper\DepositData;

class DepositBuilder
{
    use DepositData;

    /**
     * Collect Owner Model.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $owner;

    public function __construct($owner, $receiver, $amount, $service = null)
    {
        $this->owner = $owner;

        $this->receiver = $receiver;
        $this->amount = $amount;
        $this->service = $service;
    }

    /**
     * Make Deposit.
     *
     * @return \FreeThinkerz\LaravelPay\Model\Deposit
     */
    public function pay()
    {
        $deposit = (new Deposit(
            $this->receiver,
            $this->amount,
            $this->service
        ))->pay();

        $this->owner->deposits()->save($deposit);

        return $deposit;
    }
}
