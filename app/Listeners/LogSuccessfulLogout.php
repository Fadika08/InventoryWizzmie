<?php

namespace App\Listeners;

use App\Services\ActivityLogService;
use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
{
    public function __construct(
        private ActivityLogService $activityLogService
    ) {
    }

    public function handle(Logout $event): void
    {
        if (!$event->user) {
            return;
        }

        $this->activityLogService->log(
            'LOGOUT',
            'Authentication',
            "User {$event->user->name} berhasil logout.",
            $event->user
        );
    }
}