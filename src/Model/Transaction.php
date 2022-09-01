<?php

namespace Hachther\MeSomb\Model;

use Illuminate\Database\Eloquent\Model;
use Hachther\MeSomb\Helper\ModelUUID;

class Transaction extends Model
{
    use ModelUUID;

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
     * Guarded Properties.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Transaction Model Table.
     *
     * @var string
     */
    protected $table = 'mesomb_transactions';

    /**
     * Model Morph.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function transacable()
    {
        return $this->morphTo();
    }

    /**
     * Check if Transaction is Successful.
     *
     * @return bool
     */
    public function successful()
    {
        return $this->status == 'SUCCESS' ? true : false;
    }
}
