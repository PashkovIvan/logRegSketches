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

    $connection = DataBase::getConnection();
    $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return empty($user) ? null : $user;
}

class DataBase
{
    private static DataBase $dataBase;
    private mysqli $connection;

    private function __construct()
    {
        $this->connection = mysqli_connect("localhost", "app", "app", "local_app_db");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL:" . mysqli_connect_error();
        } else {
            $this->connection->query('USE local_app_db;');
        }
    }

    public static function getConnection(): mysqli
    {
        if (empty(self::$dataBase)) {
            self::$dataBase = new DataBase();
        }
        return self::$dataBase->connection;
    }
}
