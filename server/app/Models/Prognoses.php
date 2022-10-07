<?php

namespace App\Models;

use App\Enums\BetStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prognoses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'free',
        'analyse'
    ];

    protected $casts = [
        'free' => 'boolean',
        'published' => 'boolean'
    ];

    public function isFree() {
        if ($this->free) {
            return true;
        }

        return false;
    }

    public function bets() {
        return $this->hasMany(Bet::class);
    }

    public function syncCurrentState()
    {
        $states = [];

        foreach ($this->bets()->get() as $bet) {
            $states[] = $bet->state->value;
        }

        // Check if prediction is lose

        if (in_array(BetStateEnum::LOSE->value, $states)) {
            $this->current_state = BetStateEnum::LOSE->value;
            $this->save();
            return BetStateEnum::LOSE->value;
        }

        // Check if prediction is win

        if (array_unique($states) === [BetStateEnum::WIN->value]) {
            $this->current_state = BetStateEnum::WIN->value;
            $this->save();
            return BetStateEnum::WIN->value;
        }

        // Check if prediction is in progress

        if (!in_array(BetStateEnum::LOSE->value, $states)) {
            $this->current_state = BetStateEnum::IN_PROGRESS->value;
            $this->save();
            return BetStateEnum::IN_PROGRESS->value;
        }
    }
}
