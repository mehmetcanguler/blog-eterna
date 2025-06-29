<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Vue Reverb Test</title>
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="auth-token" content="{{ auth()->user()?->currentAccessToken()?->plainTextToken }}">
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app"></div>
</body>
</html>
