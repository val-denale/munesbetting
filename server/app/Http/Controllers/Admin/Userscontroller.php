<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SportResource;
use App\Http\Resources\PredictionResource;
use App\Http\Resources\UserResource;
use App\Models\Prognoses;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Userscontroller extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all()->sortDesc());
    }

    public function show($id, Request $request)
    {
        return UserResource::make(User::findOrFail($id));
    }

    public function createSubscription($id, Request $request) {

        $request->validate([
            'endDate' => 'required'
        ]);

        $user = User::findOrFail($id);

        $user->newSubscription('default', 'price_1LG0MKJ7yLDEwD6vuFzQQ318')->create(null);

        $user->subscription('default')->cancelAt(Carbon::parse($request->endDate));
    }
}
