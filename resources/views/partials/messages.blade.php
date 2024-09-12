@foreach( $chat as  $messages)
    @if($messages->sender_id == auth()->user()->id)
        <div class="d-flex justify-content-end p-2">
            <div style="max-width: 90%" class="p-2 rounded shadow bg-white">
                <span style="max-width: 75%" class="text-break text-end">{!! $messages->content !!}</span>
                <small style="font-size: 10px" class="text-secondary d-block">{{ $messages->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-start p-2">
            <div style="max-width: 90%" class="p-2 rounded shadow bg-white">
                <span style="max-width: 75%" class="text-break text-end">{!! $messages->content !!}</span>
                <small style="font-size: 10px" class="text-secondary d-block">{{ $messages->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @endif
@endforeach
