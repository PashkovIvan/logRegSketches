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
    sendResponse($response);
}

$userFormDB = findUserByEmail($_POST[EMAIL_INPUT_NAME]);
if (empty($userFormDB)) {
    $response["success"] = false;
    $response["messages"][] = "Неправильно указана почта";
} elseif (hash('sha256', $_POST[PASSWORD_INPUT_NAME]) !== $userFormDB["password"]) {
    $response["success"] = false;
    $response["messages"][] = "Неправильно указан пароль";
}

if ($response["success"]) {
    $response["messages"][] = "Вы были успешно авторизованы";
    $_SESSION[AUTH_USER_SK] = $userFormDB;
}

sendResponse($response, ["data"]);
