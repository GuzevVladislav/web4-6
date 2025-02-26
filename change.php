<?php
     if(!empty($_GET['answer'])) {
        $answer = $_GET["answer"];
        }

    session_start();
    if(!isset($_SESSION["id"])){
        header("Location: index.php?answer=Ошибка");
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $number = $_POST["number"];
        $date = $_POST["date"];
        $gen = $_POST["gen"];
        $lengs = $_POST["leng"];
        $about = $_POST["about"];

        $flag = 0;

        setcookie("email", $email, time()+31536,"/");
        // Валидация имени
        if (!preg_match('/^[а-яёА-ЯЁ]+$/u', $name)){
            setcookie("nameErr", 'error', time()+5000, "/");
            setcookie("name", '', time()-5000,"/");
            $flag = 1;
        }
        else{
            setcookie("nameErr", '', time()-5000, "/");
            setcookie("name", $name, time()+5000, "/");
        }
        // Валидация номера
        if (strlen($number) != 11){
            setcookie("numberErr", 'error', time()+5000, "/");
            setcookie("number", "", time()-5000);
            $flag = 1;
        }
        else{
            setcookie("number", $number, time()+5000, "/");
            setcookie("numberErr", '', time()-3600, "/");
        }
        // Валидация даты
        if(intval($date) < 1924 || intval($date) > 2008){
            setcookie("dateErr", 'error', time()+5000,"/");
            setcookie("date", '', time()-5000,"/");
            $flag = 1;
        }else{
            setcookie("dateErr", '', time()-5000,'/');
            setcookie("date", $date, time()+5000,"/");
        }

        if($flag == 1){
            $answer = "Ошибка";
            header("Location: change.php?answer=".$answer);
        }else{
            $content = file("Pop.txt");
            $decodedLogin = base64_decode($content[0]);
            $decodedPassword = base64_decode($content[1]);
            $db = mysqli_connect('localhost', 'u67375', '7012734', 'u67375');
            if(!$db){
                die('Error connecting to database: ' . mysqli_connect_error());
            }
            mysqli_set_charset($db, 'utf8');

            $name = mysqli_real_escape_string($db, $name);
            $number = mysqli_real_escape_string($db, $number);
            $email = mysqli_real_escape_string($db, $email);
            $date = mysqli_real_escape_string($db, $date);
            $gen = mysqli_real_escape_string($db, $gen);
            $about = mysqli_real_escape_string($db, $about);
            $id = mysqli_real_escape_string($db, $_SESSION["id"]);
            
            $db->query("UPDATE users SET name='$name', number='$number', mail='$email',date='$date', gen='$gen', about='$about' WHERE id = '$id'");
            $db->query("DELETE FROM user_lengs where user_id = '$id'");
            $stmt = $db->prepare("INSERT INTO user_lengs(user_id, leng_id) SELECT ?, lengs.id FROM lengs WHERE lengs.leng = ?");
            foreach ($lengs as $leng) {
                $stmt->bind_param("is", $_SESSION['id'], $leng);
                $stmt->execute();
            }

            $answer = "Форма успешно изменена !";
            header("Location: change.php?answer=".$answer);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма для записи</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1><?php if(!empty($_GET['answer'])) { echo $answer; }  ?></h1>
    <form id="form" action="<?php if(!empty($_GET['answer'])) { echo "change.php?answer=".$answer; } if(!empty($_GET['password'])) { echo "&pasword=".$password; } if(!empty($_GET['id'])) { echo "&id=".$id;} ?>" method="POST">
        <div class="body">
            <div class="info">
                <div class="input">
                    <!-- Имя -->
                    <input class="<?php if(!empty($_COOKIE['nameErr'])) { echo $_COOKIE['nameErr']; } ?>" name="name" id="name" type="text" value="<?php if(!empty($_COOKIE['nameC'])) { echo $_COOKIE["nameC"]; }?>" placeholder="Введите имя" required>
                    <span class="span <?php if(!empty($_COOKIE['nameErr'])) { echo $_COOKIE['nameErr']; } ?>"> <?php if(isset($_COOKIE['nameErr'])) echo "Неверные символы" ?> </span>
                    <!-- Номер -->
                    <input class="<?php if(!empty($_COOKIE['numberErr'])) { echo $_COOKIE['numberErr']; } ?>" name="number" id="number" type="number" value="<?php if(!empty($_COOKIE['numberC'])) { echo $_COOKIE["numberC"]; } ?>" placeholder="Введите телефон" required>
                    <span class="span <?php if(!empty($_COOKIE['numberErr'])) { echo $_COOKIE['numberErr']; } ?>"> <?php if(isset($_COOKIE['numberErr'])) echo "Неправильное количество цифр" ?> </span>
                    <!-- Почта -->
                    <input name="email" id="email" type="email" value="<?php echo $_COOKIE["emailC"]; ?>" placeholder="Введите почту" required>
                    <!-- Дата -->
                    <input class="<?php if(!empty($_COOKIE['dateErr'])) { echo $_COOKIE['dateErr']; } ?>" name="date" id="date" type="date" value="<?php if(!empty($_COOKIE['dateC'])) { echo $_COOKIE['dateC']; } ?>" placeholder="" required>
                    <span class="span <?php if(!empty($_COOKIE['dateErr'])) {  echo $_COOKIE['dateErr']; } ?>"> <?php if(isset($_COOKIE['dateErr'])) echo "Некорректная дата" ?> </span>

                </div>
                <div class="cheked">
                    <div class="radio_pol">
                        <label>
                            <input name="gen" value="1" type="radio" required>Мужчина
                        </label>
                        <label>
                            <input name="gen" value="2" type="radio" required>Женщина
                        </label>
                    </div>
                    <div class="langvich_section">
                        <h4>Выберите язык программирования</h4>
                        <select multiple name="leng[]" class="langvich" name="langvich">
                            <option value="pasc">Pasc</option>
                            <option value="c">C</option>
                            <option value="c++">C++</option>
                            <option value="js">JS</option>
                            <option value="php">PHP</option>
                            <option value="py">Py</option>
                            <option value="java">Java</option>
                            <option value="hask">Hask</option>
                            <option value="cloj">Cloj</option>
                            <option value="prol">Prol</option>
                            <option value="scar">Scarse</option>
                        </select>
                    </div>
                    <div class="textarea">
                        <h4>Напишите о себе</h4>
                        <textarea value="<?php echo $_COOKIE['aboutC'];?>" name="about" cols="30" rows="8" required></textarea>
                    </div>
                    <label>
                        <input class="custom-checkbox" type="checkbox" name="document" id="" required>Я согласен(а) c условиями <pre> </pre> <a href="#"> коденфиденциальности</a>
                    </label>
                </div>
            </div>
            <button class="button" name="send" type="submit">Отправить</button>
        </div>
    </form>
        <a href="logout.php"><button name="exit" type="submit">Выход</button></a>
</body>
</html>
