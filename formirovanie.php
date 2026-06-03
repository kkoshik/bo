<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Формирование заявки</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>
<body>

    <header>
        <img src="./img/logo.png" alt="logo" loading="lazy">
        <h1>НАЗВАНИЕ_САЙТА</h1>
        <nav>
            <a href="./home.php">Вернуться</a>
            <a href="./logout.php">Выход</a>
        </nav>
    </header>

    <main>
        <h1>Формирование заявки</h1>
        <form method="post">
            <select name='name' required>
                <option value='ВАРИАНТ_1'>ВАРИАНТ_1</option>
                <option value='ВАРИАНТ_2'>ВАРИАНТ_2</option>
                <option value='ВАРИАНТ_3'>ВАРИАНТ_3</option>
                <option value='ВАРИАНТ_4'>ВАРИАНТ_4</option>
            </select>
            <input type="text" name="date" placeholder="ДД.ММ.ГГГГ" required>
            <select name='oplata'>
                <option value='Наличными'>Наличными</option>
                <option value='Переводом'>Переводом</option>
                <option value='Картой'>Картой</option>
            </select>
            <button type="submit">Отправить</button>
        </form>

        <?
            if (!(isset($_COOKIE['login'])) || !(isset($_COOKIE['role']))) {
                header('Location: ./index.php');
            }

            if (isset($_POST['name']) && isset($_POST['date']) && isset($_POST['oplata'])) {
                include './db.php';
                $dbh = $pdo -> prepare("INSERT INTO tasks (login, name, date, oplata, status) VALUES (:login, :name, :date, :oplata, 'Новая')");
                $dbh -> execute([
                    'login' => $_COOKIE['login'],
                    'name' => $_POST['name'],
                    'date' => $_POST['date'],
                    'oplata' => $_POST['oplata']
                ]);
                echo '<p>Заявка отправлена на рассмотрение</p>';
            }
        ?>
    </main>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
