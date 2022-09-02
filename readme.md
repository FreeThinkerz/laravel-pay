# Laravel MeSomb

Laravel Wrapper on top of MeSomb Payment API

## Roadmap

API Features and their implementations [https://mesomb.hachther.com/en/api/schema/](https://mesomb.hachther.com/en/api/schema/)

| Feature              | Status  |
| -------------------- | ------- |
| Payment              | &#9745; |
| Transaction Status   | &#9745; |
| Application Status   | &#9745; |
| Deposits             | &#9745; |
| Test                 | &#9744; |
| Better Documentation | &#9744; |

## Installation

Install Package

```shell
composer require hachther/laravel-mesomb
```

Publish Configuration Files

```shell
php artisan vendor:publish --tag=mesomb-configuration
```

Sign up and Create new Application at [https://mesomb.hachther.com/](https://mesomb.hachther.com/). Provide appropriate from your dashboard configure for the `config/mesomb.php`;

```php
<?php

return [

    /**
     * Api Version
     *
     * @var string
     */
    'version' => 'v1.0',

    /**
     * MeSomb Application Key
     * Copy from https://mesomb.hachther.com/en/applications/{id}
     *
     * @var string
     */
    'key' => env('MESOMB_APP_KEY'),

    /**
     * MeSomb API Application Key
     * Copy from https://mesomb.hachther.com/en/applications/{id}
     *
     * @var string
     */
    'api_key' => env('MESOMB_API_KEY'),

    /**
     * PIN used for MeSomb Pin
     * Configure @ https://mesomb.hachther.com/en/applications/{id}/settings/setpin/
     *
     * @var int|string
     */
    'pin' => env('MESOMB_PIN', null),

    /**
     * Supported Payment Methods
     *
     * @var array
     */
    'currencies' => ['XAF', 'XOF'],

    /**
     * Support Payment Methods
     * Array in order of preference
     *
     * @var array
     */
    'services' => ['MTN', 'ORANGE', 'AIRTEL'],

    /**
     * Set to True if your application uses uuid instead auto-incrmenting ids
     *
     * @var bool
     */
    'uses_uuid' => false,


    /*
     * Used to store the application Status
     */
    'application_cache_key' => 'mesomb_application_status',

    /*
     * You can choose to wait till the application to wait till the payment is approved
     * or queue the payment request check later
     * enum: asynchronous, synchronous

     */
    'mode' => 'synchronous',

    'throw_exceptions' => true,
];

```

Migrate Mesomb Transaction Tables

```shell
php artisan migrate
```

## Usage

### Payments

Examples

1. Simple Payments

    ```php
    // OrderController.php
    use Hachther\MeSomb\Payment;

    class OrderController extends Controller {

        public function confirmOrder()
        {
            $request = new Payment('67xxxxxxx', 1000, 'MTN', 'CM');

            $payment = $request->pay();

            if($payment->success){
                // Fire some event,Pay someone, Alert user
            } else {
                // fire some event, redirect to error page
            }

            // get Transactions details $payment->transactions
        }
    }
    ```

2. Attaching Payments to Models Directly

    ```php

    // Order.php

    use Hachther\MeSomb\Helper\HasPayments;

    class Order extends Model
    {
        use HasPayments;
    }

    // OrderController.php

    class OrderController extends Controller {

        public function confirmOrder(){

            $order = Order::create(['amount' => 100]);

            $payment  = $order->payment('67xxxxxxx', $order->amount, 'MTN', 'CM')->pay();

            if($payment->success){
                // Fire some event,Pay someone, Alert user
            } else {
                // fire some event, redirect to error page
            }

            // View Order payments via $order->payments

            // Get payment transaction with $payment->transaction

            return $payment;
        }
    }
    ```

#### Author

Hachther LLC
[contact@hachther.com](contact@hachther.com)

Thank you to Malico ([hi@malico.me](hi@malico.me)) for starting this module.
