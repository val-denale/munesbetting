<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PlanResource::collection(Plan::where('buyable', true)->orderBy('price', 'asc')->get());
    }

    public function show($slug): PlanResource
    {
        return PlanResource::make(Plan::where('slug', $slug)->where('buyable', true)->firstOrFail());
    }
}
