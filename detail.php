<?php
// Maak een verbinding met de database
try {
    $db = new PDO('mysql:host=localhost;dbname=tech-one', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Debug: Controleer of de ID wordt doorgegeven in de URL
    if (isset($_GET['id'])) {
        // Ontvang de ID en echo deze voor debugdoeleinden
        echo "ID ontvangen: " . htmlspecialchars($_GET['id']) . "<br>"; // Veiligheidsmaatregel om XSS te voorkomen
    } else {
        echo "Geen ID ontvangen<br>";
    }

    // Valideer en haal gegevens op op basis van de ID
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        // Bereid de query voor om producten op te halen die bij de vendor_id horen
        $query = $db->prepare("SELECT * FROM products WHERE vendor_id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        // Haal alle producten op
        $products = $query->fetchAll(PDO::FETCH_ASSOC);

    } else {
        // Foutmelding voor een ongeldige ID
        echo "Ongeldige ID.";
    }
} catch (PDOException $e) {
    // Toon de foutmelding bij een databasefout
    echo "Fout: " . $e->getMessage();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <style>
        /*  card styling  */
        .card-image {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- header ophalen  -->
<?php require 'header.php' ?>

<!-- start product container  -->
<main>
    <div class="container-fluid bg-transparent my-4 p-3" style="position: relative;">
        <div class="row p-3"></div>
        <div class="row row-cols-3 g-3 mt-5">
            <?php foreach ($products as $product) : ?>
                <div class="col p-3">
                    <div class="card shadow-sm img-fluid">
                        <img src="<?= $product['img'] ?>" class="card-img-top card-image" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <div class="clearfix mb-3">
                                <span class="float-start badge rounded-pill bg-primary">€<?= $product['price'] ?></span>
                                <span class="float-end"><a href="#">Example</a></span>
                            </div>
                            <h6 class="card-title"><?= $product['name'] ?></h6>
                            <div class="d-grid gap-2 my-4">
                                <a href="product-page.php?id=<?= htmlspecialchars($product['id']) ?>"
                                   class="btn btn-primary text-white">Check offer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end product container  -->
</main>

<!-- footer ophalen  -->
<?php require 'footer.php' ?>

</body>
</html>

