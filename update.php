<?php
include("app/includes/components/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch record from database based on id
    $sql = "SELECT * FROM records WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Prepare JSON response
    $response = array(
        'type' => $row['type'],
        'amount' => $row['amount'],
        'description' => $row['description']
    );

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
