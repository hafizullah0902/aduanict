<?php

namespace App\Listeners;

use App\Events\ComplainAssignUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailAssignUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ComplainAssignUser  $event
     * @return void
     */
    public function handle(ComplainAssignUser $event)
    {
        /*dapatkan nama pengadu */
        $complain_id = $event->complain->complain_id;

        /*dapatkan nama pengadu */
        $complain_name = $event->complain->user->name;

        /*dapatkan emel pengadu */
        $complain_email = $event->complain->user->email;

        $complain_detail = $event->complain->complain_description;

        /*dapatkan status aduan */
        $complain_status = $event->complain->complain_status->description;

        $assign_user = $event->complain->action_user->email;
        $ketua_unit = $event->complain->unit_no->ketua_unit->email;

//        dd($assign_user);
        /*dapatkan email ICTHelpdesk */

        $helpdesk_email = 'hafizullah@zakat.com.my';
        $data = [
            'complain_id'=>$complain_id,
            'complain_name'=>$complain_name,
            'complain_email'=>$complain_email,
            'complain_detail'=>$complain_detail,
            'complain_status'=>$complain_status,

        ];



        Mail::queue('complains.email.complain_assign_action', $data,function ($message) use ($data,$complain_email,$complain_name,$assign_user,$ketua_unit)
        {

            $message->from($ketua_unit, 'Ketua/Pengurus Unit');
            $message->to($assign_user, 'nama Staf')->subject('Aduan Baru');
        });
    }
}
