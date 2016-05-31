<?php

namespace App\Http\Controllers;

use App\AssetsLocation;
use App\Branch;
use App\ComplainCategory;
use App\ComplainSource;
use App\ComplainStatus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Complain;
use Validator;
use App\Http\Requests\ComplainRequest;
use Auth;
use App\User;
use Entrust;

class ComplainController extends Controller
{
//    code untuk trigger login or belum
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->user_id = 0;

        if(Auth::check())
        {
            $this->user_id=Auth::user()->id;
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Entrust::hasRole('user'))
        {
            $complain2 =Complain::where('user_emp_id',$this->user_id)
                                ->orwhere('action_emp_id',$this->user_id)
                                ->orwhere('user_id',$this->user_id)
                                ->paginate(20);
        }
        else
        {

            $complain2 =Complain::orderBy('created_at','DESC')->paginate(15);
        }

//        show semua rekod


//        untuk cek result betul ke x
//        return $complain2;

        return view('complains/index',compact('complain2'));
    }

    public function action($id)
    {
        
            $complain2 =Complain::find($id);
            $complain_categories = $this->get_complain_categories();
            $complain_status = $this->get_complain_status();



            return view('complains/action',compact('complain2','complain_categories','complain_status'));
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('emp_id','!=',Auth::user()->emp_id)->lists('name','emp_id');
        $users = array(''=>'Pilih Bagi Pihak') + $users->all();

        $complain_categories = $this->get_complain_categories();
        $asset_location = $this->get_location();
        $branch = $this->get_branch();
        
        $complain_sources = ComplainSource::lists('description','source_id');
        $complain_sources = array(''=>'Pilih Saluran Aduan') + $complain_sources->all();

        return view('complains/create',compact('users','complain_categories','complain_sources','asset_location','branch'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
// cara panjang    public function store(Request $request)
    public function store(ComplainRequest $request)
    {
       /**cek data dalam form
        dd($request->toArray()); */
        /* cara panjang $messages = [
            'required'    => 'Input :attribute wajib diisi.',
            'numeric'    => 'Input :attribute mesti nombor sahaja.',
            'between' => 'The :attribute must be between :min - :max.',
            'in'      => 'The :attribute must be one of the following types: :values',
        ];

        $validator = Validator::make($request->all(), [
            'complain_description' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return redirect(route('complain.create'))
                ->withErrors($validator)
                ->withInput();
        } else {*/
            $user_id = Auth::user()->emp_id;

            $complain_status_id=1;
            $complain_description = $request->complain_description;
            $user_emp_id = $request->user_emp_id;
            $complain_source_id = $request->complain_source_id;
            $complain_category_id = $request->complain_category_id;
            $lokasi_id = $request->lokasi_id;


            if(empty($user_emp_id))
            {
                $user_emp_id = Auth::user()->emp_id;
            }

            //initilize object
            $complain = new Complain;
            $complain->user_id = $user_id;
            $complain->complain_description = $complain_description;
            $complain->complain_status_id = $complain_status_id;
            $complain->user_emp_id=$user_emp_id;
            $complain->complain_source_id=$complain_source_id;
            $complain->complain_category_id=$complain_category_id;
            $complain->lokasi_id=$lokasi_id;

//          return $request->all();
            //save rekod


            $complain->save();
            // url selepas berjaya
            return redirect(route('complain.index'));
//   cara panjang     }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('complains/show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editComplain=Complain::find($id);

        $complain_categories = $this->get_complain_categories();
        $complain_status = $this->get_complain_status();
//        $complain_status_id=1;
//        $complain_description = $request->complain_description;
//        $user_id = $request->user_emp_id;
//        $complain_source_id = $request->complain_source_id;
//        $complain_category_id = $request->complain_category_id;
//        return $editComplain;

        return view('complains/edit',compact('editComplain','complain_categories','complain_status'));
        //return view('complains/edit',compact('editComplain'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(ComplainRequest $request, $id)
    {
        $action_date = $request->action_date;
        $complain_description = $request->complain_description;
//        $complain_status_id = $request->complain_status_id;
//        $complain_category_id = $request->complain_category_id;
        $action_comment = $request->action_comment;
        $delay_reason = $request->delay_reason;


        $complain=Complain::find($id);

        $complain->action_date=$action_date;
        $complain->complain_description=$complain_description;
        $complain->complain_status_id=$complain_status_id;
        $complain->complain_category_id=$complain_category_id;
//        $complain->action_comment=$action_comment;
//        $complain->delay_reason=$delay_reason;

        $complain->save();

//        return back();
        return redirect(route('complain.index'));
    }

    public function update_action(ComplainRequest $request, $id)
    {
        $action_date = $request->action_date;
        $complain_description = $request->complain_description;
        $complain_status_id = $request->complain_status_id;
        $complain_category_id = $request->complain_category_id;
        $action_comment = $request->action_comment;
        $delay_reason = $request->delay_reason;


        $complain=Complain::find($id);

        $complain->action_date=$action_date;
        $complain->complain_description=$complain_description;
        $complain->complain_status_id=$complain_status_id;
        $complain->complain_category_id=$complain_category_id;
        $complain->action_comment=$action_comment;
        $complain->delay_reason=$delay_reason;

        $complain->save();

//        return back();
        return redirect(route('complain.index'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd($id);
        $complain=Complain::find($id);
        $complain->delete();

        return back();
    }


    function get_complain_categories()
    {
        $complain_categories = ComplainCategory::lists('description','category_id');
        $complain_categories = array(''=>'Pilih Kategori Aduan') + $complain_categories->all();

        return $complain_categories;
    }

    function get_complain_status()
    {
        $complain_status = ComplainStatus::lists('description','status_id');
        $complain_status = array(''=>'Pilih Status Aduan') + $complain_status->all();

        return $complain_status;
    }

    function get_location()
    {
        $branch_id = \Request::input ('branch_id');

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

    function get_assets()
    {
        $lokasi_id = \Request::input ('lokasi_id');

        if(!empty($lokasi_id))
        {
            $ict_no = AssetsLocation::where('branch_id',$lokasi_id)->lists('location_description','location_id');
        }
        else
        {
            $ict_no = AssetsLocation::lists('location_description','location_id');
        }

        $ict_no = array(''=>'Pilih Aset Berkenaan') + $ict_no->all();

        return $ict_no;
    }

    function get_branch()
    {
        $branch = Branch::lists('branch_description','id');
        $branch = array(''=>'Pilih Cawangan Berkenaan') + $branch->all();

        return $branch;
    }
}
