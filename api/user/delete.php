<?php

use api\config\Database;
use api\objects\User;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/user.php';

$response = [
    "status" => 200,
    "message" => "User deleted.",
    "time" => new DateTime()
];

try {

    $database = new Database();
    $conn = $database->getConnection();

    $user = new User($conn);

    $data = json_decode(file_get_contents("php://input"));

    $user->id = $data->id;

    if ($user->delete()) {
        http_response_code(200);

        echo json_encode($response);
    } else {
        http_response_code(503);

        $response['status'] = 503;
        $response['message'] = "Failed to delete user.";

        echo json_encode($response);
    }
} catch (Exception $e) {
    http_response_code(500);

    $response['status'] = 500;
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}
