<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateDonateSettings extends SettingsMigration
{
    public function up(): void
    {
     

        try{
            $this->migrator->add('donate.enable_giftaid', 0);
        } catch (Exception $e) {
            // skip - exists
        }

       

    }

    public function down() {


        try{
            $this->migrator->delete('donate.enable_giftaid');

        } catch (Exception $e) {

        }



    }

}
