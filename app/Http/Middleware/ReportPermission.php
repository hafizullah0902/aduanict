<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Zizaco\Entrust\Entrust;


class ReportPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route_name = Route::currentRouteName();
//        $route_parameters = $request->route()->parameters();

        if ($route_name == 'reports.monthly_statistic_aduan ') {
            $this->check_entrust_permission('statistic_chart', $request);

        }

        if ($route_name == 'reports.monthly_statistic_table_aduan ') {
            $this->check_entrust_permission('statistic_table', $request);

        }

        return $next($request);
    }


    function check_entrust_permission($permission_name, $request)
    {
        if (!Entrust::can($permission_name)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                abort(403, 'Access Denied');
            }
        }
    }
}
