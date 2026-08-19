<?php

namespace App\Listeners;

use App\Services\ActivityLogService;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    public function __construct(
        private ActivityLogService $activityLogService
    ) {
    }

    public function handle(Login $event): void
    {
        $this->activityLogService->log(
            'LOGIN',
            'Authentication',
            "User {$event->user->name} berhasil login.",
            $event->user
        );
    }
}
