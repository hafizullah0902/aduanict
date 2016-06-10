<div class="table">
    <table class=" table table-responsive table-striped" width="100%">
        <tr>
            <th>Tarikh / Masa</th>
            <th>Staf Aduan</th>
            <th>Staf Tindakan</th>
            <th>Aduan / Tindakan</th>
            <th>Sebab Lewat</th>
        </tr>
        @foreach($complain_actions as $key => $complain_action)



            <tr>
                <td>{{$complain_action->created_at}}</td>
                <td>
                    @if($complain_action->action_user)
                        {{$complain_action->action_user->name}}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($complain_action->user_complain)
                        {{$complain_action->user_complain->name}}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $complain_action->action_comment }}
                    {{ $complain_action->user_comment }}
                </td>
                <td>{{ $complain_action->delay_reason }}
                </td>
                {{--<td>{{$complain_action->action_user->name}}</td>--}}
            </tr>


            {{--@endif--}}
        @endforeach
    </table>
</div>