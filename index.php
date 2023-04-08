<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/settings.php";

?>
<!DOCTYPE html>
<html lang="ru" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="<?=$_SESSION[CSRF_TOKEN]?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Формы регистрации и авторизации">
    <meta name="keywords" content="регистрация, авторизации">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="/logReg.css" rel="stylesheet">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="></script>
    <title>Регистрация</title>
</head>
<body class="text-center">
<main class="form-signin w-100 m-auto">
	<ul class="nav nav-tabs" id="formToggleList">
		<li class="nav-item">
			<button class="nav-link active" data-form-id="logForm">Авторизация</button>
		</li>
		<li class="nav-item">
			<button class="nav-link" data-form-id="regForm">Регистрация</button>
		</li>
	</ul>
	<div class="container">
		<div class="alert alert-danger alert-log-reg" style="display: none;" role="alert" id="errorAlert"></div>

		<form id="logForm" action="/login.php">
			<!-- Form -->
			<div class="form-floating">
				<input type="email" required class="form-control" id="logEmail" placeholder="ivanov.i@mail.ru" value="test@test.test" name="<?=EMAIL_INPUT_NAME?>">
				<label for="logEmail">Email</label>
			</div>
			<div class="form-floating">
				<input type="password" required class="form-control" id="logPassword" placeholder="Пароль" value="Test" name="<?=PASSWORD_INPUT_NAME?>">
				<label for="logPassword">Пароль</label>
			</div>
			<button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
		</form>
		<form id="regForm" style="display: none" action="/register.php">
			<!-- Form -->
			<div class="form-floating">
				<input type="text" required class="form-control" id="regFirstName" placeholder="Иван" value="Test" name="<?=FIRST_NAME_INPUT_NAME?>">
				<label for="regFirstName">Имя</label>
			</div>
			<div class="form-floating">
				<input type="text" required class="form-control" id="regLastName" placeholder="Иванов" value="Test" name="<?=LAST_NAME_INPUT_NAME?>">
				<label for="regLastName">Фамилия</label>
			</div>
			<div class="form-floating">
				<input type="email" required class="form-control" id="regEmail" placeholder="ivanov.i@mail.ru" value="test@test.test" name="<?=EMAIL_INPUT_NAME?>">
				<label for="regEmail">Email</label>
			</div>
			<div class="form-floating">
				<input type="password" required class="form-control" id="regPassword" placeholder="Пароль" value="Test" name="<?=PASSWORD_INPUT_NAME?>">
				<label for="regPassword">Пароль</label>
			</div>
			<div class="form-floating">
				<input type="password" required class="form-control" id="regPasswordRepeat" placeholder="Повторите пароль" value="Test" name="<?=PASSWORD_REPEAT_INPUT_NAME?>">
				<label for="regPasswordRepeat">Повторите пароль</label>
			</div>
			<button class="w-100 btn btn-lg btn-primary" type="submit">Зарегистрироваться</button>
		</form>
		<div class="spinner-border text-dark" id="formLoader" style="display: none;" role="status">
			<span class="visually-hidden">Загрузка...</span>
		</div>
		<p class="mt-5 mb-3 text-body-secondary">© 2023</p>
	</div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">ОК</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="/logReg.js"></script>
</body>
</html>