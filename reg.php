<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>
<body>

    <header>
        <img src="./img/logo.png" alt="logo" loading="lazy">
        <h1>НАЗВАНИЕ_САЙТА</h1>
        <nav>
            <a href="./index.php">Авторизация</a>
            <a href="./reg.php">Регистрация</a>
        </nav>
    </header>

    <main>
        <h1>Регистрация</h1>
        <? include './forms/reg_form.php'; ?>

        <?
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];
                $fio = $_POST['fio'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];

                if (!preg_match('/^[A-Za-z0-9]{6,}$/', $login)) {
                    echo '<p>Логин должен содержать латинские буквы и цифры, минимум 6 символов</p>';
                } else if (strlen($password) < 8) {
                    echo '<p>Пароль должен быть минимум 8 символов</p>';
                } else if (strlen($fio) < 5) {
                    echo '<p>Введите корректное ФИО</p>';
                } else if (strpos($email, '@') === false || strpos($email, '.') === false) {
                    echo '<p>Введите корректный email</p>';
                } else if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
                    echo '<p>Телефон должен содержать от 10 до 15 цифр</p>';
                } else {
                    try {
                        include './db.php';
                        $dbh = $pdo -> prepare("SELECT * FROM users WHERE login = :login");
                        $dbh -> execute(['login' => $login]);

                        if ($dbh->rowCount() > 0) {
                            echo '<p>Такой логин уже есть</p>';
                        } else {
                            $dbh = $pdo -> prepare("INSERT INTO users (login, password, fio, birthday, email, phone, role) VALUES (:login, :password, :fio, :birthday, :email, :phone, 'Пользователь')");
                            $dbh -> execute([
                                'login' => $login,
                                'password' => $password,
                                'fio' => $fio,
                                'birthday' => $_POST['birthday'] == '' ? null : $_POST['birthday'],
                                'email' => $email,
                                'phone' => $phone
                            ]);

                            setcookie('login', $login, time() + 3600, '/');
                            setcookie('role', 'Пользователь', time() + 3600, '/');
                            header('Location: ./home.php');
                        }
                    } catch (PDOException $error) {
                        print_r($error);
                    }
                }
            }
        ?>
    </main>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
