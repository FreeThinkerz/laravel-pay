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
        return new PaymentBuilder($this, $payer, $amount, $service ?? $this->getPaymentServiceFromPhone($payer));
    }

    /**
     *  Get the payment service from from the phone number
     */
    public function getPaymentServiceFromPhone(string $phone): string | Exception
    {
        if (Str::match('/^(?:\+237|237)?6(?:5[0-4]|[87][0-9])\d{6}$/', $phone)) {
            return 'MTN';
        } elseif (Str::match('/^(?:\+237|237)?6(?:5[5-9]|[9][0-9])\d{6}$/', $phone)) {
            return 'Orange';
        } else {
            throw new Exception("Invalid Payment Number: {$phone}");
        }
    }
}
