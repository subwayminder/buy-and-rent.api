<?php

namespace App\Services\Auth\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class TokenDTO extends Data
{
    public string $access_token;
    public Carbon $expired_at;
    public string $refresh_token;
}