<?php

namespace App\Listeners;

use App\Events\ComplainHelpdeskAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailComplainHelpdeskAction
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
     * @param  ComplainHelpdeskAction  $event
     * @return void
     */
    public function handle(ComplainHelpdeskAction $event)
    {
        /*dapatkan nama pengadu */
        $complain_id = $event->complain->complain_id;

        /*dapatkan nama pengadu */
        $complain_name = $event->complain->user->name;

        /*dapatkan emel pengadu */
        $complain_email = $event->complain->user->email;

        $complain_detail = $event->complain->complain_description;

        /*dapatkan status aduan */
        $complain_status_id = $event->complain->complain_status_id;
        $complain_action_coment = $event->complain->action_comment;
        $complain_status = $event->complain->complain_status->description;

        $ketua_unit = $event->complain->unit_no->ketua_unit->email;

//        dd($complain_status);
        /*dapatkan email ICTHelpdesk */

        $helpdesk_email = 'hafizullah@zakat.com.my';
        $data = [
            'complain_id'=>$complain_id,
            'complain_name'=>$complain_name,
            'complain_email'=>$complain_email,
            'complain_detail'=>$complain_detail,
            'complain_status'=>$complain_status,
            'complain_status_id'=>$complain_status_id,
            'ketua_unit'=>$ketua_unit,
            'complain_action_coment'=>$complain_action_coment,

        ];

        if($complain_status_id==3)
        {
            Mail::send('complains.email.complain_helpdesk_action', $data,function ($message) use ($data,$complain_email,$complain_name,$helpdesk_email)
            {

                $message->from($helpdesk_email, 'ICT Helpdesk');
                $message->to($complain_email,$complain_name )->subject('Aduan sedang diproses');
            });

        }

        elseif($complain_status_id==7)
        {
            Mail::send('complains.email.complain_helpdesk_manage', $data,function ($message) use ($data,$complain_email,$complain_name,$helpdesk_email,$ketua_unit)
            {
                $message->from($helpdesk_email, $complain_name);
                $message->to($ketua_unit, 'Ketua/Pengurus Unit')->subject('Aduan Baru');
            });
        }
        elseif($complain_status_id==5)
        {
            Mail::send('complains.email.complain_helpdesk_tutup', $data,function ($message) use ($data,$complain_email,$complain_name,$helpdesk_email)
            {
                $message->from($helpdesk_email,'ICT Helpdesk');
                $message->to($complain_email, $complain_name)->subject('Aduan Ditutup');
               
            });
        }


    }
}
