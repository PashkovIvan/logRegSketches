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

$userFormDB = findUserByEmail($_POST[EMAIL_INPUT_NAME]);
if(!empty($userFormDB)) {
    $response["success"] = false;
    $response["messages"][] = "Почта уже занята, попробуйте войти";
}

if ($response["success"]) {
    $response["messages"][] = "Вы были успешно зарегистрированы";
    //После реги, пользователь попадает в БД и там ему присваивается ID
    $_SESSION[AUTH_USER_SK] = [
        "id" => random_int(100, 1000),
        "name" => sprintf("%s %s", $_POST[LAST_NAME_INPUT_NAME], $_POST[FIRST_NAME_INPUT_NAME]),
        "email" => $_POST[EMAIL_INPUT_NAME],
    ];
}

sendResponse($response, ["data","messages"]);
