<?php
function show_error($error) {
    echo $error;
}

function get_db() {
    return new PDO('mysql:host=localhost;dbname=quizilla', 'ninja', 'ninja');
}

function get_userid() {
    return 1;
}

// HTML Components
function get_header() {
    return '
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">Quizilla</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="esercizi.php">Esercizi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="verifiche.php">Verifiche</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="stats.php">Statistiche</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    ';
}
?>