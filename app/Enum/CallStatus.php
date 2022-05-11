<?php

namespace App\Enum;

enum CallStatus: string {
    case QUEUED = "QUEUED";
    case POSITIVE = "POSITIVE";
    case UNANSWERED = "UNANSWERED";
    case BUSY = "BUSY";
}