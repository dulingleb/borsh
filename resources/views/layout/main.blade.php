<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Домашний борщ</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Домашний борщ</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{ route('dishes.index') }}">Блюда</a>
            <a class="p-2 text-dark" href="{{ route('menu.index') }}">Создать меню</a>
        </nav>
    </header>

    <main>
        <section>
            @yield('content')
        </section>
    </main>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
