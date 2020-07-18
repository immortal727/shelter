<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>
        <? echo $page_title?>
    </title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="/">Главная</a></li>
            <li>Животные
                <ul>
                    <li><a href="/cats">Кошки</a></li>
                    <li><a href="/dogs">Собаки</a></li>
                </ul>
            </li>
            <li><a href="/find/friend">Найти друга</a></li>
            <li><a href="/contacts">Контакты</a></li>

            <? if (isset($_SESSION['email'])):?>
                <li><a href="/registration">Личный кабинет</a></li>
                <a href="/logout">Выйти</a>
            <? else: ?>
            <li>
                <form name="auth">
                    <input name="email" type="email" placeholder="e-mail">
                    <input name="password" type="password" placeholder="пароль">
                    <button type="submit">Войти</button>
                </form>
            </li>
            <li><a href="/registration">Регистрация</a></li>
            <? endif; ?>
        </ul>
    </nav>

    <section>
        <? include_once "$content"; ?>
    </section>

    <script src="/static/js/auth.js"></script>
</body>

</html>