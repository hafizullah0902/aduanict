<?php

namespace App\Listeners;

use App\Events\ComplainUserVerify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailComplainVerify
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
     * @param  ComplainUserVerify  $event
     * @return void
     */
    public function handle(ComplainUserVerify $event)
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
        $user_comment = $event->complain->user_comment ;
        $complain_status = $event->complain->complain_status->description;
        $action_id=$event->complain->action_user->email;

        $unit_id = $event->complain->user->email;

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
            'unit_id'=>$unit_id,
            'complain_action_coment'=>$complain_action_coment,
            'user_comment'=>$user_comment,

        ];

        if($complain_status_id==4)
        {
            Mail::queue('complains.email.complain_user_verify_yes', $data,function ($message) use ($data,$complain_email,$complain_name,$helpdesk_email)
            {

                $message->from($complain_email, $complain_name);
                $message->to($helpdesk_email,'ICT Helpdesk' )->subject('Aduan Telah Diselesaikan');
            });
        }
        elseif($complain_status_id==2)
        {
            Mail::queue('complains.email.complain_user_verify_no', $data,function ($message) use ($data,$complain_email,$complain_name,$action_id)
            {

                $message->from($complain_email, $complain_name);
                $message->to($action_id,'staf Terlibat' )->subject('Aduan Tidak Dapat Diselesaikan');
            });
        }


    }
}
