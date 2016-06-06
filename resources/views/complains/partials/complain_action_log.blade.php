<div class="table">
    <table class=" table table-responsive table-striped" width="100%">
        <tr>
            <th>Tarikh/Masa</th>
            <th>Staf Tindakan</th>
            <th>Tindakan</th>
            <th>Sebab Lewat</th>
            <th>Detail</th>
            <th>Nama Pengadu</th>
        </tr>
        @foreach($complain_actions as $key => $complain_action)



            <tr>
                <td>{{$complain_action->created_at}}</td>
                <td>
                    @if($complain_action->user)
                        {{$complain_action->user->name}}
                        @else
                        -
                    @endif
                </td>
                <td>{{ $complain_action->action_comment }}</td>
                <td>{{ $complain_action->delay_reason }}</td>
                <td>{{$complain_action->user_emp_id}}</td>
            </tr>


            {{--@endif--}}
        @endforeach
    </table>
</div>