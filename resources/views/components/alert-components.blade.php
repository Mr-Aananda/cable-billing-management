@props(['type' => 'success', 'messages' => 'Operation successful'])

<!-- Alert -->
<div role="alert" {{ $attributes->merge(['class' => 'alert alert-dismissible fade show p-2 text-start alert-' . $type]) }}>
    <strong>{{ ($type == 'success') ? 'Messages' : 'Exceptions' }}: </strong>

    @if (is_array($messages))
        @foreach($messages as $message)
            <small class="d-block">{{ str_replace('_', ' ', $message) }}</small>
        @endforeach
    @else
        <small class="d-block">{{ str_replace('_', ' ', $messages) }}</small>
    @endif

    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<!-- End Alert -->
