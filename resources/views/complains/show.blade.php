@extends('layout.app')
@section('content')

    @include('layout/alert_message')

    @include('partials.complain_notification')

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
        </div>


@endsection