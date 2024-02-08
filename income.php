<?php
include("app/includes/components/connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $date = 1;
    $stmt = $conn->prepare('INSERT INTO income_tbl (income, date, description)VALUES(?,?,?)');
    $stmt->bind_param('iss', $amount, $date, $desc);
    $stmt->execute();
    $result = $stmt->get_result();
    if($stmt->affected_rows > 0){
        $message = 'Recorded Successfully';
    }else{
        $message = 'An error occured';
    }
    echo "<script>alert($message)
        window.location = 'index.php'</script>";
    $stmt->close();
    exit;
}