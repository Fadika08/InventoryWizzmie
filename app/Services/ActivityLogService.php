<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    public function log(
        string $action,
        string $module,
        string $description,
        ?Model $subject = null,
        ?array $oldData = null,
        ?array $newData = null
    ): ActivityLog {

        return ActivityLog::create([
            'user_id' => Auth::id(),

            'action' => $action,

            'module' => $module,

            'description' => $description,

            'subject_type' => $subject
                ? $subject->getMorphClass()
                : null,

            'subject_id' => $subject?->getKey(),

            'old_data' => $oldData,

            'new_data' => $newData,

            'ip_address' => Request::ip(),

            'user_agent' => Request::userAgent(),

            'created_at' => now(),
        ]);
    }
}
