<h3>Форма регистрации</h3>
<p>
    <? echo $result; ?>
</p>
<form action="/registration" method="post">
    <input type="text" name="name" placeholder="Имя">
    <input type="text" name="phone" placeholder="Телефон">
    <input type="email" name="email" placeholder="email@email.com">
    <input type="password" name="password" placeholder="Пароль">
    <input type="submit" value="Отправить">
</form>