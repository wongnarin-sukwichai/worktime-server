<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ระบบลงเวลาปฏิบัติงาน | AREC MSU</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ url('img/favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css?family=Anuphan|Kanit" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="antialiased">

    <div id="app"></div>

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="flex-center position-ref full-height">
                <div class="message text-center" style="padding-top: 20%;">
                    <a href="/login">
                        <h5 class="text-gray-400 text-4xl hover:text-blue-400 cursor-pointer">Welcome to Worktime
                            System</h5>
                    </a><br>
                    <h6 class="text-gray-300">Academic Resource Center MSU</h6>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
