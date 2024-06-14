<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz Night</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h1>Bienvenue sur Quiz Night</h1>
    <p>Découvrez et participez à des quiz sur divers sujets passionnants !</p>
    <a href="all_quizzes.php" class="btn btn-primary">Voir tous les quiz</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="create_quiz.php" class="btn btn-success">Créer un quiz</a>
    <?php endif; ?>
</div>
</body>
</html>

