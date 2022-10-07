<?php

namespace App\Enums;

enum BetStateEnum: String {
    case IN_PROGRESS = "progress";
    case WIN = "win";
    case LOSE = "lose";
}
