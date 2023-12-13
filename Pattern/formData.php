<?php
const form = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{{title}}}</title>
</head>
<body>
    <form action="{{{method}}}" method="post">
        <h1>{{{head}}}</h1>
        <p>Почта</p>
            <input type="email" id="email" name="email" value="{{{email}}}">
        <p>Имя</p>
            <input type="text" id="first_name" name="first_name" value="{{{first_name}}}" >
        <p>Фамилия</p>
            <input type="text" id="surname" name="surname" value="{{{surname}}}" >
            {{{gender}}}
        <p>ВУЗ</p>
            <input type="text" id="place" name="place" value="{{{place}}}">
        <p>Группа</p>
            <input type="text" id="group_id" name="group_id" value="{{{group_id}}}">
        <p>Баллы</p>
            <input type="number" id="mark" name="mark" value="{{{mark}}}" >
        <br>
        <br>    
        <button type="submit">{{{button}}}</button>

    </form>
</body>
</html>
HTML;