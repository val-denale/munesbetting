<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeIntentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function __invoke(Request $request)
    {
        return [
            'data' => [
                'client_secret' => $request->user()->createSetupIntent()->client_secret
            ]
        ];
    }
}
