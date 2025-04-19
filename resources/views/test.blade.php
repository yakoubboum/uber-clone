<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Reverb Test (Console)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Laravel Reverb Test (Console Output)</h1>

    <p>Open your browser's developer console (usually by pressing F12) to see received messages.</p>

    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Listen for messages on the 'test-channel' and 'new-message' event
            Echo.channel('test')
                .listen('.TestEvent', function (data) {
                    console.log('Received Message Data:', data);
                    if (data && data.text) {
                        console.log('Received Text:', data.text);
                    } else {
                        console.log('Received Data (no text property):', data);
                    }
                });
        });
    </script>
</body>
</html>
