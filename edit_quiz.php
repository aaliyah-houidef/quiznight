<?php
require_once 'classes/Quiz.php';
require_once 'classes/Questions.php';
require_once 'classes/Answers.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("Quiz non spécifié.");
}

$quiz_id = $_GET['id'];

$quizClass = new Quiz();
$questionClass = new Questions();

try {
    $quiz = $quizClass->getQuizById($quiz_id);
    if ($quiz['create_id'] != $user_id) {
        die("Vous n'avez pas la permission de modifier ce quiz.");
    }
    $questions = $questionClass->getQuestionsByQuiz($quiz_id);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_question'])) {
        $question_text = $_POST['question_text'];
        $questionClass->addQuestion($quiz_id, $question_text);
        header("Location: edit_quiz.php?id=$quiz_id");
        exit();
    } elseif (isset($_POST['delete_question'])) {
        $question_id = $_POST['question_id'];
        $questionClass->deleteQuestion($question_id);
        header("Location: edit_quiz.php?id=$quiz_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Quiz</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Modifier le Quiz : <?php echo htmlspecialchars($quiz['title']); ?></h2>
    <form method="post">
        <div class="form-group">
            <label for="question_text">Nouvelle Question</label>
            <input type="text" class="form-control" id="question_text" name="question_text" required>
        </div>
        <button type="submit" name="add_question" class="btn btn-primary">Ajouter Question</button>
    </form>
    <hr>
    <h3>Questions Existantes</h3>
    <?php if (!empty($questions)): ?>
        <ul class="list-group">
            <?php foreach ($questions as $question): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($question['question']); ?>
                    <form method="post" style="margin: 0;">
                        <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                        <button type="submit" name="delete_question" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune question disponible pour ce quiz.</p>
    <?php endif; ?>
</div>
</body>
</html>
