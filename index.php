<?php
require 'functions.php';

$conn = get_db();

// Vars
$exercises = [];

// Get exercises
$result = $conn->query('SELECT id, exercise FROM exercises');
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $exercises[] = $row;
}
// Get exercises statuses for current user
$userid = get_userid();
$stmt = $conn->prepare('SELECT exercise_id, status FROM exercises_statuses WHERE user_id = ?');
$stmt->execute([$userid]);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    for ($i = 0; $i < count($exercises); $i++) {
        if ($exercises[$i]['id'] === $row['exercise_id']) {
            $exercises[$i]['status'] = $row['status'];
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
                <h3 class="mb-3">Esercizi</h3>
                <div class="list-group">
                    <?php foreach ($exercises as $exercise): ?>
                        <a href="<?= 'exercise.php?id=' . $exercise['id'] ?>" class="p-3 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <?= $exercise['exercise'] ?>
                            <?php
                            switch ($exercise['status']) {
                                case 'completed':
                                    echo '<span class="badge text-bg-success rounded-pill">Completato</span>';
                                    break;
                                case 'todo':
                                    echo '<span class="badge text-bg-danger rounded-pill">Da fare</span>';
                                    break;
                                case 'locked':
                                    echo '<span class="badge text-bg-secondary rounded-pill">Bloccato</span>';
                                    break;
                            }
                            ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
