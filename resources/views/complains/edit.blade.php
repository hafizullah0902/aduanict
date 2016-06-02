@extends('layout.app')
@section('content')

    @include('layout/alert_message')

   @include('partials.complain_notification')

    @if($editComplain->complain_status_id==1)

        @include('complains.partials.edit_form')
    @else
        @include('complains.partials.verify_form')
        <h3>Sejarah Tindakan</h3>
        @include('complains.partials.complain_action_log')
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