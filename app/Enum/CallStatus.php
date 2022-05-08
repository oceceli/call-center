<?php

namespace App\Enum;

enum CallStatus: string {
    case Queued = "queued";
    case Positive = "positive";
    case Negative = "negative";
    case Busy = "busy";
}