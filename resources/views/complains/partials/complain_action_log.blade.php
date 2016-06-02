<div class="table">
    <table class=" table table-responsive table-striped" width="100%">
        <tr>
            <th>Tarikh/Masa</th>
            <th>Staf Tindakan</th>
            <th>Tindakan</th>
            <th>Sebab Lewat</th>
            <th>Detail</th>
        </tr>
        @foreach($complain_actions as $key => $complain_action)



            <tr>
                <td>{{$complain_action->created_at}}</td>
                <td>{{$complain_action->action_by}}</td>
                <td>{{ $complain_action->action_comment }}</td>
                <td>{{ $complain_action->delay_reason }}</td>
            </tr>


            {{--@endif--}}
        @endforeach
    </table>
</div>