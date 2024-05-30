<?php
    // Conected to BD
    $db = mysqli_connect('localhost', 'u67375', '7012734', 'u67375');
    if (!$db) {
        die('Error connecting to database: ' . mysqli_connect_error());
    }
    mysqli_set_charset($db, 'utf8');

    $countLeng = [];
    for($i = 1; $i <= 11; $i++){
        $result = $db->query("SELECT count(*) as leng FROM user_lengs WHERE leng_id = '$i'");
        $row = $result->fetch_assoc();
        $countLeng[$i-1] =  $row['leng'];
    }

    $lengs = array(
        "Pascal" => $countLeng[0],
        "C" => $countLeng[1],
        "C++" => $countLeng[2],
        "JavaScript" => $countLeng[3],
        "Php" => $countLeng[4],
        "Python" => $countLeng[5],
        "Java" => $countLeng[6],
        "Haskel" => $countLeng[7],
        "Clojure" => $countLeng[8],
        "Prolog" => $countLeng[9],
        "Scarse" => $countLeng[10],
    );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/lengStatus.css">
    <title>LengStatus</title>
</head>
<body>
    <div class="statusContent">
        <div class="inputStatus">
            <h1>Статистика:</h1>
            <div class="lengs">
                <h2>Pascal : <?php echo $lengs['Pascal']?></h2>
                <h2>C : <?php echo $lengs['C']?></h2>
                <h2>C++ : <?php echo $lengs['C++']?></h2>
                <h2>JavaScript : <?php echo $lengs['JavaScript']?></h2>
                <h2>Php : <?php echo $lengs['Php']?></h2>
                <h2>Python : <?php echo $lengs['Python']?></h2>
                <h2>Java : <?php echo $lengs['Java']?></h2>
                <h2>Haskel : <?php echo $lengs['Haskel']?></h2>
                <h2>Clojure : <?php echo $lengs['Clojure']?></h2>
                <h2>Prolog : <?php echo $lengs['Prolog']?></h2>
                <h2>Scarse : <?php echo $lengs['Scarse']?></h2>
            </div>
            <a href="allTable.php"><button>Назад</button></a>
        </div>
    </div>
</body>
</html>