<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Admin pannel</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/styles/main_styles.css">
</head>

<body>
    <header class="bg-dark text-white p-3">
        <div class="container-fluid">
            <h1>Административная панель</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.products.index') }}">Продукты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Заказы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Пользователи</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container-fluid mt-4">
        @yield('content')
    </div>

    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/styles/bootstrap4/popper.js"></script>
    <script src="/styles/bootstrap4/bootstrap.min.js"></script>
</body>

</html>
