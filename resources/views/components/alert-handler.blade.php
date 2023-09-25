@if(session()->has('success'))
    <x-alert :message="session()->get('success')" type="success" dismissable></x-alert>
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
        <x-alert :message="$error" type="danger" dismissable></x-alert>
    @endforeach
@endif
