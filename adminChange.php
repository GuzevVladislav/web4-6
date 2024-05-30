<?php 
    $id = $_GET['id'];
    session_start();
    if(empty($_SESSION['admin']) || $_SESSION['admin'] == "True"){
        header("Location: index.php");
    }

    $db = mysqli_connect('localhost', 'u67375', '7012734', 'u67375');
    if (!$db) {
        die('Error connecting to database: ' . mysqli_connect_error());
    }
    mysqli_set_charset($db, 'utf8');

    $result = $db->query("SELECT * FROM users WHERE id = '$id'");
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $number = $row['number'];
    $email = $row['mail'];
    $date = $row['date'];
    $about = $row['about'];

    setcookie("nameC", $name, time()+5000,"/");
    setcookie("numberC", $number, time()+5000,"/");
    setcookie("emailC", $email, time()+5000,"/");
    setcookie("dateC", $date, time()+5000,"/");
    setcookie("aboutC", $about, time()+5000,"/");
    // Использование данных из сессии
    $_SESSION['id'] = $id;
    header("Location:change.php?");
?>