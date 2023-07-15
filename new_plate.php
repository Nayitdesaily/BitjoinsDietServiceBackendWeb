<?php

/*--------------------*/
// App Name: Yonia
// Author: Wicombit
// Author URI: https://codecanyon.net/user/wicombit/portfolio
/*--------------------*/

session_start();
if (isset($_SESSION['username'])) {


    require '../admin/config.php';
    require '../admin/functions.php';
    require '../views/header.view.php';
    require '../views/navbar.view.php';

    $connect = connect($database);
    if (!$connect) {
        header('Location: ' . SITE_URL . '/controller/error.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $plate_title = cleardata($_POST['plate_title']);
        $plate_restaurant = cleardata($_POST['plate_restaurant']);
        $plate_description = cleardata($_POST['plate_description']);
        $plate_type_food = cleardata($_POST['plate_type_food']);
        $plate_portion = cleardata($_POST['plate_portion']);
        $plate_counter_like = cleardata($_POST['plate_counter_like']);
        $plate_status = cleardata($_POST['plate_status']);

        $plate_image = $_FILES['plate_image']['tmp_name'];

        $imagefile = explode(".", $_FILES["plate_image"]["name"]);
        $renamefile = round(microtime(true)) . '.' . end($imagefile);

        $plate_image_upload = '../' . $items_config['images_folder'];

        move_uploaded_file($plate_image, $plate_image_upload . 'plate_' . $renamefile);

        $statment = $connect->prepare(
            'INSERT INTO plates (plate_id,plate_title,plate_image, plate_restaurant, plate_type_food, plate_description, plate_portion, plate_counter_like, plate_status  ) 
            VALUES (null, :plate_title, :plate_image, :plate_restaurant, :plate_type_food, :plate_description, :plate_portion, :plate_counter_like , :plate_status)'
        );

        $statment->execute(array(
            ':plate_title' => $plate_title,
            ':plate_restaurant' => $plate_restaurant,
            ':plate_description' => $plate_description,
            ':plate_type_food' => $plate_type_food,
            ':plate_portion' => $plate_portion,
            ':plate_counter_like' => $plate_counter_like,
            ':plate_status' => $plate_status,
            ':plate_image' => 'plate_' . $renamefile
        ));

        header('Location:' . SITE_URL . '/controller/plates.php');
    }

    $chefs = get_all_chefs($connect);

    require '../views/new.plate.view.php';
    require '../views/footer.view.php';
} else {
    header('Location: ' . SITE_URL . '/controller/login.php');
}
