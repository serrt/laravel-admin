@if(isset($item) && isset($item['children']))
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
                @include('admin.layouts._menu', ['item' => $child])
            </li>
        @endforeach
    </ul>
@endif