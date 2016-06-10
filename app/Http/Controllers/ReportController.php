<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Complain;
use App\ComplainCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{

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



    public function monthly_statistic_aduan()
    {
        $start_date = $this->request->start_date;
        $end_date =  $this->request->end_date;
        $complain_category_id=$this->request->complain_category_id;
        $branch_id=$this->request->branch_id;

        $complain_categories = $this->get_complain_categories();
        $branch = $this->get_branch();

        if(empty($start_date))
        {
            $current_year_start_date = date ('Y'.'-1-1');
            $start_date= $current_year_start_date;
        }
        else
        {
            /* Kalau Pengguna nak format slash '/'
             * $exp_start_date = explode('/',$start_date);
            $get_year= $exp_start_date[2];
            $get_month= $exp_start_date[1];
            $get_day= $exp_start_date[0];

            $start_date = Carbon::createFromDate($get_year,$get_month,$get_day)->format('Y-m-d');
            */

            $start_date=Carbon::parse($start_date)->format('Y-m-d');
        }
        if(empty($end_date))
        {
            $current_year_end_date = date ('Y'.'-12-31');
            $end_date=$current_year_end_date;
        }
        else
        {
            $end_date=Carbon::parse($end_date)->format('Y-m-d');
        }
        $complains= Complain::whereBetween('created_at',array($start_date,$end_date ));
            if(!empty($complain_category_id))
            {
                $exp_complain_category_id = explode('-',$complain_category_id );
                $complain_category_id = $exp_complain_category_id[0];
                $complains = $complains ->where('complain_category_id',$complain_category_id);
            }
            $complains = $complains->orderBy('created_at')
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('M');
            });

        $monthly_total =[];
        $month_name=[];

        foreach ($complains as $key => $complain)
        {
            $month_name[] = $key;
            $monthly_total[] = $complain->count();

        }
        $date_search = [$start_date,$end_date];
        $month_name=json_encode($month_name);
        $monthly_total=json_encode($monthly_total);
//            dd($monthly_total,$month_name);
        return view('reports.monthly_statistic_aduan',compact('complains','month_name','monthly_total','date_search','branch','complain_categories'));

    }

    public function monthly_statistic_table_aduan()
    {
        $get_startdate_enddate = $this->get_startdate_enddate();
        $start_date = $get_startdate_enddate['start_date'];
        $end_date = $get_startdate_enddate['end_date'];


        $sql_query =
                    " SELECT complain_categories.description, month(complains.created_at) as MONTH, count(*) AS bil
                    FROM complains,complain_categories 
                    WHERE (complains.created_at BETWEEN '$start_date' AND '$end_date') 
                    and complain_categories.category_id=complains.complain_category_id 
                    GROUP BY complain_category_id, month(complains.created_at) 
                    order by complain_category_id, month(complains.created_at) ";

        $complain = DB::select(DB::raw($sql_query));

        $complains_statistic_row = [];
        $complains_statistic_col = [];
        foreach ($complain as $key => $row)
        {
            if(array_key_exists($row->description,$complains_statistic_row ))
            {
                $complains_statistic_col = $complains_statistic_row[$row->description];
                $complains_statistic_col = array_replace($complains_statistic_col, [$row->MONTH=>$row->bil]);
                $complains_statistic_row[$row->description] = $complains_statistic_col;

            }
            else
            {
//            $default_value = ['1'=>0,'1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>,'12'=>0];

                $default_value = [];
                for($i=1;$i<=12;$i++)
                {
                    $default_value = $default_value + [$i=>0];
                }

                $complains_statistic_row[$row->description] = array_replace($default_value,[$row->MONTH=>$row->bil] );
//            $complains_statistic_row[$row->description] = array_replace($default_value,[$row->MONTH=>$row->$bil] );
            }
        }

//        dd($complains_statistic_row);
        if($this->request->submit_type != 'downloadPdf')
        {
            return view('reports.monthly_statistic_table_aduan',compact('complains_statistic_row','complains_statistic_col'));
        }
        else
        {
            $data = ['complains_statistic_row'=>$complains_statistic_row];
            $pdf = PDF::loadView('reports.pdf.monthly_statistic_table_aduan_pdf', $data);
            return $pdf->download('monthly_statistic_aduan_pdf.pdf');
//            return view('reports.pdf.monthly_statistic_table_aduan_pdf',compact('complains_statistic_row','complains_statistic_col'));
        }

//
    }

    function get_startdate_enddate()
    {

        $start_date = $this->request->start_date;
        $end_date =  $this->request->end_date;

        if(empty($start_date))
        {
            $current_year_start_date = date ('Y'.'-1-1');
            $start_date= $current_year_start_date;
        }
        else
        {
            /* Kalau Pengguna nak format slash '/'
             * $exp_start_date = explode('/',$start_date);
            $get_year= $exp_start_date[2];
            $get_month= $exp_start_date[1];
            $get_day= $exp_start_date[0];

            $start_date = Carbon::createFromDate($get_year,$get_month,$get_day)->format('Y-m-d');
            */

            $start_date=Carbon::parse($start_date)->format('Y-m-d');
        }
        if(empty($end_date))
        {
            $current_year_end_date = date ('Y'.'-12-31');
            $end_date=$current_year_end_date;
        }
        else
        {
            $end_date=Carbon::parse($end_date)->format('Y-m-d');
        }

        return ['start_date'=>$start_date,'end_date'=>$end_date];

    }

    function get_complain_categories()
    {
        $complain_categories = ComplainCategory::select('description', DB::raw('CONCAT(category_id, "-" , kod_unit) AS category_value'))->lists('description','category_value');
        $complain_categories = array(''=>'Pilih Kategori Aduan') + $complain_categories->all();
        return $complain_categories;
    }

    function get_branch()
    {
        $branch = Branch::lists('branch_description','id');
        $branch = array(''=>'Pilih Cawangan Berkenaan') + $branch->all();

        return $branch;
    }
}
