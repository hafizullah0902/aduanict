@extends('layout.app')
@section('content')

    @include('layout/alert_message')

   @include('partials.complain_notification')

    @if($editComplain->complain_status_id==1)

        @include('complains.partials.edit_form')
    @else

        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#pengesahan" aria-controls="pengesahan" role="tab" data-toggle="tab"><strong>PENGESAHAN ADUAN</strong></a>
                </li>
                <li role="presentation">
                    <a href="#bayaran" aria-controls="bayaran" role="tab" data-toggle="tab"><strong>MAKLUMAT ADUAN</strong></a>
                </li>
                <li role="presentation">
                    <a href="#bayaran2" aria-controls="bayaran2" role="tab" data-toggle="tab"><strong>SEJARAH TINDAKAN</strong></a>
                </li>
            </ul>
        </div>

        <div class="tab-content paddingcontent">

            <div role="tabpanel" class="tab-pane fade in active" id="pengesahan">
                @include('complains.partials.verify_form')
            </div>
            <div role="tabpanel" class="tab-pane fade in active" id="bayaran">
                @include('complains.partials.view_form')
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
                var submit_type='finish';
                submit_form(submit_type);

            });

            $("#submit_reject").click(function () {
                var submit_type='reject';
                submit_form(submit_type);

            });

            function submit_form(submit_type) {
                $('#submit_type').val(submit_type);

                $('#form1').submit();

            }

        });

    </script>
@endsection