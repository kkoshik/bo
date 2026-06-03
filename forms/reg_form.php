<form method="post">
    <input type="text" name="login" placeholder="login" minlength="6" pattern="[A-Za-z0-9]+" required>
    <input type="password" name="password" placeholder="password" minlength="8" required>
    <input type="text" name="fio" placeholder="ФИО" required>
    <input type="date" name="birthday" placeholder="Дата рождения">
    <input type="email" name="email" placeholder="email" required>
    <input type="text" name="phone" placeholder="phone" pattern="\+?[0-9]{10,15}" required>
    <button type="submit">Регистрация</button>
    <a href="./index.php">Уже зарегистрированы? Авторизация</a>
</form>