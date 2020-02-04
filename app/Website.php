<?php

namespace App;

use Hyn\Tenancy\Abstracts\SystemModel;
use Hyn\Tenancy\Contracts\Website as WebsiteContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;

class Website extends SystemModel implements WebsiteContract
{
    use SoftDeletes, Billable;

    /**
    * Get all of the hostnames for the Website.
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function hostnames(): HasMany
    {
        return $this->hasMany(config('tenancy.models.hostname'));
    }

    /**
    * Get all of the subscriptions for the Website using a custom Subscription model.
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function subscriptions()
    {
	return $this->hasMany(\App\Subscription::class, $this->getForeignKey())->orderBy('created_at', 'desc');
    }
}
