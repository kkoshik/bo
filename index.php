<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
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
        <h1>Авторизация</h1>
        <? include './forms/auth_form.php'; ?>

        <?
            if (isset($_POST['login']) && isset($_POST['password'])) {
                try {
                    if ($_POST['login'] == 'Admin26' && $_POST['password'] == 'Demo20') {
                        setcookie('login', 'Admin26', time() + 3600, '/');
                        setcookie('role', 'Администратор', time() + 3600, '/');
                        header('Location: ./admin.php');
                    } else {
                        include './db.php';
                        $dbh = $pdo -> prepare("SELECT * FROM users WHERE login = :login AND password = :password");
                        $dbh -> execute(['login' => $_POST['login'], 'password' => $_POST['password']]);
    
                        if ($dbh->rowCount() > 0) {
                            $users = $dbh->fetch(PDO::FETCH_ASSOC);
    
                            setcookie('login', $users['login'], time() + 3600, '/');
                            setcookie('role', $users['role'], time() + 3600, '/');
                            header('Location: ./home.php');
                        } else {
                            echo 'Вы ввели неверные данные';
                        }
                    }
    
                } catch (PDOException $error) {
                    print_r($error);
                }
            }
        ?>
    </main>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
