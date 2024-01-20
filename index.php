<?php include("includes/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
</head>
<body>
    <div>
        <?php 
            $sql = "SELECT * FROM savings_tbl";
            $result = mysqli_query($conn, $sql);
            $balance = 0;
            if($result->num_rows > 0){
                while($rows = mysqli_fetch_assoc($result)){
                    $balance += $rows['income'];
                }
            }
        ?>
        <h3>Balance: <?php echo $balance; ?></h3>
    </div>
</body>
</html>