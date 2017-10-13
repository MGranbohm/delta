<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF8">
    <title>Document</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <style>
        section{
            padding: 49px;
        }
    </style>
</head>
<body>
<div>
    <section>
        @yield('content')
    </section>
</div>
@yield('footer')
</body>
</html>