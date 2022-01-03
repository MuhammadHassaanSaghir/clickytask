@component('mail::message')
    <h1 style="text-align: center;"> clickyTask </h1>
    <h3 style="text-transform: capitalize;"> {{ $name }} - Please Confirm your clickyTask Account </h3>
@component('mail::button', ['url' => $url])
    Confirm!
@endcomponent  
    Thanks
@endcomponent