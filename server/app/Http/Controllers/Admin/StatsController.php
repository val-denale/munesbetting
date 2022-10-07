<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SportResource;
use App\Http\Resources\UserResource;
use App\Models\Sport;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

class StatsController extends Controller
{
    public function index()
    {
        return [
            'users' => User::all()->count(),
            'subscriptions' => Subscription::all()->count(),
            'active_subscriptions' => Subscription::where('stripe_status', 'active')->count()
        ];
    }
}
