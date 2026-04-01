@if(session()->has("message"))
    @php
        $message = session()->get("message")
    @endphp
@endif
@if($message["type"]!="" && $message["message"]!="")
    <div class="alert alert-outline-{{$message["type"]}}" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {{$message["message"]}}
    </div>
@endif