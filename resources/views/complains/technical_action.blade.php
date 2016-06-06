@extends('layout.app')
@section('content')

    @include('layout/alert_message')
    @include('partials/complain_notification')

    @if($editComplain->complain_status_id==2)

        {{--@include('complains.partials.edit_form')--}}
        {{--@include('complains.partials.actionhelpdesk_form')--}}

        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#bayaran" aria-controls="bayaran" role="tab" data-toggle="tab"><strong>MAKLUMAT ADUAN - 2</strong></a>
                </li>
                <li role="presentation">
                    <a href="#bayaran2" aria-controls="bayaran2" role="tab" data-toggle="tab"><strong>TINDAKAN</strong></a>
                </li>
            </ul>
        </div>

        <div class="tab-content paddingcontent">
            <div role="tabpanel" class="tab-pane fade in active" id="bayaran">
                @include('complains.partials.edit_form',['hide_dropdown_category'=>'Y'])
            </div>
            <div role="tabpanel" class="tab-pane fade" id="bayaran2">
                @include('complains.partials.technical_action_form')
            </div>
        </div>
    @elseif($editComplain->complain_status_id==7)
        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#bayaran" aria-controls="bayaran" role="tab" data-toggle="tab"><strong>MAKLUMAT ADUAN</strong></a>
                </li>
                <li role="presentation">
                    <a href="#bayaran2" aria-controls="bayaran2" role="tab" data-toggle="tab"><strong>SEJARAH TINDAKAN</strong></a>
                </li>
            </ul>
        </div>

        <div class="tab-content paddingcontent">
            <div role="tabpanel" class="tab-pane fade in active" id="bayaran">
                @include('complains.partials.view_form')
            </div>
            <div role="tabpanel" class="tab-pane fade" id="bayaran2">
                <h3>Sejarah Tindakan</h3>
                @include('complains.partials.complain_action_log')
            </div>
        </div>
    @else
        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#bayaran" aria-controls="bayaran" role="tab" data-toggle="tab"><strong>MAKLUMAT ADUAN</strong></a>
                </li>
                <li role="presentation">
                    <a href="#bayaran2" aria-controls="bayaran2" role="tab" data-toggle="tab"><strong>SEJARAH TINDAKAN</strong></a>
                </li>
            </ul>
        </div>

        <div class="tab-content paddingcontent">
            <div role="tabpanel" class="tab-pane fade in active" id="bayaran">
                @include('complains.partials.view_form')
                {{--@include('complains.partials.actionhelpdesk_form')--}}
            </div>
            <div role="tabpanel" class="tab-pane fade" id="bayaran2">
                <h3>Sejarah Tindakan</h3>
                @include('complains.partials.complain_action_log')
            </div>
        </div>
    @endif

@endsection
@section('script')
    <script type="text/javascript">
        $( document).ready(function () {

            $("#submit_finish").click(function () {
                var submit_type='tutup';
                submit_form(submit_type);

            });

            function submit_form(submit_type) {
                $('#submit_type').val(submit_type);

                $('#form1').submit();

            }

        });

    </script>
@endsection