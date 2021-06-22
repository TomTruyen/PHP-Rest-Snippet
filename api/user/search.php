<?php

use api\config\Database;
use api\objects\User;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/user.php';

$response = [
    "users" => [],
    "status" => 200,
    "message" => "User updated.",
    "time" => new DateTime()
];

try {
    $database = new Database();
    $conn = $database->getConnection();

    $user = new User($conn);

    $keywords = isset($_GET["s"]) ? $_GET["s"] : "";

    $stmt = $user->search($keywords);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_item = array(
                "id" => $id,
                "email" => $email,
                "password" => $password
            );

            array_push($response["users"], $user_item);
        }

        http_response_code(200);

        echo json_encode($response);
    } else {
        http_response_code(404);

        $response['status'] = 404;
        $response['message'] = "No results found.";

        echo json_encode($response);
    }
} catch (Exception $e) {
    http_response_code(500);

    $response['status'] = 500;
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}
