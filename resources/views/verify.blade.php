@extends('layouts.user-index')


@section('files')
    <script src="/js/just-validate.js"></script>
@endsection


@section('body')
    <section class="stack-bg" style="min-height: 400px">
        <div class="container py-4 bg-light " style="max-width: 600px">


            <h2 class="text-center">Security Check</h2>
            <p>To help keep your account safe, Please Enter the code </p>
            <form method="POST" action="/verify">
                <div class="mb-2">
                    <label for="code">An email with a verification code was just sent to you</label>
                    <input id="code" type="text" class="form-control" name="code">
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                @if(isset($error))
                    <span class="text-danger">{{$error}}</span>
                @endif

            </form>
            <div class="d-flex gap-2">

                <form method="POST" action="/logout">
                    <button type="submit" class="link-btn text-secondary">
                        logout
                    </button>
                </form>

                <form id="resendCodeForm" method="POST" action="/resend-verification">
                    <button id="resendLink" disabled type="submit" class="link-btn text-secondary">
                        <p>You can resend the code in <span id="timer">300</span> seconds.</p>
                    </button>
                </form>
            </div>

        </div>
    </section>
@endsection

@section('javascript')
    <script>
        // Get the resend link button and timer element
        const resendLink = document.getElementById('resendLink');
        const timerElement = document.getElementById('timer');
        const resendCodeForm = document.getElementById('resendCodeForm');

        resendCodeForm.addEventListener('submit', (event) => {
            event.preventDefault();
            resendCodeForm.submit();
            startTimer();
        })

        // Set the initial timer value to 300 seconds (5 minutes)
        let timer = 300;

        // Function to update the timer display
        function updateTimer() {
            timerElement.textContent = timer;
        }

        // Function to enable the resend link button
        function enableResendLink() {
            resendLink.disabled = false;
            resendLink.textContent = 'Resend Code';
        }

        // Function to start the timer
        function startTimer() {
            // Update the timer every second
            const interval = setInterval(() => {
                timer--;
                updateTimer();

                // If the timer reaches 0, enable the resend link button
                if (timer === 0) {
                    clearInterval(interval);
                    enableResendLink();
                }
            }, 1000);
        }

        // Start the timer when the page loads
        startTimer();
    </script>
@endsection


