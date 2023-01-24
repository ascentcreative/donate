<?php

namespace AscentCreative\Donate\StackEditor\TypeDescriptors;

use AscentCreative\StackEditor\TypeDescriptors\AbstractDescriptor; 

use Illuminate\Database\Eloquent\Model;

class DonationForm extends AbstractDescriptor { 

    public static $name = 'Donation Form';

    public static $bladePath = 'donation-form';

    public static $description = "Includes a Donation Form - requires a Stripe account";

    public static $category = "Donations";

    public function extractText(Model $model, array $block) {

       return "Donate to [Sitename] via credit card.";

    }

}   