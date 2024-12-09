<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create a single database connection
try {
    $db = new PDO('mysql:host=localhost;dbname=tech-one', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate and fetch data based on ID
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare and execute the product query
        $query = $db->prepare("SELECT * FROM products WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);

        // Fetch reviews for the specific product
        $query2 = $db->prepare("SELECT * FROM Review WHERE product_id = :product_id");
        $query2->bindParam(':product_id', $id, PDO::PARAM_INT);
        $query2->execute();
        $reviews = $query2->fetchAll(PDO::FETCH_ASSOC);

    } else {
        echo "Invalid ID.";
        exit; // Exit if the ID is invalid
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit; // Exit after displaying the error
}

// Review system logic
const NAME_REQUIRED = 'Naam invullen';
const REVIEW_REQUIRED = 'Review invullen';
const AGREE_REQUIRED = 'Voorwaarden accepteren';

$errors = [];
$inputs = [];

if (isset($_POST['send'])) {
    // Sanitize and validate name
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $inputs['name'] = $name;
    $name = trim($name);
    if (empty($name)) {
        $errors['name'] = NAME_REQUIRED;
    }

    // Sanitize and validate review content
    $review = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $inputs['content'] = $review;
    $review = trim($review);
    if (empty($review)) {
        $errors['content'] = REVIEW_REQUIRED;
    }

    // Validate rating
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    if ($rating < 1 || $rating > 5) {
        $errors['rating'] = 'Selecteer een rating tussen 1 en 5';
    }

    // Check if terms are accepted
    $agree = filter_input(INPUT_POST, 'agree', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($agree)) {
        $errors['agree'] = AGREE_REQUIRED;
    }

    // If no errors, insert review into database
    if (count($errors) === 0) {
        $sth = $db->prepare('INSERT INTO review (name, content, rating, product_id, likes) VALUES (:name, :content, :rating, :product_id, 0)');
        $sth->bindParam(':name', $inputs['name']);
        $sth->bindParam(':content', $inputs['content']);
        $sth->bindParam(':rating', $rating);
        $sth->bindParam(':product_id', $id, PDO::PARAM_INT); // Use the validated product ID
        $result = $sth->execute();

        if ($result) {
            echo "<p class='text-success'>Review succesvol toegevoegd!</p>";
            // Refresh reviews after adding a new one
            $query2->execute(); // Re-fetch reviews to show the new one
            $reviews = $query2->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "<p class='text-danger'>Er is een fout opgetreden bij het toevoegen van de review.</p>";
        }
    }
}

// Like system
if (isset($_POST['like_review'])) {
    $review_id = filter_input(INPUT_POST, 'review_id', FILTER_VALIDATE_INT);

    if ($review_id) {
        // Update the likes in the database
        $sth = $db->prepare('UPDATE review SET likes = likes + 1 WHERE id = :id');
        $sth->bindParam(':id', $review_id, PDO::PARAM_INT);
        $result = $sth->execute();

        if ($result) {
            // you might want to give feedback or reload the reviews here
            echo "<p class='text-success'>Je hebt deze review leuk gevonden!</p>";
        } else {
            echo "<p class='text-danger'>Er is een fout opgetreden bij het liken van de review.</p>";
        }
    } else {
        echo "<p class='text-danger'>Ongeldig review ID.</p>";
    }
}
?>
