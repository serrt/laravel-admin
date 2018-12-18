<div class="collapse {{$pid==0?'show':''}}" id="collapseExample{{$pid}}">
    <ul class="list-group" style="margin-bottom: 0;padding-left: {{$pid==0?'':'3'}}rem;">
        @foreach($permissions as $permission)
            @if($permission->pid == $pid)
                <li class="list-group-item" data-toggle="collapse" data-target="#collapseExample{{$permission->id}}" aria-controls="collapseExample{{$permission->id}}">
                    <i class="{{$permission->key}}"></i>
                    <a class="margin-r-5" href="{{route('admin.permission.edit', $permission)}}" title="修改">{{$permission->display_name}}</a>
                    <button type="submit" form="delForm{{$permission->id}}" class="btn btn-default btn-xs" title="删除" onclick="return confirm('是否确定？')"><i class="fa fa-trash-o"></i></button>
                    <form class="form-inline hide" id="delForm{{$permission->id}}" action="{{ route('admin.permission.destroy', $permission) }}" method="post">
                        {{ csrf_field() }} {{ method_field('DELETE') }}
                    </form>
                    @if(!$permission->pid)
                    <i class="fa fa-angle-left pull-right"></i>
                    @endif
                </li>
                @include('admin.permission.tree', ['permissions'=>$permissions, 'pid'=>$permission->id])
            @endif
        @endforeach
    </ul>
</div>