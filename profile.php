<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/settings.php";

?>
<!DOCTYPE html>
<html lang="ru" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Профиль пользователя">
    <meta name="keywords" content="профиль, личный кабинет">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="></script>
    <title>Личный кабинет</title>
</head>
<body class="text-center">
<main class="form-signin w-100 m-auto">
    <?php
    $user = $_SESSION[AUTH_USER_SK];
    if (!empty($user)) {
        unset($user["password"]);
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    }
    ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>