<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="favicon.ico" rel="icon" />
        <link rel="stylesheet" href="/css/app.css" />
        <title>University Domain List</title>
    </head>
    <body>
        <div class="container mx-auto p-4 flex h-24 items-center">
            <img class="w-16 h-16 mr-4 float-left" src="uberflip.png" alt="Logo" />
            <h1 class="text-5xl">{{ $title ?? 'University Domain List' }}</h1>    
        </div>
        @yield('content')       
    </body>
</html>