<ul class="sidebar-menu">
@foreach($current_user_menus as $item)
    <li class="treeview {{$item['active']?'active':''}}">
        <a href="{{isset($item['url'])?url($item['url']):'javascript:void(0)'}}" class="nav-link">
            <i class="{{$item['icon']}}"></i>
            <span class="title menu-text">{{$item['text']}}</span>
            @if(isset($item['children']))
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            @endif
        </a>
        @if(isset($item['children']))
            <ul class="treeview-menu" style="display: {{$item['active']?'block':'none'}}">
                @foreach($item['children'] as $child)
                    <li class="treeview {{$child['active']?'active':''}}">
                        <a href="{{isset($child['url'])?url($child['url']):'javascript:void(0)'}}" class="nav-link">
                            <i class="{{$child['icon']}}"></i>
                            <span class="title menu-text">{{$child['text']}}</span>
                            @if(isset($child['children']))
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach
</ul>