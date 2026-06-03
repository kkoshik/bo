<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>
<body>

    <header>
        <img src="./img/logo.png" alt="logo" loading="lazy">
        <h1>НАЗВАНИЕ_САЙТА</h1>
        <nav>
            <a href="./formirovanie.php">Создать заявку</a>
            <a href="./logout.php">Выход</a>
        </nav>
    </header>

    <main>
        <h1>Личный кабинет</h1>
        <p>ОПИСАНИЕ_САЙТА</p>

        <div id="slider">
            <button onclick='slidedown()'><</button>
            <img src='./img/1.webp' alt='slide1'>
            <button onclick='slideup()'>></button>
        </div>

        <?
            if (!(isset($_COOKIE['login'])) || !(isset($_COOKIE['role']))) {
                header('Location: ./index.php');
            } else if ($_COOKIE['role'] == 'Администратор') {
                header('Location: ./admin.php');
            } else {
                include './db.php';

                if (isset($_POST['id']) && isset($_POST['review'])) {
                    $dbh = $pdo -> prepare("UPDATE tasks SET review = :review WHERE id = :id AND login = :login AND status != 'Новая'");
                    $dbh -> execute(['review' => $_POST['review'], 'id' => $_POST['id'], 'login' => $_COOKIE['login']]);
                }

                $dbh = $pdo -> prepare("SELECT * FROM tasks WHERE login = :login ORDER BY id DESC");
                $dbh -> execute(['login' => $_COOKIE['login']]);
                $tasks = $dbh->fetchALL(PDO::FETCH_ASSOC);

                echo '<h2>Мои заявки</h2>';
                echo '<div class="tasks">';
                foreach ($tasks as $task) {
                    echo '<div class="task">';
                    echo '<div class="task-title">Заявка #' . $task['id'] . '</div>';
                    echo '<div class="task-row"><b>Услуга:</b> <span>' . $task['name'] . '</span></div>';
                    echo '<div class="task-row"><b>Дата:</b> <span>' . $task['date'] . '</span></div>';
                    echo '<div class="task-row"><b>Оплата:</b> <span>' . $task['oplata'] . '</span></div>';
                    echo '<div class="task-row"><b>Статус:</b> <span class="status">' . $task['status'] . '</span></div>';

                    if ($task['status'] != 'Новая') {
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                        echo "<input type='text' name='review' placeholder='Отзыв' value='" . $task['review'] . "'>";
                        echo "<button type='submit'>Оставить отзыв</button>";
                        echo "</form>";
                    } else {
                        echo "<p class='small-text'>Отзыв можно оставить после изменения статуса заявки</p>";
                    }

                    echo '</div>';
                }
                echo '</div>';
            }
        ?>
    </main>

    <script src='./slider.js'></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
