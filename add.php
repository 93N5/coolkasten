<?php
require_once('index.php');

$params = array();
$tablecoolkasten = true;
$sort_coolkasten = "SELECT * FROM coolkasten ";

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $tablecoolkasten = false;
    $id = intval($_GET['id']);
    $id_coolkasten = "SELECT * FROM coolkasten WHERE id=? "; 
    $prepared = $conn->prepare($id_coolkasten);
    $prepared->execute(array($id));
} else {
    $id_coolkasten = "SELECT * FROM coolkasten ";
    $prepared = $conn->prepare($id_coolkasten);
    $prepared->execute(array());
}

// --------------------------------------------------------------------

$table_edit_coolkasten = true;

if (isset($_GET['e_id']) && ctype_digit($_GET['e_id'])) {
    $table_edit_coolkasten = false;
    $e_id = intval($_GET['e_id']);
    $edit_id_coolkasten = "SELECT * FROM coolkasten WHERE id=? "; 
    $prepared3 = $conn->prepare($edit_id_coolkasten);
    $prepared3->execute(array($e_id));
} else {
    $edit_id_coolkasten = "SELECT * FROM coolkasten ";
    $prepared3 = $conn->prepare($edit_id_coolkasten);
    $prepared3->execute(array());
}

// --------------------------------------------------------------------

$table_add_coolkasten = true;

if (isset($_GET['amid']) && ctype_digit($_GET['amid'])) {
    $table_add_coolkasten = false;
    $amid = intval($_GET['amid']);
    $add_id_coolkasten = "SELECT * FROM coolkasten WHERE id=? "; 
    $prepared7 = $conn->prepare($add_id_coolkasten);
    $prepared7->execute(array($amid));
} else {
    $add_id_coolkasten = "SELECT * FROM coolkasten ";
    $prepared7 = $conn->prepare($add_id_coolkasten);
    $prepared7->execute(array());
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>voeg een item toe</title>
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

        <!-- start toevoegen -->
        <div class="title text-light bg-dark mx-auto px-4">
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
                    $sql = "INSERT INTO coolkasten (naam, euro, energieklasse, cm, img) 
                    VALUES (:naam, :euro, :energieklasse, :cm, :img)";
                    $prepared = $conn->prepare($sql);
                    $prepared->bindParam(':naam', $naam);
                    $prepared->bindParam(':energieklasse', $energieklasse);
                    $prepared->bindParam(':euro', $euro);
                    $prepared->bindParam(':cm', $cm);
                    $prepared->bindParam(':img', $upload_image);
                    $prepared->execute();
                    echo '<p>item toegevoegd</p>';
                }
            }
            ?>
            <h2>add item</h2>
            <form action="add.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <th>naam</th>
                        <td><input type="text" name="naam"></td>
                    </tr>
                    <tr>
                        <th>euro</th>
                        <td><input type="number" name="euro"></td>
                    </tr>
                    <tr>
                        <th>energieklasse</th>
                        <td><input type="text" name="energieklasse"></td>
                    </tr>
                    <tr>
                        <th>cm</th>
                        <td><input type="number" name="cm"></td>
                    </tr>
                    <tr>
                        <th>img</th>
                        <td><input type="file" name="img"></td>
                    </tr>
                </table>
                <br>
                <input type="submit" name="submit" value="submit">
                <br>
            </form>
        </div>
        <!-- end toevoegen -->
    </div>
</body>
</html>