<?php

namespace App\Http\Middleware;

use App\Complain;
use Closure;
use Illuminate\Support\Facades\Auth;
use Route;
use Entrust;

class ComplainPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//        if (env('APP_ENV') === 'testing') {
//            return $next($request);
//        }

        $route_name = Route::currentRouteName();
        $route_parameters = $request->route()->parameters();

        /* Aduan*/

        if ($route_name == 'complain.create' || $route_name == 'complain.store') {
            $this->check_entrust_permission('create_complain', $request);

        }

        if ($route_name == 'complain.edit' || $route_name == 'complain.update') {
            $this->check_entrust_permission('edit_complain', $request);

            $complain_id =$route_parameters['complain'];
            $complain = Complain::find($complain_id);

            if($complain->complain_status_id==1)
            {
                if(Auth::user()->emp_id !=$complain->register_user_id && Auth::user()->emp_id !=$complain->user_emp_id)
                {
                    $this->access_denied($request);
                }
            }

        }

        /* helpdesk */
        if ($route_name == 'complain.destroy') {
            $this->check_entrust_permission('delete_complain', $request);

        }

        if ($route_name == 'complain.action' || $route_name == 'complain.update_action') {
            $this->check_entrust_permission('action_complain', $request);

        }

        /* Technical */
        if ($route_name == 'complain.technical_action' || $route_name == 'complain.update_technical_action') {
            $this->check_entrust_permission('technical_action', $request);

//            dd($route_parameters);
            $complain_id =$route_parameters['complain'];
            $complain = Complain::find($complain_id);

            if($complain->complain_status_id==2)
            {
                if(Auth::user()->id !=$complain->register_user_id && Auth::user()->emp_id !=$complain->action_emp_id)
                {
                    $this->access_denied($request);
                }
            }

        }

        /* Manager */
        if ($route_name == 'complain.assign_staff' || $route_name == 'complain.update_assign_staff') {
            $this->check_entrust_permission('assign_technical_staff', $request);

        }

        /* Verify */
        if ($route_name == 'complain.verify') {
            $this->check_entrust_permission('verify_complain', $request);

            $complain_id =$route_parameters['complain'];
            $complain = Complain::find($complain_id);

            if($complain->complain_status_id==4)
            {
                if(Auth::user()->id !=$complain->register_user_id && Auth::user()->emp_id !=$complain->user_emp_id)
                {
                    $this->access_denied($request);
                }
            }
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

    function access_denied($request)
    {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                abort(403, 'Access Denied');
            }
    }

}