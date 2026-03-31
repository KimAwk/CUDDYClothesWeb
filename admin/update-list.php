<?php
session_start();
include('config/dbcnn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];

    if (!empty($category_name)) {
        $query = "UPDATE list_product SET category_name = '$category_name' WHERE category_id = '$_GET[id]'";
        if (mysqli_query($conn, $query)) {
            header("Location: list-products.php");
            exit();
        } else {
            echo "Lỗi cập nhật: " . mysqli_error($conn);
        }
    }
}

?>
