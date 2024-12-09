<?php

//login systeem
session_start();

try {
    // Maak verbinding met de database
    $db = new PDO('mysql:host=localhost;dbname=tech-one;charset=utf8', 'root', '');

    // Controleer of het formulier is ingediend
    if (isset($_POST['login'])) { // Aangepast van 'submit' naar 'login'
        // Sanitize input
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Bereid de query voor om op basis van e-mailadres te zoeken
        $query = $db->prepare("SELECT * FROM user WHERE email = :email");
        $query->bindParam(':email', $email);

        // Voer de query uit
        $query->execute();

        // Controleer of er een gebruiker met het opgegeven e-mailadres is gevonden
        if ($query->rowCount() == 1) {
            // Haal de gegevens van de gebruiker op
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // Controleer of het ingevoerde wachtwoord overeenkomt met het gehashte wachtwoord
            if (password_verify($password, $result['password'])) {
                // Sla een succesbericht op in de sessie
                $_SESSION['success_message'] = "U bent succesvol ingelogd!";

                // Optioneel: sla ook gebruikersinformatie op in de sessie
                $_SESSION['user'] = $result['email'];

                // Redirect naar de homepage
                header("Location: index.php");
                exit(); // Stop verdere uitvoering van het script
            } else {
                echo "Onjuiste gegevens";
            }
        } else {
            echo "De gegevens zijn onjuist";
        }

        echo "<br>";
    }
} catch (PDOException $e) {
    die("Fout! : " . $e->getMessage());
}

//register systeem
$db = new PDO('mysql:host=localhost;dbname=tech-one;charset=utf8', 'root', '');
$query = $db->prepare('SELECT *FROM user');
$query->execute();

include_once 'modules/database.php';
include_once 'modules/function.php';

const FIRSTNAME_REQUIRED = 'Voornaam invullen';
const LASTNAME_REQUIRED = 'Achternaam invullen';
const EMAIL_REQUIRED = 'E-mail invullen';
const PASSWORD_REQUIRED = 'Password invullen';

$errors = [];
$inputs = [];

if (isset($_POST['send'])) {
    //firstname part
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $inputs['firstname'] = $firstname;
    $firstname = trim($firstname);
    if (empty($firstname)) {
        $errors['firstname'] = FIRSTNAME_REQUIRED;
    }


    //lastname part
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    $inputs["lastname"] = $lastname;

    $lastname = trim($lastname);
    if (empty($lastname)) {
        $errors['lastname'] = LASTNAME_REQUIRED;
    }

    //email part
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email === false) {
        $errors['email'] = EMAIL_REQUIRED;
    } else {
        $inputs["email"] = $email;
    }

    //password part
    $password = filter_input(INPUT_POST, 'password');

    if ($password === '') {
        $errors['password'] = PASSWORD_REQUIRED;
    } else {
        $inputs["password"] = password_hash($password, PASSWORD_DEFAULT);
    }


    if (count($errors) === 0) {
        global $db;

        // Correct SQL statement
        $sth = $db->prepare('INSERT INTO user (email, password, first_name, last_name, role) VALUES (:email, :password, :firstname, :lastname, "member")');
        $sth->bindParam(':firstname', $inputs['firstname']);
        $sth->bindParam(':lastname', $inputs['lastname']);
        $sth->bindParam(':email', $inputs['email']);
        $sth->bindParam(':password', $inputs['password']);

        $result = $sth->execute();
    }
}
?>