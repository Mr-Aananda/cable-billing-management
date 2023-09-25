@props([
'dismissable' => false,
'message' => '',
'type' => '',
])

@php
    switch ($type)
    {
        case 'success':
            $type = 'alert-success';
            break;
        case 'info':
            $type = 'alert-info';
            break;
        case 'warning':
            $type = 'alert-warning';
            break;
        case 'danger':
            $type = 'alert-danger';
            break;
        case 'secondary':
            $type = 'alert-secondary';
            break;
        case 'light':
            $type = 'alert-light';
            break;
        case 'dark':
            $type = 'alert-dark';
            break;
        default:
            $type = 'alert-primary';
            break;
    }
@endphp

@if(!empty($message))
    <div role="alert" {{
    $attributes->merge([
            'class' => 'alert ' . $type . ' ' . ($dismissable ? 'alert-dismissible fade show' : ''),
    ])
}}
    >
        {{ $message }}
        @if($dismissable)
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @endif
    </div>
@endif
