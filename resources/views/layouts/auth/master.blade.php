<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="SITAMPAN" />
        <meta name="keywords" content="SITAMPAN" />
        <meta name="author" content="Codelabs" />
        <title>SITAMPAN</title>
        <!-- Google font-->
        @includeIf('layouts.auth.partials.css')
    </head>
    <body>
        @yield('content')
        @includeIf('layouts.auth.partials.js')
    </body>
</html>



