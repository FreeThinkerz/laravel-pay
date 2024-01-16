<?php

namespace FreeThinkerz\LaravelPay\Helper;

use Exception;
use FreeThinkerz\LaravelPay\Builder\PaymentBuilder;
use Illuminate\Support\Str;

trait HasPayments
{
    /**
     * Model Collect.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments()
    {
        return $this->morphMany(\FreeThinkerz\LaravelPay\Model\Payment::class, 'payable');
    }

    /**
     * Make Collect.
     *
     * @param string|null $payer
     * @param float|int|null $amount
     * @param string|null $service
     *
     * @return PaymentBuilder
     */
    public function payment(string $payer = null, float|int $amount = null, string $service = null): PaymentBuilder
    {
        return new PaymentBuilder($this, $payer, $amount);
    }
}
