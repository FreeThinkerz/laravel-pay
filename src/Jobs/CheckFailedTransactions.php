<?php

namespace Hachther\MeSomb\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Hachther\MeSomb\Transaction;

class CheckFailedTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Transaction Model.
     *
     * @var \Hachther\MeSomb\Model\Deposit|\Hachther\MeSomb\Model\Payment
     */
    protected $model;

    /**
     * Create a new job instance.
     *
     * @param \Hachther\MeSomb\Model\Payment $model
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transaction = Transaction::checkStatus($this->model);

        if ($transaction->successful()) {
            $this->model->toggleToSuccess();
        }
    }
}
