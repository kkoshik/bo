<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админка</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>
<body>

    <header>
        <img src="./img/logo.png" alt="logo" loading="lazy">
        <h1>НАЗВАНИЕ_САЙТА</h1>
        <nav>
            <a href="./logout.php">Выход</a>
        </nav>
    </header>

    <main>
        <h1>Панель администратора</h1>

        <form method="get" class="admin-tools">
            <select name="filter">
                <option value="">Все заявки</option>
                <option value="Новая">Новая</option>
                <option value="СТАТУС_2">СТАТУС_2</option>
                <option value="СТАТУС_3">СТАТУС_3</option>
            </select>
            <select name="sort">
                <option value="id">Сначала новые</option>
                <option value="date">Сортировка по дате</option>
                <option value="status">Сортировка по статусу</option>
                <option value="login">Сортировка по логину</option>
            </select>
            <button type="submit">Фильтр</button>
        </form>

        <form method="post">
            <h2>Изменение статуса заявки</h2>
            <input type="text" name="id" placeholder="id">
            <select name='status'>
                <option value='Новая'>Новая</option>
                <option value='СТАТУС_2'>СТАТУС_2</option>
                <option value='СТАТУС_3'>СТАТУС_3</option>
            </select>
            <button type="submit">Изменить</button>
        </form>

        <?
            if (!(isset($_COOKIE['login'])) || !(isset($_COOKIE['role']))) {
                header('Location: ./index.php');
            } else if ($_COOKIE['role'] == 'Пользователь') {
                header('Location: ./home.php');
            } else if ($_COOKIE['role'] == 'Администратор') {
                include './db.php';

                if (isset($_POST['id']) && isset($_POST['status'])) {
                    $dbh = $pdo -> prepare("UPDATE tasks SET status = :status WHERE id = :id");
                    $dbh -> execute(['status' => $_POST['status'], 'id' => $_POST['id']]);
                    echo '<div class="popup">Статус заявки изменен</div>';
                    echo "<script>setTimeout(function(){document.querySelector('.popup').style.display='none';}, 3000);</script>";
                }

                $page = 1;
                if (isset($_GET['page'])) {
                    $page = (int)$_GET['page'];
                }
                if ($page < 1) {
                    $page = 1;
                }

                $limit = 4;
                $start = ($page - 1) * $limit;

                $sort = 'id';
                if (isset($_GET['sort'])) {
                    if ($_GET['sort'] == 'date') {
                        $sort = 'date';
                    } else if ($_GET['sort'] == 'status') {
                        $sort = 'status';
                    } else if ($_GET['sort'] == 'login') {
                        $sort = 'login';
                    }
                }

                if (isset($_GET['filter']) && $_GET['filter'] != '') {
                    $dbh = $pdo -> prepare("SELECT COUNT(*) FROM tasks WHERE status = :status");
                    $dbh -> execute(['status' => $_GET['filter']]);
                    $count = $dbh->fetchColumn();

                    $dbh = $pdo -> prepare("SELECT * FROM tasks WHERE status = :status ORDER BY $sort DESC LIMIT $start, $limit");
                    $dbh -> execute(['status' => $_GET['filter']]);
                } else {
                    $dbh = $pdo -> prepare("SELECT COUNT(*) FROM tasks");
                    $dbh -> execute([]);
                    $count = $dbh->fetchColumn();

                    $dbh = $pdo -> prepare("SELECT * FROM tasks ORDER BY $sort DESC LIMIT $start, $limit");
                    $dbh -> execute([]);
                }

                $tasks = $dbh->fetchALL(PDO::FETCH_ASSOC);
                $pages = ceil($count / $limit);

                echo '<h2>Заявки пользователей</h2>';
                echo '<div class="tasks">';
                foreach ($tasks as $task) {
                    echo '<div class="task">';
                    echo '<div class="task-title">Заявка #' . $task['id'] . '</div>';
                    echo '<div class="task-row"><b>Логин:</b> <span>' . $task['login'] . '</span></div>';
                    echo '<div class="task-row"><b>Услуга:</b> <span>' . $task['name'] . '</span></div>';
                    echo '<div class="task-row"><b>Дата:</b> <span>' . $task['date'] . '</span></div>';
                    echo '<div class="task-row"><b>Оплата:</b> <span>' . $task['oplata'] . '</span></div>';
                    echo '<div class="task-row"><b>Статус:</b> <span class="status">' . $task['status'] . '</span></div>';
                    echo '<div class="task-row"><b>Отзыв:</b> <span>' . $task['review'] . '</span></div>';
                    echo '</div>';
                }
                echo '</div>';

                echo '<div class="pagination">';
                for ($i = 1; $i <= $pages; $i++) {
                    $filter = '';
                    if (isset($_GET['filter'])) {
                        $filter = $_GET['filter'];
                    }
                    echo "<a href='?filter=" . urlencode($filter) . "&sort=" . $sort . "&page=" . $i . "'>" . $i . "</a>";
                }
                echo '</div>';
            }
        ?>
    </main>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
