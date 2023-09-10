<?php

namespace AscentCreative\Donate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;

use AscentCreative\Transact\Contracts\iSubscribable;
use AscentCreative\Transact\Contracts\iTransactable;

use Carbon\Carbon;

/**
 * A model to represent a confirmed order.
 */
class DonationProfile extends Model implements iSubscribable, iTransactable
{
    use HasFactory;
    
    /*
    * Uses a global scope to ensure we never include un-completed orders (baskets) when requesting orders
    */
    public $table = "donate_profiles"; 
   
    public $fillable = ['uuid', 'donor_name', 'donor_email', 'amount', 'recur', 'user_id'];


    protected static function booted() {

        static::saving(function($model) {
            if(!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });

    }


    // iTransactable
    public function getTransactionAmount():float {
        return $this->amount;
    }

    public function onTransactionComplete() {
        
    }



    // iSubscribable
    public function getSubscriptionAmount():float {
        return $this->amount;
    }

    public function onSubscriptionComplete() {

    }

    public function onRecurringPayment() {

    }


    // rather than anything specific to this model, 
    // we'll get the product ID as stored in the settings
    public function getStripeProductId():string {
        return app(\AscentCreative\Donate\Settings\DonateSettings::class)->stripe_product_id;   
    }


    public function getSubscriptionItems():array {

        // return [
        //     'price' => 'price_1N9U3GHZw0ztnS0JIwYvPwSQ',
        // ];

        return [
            'price_data' => [
                'product' => $this->getStripeProductId(),
                    'currency'=>'GBP',
                    'recurring'=>[
                        'interval'=>$this->getInterval(),
                        'interval_count'=>$this->getIntervalCount()
                    ],
                    'unit_amount'=>$this->getSubscriptionAmount() * 100
            ]
        ];

    }

    public function getIterations():int {
        return 0;
    }

    public function getInterval():string {
        switch ($this->recur) {
            case 'M':
                return 'month';
                break;
            default:
                throw new \Exception('Not a recurring donation');
        }
    }
    
    public function getIntervalCount():int {
        return 1;
    }

    public function getCustomerName():string {
        return $this->donor_name;
    }

    public function getCustomerEmail():string {
        return $this->donor_email;
    }



}
