<?php
require_once 'classes/Quiz.php';
require_once 'classes/Questions.php';
require_once 'classes/Answers.php';

session_start();

if (!isset($_GET['id'])) {
    die("Quiz non spécifié.");
}

$quiz_id = $_GET['id'];

$quizClass = new Quiz();
$questionClass = new Questions();
$answerClass = new Answers();

try {
    $quiz = $quizClass->getQuizById($quiz_id);
    $questions = $questionClass->getQuestionsByQuiz($quiz_id);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

$isCreator = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $quiz['create_id'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Quiz</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2><?php echo htmlspecialchars($quiz['title']); ?></h2>
    <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($quiz['category_name']); ?></p>
    <p><?php echo htmlspecialchars($quiz['description']); ?></p>

    <?php if ($isCreator): ?>
        <a href="edit_quiz.php?id=<?php echo $quiz_id; ?>" class="btn btn-primary mb-3">Ajouter une question</a>
    <?php endif; ?>

    <h3>Questions</h3>
    <?php if (!empty($questions)): ?>
        <div id="quizCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
            <div class="carousel-inner">
                <?php foreach ($questions as $index => $question): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="d-flex justify-content-center">
                            <div class="question-container">
                                <strong><?php echo htmlspecialchars($question['question']); ?></strong>
                                <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapse<?php echo $question['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $question['id']; ?>">
                                    Voir les réponses
                                </button>
                                <div class="collapse mt-2" id="collapse<?php echo $question['id']; ?>">
                                    
                                        <?php 
                                        $answers = $answerClass->getAnswersByQuestion($question['id']);
                                        foreach ($answers as $answer): ?>
                                            <p><?php echo htmlspecialchars($answer['answer']); ?></p>
                                        <?php endforeach; ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#quizCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Précédent</span>
            </a>
            <a class="carousel-control-next" href="#quizCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Suivant</span>
            </a>
        </div>
    <?php else: ?>
        <p>Aucune question disponible pour ce quiz.</p>
    <?php endif; ?>
</div>
</body>
</html>
