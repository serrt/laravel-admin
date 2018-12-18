<div class="collapse {{$pid==0?'in':''}}" id="collapseExample{{$pid}}">
    <ul class="list-group" style="margin-bottom: 0;padding-left: {{$pid==0?'':'3'}}rem;">
        @foreach($permissions as $permission)
            @if($permission->pid == $pid)
                <li class="list-group-item {{$checked->contains($permission->id)?'list-group-item-success':''}}" data-toggle="collapse" data-target="#collapseExample{{$permission->id}}" aria-controls="collapseExample{{$permission->id}}">
                    <input type="checkbox" name="permissions[]" class="permission-checkbox" onclick="permissionCheckbox(this, true)" data-pid="{{$pid}}" {{$checked->contains($permission->id)?'checked':''}} value="{{$permission->id}}">
                    <i class="{{$permission->key}}"></i>
                    {{$permission->display_name}}
                    @if(!$permission->pid)
                    <i class="fa fa-angle-left pull-right"></i>
                    @endif
                </li>
                @include('admin.role.tree', ['permissions'=>$permissions, 'pid'=>$permission->id, 'checked' => $checked])
            @endif
        @endforeach
    </ul>
</div>
