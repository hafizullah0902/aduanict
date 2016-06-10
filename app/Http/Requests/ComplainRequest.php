<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ComplainRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route_name = $this->route()->getName();
        switch($this->method()){
            case 'POST' : {
                $validation_rules = array(
                    'complain_category_id'=>'required',
                    'complain_source_id'=>'required',
                    'complain_description'=>'required',
                    'complain_attachment' => 'mimes:jpeg,bmp,png,pdf,doc,docs,txt,zip,rar',
                    );

                $aduan_category_exception_value = array('5','6');

                $others_field_validation = array(
                    'branch_id'=>'required',
                    'lokasi_id'=>'required',
                    'ict_no'=>'required',
                );

                $complain_category_id_exp = explode('-',$this->complain_category_id );
                $complain_category_id = $complain_category_id_exp[0];

                if(!in_array($complain_category_id,$aduan_category_exception_value))
                {
                    $validation_rules = $others_field_validation + $validation_rules;
                }

                return $validation_rules;



            }
            case 'PUT' : {
//            dd($route_name);
//
                $validation_rules=array();

                if($route_name=='complain.update')
                {
                    $validation_rules = array(
                        'complain_category_id'=> 'required',
                        'lokasi_id' => 'required',
                        'ict_no'=> 'required',
                    );

                    if($this->hide_dropdown_category=='Y')
                    {
                        array_pull($validation_rules,'complain_category_id');
                    }

                    if($this->exclude_branch_asset=='Y')
                    {
                        array_pull($validation_rules,'complain_category_id');
                        array_pull($validation_rules,'lokasi_id');
                        array_pull($validation_rules,'ict_no');
                    }
                }
                else if($route_name=='complain.update_action')
                {
                    if(!$this->has('submit_type'))
                    {
                        $validation_rules = array('complain_status_id'=> 'required',
                            'action_comment' => 'required'
                        );

                    }

                }
                else if($route_name=='complain.verify')
                {
                    if($this->submit_type =='reject')
                    {
                        $validation_rules = array('user_comment'=> 'required',

                        );

                    }

                }
                return $validation_rules;
            }
            default:break;
        }

    }

    public function messages()
    {
        return [
            'complain_description.required' => 'Aduan perlu diisi!',
            'lokasi_id.required' => 'Lokasi perlu diisi!',
            'ict_no.required' => 'Aset perlu diisi!',
            'branch_id.required' => 'Cawangan perlu diisi!',
            'complain_category_id.required' => 'Kategori perlu diisi!',
            'user_comment.required' => 'Komen perlu diisi jika tidak selesai',
        ];
    }
}
