@extends('layouts.admin-index')

@section('styles')
    <style>
        #search {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .messages {
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection

@section('body')
    <div class="row" style="height:  calc(95svh - 73px)">

        <div class="d-none d-md-block col-3 border-end">

            <form class="form mb-2">
                <label for="search">Search User</label>
                <div class="bg-white form-control d-flex gap-1 align-items-center">
                    <i class="bi bi-search"></i>
                    <input class="overflow-hidden" value="{{$app->request->search}}" autocomplete="off" id="search"
                           name="search"
                           type="search" placeholder="Search User">
                </div>

            </form>

            <ul class="list-group">
                @forelse($users as $loopUser)
                    <li class="list-group-item">
                        <a class="text-secondary text-capitalize" href="/admin/messages/{{$loopUser->id}}">
                             {{strtolower( $loopUser->name .' '. $loopUser->last_name)}}
                        </a>
                    </li>
                @empty
                    <div class="h-100 d-flex align-items-center justify-content-center">
                        <h5 class="text-secondary">No Recent Messages</h5>
                    </div>
                @endforelse
            </ul>
        </div>
        <div class="col-12 col-md-9 bg-light h-100">
            <div class="border-bottom d-flex gap-2 align-items-center py-2" style="height: max-content">
                <div class="d-block d-md-none">
                    <a href="/admin/messages">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <h4 class="text-secondary">{{$user->name}}</h4>
            </div>
            <div class="chat overflow-auto" style="height: 85%">
                <div class="h-100 d-flex align-items-center justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div class="bg-white pt-2" style="height: 10%">
                <form id="messageForm" class="d-flex align-items-center justify-content-between gap-2">
                    <input type="text" id="inputMessage" class="form-control" name="message">
                    <div>
                        <button class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        const chat = document.querySelector('.chat');
        const issueMessageForm = document.querySelector('#messageForm')
        let initialLoad = true;

        issueMessageForm.addEventListener('submit', async (event) => {

            event.preventDefault();

            let formData = new FormData();
            let message = document.querySelector('#inputMessage');

            if (!message.value.length) {
                return
            }

            formData.append('content', message.value)

            let result = await fetch('/admin/api/messages/{{$user->id}}', {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-Token': '{{csrf_token()}}'
                }
            })

            if (result.ok) {
                message.value = "";
            } else {
                alert('failed sending message');
            }
        })

        const updateChat = async () => {
            $.ajax({
                url: "/admin/api/messages/{{$user->id}}",
                success: function (result) {
                    if (Math.floor(chat.scrollTop + chat.offsetHeight + 10) > Math.floor(chat.scrollHeight) || initialLoad) {
                        $(".chat").html(result);
                        $(".chat").scrollTop(Number.MAX_SAFE_INTEGER);
                        initialLoad = false
                    } else {
                        $(".chat").html(result);
                    }
                },
            });
        }

        window.addEventListener("load", function () {
            setInterval(updateChat, 1000)
        });
    </script>
@endsection
