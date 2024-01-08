<?php

namespace FreeThinkerz\LaravelPay\Jobs;

use FreeThinkerz\LaravelPay\Model\Deposit;
use FreeThinkerz\LaravelPay\Model\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use FreeThinkerz\LaravelPay\Operation\Payment\Transaction;

class CheckFailedTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Transaction Model.
     *
     * @var Deposit|Payment
     */
    protected $model;

    /**
     * Create a new job instance.
     *
     * @param Payment $model
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
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle()
    {
        $transactions = Transaction::checkStatus($this->model);

        foreach ($transactions as $transaction) {
            if ($transaction->successful()) {
                $this->model->toggleToSuccess();
            }
        }
    }
}
