<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode\Http\Middleware;

use Statamic\Support\Str;
use Wahlemedia\StatamicMaintenanceMode\MaintenanceMode;

class HandleMaintenanceMode
{
    /**
     * Check if the maintenance mode is activated and handle
     * the request accordingly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $url = Str::start($request->getRequestUri(), '/');
        $maintenance = app(MaintenanceMode::class);

        /**
         * If user is a super user or has permission to access the control panel,
         * the request will be passed to the next middleware.
         */

        /** @var \App\Models\User */
        $user = auth()->user();

        if ($user?->isSuper() || $user?->hasPermission('access cp')) {
            return $next($request);
        }

        /**
         * If maintenance mode is not activated, the request will be passed to the next middleware.
         */
        if ($maintenance->isNotActivated()) {
            return $next($request);
        }

        /**
         * If the request is for the maintenance page and the maintenance mode is not activated,
         * redirect the user back to the home page.
         */
        if ($maintenance->isNotActivated() && $maintenance->isMaintenancePage($url)) {
            return redirect('/', 302);
        }

        /**
         * If the request is for a whitelisted site and the maintenance mode is activated,
         * the request will be passed to the next middleware.
         */
        if ($maintenance->isActivated() && $maintenance->isWhitelistedPage($url)) {
            return $next($request);
        }

        /**
         * If the request is not for the maintenance page and the maintenance mode is activated,
         * redirect the user to the maintenance page.
         */
        if ($maintenance->isActivated() && $maintenance->isNotMaintenancePage($url)) {
            return redirect($maintenance->getPageUri(), 302);
        }

        /** Should not be reachable */
        return $next($request);
    }
}
