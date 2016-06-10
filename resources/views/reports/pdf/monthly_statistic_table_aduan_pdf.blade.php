{{--<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}
<link href="{{URL::asset('css/table_biru.css')}}" rel="stylesheet">

@extends('layout.print')

@section('content')
    <img src="{{ url('images/letterheadppz.jpg') }}" alt>
<table class="CSS_Table_Example" cellspacing="0" cellpadding="0"   width="100%">
    <tr>
        <td>Kategori</td>
        <td>Jan</td>
        <td>Feb</td>
        <td>Mac</td>
        <td>April</td>
        <td>May</td>
        <td>Jun</td>
        <td>Julai</td>
        <td>Ogos</td>
        <td>Sept</td>
        <td>Okt</td>
        <td>Nov</td>
        <td>Dis</td>
    </tr>
    @foreach($complains_statistic_row as $key => $value)
        <tr>
            <td>{{$key}}</td>

            @foreach($value as $month_total)
                <td class="text-center">{{ $month_total }}</td>


            @endforeach
        </tr>
    @endforeach
    <tfoot>
    <tr class="">
        <td> Jumlah</td>
    </tr>
    </tfoot>
</table>


@endsection
