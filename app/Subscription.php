<?php

namespace App;

use Hyn\Tenancy\Traits\UsesSystemConnection;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    use UsesSystemConnection;    
}
