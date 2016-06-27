<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetsLocation;
use App\Branch;
use App\Complain;
use App\ComplainCategory;
use App\ComplainStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->user_id = 0;
        $this->unit_id = 0;

        if(Auth::check())
        {
            $this->user_id=Auth::user()->emp_id;
            $this->unit_id=Auth::user()->unit_id;
        }
        $this-> exclude_array =[5,6];
    }


    function get_complain_status()
    {
        $complain_status = ComplainStatus::lists('description','status_id');
        $complain_status = array(''=>'Pilih Status Aduan') + $complain_status->all();

        return $complain_status;
    }

    function get_complain_categories()
    {
       /* ================MYSQL====================
       $complain_categories = ComplainCategory::select('description', DB::raw('CONCAT(category_id, "-" , kod_unit) AS category_value'))->lists('description','category_value');
        $complain_categories = array(''=>'Pilih Kategori Aduan') + $complain_categories->all();
        return $complain_categories;*/

        /* ==============ORACLE======================*/
        $complain_categories = ComplainCategory::select('description',
            DB::raw('category_id||\'-\'|| kod_unit AS category_value'))
            ->lists('description','category_value');
        $complain_categories = array(''=>'Pilih Kategori')+$complain_categories ->all();
        return $complain_categories;

    }

    function get_location($filter=array())
    {
        if(isset($filter['branch_id']) && !empty($filter['branch_id']))
        {
            $branch_id = $filter['branch_id'];
        }

        if($this->request->has('branch_id'))
        {
            $branch_id = $this->request->input ('branch_id');
        }

        if(empty($branch_id))
        {
            $validation_branch_id = $this->request->old('branch_id');
            $branch_id = $validation_branch_id;
        }

        if(!empty($branch_id))
        {
            $asset_location = AssetsLocation::where('branch_id',$branch_id)->lists('location_description','location_id');
        }
        else
        {
            $asset_location = AssetsLocation::lists('location_description','location_id');
        }

        $asset_location = array(''=>'Pilih Lokasi Aduan') + $asset_location->all();

        return $asset_location;
    }

    function get_assets($filter=array())
    {

        $lokasi_id = $this->request->lokasi_id;

        if(isset($filter['lokasi_id']) && !empty($filter['lokasi_id']))
        {
            $lokasi_id = $filter['lokasi_id'];
        }

        if(empty($lokasi_id))
        {
            $validation_lokasi_id = $this->request->old('lokasi_id');
            $lokasi_id = $validation_lokasi_id;
        }

        if(!empty($lokasi_id))
        {

            /*$ict_no = Asset::select('asset_id', DB::raw('CONCAT(asset_id, " - " , butiran) AS butiran_aset'))
                ->where('lokasi_id',$lokasi_id)->lists('butiran_aset','asset_id');

            $ict_no = array(''=>'Pilih Aset Berkenaan') + $ict_no->all();*/

            /*=============ORACLE======================*/
            $ict_no =Asset::select('ict_no', DB::raw('ict_no||\'-\'|| butiran AS butiran_aset'))
                ->where('lokasi_id',$lokasi_id)
                ->lists('butiran_aset', 'ict_no');

            $ict_no = array(''=>'Pilih Aset') + $ict_no->all();
        }

        else
        {
            if (env('APP_ENV') === 'testing') {

                /*$ict_no = Asset::select('asset_id', DB::raw('CONCAT(asset_id, " - " , butiran) AS butiran_aset'))
                    ->lists('butiran_aset','asset_id');*/

                /*==========ORACLE================*/
                $ict_no =Asset::select('ict_no', DB::raw('ict_no||\'-\'|| butiran AS butiran_aset'))
                    ->lists('butiran_aset', 'ict_no');
                
            }
            else
            {
                $ict_no = array(''=>'Pilih Aset Berkenaan');
            }
        }



        return $ict_no;
    }

    function get_branch()
    {
        $branch = Branch::lists('branch_description','id');
        $branch = array(''=>'Pilih Cawangan Berkenaan') + $branch->all();

        return $branch;
    }

    function get_complain_action($id)
    {
        $complain_actions = Complain::find($id)->complain_action()->orderBy('id','desc')->get();
        return $complain_actions;
    }

    function prepare_branch_location_assets($editComplain,$method='edit')
    {

        if(!in_array($editComplain->complain_category_id,$this->exclude_array ))
        {
            $complain_branchId = $editComplain->assets_location->branch_id;
            $location_filter = array('branch_id'=>$complain_branchId);
            $complain_lokasi_id = $editComplain->lokasi_id;
            $asset_filter = ['lokasi_id'=>$complain_lokasi_id];
            $asset_location = $this->get_location($location_filter);
            $ict_no = $this->get_assets($asset_filter);
            $branch = $this->get_branch();
            $hide_branch_location_asset = 'N';
        }
        else
        {
            if($method=='action')
            {
                $branch = $this->get_branch();
                $ict_no = $this->get_assets();
                $asset_location = $this->get_location();
                $hide_branch_location_asset = 'N';
            }else
            {
                $asset_location = [];
                $ict_no = [];
                $branch = [];
                $hide_branch_location_asset = 'Y';
            }

        }
        return ['branch'=>$branch,'asset_location'=>$asset_location,'ict_no'=>$ict_no,'hide_branch_location_asset'=>$hide_branch_location_asset];
    }

    function format_date($date)
    {

            /* Kalau Pengguna nak format slash '/'
             * $exp_start_date = explode('/',$start_date);
            $get_year= $exp_start_date[2];
            $get_month= $exp_start_date[1];
            $get_day= $exp_start_date[0];

            $start_date = Carbon::createFromDate($get_year,$get_month,$get_day)->format('Y-m-d');
            */
        $formatted_date=Carbon::parse($date)->format('Y-m-d');

        return $formatted_date;
    }
}
