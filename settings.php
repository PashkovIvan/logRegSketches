<?php

const PASSWORD_REPEAT_INPUT_NAME = "passwordRepeat";
const PASSWORD_INPUT_NAME = "password";
const EMAIL_INPUT_NAME = "email";
const LAST_NAME_INPUT_NAME = "lastName";
const FIRST_NAME_INPUT_NAME = "firstName";

const HASH_SALT = "password";
const AUTH_USER_SK = "AUTH_USER";

const CSRF_TOKEN = "csrfToken";

session_start();

if (!isset($_SESSION[CSRF_TOKEN])) {
    $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(32));
}

function isAjaxRequest(): bool
{
    return
        !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function sendResponse($response, array $unsetFields = [])
{
    $logFileName = "/logs/" . date('d.m.Y') . ".txt";
    $logData = array_merge(
        $response,
        [
            "time" => date('d.m.Y H:i:s'),
            "event" => "reg form request",
            "type" => $response["success"] ? "INFO" : "ERROR",
        ]
    );
    file_put_contents(
        $_SERVER["DOCUMENT_ROOT"] . $logFileName,
        print_r($logData, true),
        FILE_APPEND
    );

    foreach ($unsetFields as $unsetField) {
        if (key_exists($unsetField, $response)) {
            unset($response[$unsetField]);
        }
    }

    header('Content-type: application/json');
    die(json_encode($response));
}

function findUserByEmail(string $email): ?array
{
    $users = [
        [
            "id" => "1",
            "name" => "Коля",
            "email" => "nikolay@mail.ru",
            "password" => hashPassword("nikolay@mail.ru"),
        ],
        [
            "id" => "12",
            "name" => "Гриша",
            "email" => "gregory@mail.ru",
            "password" => hashPassword("gregory@mail.ru"),
        ],
        [
            "id" => "13",
            "name" => "Петя",
            "email" => "petrovich@gmail.com",
            "password" => hashPassword("petrovich@gmail.com"),
        ],
        [
            "id" => "15",
            "name" => "Витя",
            "email" => "vitok@mail.ru",
            "password" => hashPassword("vitok@mail.ru"),
        ],
        [
            "id" => "115",
            "name" => "Андрей",
            "email" => "andy@gmail.com",
            "password" => hashPassword("andy@gmail.com"),
        ],
    ];

    foreach ($users as $user) {
        if ($user["email"] === $email) {
            return $user;
        }
    }
    return null;
}

function hashPassword(string $password):string
{
    return hash("murmur3a",$password, true, ["seed" => HASH_SALT]);
}