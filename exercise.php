<?php
require 'functions.php';

$conn = get_db();

// Vars
$exercise = '';
$questions = [];

// Check if user has access to exercise
$userid = get_userid();
$stmt = $conn->prepare('SELECT status FROM exercises_statuses WHERE user_id = ? AND exercise_id = ?');
$stmt->execute([$userid, $_GET['id']]);
if ($stmt->fetch(PDO::FETCH_NUM)[0] === 'todo') {
    // Get exercise title
    $stmt = $conn->prepare('SELECT exercise FROM exercises WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $exercise = $stmt->fetch(PDO::FETCH_NUM)[0];

    // Get exercise questions
    $stmt = $conn->prepare('SELECT id, question FROM questions WHERE exercise_id = ?');
    $stmt->execute([$_GET['id']]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $questions[] = $row;
    }

    // For every question, get possible answers
    for ($i = 0; $i < count($questions); $i++) {
        $stmt = $conn->prepare('SELECT id, answer FROM answers WHERE question_id = ?');
        $stmt->execute([$questions[$i]['id']]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $questions[$i]['answers'][] = $row;
        }
    }
}
?>

<!doctype html>
<html lang="it">
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="Astro description" />
        <meta name="viewport" content="width=device-width" />
        <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
        <meta name="generator" content={Astro.generator} />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Quizilla</title>
    </head>
    <body>
        <?= get_header() ?>

        <main class="container my-3">
            <section class="mb-3">
                <h3 class="mb-3"><?= $exercise ?></h3>
                <?php foreach ($questions as $question): ?>
                    <div class="d-flex flex-column mb-4">
                        <p class="mb-1"><?= $question['question']?></p>
                        <?php foreach ($question['answers'] as $answer): ?>
                            <div class="d-flex gap-3">
                                <input class="form-check-input" type="radio" name="<?= $question['id'] ?>" id="<?= $answer['id'] ?>" value="<?= $answer['id'] ?>">
                                <label class="form-check-label" for="<?= $answer['id'] ?>"><?= $answer['answer'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>