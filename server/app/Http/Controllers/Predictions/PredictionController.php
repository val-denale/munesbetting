<?php

namespace App\Http\Controllers\Predictions;

use App\Http\Controllers\Controller;
use App\Http\Resources\PredictionResource;
use App\Models\Prognoses;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->subscribed()) {
            return PredictionResource::collection(Prognoses::where('published', true)->orderBy('created_at', 'desc')->get());
        }


        $free = collect(Prognoses::where('free', true)->get());
        $premium_terminated = collect(Prognoses::where('free', false)->where('current_state', 'win')->orWhere('current_state', 'lose')->get());

        $final = $free->merge($premium_terminated)->unique();



        return [
            "premium_in_progress" => Prognoses::where('free', false)->where('current_state', 'progress')->count(),
            "data" => PredictionResource::collection($final)
        ];
    }

    public function lastPrediction()
    {
        $bet = collect(Prognoses::where('current_state', 'win')->orWhere('current_state', 'lose')->orderBy('created_at', 'desc')->get());

        return PredictionResource::collection($bet)->take(3);
    }
}
