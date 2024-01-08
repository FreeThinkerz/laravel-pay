<?php

namespace FreeThinkerz\LaravelPay\Helper;

use FreeThinkerz\LaravelPay\Builder\DepositBuilder;

trait HasDeposits
{
    /**
     * Model Deposits.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function deposits()
    {
        return $this->morphMany('FreeThinkerz\LaravelPay\Model\Deposit', 'depositable');
    }

    /**
     * Make Deposit.
     *
     * @param string|null $receiver
     * @param float|int|null $amount
     *
     * @return DepositBuilder
     */
    public function deposit(string $receiver = null, float|int $amount = null, string $service = null): DepositBuilder
    {
        return new DepositBuilder($this, $receiver, $amount, $service);
    }
}
