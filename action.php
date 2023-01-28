<?php
include_once "dbconnect.php";
if (!isset($_SESSION)) {
    session_start();
}

function check_autorize($log, $pas)
{
    global $conn;
    $users = [];
    $i = 0;
    $sql = "SELECT * FROM Users";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $users[$i] = $row;
        $i++;
    }
    $boolValue = false;
    for ($i = 0; $i < count($users); $i++) {
        if (password_verify($pas, $users[$i]['pas']) && $log == $users[$i]['log']) {
            $_SESSION['user_login'] = $log;
            return true;
        }
    }
    if (!$boolValue) return false;
}

function check_log($log)
{
    global $conn;
    try {
        $sql = "SELECT log FROM Users WHERE log = '" . $log . "'";
        $result = $conn->query($sql);
        $n = $result->num_rows;
        if ($n != 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function registration($log, $pas)
{
    global $conn;
    $sql = "INSERT INTO Users (log, pas) VALUES (" . "'" . $log . "', " . "'" . $pas . "')";
    if (!$conn->query($sql)) {
        return false;
    } else {
        $_SESSION['user_login'] = $log;
        return true;
    }
}

function add()
{
    global $conn;
    $username = $_SESSION['user_login'];
    $message = $_REQUEST['message'];
    $category = $_REQUEST['categories'];
    $name = $_REQUEST['name'];

    try {
        if (!$conn->query("INSERT INTO News(username, date, message, category, name) VALUES ('$username', NOW(), '$message', '$category', '$name')")) {
            throw new Exception('Ошибка заполнения таблицы News: [' . $conn->error . ']');
        }

        $_SESSION['add'] = true;
        header("Location: admin_panel.php");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function logout()
{
    unset($_SESSION['user_login']);
    session_unset();
    header("Location: index.php");
}

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    switch ($action) {
        case 'add':
            add();
            break;
        case 'logout':
            logout();
            break;
        default:
            header("Location: index.php");
    }
}

function pagination($posts)
{
    global $conn;
    $i = 0;
    $sql = "SELECT * FROM `News` ORDER BY date DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $posts[$i] = $row;
        $i++;
    }
    return $posts;
}

function paginationOutput($page, $numPages, $type)
{
    if ($type == "outputSearch") $strLink = "&desired=" . $_GET['desired'] . "&search=🔍";
    if ($type == "outputSimple") $strLink = "";
    echo '<div class="container d-flex justify-content-center mt-3">';
    echo "<ul class='pagination'>";
    ($page - 1) < 0
        ?
        $strElements = [$page, "Prev"]
        :
        $strElements = [$page - 1, "Prev"];
    echo "<li class='page-item'><a class='page-link' href='?page=" . $strElements[0] . $strLink . "'>" . $strElements[1] . "</a></li>";

    for ($i = 0; $i < $numPages; $i++) {
        echo "<li class='page-item'><a class='page-link pag-link' id='pag" . $i . "' href='?page=" . $i . $strLink . "'>" . $i + 1 . "</a></li>";
    }

    ($page + 1) > ($numPages - 1)
        ?
        $strElements = [$page, "Next"]
        :
        $strElements = [$page + 1, "Next"];

    echo "<li class='page-item'><a class='page-link' href='?page=" . $strElements[0] . $strLink . "'>" . $strElements[1] . "</a></li>";
    echo "</ul>";
    echo "</div>";
}

function output($pagination, $page, $fragmentLen)
{
    echo '<div class="container d-flex justify-content-center justify mt-3">';
    echo "<div class='row'>";
    if (count($pagination) > 0) {
        $counter = 0;
        for ($i = $page * $fragmentLen; $i < ($page + 1) * $fragmentLen; $i++) {
            if (isset($pagination[$i])) {
                $counter++;
?>
                <div class="news-block">
                    <div class="bottom_border_line"><span class="news_text">Опубликовал:</span> <span class="writer"><?php echo $pagination[$i]['username']; ?></span></div>
                    <div class="bottom_border_line"><span class="news_text">Категория:</span> <a class="category_link" href="category.php?category=<?= $pagination[$i]['category'] ?>&page=0"><?php echo $pagination[$i]['category']; ?></a></div>
                    <div class="bottom_border_line"><span class="main_text"><?php echo $pagination[$i]['name']; ?></span></div>
                    <div class="news_field"><span class="main_text"><?php echo $pagination[$i]['message']; ?></span></div>
                    <div class="top_border_line"><span class="news_text">Дата публикации:</span> <span class="date"><?php echo $pagination[$i]['date']; ?></span>
                    </div>
                </div>
<?php
            } else {
                break;
            }
        }
    } else {
        echo "Пока что нет новостей...<br>";
    }
    echo "</div>";
    echo "</div><br>";
    return $pagination;
}

function getCategories()
{
    global $conn;
    $categories = [];
    $i = 0;
    $sql = "SELECT category FROM `category`";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $categories[$i] = $row;
        $i++;
    }
    return $categories;
}

function findSameCategories($sameCategories, $name)
{
    global $conn;
    $i = 0;
    $sql = "SELECT * FROM `News` WHERE category = '" . $name . "'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $sameCategories[$i] = $row;
        $i++;
    }
    return $sameCategories;
}
function search($desired)
{
    global $conn;
    $desired_value = [];
    $i = 0;
    $sql = "SELECT * FROM `News` WHERE category = '" . $desired . "' or username = '" . $desired . "' or name = '" . $desired . "' or message = '" . $desired . "'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $desired_value[$i] = $row;
        $i++;
    }
    // print_r($desired_value);
    return $desired_value;
}
