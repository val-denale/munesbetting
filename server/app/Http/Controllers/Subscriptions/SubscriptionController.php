<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['subscribed'])->only('update', 'cancel');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'plan' => ['nullable', 'exists:plans,slug'],
            'token' => ['required']
        ]);

        $plan = Plan::whereSlug($request->get('plan', '1-mois'))->first();

        $request->user()->newSubscription('default', $plan->stripe_id)
            ->create($request->token);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'plan' => ['required', 'exists:plans,slug'],
        ]);

        $plan = Plan::whereSlug($request->plan)->first();

        if (!$plan->buyable) {
            $request->user()->subscription('default')->cancel();
            return;
        }

        $request->user()->subscription('default')->swap($plan->stripe_id);
    }

    public function cancel(Request $request) {
        if ($request->user()->subscribed()){
            return $request->user()->subscription('default')->cancel();
        }
    }

    public function invoices(Request $request)
    {
        return InvoiceResource::collection($request->user()->invoices());
    }
}
