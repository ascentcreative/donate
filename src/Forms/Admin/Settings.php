<?php
namespace AscentCreative\Donate\Forms\Admin;

use AscentCreative\Forms\Form;
use AscentCreative\Forms\Fields\Checkbox;
use AscentCreative\Forms\Fields\Input;

class Settings extends Form {

    public function __construct() {

        // parent::__construct();

        $this->children([
            Checkbox::make('enable_giftaid', 'Enable GiftAid on Donations')
                // ->labelAfter(true)
                ->wrapper('inline')
                ->uncheckedValue(0),
        ]);

    }

}