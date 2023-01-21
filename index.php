<?php
if (!str_contains($_SERVER['REQUEST_URI'], "page") && !str_contains($_SERVER['REQUEST_URI'], "desired")) {
    header("Location: index.php?page=0");
}
if (str_contains($_SERVER['REQUEST_URI'], "desired") && !str_contains($_SERVER['REQUEST_URI'], "page")) {
    header("Location: index.php?page=0&desired=" . $_GET['desired'] . "&search=🔍");
}

include_once "action.php";
include "header.php";

echo '<div class="container d-flex justify-content-center mt-3">';
echo '<div class="btn-group">';
if (isset($_SESSION['user_login'])) {
    if ($_SESSION['user_login'] == "admin") echo "<a class='btn btn-info' href='admin_panel.php'>Войти в административную панель</a><br/>";
    echo "<a class='btn btn-info' href='action.php?action=logout'>Выйти из учётной записи</a><br/>";
} else {
    echo "<a class='btn btn-info' href='autorize.php'>Войти</a>";
    echo "<a class='btn btn-info' href='registration.php'>Зарегистрироваться</a>";
}
echo "</div>";
echo "</div>";
echo
"<div class='container d-flex justify-content-center mt-3'>
    <form action=" . $_SERVER['PHP_SELF'] . " method='get'>
        <div class='input-group mb-3'>
            <input type='search' class='form-contol' name='desired' placeholder='Search'>
            <input type='submit' class='btn btn-info' name='search' value='&#128269;'>
        </div>
    </form>
</div>";
$page = $_GET['page'];
$fragmentLen = 5;
if (isset($_GET['search'])) {
    $searching = search($_GET['desired']);
    $numPages = ceil(count($searching) / $fragmentLen);
    $type = "outputSearch";
    output($searching, $page, $fragmentLen);
    paginationOutput($page, $numPages, $type);
} else {
    $pagination = pagination($posts = []);
    $numPages = ceil(count($pagination) / $fragmentLen);
    $type = "outputSimple";
    output($pagination, $page, $fragmentLen);
    paginationOutput($page, $numPages, $type);
    $categoriesList = getCategories();
}

include "footer.php";
