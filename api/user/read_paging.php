<?php

use api\config\Database;
use api\objects\User;
use api\shared\Utilities;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/user.php';

$response = [
    "paging" => [],
    "users" => [],
    "status" => 200,
    "message" => "",
    "time" => new DateTime()
];

$MAX_LIMIT = 25;

try {
    $utilities = new Utilities();

    $database = new Database();
    $conn = $database->getConnection();

    $user = new User($conn);

    $start = isset($_GET['start']) ? $_GET['start'] : die();
    $limit = isset($_GET['limit']) ? $_GET['limit'] : die();

    // start = start index, limit = amount of items
    if ($limit > $MAX_LIMIT) $limit = $MAX_LIMIT;

    $stmt = $user->readPaging($start, $limit);

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

        // include paging
        $total_rows = $user->count();
        $page_url = "{$home_url}user/read_paging.php";
        $paging = $utilities->getPaging($total_rows, $page_url, $start, $limit);
        $response["paging"] = $paging;

        http_response_code(200);

        echo json_encode($response);
    } else {
        http_response_code(404);

        $response['status'] = 404;
        $response['message'] = "No more users found.";

        echo json_encode($response);
    }
} catch (Exception $e) {
    http_response_code(500);

    $response['status'] = 500;
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}
