    <?php
    session_start();
    if(empty($_SESSION['admin']) || $_SESSION['admin'] != "True"){
        header('Location: index.php');
    }

    $db = mysqli_connect('localhost',  'u67375', '7012734', 'u67375');
    if (!$db) {
        die('Error connecting to database: ' . mysqli_connect_error());
    }
    $result = $db->query("SELECT * FROM users");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tables</title>
    <link rel="stylesheet" href="css/allTables.css">
    <script src="admin.js" defer></script>
</head>
<body>
    <table border="0">
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Number</th>
            <th>Mail</th>
            <th>Date</th>
            <th>Gender</th>
            <th>About</th>
        </tr>
        <?php
            while($row = $result->fetch_assoc()){
                print(
                    "<tr>
                        <td>". $row['id'] ."</td>
                        <td>". $row['name'] ."</td>
                        <td>". $row['number'] ."</td>
                        <td>". $row['mail'] ."</td>
                        <td>". $row['date'] ."</td>
                        <td>". $row['gen'] ."</td>
                        <td>". $row['about'] ."</td>
                    </tr>"
                );
            }
        ?>
    </table>
    <div>
        <input id="id" type="text" placeholder="id">
        <button id="change" >Изменить</button>
        <button id="delete" >Удалить</button>
    </div>
    <a href="http://u67375.kubsu-dev.ru/Web4/lengStatus.php"><button>Посмотреть статиcтику</button></a>
    <a href="index.php"><button name="exit" type="submit">Выход</button></a>
</body>
</html>