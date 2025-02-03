<?php
    if ($_FILES['image']['name']) {
        if (!$_FILES['image']['error']) {
            $name = md5(rand(100, 200));
            $ext = explode('.', $_FILES['image']['name']);
            $filename = $name . '.' . $ext[1];
            $destination = '../img/ImagesSummer/' . $filename;
            $location = $_FILES["image"]["tmp_name"];
            move_uploaded_file($location, $destination);
            echo '/img/ImagesSummer/' . $filename;//change this URL
        }
    else
    {
        echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['image']['error'];
    }
}
?>