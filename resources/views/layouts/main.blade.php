
<html>
    <head>
        <title>Todo - @yield('title')</title>
        <style>
            .is-invalid { border: 1px solid red;}
            .alert { color:red; }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    </head>
    <body>


        
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>