<!-- TODO List:
- Add an update 
- Add delete
-->
<?php include("includes/connection.php"); ?>
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
        $result = mysqli_query($conn, $sql);
        $balance = 0;
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $balance += $row['income'];
        ?>
                <div class="top-header">
                    <h3>Balance: <?php echo $balance; ?></h3>
                    <input class="btn btn-success" type="button" name="income" id="income" value="Income" data-bs-toggle="modal" data-bs-target="#income-modal">
                    <input class="btn btn-danger" type="button" name="expense" id="expense" value="Expense" data-bs-toggle="modal" data-bs-target="#expense-modal">
                </div>

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
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['income']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    <?php
                }
            } else {
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
    <!-- Income Section Modal -->
    <div class="modal fade" id="income-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Income</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="text" placeholder="Amount" aria-label="default input example"><br>
                    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Description" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Expense Modal -->

</body>

</html>