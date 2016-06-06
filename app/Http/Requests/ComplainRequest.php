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
                return ['complain_description'=>'required'];
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
                    );

                    if($this->hide_dropdown_category=='Y')
                    {
                        array_pull($validation_rules,'complain_category_id');
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
        ];
    }
}
