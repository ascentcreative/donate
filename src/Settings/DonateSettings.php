<?php

namespace AscentCreative\Donate\Settings;

use Spatie\LaravelSettings\Settings;

class DonateSettings extends Settings
{
 
    public ?int $enable_giftaid;

    public ?string $stripe_product_id;

   
    public static function group(): string
    {
        return 'donate';
    }

}