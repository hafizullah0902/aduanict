<?php

namespace App\Helpers;

    use Illuminate\Support\Facades\Auth;
    use Entrust;

    class Helper
    {
        public static function get_status_panel($status)
        {
            if ($status == 1)
                $status = '<span class="label label-primary">Baru</span>';
            elseif ($status == 2)
                $status = '<span class="label label-info">Tindakan</span>';
            elseif ($status == 3)
                $status = '<span class="label label-success">Sahkan (P)</span>';
            elseif ($status == 4)
                $status = '<span class="label label-success">Sahkan (H)</span>';
            elseif ($status == 5)
                $status = '<span class="label label-success">Selesai</span>';
            elseif ($status == 7)
                $status = '<span class="label label-warning">Agihan</span>';

            return $status;
        }

        public static function get_function_button($rekodcomplain)
        {

            if($rekodcomplain->complain_status_id== 1)
            {
                if(Entrust::can("action_complain")&& Entrust::hasRole("ict_helpdesk"))
                {
                    $url_link= route("complain.action",$rekodcomplain->complain_id);

                    $function_button='<a href=" '.$url_link.'" class="btn btn-warning">
                                                <span class="glyphicon glyphicon-wrench"></span> Kemaskini</a>';
                }
                elseif (Entrust::can("edit_complain")&& ($rekodcomplain->user_id==Auth::user()->emp_id || $rekodcomplain->user_emp_id==Auth::user()->emp_id))
                {
                    $url_link= route("complain.edit",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.'" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>';
                }
                else
                {
                    $url_link= route("complain.show",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.' "class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
                }
                if (Entrust::can("delete_complain"))
                {
                    $function_button= $function_button.' '.'<button type="button" class="btn btn-danger glyphicon glyphicon-trash" data-destroy> Padam </button> ';
                }

            }

            elseif($rekodcomplain->complain_status_id== 2 && $rekodcomplain->action_emp_id == Auth::user()->emp_id)
            {
                if(Entrust::can("technical_action"))
                {
                    $url_link= route("complain.technical_action",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.' "class="glyphicon glyphicon-pencil" role="button">Tindakan</a>';
                }
                elseif( Entrust::can("action_complain"))
                {
                    $url_link= route("complain.action",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.' " class="btn btn-warning">
                                                <span class="glyphicon glyphicon-wrench"></span> Kemaskini</a>';
                }
                else
                {
                    $url_link= route("complain.show",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.' "class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
                }
            }

            elseif($rekodcomplain->complain_status_id== 3)
            {
                if(Entrust::can("verify_complain")&& ($rekodcomplain->user_id==Auth::user()->emp_id || $rekodcomplain->user_emp_id==Auth::user()->emp_id))
                {
                    $url_link= route("complain.edit",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.' " class="btn btn-success">
                                                <span class="glyphicon glyphicon-copy"></span> Pengesahan(P)</a>';
                }
                else
                {
                    $url_link= route("complain.show",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.' " class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
                }
            }

            elseif($rekodcomplain->complain_status_id== 4)
            {
                if(Entrust::can("action_complain")&& Entrust::hasRole("ict_helpdesk"))
                {
                    $url_link= route("complain.action",$rekodcomplain->complain_id);
                    $function_button='<a href=" '.$url_link.' " class="btn btn-success">
                                                <span class="glyphicon glyphicon-copy"></span> Pengesahan(H)</a>';
                }

                else
                    $url_link= route("complain.show",$rekodcomplain->complain_id) ;
                    $function_button='<a href=" '.$url_link.' " class="btn btn-info">
                                                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
            }

            elseif($rekodcomplain->complain_status_id== 6)
            {
                $function_button='';
            }
            else
            {
                $url_link= route("complain.show",$rekodcomplain->complain_id);
                $function_button='<a href=" '.$url_link.' " class="btn btn-info">
                                            <span class="glyphicon glyphicon-eye-open"></span> Papar</a> ';
            }

            return $function_button;

        }






    }