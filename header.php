<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="news.css">
    <link rel="stylesheet" href="loader.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>News</title>
</head>

<body>
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <script>
        window.onload = function() {
            document.body.classList.add('loaded_hiding');
            window.setTimeout(function() {
                document.body.classList.add('loaded');
                document.body.classList.remove('loaded_hiding');
            }, 500);
        }
    </script>
    <style>
        * {
            color: darkcyan;
        }
    </style>
    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container-fluid">
            <a class="nav-link me-5 text-white" href='index.php'>&starf; Новостное агенство</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-3" id="collapsibleNavbar">
                <ul class="navbar-nav me-auto">
                    <?php
                    if (isset($_SESSION['user_login'])) {
                        if ($_SESSION['user_login'] == "admin") echo "<a class='nav-link' href='admin_panel.php'>Войти в административную панель</a><br />";
                        echo "<a class='nav-link' href='action.php?action=logout'>Выйти</a><br />";
                    } else {
                        echo "<a class='nav-link' href='autorize.php'>Войти</a>";
                        echo "<a class='nav-link' href='registration.php'>Зарегистрироваться</a>";
                    }
                    ?>
                    <!-- <a class='nav-link me-5' href='index.php'>На главную</a> -->
                    <?php
                    foreach (getCategories() as $key => $value) {
                        foreach ($value as $category => $category_name) {
                    ?>
                            <li class="nav-item">
                                <a class='nav-link' href='category.php?category=<?php echo $category_name ?>&page=0'><?php echo $category_name ?></a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
                <form class="d-flex">
                    <input type='search' class='form-control me-2' name='desired' placeholder='Поиск'>
                    <input type='submit' class='btn btn-info' name='search' value='&#128269;'>
                </form>
            </div>
        </div>
    </nav>
    <?php
    if (isset($_GET['category'])) echo "<h1 class='mt-3' style='text-align:center;'>{$_GET['category']}</h1>";

    if (str_contains($_SERVER['REQUEST_URI'], "desired") && !str_contains($_SERVER['REQUEST_URI'], "page")) {
        header("Location: index.php?page=0&desired=" . $_GET['desired'] . "&search=🔍");
        ob_end_flush();
    }
    ?>