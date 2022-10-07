<?php

namespace App\Models;

use App\Enums\BetStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'odd'];

    protected $casts = [
        'state' => BetStateEnum::class
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function prognosis(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Prognoses::class);
    }
}
