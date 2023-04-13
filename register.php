<?php
//Реализует обработку AJAX запроса на php

require_once $_SERVER["DOCUMENT_ROOT"] . "/settings.php";

$response = [
    "success" => true,
    "data" => $_POST,
    "messages" => [],
];

if ($_SERVER["HTTP_X_CSRFTOKEN"] !== $_SESSION[CSRF_TOKEN] || !isAjaxRequest()) {
    $response["success"] = false;
    $response["messages"][] = "Доступ запрещён";
    sendResponse($response);
}

if (!filter_var($_POST[EMAIL_INPUT_NAME], FILTER_VALIDATE_EMAIL)) {
    $response["success"] = false;
    $response["messages"][] = sprintf(
        "E-mail адрес '%s' указан неверно.",
        $_POST['email']
    );
}

if ($_POST[PASSWORD_INPUT_NAME] !== $_POST[PASSWORD_REPEAT_INPUT_NAME]) {
    $response["success"] = false;
    $response["messages"][] = "Пароли не совпадают";
}

$userFromDB = findUserByEmail($_POST[EMAIL_INPUT_NAME]);
if (!empty($userFromDB)) {
    $response["success"] = false;
    $response["messages"][] = "Почта уже занята, попробуйте войти";
}

if ($response["success"]) {

    $connection = DataBase::getConnection();
    $stmt = $connection->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

    $firstName = $_POST[FIRST_NAME_INPUT_NAME];
    $lastName = $_POST[LAST_NAME_INPUT_NAME];
    $email = $_POST[EMAIL_INPUT_NAME];
    $password = hash('sha256', $_POST[PASSWORD_INPUT_NAME]);

    $result = $stmt->execute();
    $response["messages"][] = "Вы были успешно зарегистрированы";

    $_SESSION[AUTH_USER_SK] = findUserByEmail($_POST[EMAIL_INPUT_NAME]);
}

sendResponse($response, ["data"]);
