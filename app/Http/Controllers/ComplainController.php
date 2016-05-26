<?php

namespace App\Http\Controllers;

use App\ComplainCategory;
use App\ComplainSource;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Complain;
use Validator;
use App\Http\Requests\ComplainRequest;
use Auth;
use App\User;

class ComplainController extends Controller
{
//    code untuk trigger login or belum
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        show semua rekod
        $complain2 =Complain::paginate(15);

//        untuk cek result betul ke x
//        return $complain2;

        return view('complains/index',compact('complain2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('id','!=',Auth::user()->id)->lists('name','id');
        $users = array(''=>'Pilih Bagi Pihak') + $users->all();

        $complain_categories = $this->get_complain_categories();
        
        $complain_sources = ComplainSource::lists('description','source_id');
        $complain_sources = array(''=>'Pilih Saluran Aduan') + $complain_sources->all();

        return view('complains/create',compact('users','complain_categories','complain_sources'));
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
            $user_id = Auth::user()->id;

            $complain_status_id=1;
            $complain_description = $request->complain_description;
            $user_id = $request->user_emp_id;
            $complain_source_id = $request->complain_source_id;
            $complain_category_id = $request->complain_category_id;


            if(empty($user_id))
            {
                $user_id=Auth::user()->id;
            }

            //initilize object
            $complain = new Complain;
            $complain->user_id = $user_id;
            $complain->complain_description = $complain_description;
            $complain->complain_status_id = $complain_status_id;
            $complain->user_emp_id=$user_id;
            $complain->complain_source_id=$complain_source_id;
            $complain->complain_category_id=$complain_category_id;

//            return $request->all();
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
//        return $editComplain;

        return view('complains/edit',compact('editComplain','complain_categories'));
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
        $complain_description = $request->complain_description;

        $complain=Complain::find();

        $complain->complain_description=$complain_description;
        $complain->save();

        return back();
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
}
