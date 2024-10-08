@extends('layouts.user-account')


@section('styles')
    <style>

        #changeImage:hover {
            cursor: pointer;
        }

        .messages {
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection

@section('body')
    <div style="height:  calc(95svh - 88px)">
        <div class="chat overflow-auto" style="height: 90%">
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
@endsection

@section('javascript')

    <script>

        const chat = document.querySelector('.chat');
        let initialLoad = true;

        const updateChat = async () => {

            try {

                const response = await fetch('api/messages/{{auth()->user()->id}}');

                if (!response.ok) {
                    throw new Error('Something went wrong');
                }

                chat.innerHTML = await response.text();

            } catch (error) {
                console.log(error.message)
            }
        }

        window.addEventListener("load", function () {

            const issueMessageForm = document.querySelector('#messageForm');

            issueMessageForm.addEventListener('submit', async (event) => {

                event.preventDefault();

                let formData = new FormData();
                let message = document.querySelector('#inputMessage');

                formData.append('content', message.value)

                let response = await fetch('/api/message/admin', {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-Token": $('input[name="_token"]').val()
                    }
                })

                if (response.ok) {
                    message.value = "";
                    updateChat();
                } else {
                    alert('failed to send message');
                }

            })

            setInterval(updateChat, 3000)
        });

    </script>

@endsection
