<?php
$db = mysqli_connect('localhost', 'u67375', '7012734', 'u67375');
if (!$db) {
    die('Error connecting to database: ' . mysqli_connect_error());
}
mysqli_set_charset($db, 'utf8');


if ($_SERVER['PHP_AUTH_USER'] != "" && $_SERVER['PHP_AUTH_PW'] != ""){

    // Получаем имя пользователя и пароль из заголовка Authorization
    $username = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];

    $result = $db->query("SELECT * FROM admins WHERE login = '$username'");
    $row = $result->fetch_assoc();
    $login = $row['login'];
    $password = $row['pass'];

    if($username == $login && $pass == $password){
        $flag = "True";
        session_start();
        $_SESSION['admin'] = $flag;
        header("Location: allTable.php");
    }
    else{
        header('WWW-Authenticate: Basic realm="Restricted Area"');
        header('HTTP/1.0 401 Unauthorized');
        die("Пожалуйста введите свой логин и пароль");
    }
}else{
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    die("Пожалуйста введите свой логин и пароль");
}
?>
