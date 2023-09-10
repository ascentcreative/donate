<?php

namespace AscentCreative\Donate\Commands;

use Illuminate\Console\Command;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use AscentCreative\Checkout\Models\Order;
use AscentCreative\Checkout\Models\OrderItem;
use AscentCreative\Checkout\Models\Customer;
use AscentCreative\Checkout\Models\Shipping\Shipment;
use AscentCreative\Checkout\Models\Shipping\ShipmentItem;
use AscentCreative\Store\Models\Product;
use App\Models\User;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donate:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs Setup / Init tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        dump('Creating Stripe Product');

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
          );
        
        $prod = $stripe->products->create([
            'name' => 'Website Donations',
        ]);

        dump($prod);

        $settings = app(\AscentCreative\Donate\Settings\DonateSettings::class);
        $settings->stripe_product_id = $prod->id;
        $settings->save();

        return 0;
    }
}
