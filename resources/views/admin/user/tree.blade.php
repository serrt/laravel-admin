<div class="collapse {{$pid==0?'in':''}}" id="collapseExample{{$pid}}">
    <ul class="list-group" style="margin-bottom: 0;padding-left: {{$pid==0?'':'3'}}rem;">
        @foreach($permissions as $permission)
            @if($permission->pid == $pid)
                <li class="list-group-item" data-toggle="collapse" data-target="#collapseExample{{$permission->id}}" aria-controls="collapseExample{{$permission->id}}">
                    <i class="{{$permission->key}}"></i>
                    {{$permission->display_name}}
                    @if(!$permission->pid)
                        <i class="fa fa-angle-left pull-right"></i>
                    @endif
                </li>
                @include('admin.user.tree', ['permissions'=>$permissions, 'pid'=>$permission->id, 'checked' => $checked])
            @endif
        @endforeach
    </ul>
</div>
