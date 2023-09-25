<ul class="list-group">
    @php
        if(!function_exists('is_multi_array')){
    function is_multi_array($a){
        foreach($a as $v) if(is_array($v)) return TRUE;
        return FALSE;
    }
}
    @endphp

    @if(!is_multi_array($permissions))
        <li class="list-group-item">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $permissions['value'] }}"
                       id="{{ $permissions['value'] }}-{{ $permissions['key'] }}">
                <label class="form-check-label" for="{{ $permissions['value'] }}-{{ $permissions['key'] }}">
                    {{ $permissions['key'] }}
                </label>
            </div>
        </li>
    @else



        @forelse($permissions as $group => $permission)
            @if(is_multi_array($permission))
                <li class="list-group-item">
                    <div class="ms-5">
                        <p>{{ $group }}</p>
                        <x-permissions.permissions-tree :permissions="$permission"/>
                    </div>
                    {{--<ul class="list-group">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                        <li class="list-group-item">A fourth item</li>
                        <li class="list-group-item">And a fifth one</li>
                    </ul>--}}
                </li>
            @else
                <li class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $permission['value'] }}"
                               id="{{ $permission['value'] }}-{{ $permission['key'] }}">
                        <label class="form-check-label" for="{{ $permission['value'] }}-{{ $permission['key'] }}">
                            {{ $permission['key'] }}
                        </label>
                    </div>
                </li>
            @endif
        @empty
        @endforelse
    @endif
</ul>
