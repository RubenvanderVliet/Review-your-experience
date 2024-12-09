<!-- php file inladen -->
<?php include "backend-product.php"; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/product-2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>
<body>
<!-- header ophalen -->
<?php require 'header.php'?>

<main>
    <!-- start product container  -->
    <div class="container">
        <div class="row">
            <div class="col-12 p-5 mt-5"></div>
        </div>
        <div class="row">
            <div class="col-12 p-2"></div>
        </div>
        <div class="row">
            <?php foreach ($products as $product) : ?>
                <div class="col-6 bg-primary rounded-start p-3 text-white">
                    <h2><?= $product['name'] ?></h2>
                    <img src="<?= $product['img'] ?>" alt="">
                </div>
                <div class="col-6 bg-primary text-white rounded-end p-2 d-flex flex-column justify-content-center align-items-center">
                    <h2>€ <?= $product['price'] ?></h2>
                    <div class="text-center mt-4">
                        <p><?= $product['description'] ?></p>
                    </div>
                    <div class="d-grid gap-2 my-4">
                        <a href="#" class="btn btn-light text-primary">Put in shopping cart</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-12 p-3"></div>
        </div>
    </div>
    <!-- end product container  -->

    <!-- start review container -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="text-primary">Reviews van anderen</h2>
                <p class="text-muted">Lees wat onze klanten te zeggen hebben</p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($reviews as $review): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm border-0 rounded-lg position-relative">
                        <div class="card-body bg-primary position-relative" style="min-height: 200px;">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <h6 class="card-subtitle mb-2 font-weight-bold text-white">
                                        <?= htmlspecialchars($review['name']); ?>
                                    </h6>
                                    <small class="text-white">Gepubliceerd op <?= htmlspecialchars($review['time']); ?></small>
                                </div>
                            </div>
                            <p class="card-text mb-3 text-white">
                                "<?= htmlspecialchars($review['content']); ?>"
                            </p>
                            <div class="stars">
                                <?php
                                $rating = (int)$review['rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '<span class="star filled">&#9733;</span>' : '<span class="star">&#9734;</span>';
                                }
                                ?>
                            </div>

                            <!-- Heart like button -->
                            <form method="post" class="hearts position-absolute bottom-0 end-0 p-3">
                                <input type="hidden" name="review_id" value="<?= $review['id']; ?>">
                                <button type="submit" name="like_review" class="heart" style="border: none; background: none; cursor: pointer;">
                                    <span class="heart">&#10084;</span>
                                </button>
                                <span class="like-count text-white ms-2"><?= $review['likes'] ?> likes</span>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end review container -->

    <!-- start form container   -->
    <div class="container my-5 p-4 rounded shadow-lg bg-primary">
        <h2 class="text-center text-white mb-4">Laat een Review Achter</h2>
        <form method="post" action="">
            <!-- Name input field -->
            <div class="mb-3">
                <label for="name" class="form-label fw-bold text-white">Naam</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?php echo $inputs['name'] ?? '' ?>" required
                       placeholder="Voer je naam in">
                <div class="form-text text-danger">
                    <?= $errors['name'] ?? '' ?>
                </div>
            </div>

            <!-- Star rating -->
            <div class="mb-3 d-flex flex-column">
                <label class="form-label fw-bold text-white">Beoordeel je ervaring</label>
                <div class="stars">
                    <input type="radio" name="rating" id="star1" value="1" required>
                    <label for="star1" class="star">&#9733;</label>
                    <input type="radio" name="rating" id="star2" value="2">
                    <label for="star2" class="star">&#9733;</label>
                    <input type="radio" name="rating" id="star3" value="3">
                    <label for="star3" class="star">&#9733;</label>
                    <input type="radio" name="rating" id="star4" value="4">
                    <label for="star4" class="star">&#9733;</label>
                    <input type="radio" name="rating" id="star5" value="5">
                    <label for="star5" class="star">&#9733;</label>
                </div>
                <div class="form-text text-danger">
                    <?= $errors['rating'] ?? '' ?>
                </div>
            </div>

            <!-- Review textarea field -->
            <div class="mb-3">
                <label for="content" class="form-label fw-bold text-white">Je Review</label>
                <textarea name="content" id="content" class="form-control" rows="4" required
                          placeholder="Schrijf hier je review..."><?php echo $inputs['content'] ?? '' ?></textarea>
                <div class="form-text text-danger">
                    <?= $errors['content'] ?? '' ?>
                </div>
            </div>

            <!-- Agree to terms checkbox -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input text-white" id="agree" name="agree" value="agree"
                    <?php echo(isset($inputs['agree']) ? 'checked="checked"' : '') ?>>
                <label class="form-check-label text-white" for="agree">Ik accepteer de voorwaarden</label>
                <div class="form-text text-danger">
                    <?= $errors['agree'] ?? '' ?>
                </div>
            </div>

            <!-- Submit button -->
            <div class="text-center">
                <input type="submit" class="btn btn-light text-primary btn-lg" name="send" value="Review Versturen">
            </div>
        </form>
    </div>
    <!-- end form container   -->
</main>

<!-- footer ophalen -->
<?php require 'footer.php' ?>
<script src="js/star.js"></script>
</body>
</html>

