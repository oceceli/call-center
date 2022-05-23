<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = Auth::user();

        // kullanıcı adminse tüm izinleri gönderiyorum
        $userPermissions = $user && $user->isAdmin() ? array_column(Role::getAvailablePerms(), 'value') : $user?->getAllPermissions()->pluck('name')->toArray();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
                'all_permissions' => $userPermissions,
                'role' => $user?->mainRole(),

                // dd($request->user()->append([$request->user()->roles->first()]))
            ],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                    'failures' => $request->session()->get('failures'),
                ];
            },
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
        ]);
    }
}
