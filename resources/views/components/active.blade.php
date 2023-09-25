@props([
'href' => '#',
'activeClass' => 'active',
'exact' => false,
])

<a {{ $attributes->class([
    $activeClass => $exact ? url()->current() == $href : \Illuminate\Support\Str::startsWith(url()->full(), $href),
    ]) }} href="{{ $href }}">
    {{ $slot }}
</a>
