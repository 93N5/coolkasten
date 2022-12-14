<?php
// include_once('index.php');
$dbname = 'bob-vance';
$user = 'bit_academy';
$pass = 'bit';
$host = 'localhost';
$dsn = sprintf("mysql:host=$host;dbname=$dbname;charset=UTF8", $user, $dbname);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$conn = new PDO($dsn,$user, $pass, $options);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

if (isset($_GET['sort']) && strlen(trim($_GET['sort'])) > 0) {
    $sort1 = addslashes(trim($_GET['sort']));
    $sort_coolkasten .= " ORDER BY $sort1";
    $prepared = $conn->prepare($sort_coolkasten);
    $prepared->execute($params);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>coolkasten</title>
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

        <!-- start main -->
        <main>
            <div class="container">
                <div class="title text-light bg-dark mx-auto px-4">
                    <h1>COOLkasten</h1>
                    <p>
                        koop hier je koelkasten, bij COOLkasten.nl.
                    </p>
                </div>

                <!-- start info -->
                <div class="card">
                    <div class="card-body">
                        <p>
                            <b>Dit is COOLkasten</b>, het bedrijf waar jij je koelkasten gaat kopen.
                            Het bedrijf levert al meer dan 10 jaar kwaliteit koelkasten aan California, Los Angeles,
                            waar mee de oprichter in zijn eentje is begonnen | zie voor meer informatie over de oprichter op de <a href="me.php">about me</a> pagina. |
                            <br><b>COOLkasten</b> verzerkt uw koelkaten spik en span aan te leveren op uw adres door de verzerkte handmatige controles die wij doen.
                        </p>
                    </div>
                </div>
                <br>
                <!-- end info -->

                <!-- start koelkasten -->
                <div class="p-3 mb-2 bg-light text-dark">
                    <table class="table table-group-divider">
                        <tr>
                            <th>naam</th>
                            <th>euro</th>
                            <th>zie meer</th>
                            <th>edit</th>
                        </tr>
                        <?php
                        if ($prepared->rowCount() > 0) {
                            $prepared->setFetchMode(PDO::FETCH_ASSOC);
                            while ($row = $prepared->fetch()) {
                        ?>
                                <tr id="<?= $row['id'] ?>">
                                    <td><?= $row['naam']  ?></td>
                                    <td><?= $row['euro'] ?></td>
                                    <td><a href="details.php?id=<?= $row['id'] ?>">zie meer</a></td>
                                    <th><a href="edit.php?e_id=<?= $row['id'] ?>">edit</a></th>
                            <?php
                            }
                            echo '</table>';
                        } else {
                            echo '<h2>geen table data</h2>';
                        }
                            ?>
                    </table>
                </div>
                <!-- end koelkasten -->
            </div>
        </main>
        <!-- end main -->

        <!-- start footer -->
        <footer class="text-center text-lg-start bg-light text-muted">

            <!-- Section: Links  -->
            <section class="">
                <div class="container text-center text-md-start mt-5">
                    <!-- Grid row -->
                    <div class="row mt-3">
                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                            <!-- Content -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                <i class="fas fa-gem me-3"></i>COOLkasten
                            </h6>
                            <p>
                                het bedrijf bestaat al <b>10 jaar</b> en daar zijn we erg blij mee.
                                je ziet dat we kwaliteit leveren. bestel op de website, of neem contact met ons op om kwaliteit koelkasten te kopen.
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                Useful links
                            </h6>
                            <p>
                                <a href="me.php" class="text-reset">about me</a>
                            </p>
                            <p>
                                <a href="add.php" class="text-reset">voeg een item toe</a>
                            </p>
                            <p>
                                <a href="edit.php" class="text-reset">bewerk alle items</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                            <p>
                                <i class="fas fa-envelope me-3">
                                    <a href="https://github.com/93N5/coolkasten">https://github.com/93N5/coolkasten</a>
                                </i>
                            </p>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                </div>
            </section>
            <!-- Section: Links  -->

            <!-- Copyright -->
            <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2022 Copyright:
                <a class="text-reset fw-bold" href="home.php">COOLkasten</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- end footer -->
    </div>
</body>

</html>