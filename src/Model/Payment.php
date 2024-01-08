<?php

namespace FreeThinkerz\LaravelPay\Model;

use Illuminate\Database\Eloquent\Model;
use FreeThinkerz\LaravelPay\Helper\{HasDeposits, HasTransactions, ModelUUID};

class Payment extends Model
{
    use HasDeposits, HasTransactions, ModelUUID;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Payment Model Table.
     *
     * @var string
     */
    protected $table = 'mesomb_payments';

    /**
     * Guarded Properties.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Payable Morph.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function payable()
    {
        return $this->morphTo();
    }

    /**
     * Refund Payment.
     *
     * @return null|\FreeThinkerz\LaravelPay\Model\Deposit
     */
    public function refund()
    {
        if ($this->success && $this->transaction->successful()) {
            return $this->deposit($this->payer, $this->transaction->amount)->pay();
        }
    }
}
