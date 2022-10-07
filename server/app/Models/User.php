<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
        'free_access' => 'boolean'
    ];

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function plan(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            Plan::class, Subscription::class,
            'user_id', 'stripe_id', 'id', 'stripe_price'
        )
            ->whereNull('subscriptions.ends_at')
            ->withDefault(Plan::free()->toArray());
    }

    public function subscribed($name = 'default', $price = null)
    {
        $subscription = $this->subscription($name);

        if ($this->free_access) {
            return true;
        }

        if ($this->isAdmin()) {
            return true;
        }

        if (! $subscription || ! $subscription->valid()) {
            return false;
        }

        return ! $price || $subscription->hasPrice($price);
    }

    public function getNextBillingDate()
    {
        if (!$this->subscription()){
            return null;
        }

        return Carbon::createFromTimestamp($this->subscription()->asStripeSubscription()->current_period_end)->format('d/m/Y');
    }

}
