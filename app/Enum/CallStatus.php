<?php

namespace App\Enum;

enum CallStatus: string {
    case Queued = "QUEUED";
    case Positive = "POSITIVE";
    case Busy = "BUSY";
}