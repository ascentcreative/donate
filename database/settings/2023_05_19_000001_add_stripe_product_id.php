<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddStripeProductId extends SettingsMigration
{
    public function up(): void
    {
     

        try{
            $this->migrator->add('donate.stripe_product_id', '');
        } catch (Exception $e) {
            // skip - exists
        }

       

    }

    public function down() {


        try{
            $this->migrator->delete('donate.stripe_product_id');

        } catch (Exception $e) {

        }



    }

}
