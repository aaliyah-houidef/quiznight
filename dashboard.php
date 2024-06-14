<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'classes/Users.php';
require_once 'classes/Quiz.php';

$user_id = $_SESSION['user_id'];
$userClass = new Users();
$user = $userClass->getUserById($user_id);
$quizClass = new Quiz();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Créez le quiz en passant l'ID de l'utilisateur connecté
    $quizCreated = $quizClass->createQuiz($title, $description, $user_id);
    
    if ($quizCreated) {
        echo "Quiz créé avec succès.";
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Erreur lors de la création du quiz";
    }
}

$userQuizzes = $quizClass->getQuizzesByUser($user_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord</title>
</head>
<body>
<?php include 'header.php'; ?>
    <h2>Bienvenue, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <p>Ceci est votre tableau de bord.</p>
    <h3>Vos Quizs</h3>
    <?php
    if (!empty($userQuizzes)) {
        foreach ($userQuizzes as $quiz) {
            echo "<div>";
            echo "<h4>" . htmlspecialchars($quiz["title"]) . "</h4>";
            echo "<p>" . htmlspecialchars($quiz["description"]) . "</p>";
            echo "<a href='quiz.php?id=" . htmlspecialchars($quiz["id"]) . "'>Voir le quiz</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Vous n'avez créé aucun quiz pour l'instant.</p>";
    }
    ?>
    <h3>Créer un nouveau quiz</h3>
    <?php if (isset($error)) { echo '<p style="color:red;">' . $error . '</p>'; } ?>
    <form method="post" action="dashboard.php">
        <label for="title">Titre du quiz:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <button type="submit">Créer le quiz</button>
    </form>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
