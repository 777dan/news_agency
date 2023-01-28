<?php
if (!str_contains($_SERVER['REQUEST_URI'], "page") && !str_contains($_SERVER['REQUEST_URI'], "desired")) {
    header("Location: index.php?page=0");
}
if (str_contains($_SERVER['REQUEST_URI'], "desired") && !str_contains($_SERVER['REQUEST_URI'], "page")) {
    header("Location: index.php?page=0&desired=" . $_GET['desired'] . "&search=🔍");
}

include_once "action.php";
include "header.php";
$page = $_GET['page'];
$fragmentLen = 5;
if (isset($_GET['search'])) {
    $searching = search($_GET['desired']);
    $numPages = ceil(count($searching) / $fragmentLen);
    $type = "outputSearch";
    if (count($searching) > 5) paginationOutput($page, $numPages, $type);
    output($searching, $page, $fragmentLen);
} else {
    $pagination = pagination($posts = []);
    $numPages = ceil(count($pagination) / $fragmentLen);
    $type = "outputSimple";
    if (count($pagination) > 5) paginationOutput($page, $numPages, $type);
    output($pagination, $page, $fragmentLen);
    $categoriesList = getCategories();
}
?>
<script>
    let id = 'pag' + <?php echo $page ?>;
    document.getElementById(id).classList.add('active');
</script>

<?php
include "footer.php";
