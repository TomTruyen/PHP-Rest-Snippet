<?php

use api\config\Database;
use api\objects\User;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json; charset=UTF-8');

include_once '../config/database.php';
include_once '../objects/user.php';

$response = [
    "user" => null,
    "status" => 200,
    "message" => "",
    "time" => new DateTime()
];

try {
    $database = new Database();
    $conn = $database->getConnection();

    $user = new User($conn);

    $user->id = isset($_GET['id']) ? $_GET['id'] : die();

    $user->readOne();

    if ($user->email != null) {
        // create array
        $response['user'] = array(
            "id" =>  $user->id,
            "email" => $user->email,
            "password" => $user->password,

        );

        http_response_code(200);

        echo json_encode($response);
    } else {
        http_response_code(404);

        $response['status'] = 404;
        $response['message'] = "User not found.";

        echo json_encode($response);
    }
} catch (Exception $e) {
    http_response_code(500);

    $response['status'] = 500;
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}
