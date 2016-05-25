<?php

namespace App\Http\Controllers;

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
        $users = array(''=>'Select Bagi Pihak') + $users->all();
        return view('complains/create',compact('users'));
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
            'ADUAN' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return redirect(route('complain.create'))
                ->withErrors($validator)
                ->withInput();
        } else {*/
            $emp_id_aduan = Auth::user()->id;
            $kod_status=1;
            $ADUAN = $request->ADUAN;
            $login_daftar = $request->LOGIN_DAFTAR;
            if(empty($login_daftar))
            {
                $login_daftar=Auth::user()->id;
            }
            //initilize object
            $complain = new Complain;
            $complain->emp_id_aduan = $emp_id_aduan;
            $complain->ADUAN = $ADUAN;
            $complain->KOD_STATUS = $kod_status;
            $complain->LOGIN_DAFTAR=$login_daftar;
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
//        return $editComplain;
        return view('complains/edit',compact('editComplain'));
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
        $ADUAN = $request->ADUAN;

        $complain=Complain::find();

        $complain->ADUAN=$ADUAN;
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
}
