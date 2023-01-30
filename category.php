<?php
include "action.php";
include "header.php";
$category_name = $_GET['category'];
$findSameCategories = findSameCategories($sameCategories = [], $category_name);
$page = $_GET['page'];
$fragmentLen = 5;
$numPages = ceil(count($findSameCategories) / $fragmentLen);
if (count($findSameCategories) > 5) {
    echo '<div class="container d-flex justify-content-center mt-3">';
    echo "<ul class='pagination'>";
    if ($page != 0) {
        $strElements = [$page - 1, "Prev"];
        echo "<li class='page-item'><a class='page-link' href='category.php?category=" . $category_name . "&page=" . $strElements[0] . "'>" . $strElements[1] . "</a></li>";
    }

    for ($i = 0; $i < $numPages; $i++) {
        echo "<li class='page-item'><a class='page-link' id='pag" . $i . "' href='category.php?category=" . $category_name . "&page=" . $i . "'>" . $i + 1 . "</a></li>";
    }

    if ($numPages - 1 != $page) {
        $strElements = [$page + 1, "Next"];
        echo "<li class='page-item'><a class='page-link' href='category.php?category=" . $category_name . "&page=" . $strElements[0] . "'>" . $strElements[1] . "</a></li>";
    }

    echo "</ul>";
    echo "</div>";
}
?>
<script>
    let id = 'pag' + <?php echo $page ?>;
    document.getElementById(id).classList.add('active');
</script>
<?php
output($findSameCategories, $page, $fragmentLen);

include "footer.php";
