<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BetStateEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\PredictionResource;
use App\Models\Bet;
use App\Models\Prognoses;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PredictionsController extends Controller
{
    public function index()
    {
        return PredictionResource::collection(Prognoses::all()->sortDesc());
    }

    public function show($id)
    {
        return PredictionResource::make(Prognoses::findOrFail($id));
    }

    public function store(Request $request)
    {
        $rules = [
            'analyse' => 'required',
            'bets.*.name' => 'required',
            'bets.*.odd' => 'required',
            'bets.*.sport' => 'required|exists:sports,id',
            'bets.*.state' => ['required', new Enum(BetStateEnum::class)],
        ];

        if (count($request->bets) > 1) {
            $rules['name'] = 'required';
        }


        $request->validate($rules);

        $pronostic = Prognoses::create([
            'name' => $request->name,
            'free' => $request->free,
            'analyse' => $request->analyse
        ]);

        $bets = [];

        foreach ($request->bets as $bet) {
            $newBet = new Bet();
            $newBet->name = $bet['name'];
            $newBet->odd = $bet['odd'];
            $newBet->sport_id = $bet['sport'];
            $newBet->prognoses_id = $pronostic->id;
            $newBet->state = $bet['state'];
            $newBet->save();
            $bets[] = $newBet;
        }

        if (count($bets) === 1) {
            foreach ($bets as $bet) {
                $pronostic->name = $bet['name'];
                $pronostic->save();
            }
        }


        $pronostic->bets()->saveMany($bets);

        $odds = [];

        foreach ($bets as $bet) {
            $odds[] = $bet->odd;
        }

        $pronostic->total_odd = array_sum($odds);
        $pronostic->syncCurrentState();
        $pronostic->save();
    }

    public function update($id, Request $request)
    {
        $prognoses = Prognoses::findOrFail($id);

        $prognoses->name = $request->name;
        $prognoses->free = $request->free;
        $prognoses->analyse = $request->analyse;

        foreach ($request->bets as $bet) {
            $actualBet = Bet::findOrFail($bet['id']);

            if ($bet) {
                $actualBet->name = $bet['name'];
                $actualBet->odd = $bet['odd'];
                $actualBet->sport_id = $bet['sport']['id'];
                $actualBet->state = $bet['state'];
                $actualBet->update();
            } else {
                $newBet = new Bet();
                $newBet->name = $bet['name'];
                $newBet->odd = $bet['odd'];
                $newBet->sport_id = $bet['sport']['id'];
                $newBet->prognoses_id = $prognoses->id;
                $newBet->state = $bet['state'];
                $newBet->save();
            }
        }

        $prognoses->syncCurrentState();
        $prognoses->save();
    }
}
