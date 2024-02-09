<?php 
include("app/includes/components/connection.php");
$id = $_GET['deleteid'];
if(isset($_GET['deleteid'])){
    $stmt = $conn->prepare('DELETE FROM income_tbl WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>window.alert('Deleted Successfully!');
        window.location.href='index.php';</script>";
}