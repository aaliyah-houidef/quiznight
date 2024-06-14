<?php
require_once 'classes/Quiz.php';
require_once 'classes/Questions.php';
require_once 'classes/Categories.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$categoryClass = new Categories();
$categories = $categoryClass->getAllCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $questions = $_POST['questions'];

    $quizClass = new Quiz();
    $questionClass = new Questions();

    try {
        $quiz_id = $quizClass->createQuiz($title, $description, $_SESSION['user_id'], $category_id);

        foreach ($questions as $question_text) {
            $questionClass->addQuestion($quiz_id, $question_text);
        }

        header('Location: add_answers.php?quiz_id=' . $quiz_id);
        exit();
    } catch (Exception $e) {
        $error = "Erreur lors de la création du quiz : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Quiz</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Créer un Quiz</h2>
    <?php if (isset($error)) { echo '<p class="text-danger">' . $error . '</p>'; } ?>
    <form method="post">
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Catégorie</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="questions-container">
            <div class="question-group mb-3">
                <div class="form-group">
                    <label for="questions[]">Question</label>
                    <input type="text" class="form-control" name="questions[]" required>
                </div>
                <button type="button" class="btn btn-danger remove-question">Supprimer cette question</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="add-question">Ajouter une question</button>
        <button type="submit" class="btn btn-primary mt-3">Créer le quiz</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#add-question').click(function() {
            var questionGroup = $('.question-group').first().clone();
            questionGroup.find('input').val('');
            $('#questions-container').append(questionGroup);
        });

        $(document).on('click', '.remove-question', function() {
            if ($('.question-group').length > 1) {
                $(this).closest('.question-group').remove();
            } else {
                alert('Il doit y avoir au moins une question.');
            }
        });
    });
</script>
</body>
</html>
