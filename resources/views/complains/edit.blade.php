@extends('layout.app')
@section('content')

    @include('layout/alert_message')

   @include('partials.complain_notification')

    @if($editComplain->complain_status_id==1)

        @include('complains.partials.edit_form')

    @elseif($editComplain->complain_status_id==3 && ($editComplain->register_user_id==Auth::user()->emp_id ||$editComplain->user_emp_id==Auth::user()->emp_id))

        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#pengesahan" aria-controls="pengesahan" role="tab" data-toggle="tab"><strong>PENGESAHAN ADUAN</strong></a>
                </li>
                <li role="presentation">
                    <a href="#aduan" aria-controls="aduan" role="tab" data-toggle="tab"><strong>MAKLUMAT ADUAN</strong></a>
                </li>
                <li role="presentation">
                    <a href="#sejarah" aria-controls="sejarah" role="tab" data-toggle="tab"><strong>SEJARAH TINDAKAN</strong></a>
                </li>
            </ul>
        </div>

        <div class="tab-content paddingcontent">
            <div role="tabpanel1" class="tab-pane fade in active" id="pengesahan">
                @include('complains.partials.verify_form')
            </div>
            <div role="tabpanel" class="tab-pane fade" id="aduan">
                @include('complains.partials.view_form')
            </div>
            <div role="tabpanel" class="tab-pane fade" id="sejarah">
                <h3>Sejarah Tindakan</h3>
                @include('complains.partials.complain_action_log')
            </div>
        </div>
    {{--@else
        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#aduan" aria-controls="aduan" role="tab" data-toggle="tab"><strong>MAKLUMAT ADUAN</strong></a>
                </li>
                <li role="presentation">
                    <a href="#sejarah" aria-controls="sejarah" role="tab" data-toggle="tab"><strong>SEJARAH TINDAKAN</strong></a>
                </li>
            </ul>
        </div>
        <div class="tab-content paddingcontent">
            <div role="tabpanel" class="tab-pane fade in active" id="aduan">
                @include('complains.partials.view_form')
            </div>
            <div role="tabpanel" class="tab-pane fade" id="sejarah">
                <h3>Sejarah Tindakan</h3>
                @include('complains.partials.complain_action_log')
            </div>
        </div>--}}
    @endif


@endsection
@section('script')
    <script type="text/javascript">
        $( document).ready(function () {

            $("#submit_finish").click(function () {
                swal({   title: "Anda Pasti - Aduan telah SELESAI",
                            text: "Makluman : Tindakan ini tidak boleh dikemaskini",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya,saya Pasti",
                            closeOnConfirm: false
                        },
                        function() {
                            var submit_type='finish';
                            submit_form(submit_type);

                        });

            });

            $("#submit_reject").click(function () {
                swal({   title: "Anda Pasti - Aduan TIDAK SELESAI",
                            text: "Makluman : Tindakan ini tidak boleh dikemaskini",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya,saya Pasti",
                            closeOnConfirm: false
                        },
                        function() {
                            var submit_type='reject';
                            submit_form(submit_type);

                        });


            });

            function submit_form(submit_type) {
                $('#submit_type').val(submit_type);

                $('#form1').submit();

            }

        });

    </script>
    @include('complains.partials.form_script')
@endsection