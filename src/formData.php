<?php
const form = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <title>{{{title}}}</title>
</head>
<body>
    {{{home}}}
    <form action="{{{method}}}" method="post">
        <h1>{{{head}}}</h1>
        <p>Почта</p>
            <input type="email" id="email" name="email" {{{email}}}>
        <p>Имя</p>
            <input type="text" id="first_name" name="first_name" {{{first_name}}} >
        <p>Фамилия</p>
            <input type="text" id="surname" name="surname" {{{surname}}} >
            {{{gender}}}
        <p>ВУЗ</p>
            <input type="text" id="place" name="place" {{{place}}}>
        <p>Группа</p>
            <input type="text" id="group_id" name="group_id" {{{group_id}}}>
        <p>Баллы</p>
            <input type="number" id="mark" name="mark" {{{mark}}} >
        <br>    
        <button type="submit">{{{button}}}</button>

    </form>
</body>
</html>
HTML;