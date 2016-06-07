<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetsLocation;
use App\Branch;
use App\ComplainAction;
use App\ComplainCategory;
use App\ComplainSource;
use App\ComplainStatus;
use App\Events\ComplainAssignUser;
use App\Events\ComplainCreated;
use App\Events\ComplainHelpdeskAction;
use App\Events\ComplainStaffAction;
use App\Events\ComplainUserVerify;
use Event;
use App\KodUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Complain;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
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
        $this->unit_id = 0;

        if(Auth::check())
        {
            $this->user_id=Auth::user()->emp_id;
            $this->unit_id=Auth::user()->kod_id;
        }
        $this-> request =$request;
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
        elseif(Entrust::hasRole('unit_manager'))
        {
            $complain2 =Complain::where('user_emp_id',$this->user_id)
                ->orwhere('action_emp_id',$this->user_id)
                ->orwhere('user_id',$this->user_id)
                ->orwhere('unit_id',$this->unit_id)
                ->where('complain_status_id','!=',7)
                ->paginate(20);
        }
        else
        {
            $complain2 =Complain::orderBy('created_at','DESC')->paginate(15);
        }


        return view('complains/index',compact('complain2'));
    }


    /* FUNCTION UNTUK MANAGER AGIH STAFF
    ==================================MULA========================================================================== */
    public function assign()
    {

            $complain2 = Complain::where('unit_id', $this->unit_id)
            ->where('complain_status_id',7)
            ->paginate(20);

        return view('complains/assign_index',compact('complain2'));
    }
    public function assign_staff($id)
    {

        $editComplain=Complain::find($id);
        
        $complain_actions=$this->get_complain_action($id);
        $unit_staff_list = User::where('kod_id',$this->unit_id)
                                 ->where('emp_id','!=',$this->user_id)
                                 ->lists('name','emp_id');

        $unit_staff_list = array(''=>'Pilih Staf') + $unit_staff_list->all();
        
        return view('complains/assign_staff',compact('editComplain','complain_actions','unit_staff_list'));
    }

    public function update_assign_staff(Request $request,$id)
    {

        $editComplain=Complain::find($id);


        $editComplain->assign_date=Carbon::now();
        $editComplain->complain_status_id=2 ;
        $editComplain->action_emp_id = $request->action_emp_id;

        $editComplain->save();
        Event::fire(new ComplainAssignUser($editComplain));
        $complain_actions=$this->get_complain_action($id);

        $complain_action = new ComplainAction;
        $complain_action->complain_id = $id;
        $complain_action->action_by = $this->user_id;
        $complain_action->delay_reason = $request->helpdesk_delay_reason;
        $complain_action->complain_status_id=7;

        $complain_action->save();

        return view('complains/assign_staff',compact('editComplain','complain_actions','unit_staff_list'));
    }

    /*==================================END FUNCTION MANAGER========================================================= */

    public function action($id)
    {
        
            $complain2 =Complain::find($id);

            $complain_categories = $this->get_complain_categories();
            $complain_status = $this->get_complain_status();
            $complain_actions = $this->get_complain_action($id);
            $editComplain=Complain::find($id);
            $asset_location = $this->get_location();
            $branch = $this->get_branch();
            $unit_id = $this->get_kod_unit();
            $ict_no = $this->get_assets();


            return view('complains/action',compact('editComplain','complain2','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no'));
    }

    public function technical_action($id)
    {

        $complain2 =Complain::find($id);

        $complain_statuses = ComplainStatus::where('status_id',2)
                                            ->orwhere('status_id',3)
                                            ->lists('description','status_id');
        $complain_categories = $this->get_complain_categories();
        $complain_status = $this->get_complain_status();
        $complain_actions = $this->get_complain_action($id);
        $editComplain=Complain::find($id);
        $asset_location = $this->get_location();
        $branch = $this->get_branch();
        $unit_id = $this->get_kod_unit();
        $ict_no = $this->get_assets();


        return view('complains/technical_action',compact('editComplain','complain2','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no','complain_statuses'));
    }

    public function update_technical_action(ComplainRequest $request, $id)
    {


        $complain_status = $this->get_complain_status();
        $complain_actions = $this->get_complain_action($id);

        $complain = Complain::find($id);
        $editComplain=Complain::find($id);
        $complain_statuses = ComplainStatus::where('status_id',2)
            ->orwhere('status_id',3)
            ->lists('description','status_id');


        $complain_status_id = $request->complain_status_id;
        $action_comment = $request->action_comment;
        $delay_reason = $request->delay_reason;

        $complain->action_comment = $action_comment;
        $complain->complain_status_id = $complain_status_id;
        $complain->delay_reason = $delay_reason;


        if ($request->complain_status_id == 3) {

            $complain->action_date = Carbon::now();

        }

        $complain->save();
        Event::fire(new ComplainStaffAction($complain));

        if ($request->complain_status_id == 3) {

            $complain_action = new ComplainAction;
            $complain_action->complain_id = $id;
            $complain_action->complain_status_id = $complain_status_id;
            $complain_action->action_by = $this->user_id;
            $complain_action->action_comment = $action_comment;
            $complain_action->delay_reason = $delay_reason;
            $complain_action->save();


        }
        return view('complains/technical_action',compact('editComplain','complain2','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no','complain_statuses'));
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
        $unit_id = $this->get_kod_unit();
        $ict_no = $this->get_assets();
        
        $complain_sources = ComplainSource::lists('description','source_id');
        $complain_sources = array(''=>'Pilih Saluran Aduan') + $complain_sources->all();

        return view('complains/create',compact('users','complain_categories','complain_sources','asset_location','branch','unit_id','ict_no'));
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
            $lokasi_id = $request->lokasi_id;
            $category_explode = explode('-',$request->complain_category_id );
            $complain_category_id = $category_explode[0];
            $unit_id = $category_explode[1];


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
            $complain->unit_id=$unit_id;
            $complain->complain_category_id=$complain_category_id;
            $complain->lokasi_id=$lokasi_id;

//             return $request->all();
            $complain->save();
            Event::fire(new ComplainCreated($complain));

            Flash::success('Aduan berjaya di hantar');
            return redirect(route('complain.index'));



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


    public function get_kod_unit($filter=array())
    {
        $unit_id = KodUnit::lists('butiran','kod_id');
        return $unit_id;
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
        $complain_actions = $this->get_complain_action($id);
        $complain_branchId = $editComplain->assets_location->branch_id;
        $location_filter = array('branch_id'=>$complain_branchId);

        $asset_location = $this->get_location($location_filter);
        $branch = $this->get_branch();
        $unit_id = $this->get_kod_unit();
        $ict_no = $this->get_assets();

        return view('complains/edit',compact('editComplain','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no'));
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

        $complain=Complain::find($id);
        

        $lokasi_id = $request->lokasi_id;
        $ict_no = $request->ict_no;
        $complain_description = $request->complain_description;

        if(!$request->has('hide_dropdown_category'))
        {
            $category_explode = explode('-',$request->complain_category_id );
            $complain_category_id = $category_explode[0];
            $unit_id = $category_explode[1];

            $complain->action_date=Carbon::now();
            $complain->complain_description=$complain_description;
            $complain->complain_category_id=$complain_category_id;
            $complain->unit_id=$unit_id;
            
        }
        $complain->lokasi_id=$lokasi_id;
        $complain->ict_no=$ict_no;

        Flash::success('Aduan '.$id.' berjaya dikemaskini');
        $complain->save();

        // return back();
        return redirect(route('complain.index'));
    }

    public function update_action(ComplainRequest $request, $id)
    {
        // Kemaskini form Helpdesk
        // $action_date = $request->action_date;
        $complain=Complain::find($id);

        if($request->submit_type=='tutup')
        {
            $complain_status_id = 5;
            $complain->complain_status_id=$complain_status_id;

        }
        else
        {
            //$complain_description = $request->complain_description;
            //$complain_category_id = $request->complain_category_id;
            $complain_status_id=$request->complain_status_id;
            $action_comment = $request->action_comment;
            $helpdesk_delay_reason = $request->helpdesk_delay_reason;

            $complain->action_date=Carbon::now();
            //$complain->complain_description=$complain_description;
            //$complain->complain_category_id=$complain_category_id;
            $complain->action_comment=$action_comment;
            $complain->action_emp_id=$this->user_id;
            $complain->helpdesk_delay_reason=$helpdesk_delay_reason;

            if($complain_status_id==7)
            {
                $complain->assign_date = Carbon::now();
            }
            $complain->complain_status_id=$complain_status_id;
        }






        $complain->save();
        Event::fire(new ComplainHelpdeskAction($complain));

        // Insert dalam complain action

        $complain_action = new ComplainAction;
        $complain_action->complain_id = $id;
        $complain_action->action_by = $this->user_id;
        $complain_action->delay_reason = $request->helpdesk_delay_reason;
        $complain_action->complain_status_id=$request->complain_status_id;

        if($request->submit_type=='tutup')
        {
            $complain_action->action_comment ='Tutup';

        }
        else
        {
            $complain_action->action_comment = $request->action_comment;
        }

          $complain_action->save();




//        return back();
        return redirect(route('complain.index'));
    }

    public function verify(Request $request, $id)
    {
        $submit_type = $request->submit_type;

        $complain = Complain::find($id);

        $complain->user_comment=$request->user_comment;
        $complain->verify_date=Carbon::now();
        $complain->verify_emp_id=$this->user_id;

        if($submit_type=='finish')
        {
            $complain->verify_status=1;
            $complain->complain_status_id=4;
        }
        else
        {
            $complain->verify_status=2;
            $complain->complain_status_id=2;

        }
        $complain->save();
        Event::fire(new ComplainUserVerify($complain));

        // Insert dalam complain action

        $complain_action = new ComplainAction;
        $complain_action->complain_id = $id;
        $complain_action->user_emp_id = $this->user_id;
        $complain_action->user_comment = $request->user_comment;

        $complain_action->save();

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
        $complain_categories = ComplainCategory::select('description', DB::raw('CONCAT(category_id, "-" , kod_unit) AS category_value'))->lists('description','category_value');
        $complain_categories = array(''=>'Pilih Kategori Aduan') + $complain_categories->all();
        return $complain_categories;
    }

    function get_complain_status()
    {
        $complain_status = ComplainStatus::lists('description','status_id');
        $complain_status = array(''=>'Pilih Status Aduan') + $complain_status->all();

        return $complain_status;
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
        
        $lokasi_id = $this->request->lokasi_id;



        if(!empty($lokasi_id))
        {

            $ict_no = Asset::select('asset_id', DB::raw('CONCAT(asset_id, " - " , butiran) AS butiran_aset'))
                            ->where('lokasi_id',$lokasi_id)->lists('butiran_aset','asset_id');
        }


        else
        {

            $ict_no = array(''=>'Pilih Aset Berkenaan');
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

    
}
