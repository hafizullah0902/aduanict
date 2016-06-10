<?php

namespace App\Listeners;

use App\Events\ComplainCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailComplainCreated
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
     * @param  ComplainCreated  $event
     * @return void
     */
    public function handle(ComplainCreated $event)
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

//        dd($complain_status);
        /*dapatkan email ICTHelpdesk */

        $helpdesk_email = 'hafizullah@zakat.com.my';
        $data = [
            'complain_id'=>$complain_id,
            'complain_name'=>$complain_name,
            'complain_email'=>$complain_email,
            'complain_detail'=>$complain_detail,
            'complain_status'=>$complain_status,

        ];

       

        Mail::queue('complains.email.complain_created', $data,function ($message) use ($data,$complain_email,$complain_name,$helpdesk_email)
        {

            $message->from($complain_email, $complain_name);
            $message->to($helpdesk_email, 'ICT Helpdesk')->subject('Aduan Baru');
        });
        
    }
}
