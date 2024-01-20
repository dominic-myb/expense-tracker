<?php include("includes/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php 
    $title = "Expense Tracker";
    include("includes/html.head.php"); 
?>
<body>
    <div>
        <?php 
            $sql = "SELECT * FROM income_tbl";
            $result = mysqli_query($conn, $sql);
            $balance = 0;
            if($result->num_rows > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $balance += $row['income'];
        ?>
        <h3>Balance: <?php echo $balance; ?></h3>
        <table class="table table-hover table-borderless align-middle">
            <thead>
                <tr class="table-primary">
                    <th scope="col">No.</th>
                    <th scope="col">Income</th>
                    <th scope="col">Date</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['income'];?></td>
                    <td><?php echo $row['date'];?></td>
                    <td><?php echo $row['description'];?></td>
                    <td>
                        <button type="button" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No Records</td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>