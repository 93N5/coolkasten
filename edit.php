<?php
$dbname = 'bob-vance';
$user = 'bit_academy';
$pass = 'bit';
$host = 'localhost';
$dsn = sprintf("mysql:host=$host;dbname=$dbname;charset=UTF8", $user, $dbname);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$conn = new PDO($dsn, $user, $pass, $options);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['e_id']) && ctype_digit($_GET['e_id'])) {
    $e_id = intval($_GET['e_id']);
    $edit_id_coolkasten = "SELECT * FROM coolkasten WHERE id=? "; 
    $prepared4 = $conn->prepare($edit_id_coolkasten);
    $prepared4->execute(array($e_id));
} else {
    $edit_id_coolkasten = "SELECT * FROM coolkasten ";
    $prepared4 = $conn->prepare($edit_id_coolkasten);
    $prepared4->execute(array());
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>edit item</title>
</head>
<body>
    <div class="container">
        <!-- start navbar -->
        <nav class="navbar navbar-expand-lg bg-primary text-white">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">COOLkasten</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="me.php">about me</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add.php">toevoegen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- end navbar -->

        <!-- start edit -->
        <div class="title text-light bg-dark mx-auto px-4">
            <h2>edit item</h2>
            <?php
            if (isset($_POST['submit'])) {
                $naam = $_POST['naam'];
                $euro = $_POST['euro'];
                $energieklasse = $_POST['energieklasse'];
                $cm = $_POST['cm'];
                $img = $_FILES['img'];
                
                $imagefilename = $img['name'];
                $imagefileerror = $img['error'];
                $imagefiletmp = $img['tmp_name'];
                $filename_separate = explode('.', $imagefilename);
                $file_extension = strtolower(end($filename_separate));

                $extension = ['jpeg', 'jpg', 'png'];
                if (in_array($file_extension, $extension)) {
                    $upload_image = 'images/' . $imagefilename;
                    move_uploaded_file($imagefiletmp, $upload_image);
                    $edit = "UPDATE coolkasten SET naam=?, euro=?, energieklasse=?, cm=?, img=? WHERE id=? ";
                    $prepared = $conn->prepare($edit);
                    $prepared->execute(array($naam, $euro, $energieklasse, $cm, $upload_image, $e_id));
                    echo "<h2>item is succesvol aangepast</h2>";
                }
            }
            
            while ($row = $prepared4->fetch(PDO::FETCH_ASSOC)) {
                echo "<form enctype='multipart/form-data' action='edit.php?e_id=" . $row['id'] . "' method='post'>";
                echo "<table>";
                echo "<tr>
                <th>naam</th>
                <td><input type='text' name='naam' value='" . $row['naam'] . "'></td>
                </tr>
                <tr>
                    <th>euro</th>
                    <td><input type='number' name='euro' value='" . $row['euro'] . "'></td>
                </tr>
                <tr>
                    <th>energieklasse</th>
                    <td><input type='text' name='energieklasse' value='" . $row['energieklasse'] . "'></td>
                </tr>
                <tr>
                    <th>cm</th>
                    <td><input type='number' name='cm' value='" . $row['cm'] . "'></td>
                </tr>
                <tr>
                    <th>img</th>
                    <td><input type='file' name='img' value='" . $row['img'] . "'></td>
                </tr>";
                echo "</table>";
                echo "<br><br>";
                echo "<input type='submit' name='submit' value='edit item'>";
                echo "</form>";
            }
            ?>
            </div>
            <!-- end edit -->
        </div>
    </body>
</html>