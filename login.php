<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/Users.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userClass = new Users();

    // Vérification des informations de connexion
    $userId = $userClass->verifyPassword($username, $password);

    if ($userId) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php'); 
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Connexion</h2>
                <?php if (isset($error)) { echo '<p class="text-danger">' . $error . '</p>'; } ?>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
