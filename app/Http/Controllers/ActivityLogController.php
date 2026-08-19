<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $action = $request->input('action');
        $module = $request->input('module');

        $logs = ActivityLog::query()
            ->with('user')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query->where(
                        'description',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas(
                        'user',
                        function ($query) use ($search) {

                            $query->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );

                });

            })

            ->when($action, function ($query) use ($action) {

                $query->where(
                    'action',
                    $action
                );

            })

            ->when($module, function ($query) use ($module) {

                $query->where(
                    'module',
                    $module
                );

            })

            ->latest('created_at')

            ->paginate(20)

            ->withQueryString();

        return view(
            'activity-logs.index',
            compact(
                'logs',
                'search',
                'action',
                'module'
            )
        );
    }
}
