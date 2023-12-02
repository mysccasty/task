<?php
    if ($_GET['auth']==="1"){
        $script = "auth.php";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
</head>
<body>
    <form action="<?=$script?>" method="post">
        <h1>Для доступа пройдите регистрацию</h1>
        <p>Почта</p>
            <input type="email" id="email" name="email" placeholder="Введите почту!" required>
        <p>Имя</p>
            <input type="text" id="first_name" name="first_name" placeholder="Введите свое имя!" required>
        <p>Фамилия</p>
            <input type="text" id="surname" name="surname" placeholder="Введите свою фамилию!" required>
        <p>Пол</p>
            <input type="radio" id="male" name="gender" value="муж" checked />
            <label for="male">Мужской</label>
            <br>
            <input type="radio" id="female" name="gender" value="жен"/>
            <label for="male">Женский</label>

        <p>ВУЗ</p>
            <input type="text" id="place" name="place" placeholder="Введите свой вуз!">
        <p>Группа</p>
            <input type="text" id="group_id" name="group_id" placeholder="Введите группу!">
        <p>Баллы</p>
            <input type="number" id="mark" name="mark" placeholder="Введите баллы!">
        
        <button type="submit">Зарегистрироваться</button>

    </form>
</body>
</html>