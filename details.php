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

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = intval($_GET['id']);
    $id_coolkasten = "SELECT * FROM coolkasten WHERE id=? "; 
    $prepared2 = $conn->prepare($id_coolkasten);
    $prepared2->execute(array($id));
} else {
    $id_coolkasten = "SELECT * FROM coolkasten ";
    $prepared2 = $conn->prepare($id_coolkasten);
    $prepared2->execute(array());
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>details</title>
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

        <!-- start details -->
        <div class="p-3 mb-2 bg-light text-dark">
        <?php
        if ($prepared2->rowCount() > 0) {
            $row = $prepared2->fetch();
            echo '<h2>' . $row['naam'] . '</h2>';
            echo '<table class="table table-group-divider">';
            echo "<tr>";
            echo "<th>naam</th>";
            echo "<th>euro</th>";
            echo "<th>energieklasse</th>";
            echo "<th>cm</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>" . $row['naam'] . "</td>";
            echo "<td>" . $row['euro'] . "</td>";
            echo "<td>" . $row['energieklasse'] . "</td>";
            echo "<td>" . $row['cm'] . "</td>";
            ?>
            <?php
            echo "</tr>";
            echo "</table>";
            ?>
            <img src="<?php echo $row['img'] ?>" alt="<?php echo $row['naam'] ?>">
            <hr>
            <?php
            }
            ?>
            </div>
            <!-- end details -->
    </div>
</body>
</html>