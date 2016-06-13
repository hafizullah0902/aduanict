<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetsLocation;
use App\Branch;
use App\ComplainAction;
use App\ComplainAttachment;
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

class ComplainController extends BaseController
{
    //    code untuk trigger login or belum
    public function __construct(Request $request){

        parent::__construct();

//        $this->middleware('ComplainPermission');
        $this-> request =$request;
        
        
    }

/* ========================================FUNCTION UMUM ==============================================================*/
    public function index()
    {
        if(Entrust::hasRole('user') || Entrust::hasRole('unit_manager'))
        {
            $complain2 =Complain::with('user','action_user')
                                ->where(function($query){
                                $query->orwhere('user_emp_id',$this->user_id)
                                ->orwhere('action_emp_id',$this->user_id)
                                ->orwhere('user_id',$this->user_id)
                                ->orwhere('unit_id',$this->unit_id);
                                });

        }

        else
        {
            $complain2 =Complain::with('user','action_user');
        }

        if(!empty($this->request->complain_status_id))
        {
            $complain2 = $complain2->where('complain_status_id',$this->request->complain_status_id);

        }
        if(!empty($this->request->carian))
        {
           $complain2 = $complain2->where(function($query){
               $query->orwhere('complain_id','like','%'.$this->request->carian.'%')
//                   ->orwhere('action_comment','like','%'.$this->request->carian.'%')
//                   ->orwhere('complain_description','like','%'.$this->request->carian.'%')
                ;
           });


        }
        if(!empty($this->request->start_date))
        {
            $start_date = $this->format_date($this->request->start_date);
            $complain2 = $complain2->whereDate('created_at','>=',$start_date);

        }
        if(!empty($this->request->end_date))
        {
            $end_date = $this->format_date($this->request->end_date);
            $complain2 = $complain2->whereDate('created_at','<=',$end_date);

        }

        $complain2=$complain2->orderBy('created_at','desc')->paginate(20);
        $complain_status = $this->get_complain_status();
        
        return view('complains/index',compact('complain2','complain_status'));
    }

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
        $branch_id = $request->branch_id;
        $ict_no = $request->ict_no;
        $category_explode = explode('-',$request->complain_category_id );
        $complain_category_id = $category_explode[0];
        $unit_id = $category_explode[1];

        if(empty($user_emp_id))
        {
            $user_emp_id = Auth::user()->emp_id;
        }

        $aduan_category_exception_value = array('5','6');

        if(in_array($complain_category_id,$aduan_category_exception_value ))
        {

            $lokasi_id = null;
            $ict_no = null;
        }

        $complain = new Complain;
        $complain->user_id = $user_id;
        $complain->complain_description = $complain_description;
        $complain->complain_status_id = $complain_status_id;
        $complain->user_emp_id=$user_emp_id;
        $complain->complain_source_id=$complain_source_id;
        $complain->unit_id=$unit_id;
        $complain->complain_category_id=$complain_category_id;
        $complain->lokasi_id=$lokasi_id;
        $complain->branch_id=$branch_id;
        $complain->ict_no=$ict_no;

//             return $request->all();
        $complain->save();

        if($request->hasFile('complain_attachment') && $request->file('complain_attachment')->isValid())
        {
            $fileName = $complain->complain_id.'-'.$request->file('complain_attachment')->getClientOriginalName();

//                dd($fileName);
            $destination_path = base_path().'/public/uploads/';
            $request->file('complain_attachment')->move($destination_path,$fileName);

            $complain_attachment = new ComplainAttachment();

            $complain_attachment->attachment_filename = $fileName;
            $complain->attachments()->save($complain_attachment);

        }

        Event::fire(new ComplainCreated($complain));

        Flash::success('Aduan '.$id.' berjaya di hantar');
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
        $editComplain=Complain::find($id);
        $complain_actions = $this->get_complain_action($id);

        return view('complains/show',compact('editComplain','complain_actions'));
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

//        return view('complains/assign_staff',compact('editComplain','complain_actions','unit_staff_list'));
        return view('complains/show',$id);
    }

    /*==================================END FUNCTION MANAGER========================================================= */

    public function action($id)
    {
        
            $complain2 =Complain::find($id);
            $complain_categories = $this->get_complain_categories();

            $complain_status = $this->get_complain_status();
            $complain_actions = $this->get_complain_action($id);
            $editComplain=Complain::find($id);

            $unit_id = $this->get_kod_unit();

            $get_branch_location_asset = $this-> prepare_branch_location_assets($editComplain,'action');
            $branch = $get_branch_location_asset['branch'];
            $hide_branch_location_asset = $get_branch_location_asset['hide_branch_location_asset'];
            $asset_location = $get_branch_location_asset['asset_location'];
            $ict_no = $get_branch_location_asset['ict_no'];

            /*$complain_lokasi_id = $editComplain->lokasi_id;
            $asset_filter = ['lokasi_id'=>$complain_lokasi_id];
            $location_filter = array('branch_id'=>$complain_branchId);
            $asset_location = $this->get_location($location_filter);
            $ict_no = $this->get_assets($asset_filter);*/


            return view('complains/action',compact('editComplain','complain2','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no','hide_branch_location_asset'));
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

        $unit_id = $this->get_kod_unit();

        $get_branch_location_asset = $this-> prepare_branch_location_assets($editComplain);
        $branch = $get_branch_location_asset['branch'];
        $hide_branch_location_asset = $get_branch_location_asset['hide_branch_location_asset'];
        $asset_location = $get_branch_location_asset['asset_location'];
        $ict_no = $get_branch_location_asset['ict_no'];


        return view('complains/technical_action',compact('editComplain','complain2','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no','complain_statuses','hide_branch_location_asset'));
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
//        return view('complains/technical_action',compact('editComplain','complain2','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no','complain_statuses'));
        return redirect(route('complain.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



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
        $unit_id = $this->get_kod_unit();

//        $asset_location = $this->get_location($location_filter);
//        $ict_no = $this->get_assets($asset_filter);
//        $branch = $this->get_branch();
       $get_branch_location_asset = $this-> prepare_branch_location_assets($editComplain);
        $branch = $get_branch_location_asset['branch'];
        $hide_branch_location_asset = $get_branch_location_asset['hide_branch_location_asset'];
        $asset_location = $get_branch_location_asset['asset_location'];
        $ict_no = $get_branch_location_asset['ict_no'];


        return view('complains/edit',compact('editComplain','complain_categories','complain_status','complain_actions','branch','asset_location','unit_id','ict_no','hide_branch_location_asset'));
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
            $branch_id = $request->branch_id;

            $complain->action_date=Carbon::now();
//            $complain->complain_description=$complain_description;
            $complain->complain_category_id=$complain_category_id;
            $complain->unit_id=$unit_id;
            
        }
        if(!in_array($complain->complain_cotegory_id,$this->exclude_array ))
        {
            $complain->lokasi_id=$lokasi_id;
            $complain->ict_no=$ict_no;
            $complain->branch_id=$branch_id;
        }


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
        if($complain_status_id>1)
        {
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
        }





//        return back();
        return redirect(route('complain.index'));
    }

    public function verify(ComplainRequest $request, $id)
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
        Flash::success('Aduan '.$id.' berjaya di hantar');
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

    

    
}
