<?php include("app/includes/components/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "Expense Tracker";
include("app/includes/html/html.head.php");
?>

<body>
    <div>
        <?php
        $sql = "SELECT * FROM income_tbl";
        $result = $conn->query($sql);
        $balanceQuery = "SELECT SUM(income) as sum_income FROM income_tbl";
        $balance = $conn->query($balanceQuery);
        $balaceData = $balance->fetch_assoc();
        $balance = $balaceData["sum_income"];
        ?>
        <div class="top-header">
            <h3>Balance: <?php echo $balance; ?></h3>
            <input class="btn btn-success" type="button" name="income" id="income" value="Income" data-bs-toggle="modal" data-bs-target="#income-modal">
            <input class="btn btn-danger" type="button" name="expense" id="expense" value="Expense" data-bs-toggle="modal" data-bs-target="#expense-modal">
        </div>
        <table class="table table-hover table-borderless align-middle">
            <thead>
                <tr class="table-primary">
                    <th scope="col">Income</th>
                    <th scope="col">Date</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td><?php echo $row['income']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <a href="delete.php?updateid=<?php echo $row['id'] ?>" class="btn btn-primary update-btn">Update</a>
                                <a href="delete.php?deleteid=<?php echo $row['id'] ?>" class="btn btn-danger delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No Records</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Income Section Modal -->
    <div class="modal fade" id="income-modal" tabindex="-1" role="dialog" aria-labelledby="income-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="income-label">Add Income</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="income.php" method="post" id="income-form">
                    <div class="modal-body">
                        <input class="form-control" name="amount" id="income-amount" type="text" placeholder="Amount" aria-label="default input example"><br>
                        <textarea class="form-control" name="desc" id="income-desc" placeholder="Description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="income-btn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Income Modal -->

    <!-- Start of Expense Modal -->
    <div class="modal fade" id="expense-modal" tabindex="-1" role="dialog" aria-labelledby="expense-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expense-label">Add Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="text" placeholder="Amount" aria-label="default input example"><br>
                    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Description" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="expense-btn" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Expense Modal -->
    <?php include("app/includes/html/html.foot.php") ?>
</body>

</html>