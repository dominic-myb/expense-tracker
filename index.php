<?php include("app/includes/components/connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record-btn'])) {
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $stmt = $conn->prepare('INSERT INTO records (type, amount, date, description)VALUES(?,?,NOW(),?)');
    $stmt->bind_param('sds', $type, $amount, $desc);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($stmt->affected_rows > 0) {
        $message = 'Recorded Successfully';
    } else {
        $message = 'An error occured';
    }
    echo "<script>alert('$message')
        window.location = 'index.php'</script>";
    $stmt->close();
    exit;
}
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
        // Select all records ordered by id descending
        $sql = "SELECT * FROM records ORDER BY id DESC";
        $result = $conn->query($sql);

        // Calculate total income
        $incomeQuery = "SELECT SUM(CASE WHEN type = 'Income' THEN amount ELSE 0 END) AS income FROM records";
        $incomeStmt = $conn->query($incomeQuery);
        $incomeData = $incomeStmt->fetch_assoc();
        $income = $incomeData['income'];

        // Calculate total expenses
        $expenseQuery = "SELECT SUM(CASE WHEN type = 'Expense' THEN amount ELSE 0 END) AS expense FROM records";
        $expenseStmt = $conn->query($expenseQuery);
        $expenseData = $expenseStmt->fetch_assoc();
        $expense = $expenseData['expense'];

        // Calculate balance
        $balance = $income - $expense;

        ?>
        <div class="top-header">
            <h3>Balance: <?php echo number_format($balance, 2); ?></h3>
            <input class="btn btn-success" type="button" name="add-record" id="add-record" value="Add Record" data-bs-toggle="modal" data-bs-target="#record-modal">
        </div>
        <table class="table table-hover table-borderless align-middle">
            <thead>
                <tr class="table-primary">
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['type'] === "Income")
                ?>
                        <tr>
                            <td style="background-color: <?php echo $row['type'] === "Income" ? '#AFE1AF' : '#E97451' ?>;"><?php echo $row['type']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <form action="" method="post" id="update-form">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="button" name="update-btn" class="btn btn-primary update-btn" data-bs-toggle="modal" data-bs-target=".record-modal">Update</button>
                                    <a href="delete.php?deleteid=<?php echo $row['id'] ?>" class="btn btn-danger delete-btn">Delete</a>
                                </form>
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
    <!-- Record Section Modal -->
    <div class="modal fade" id="record-modal" tabindex="-1" role="dialog" aria-labelledby="record-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="record-label">Add Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="record-form">
                    <div class="modal-body">
                        <div class="col-auto mb-4">
                            <select id="dropdown" name="type" class="form-select">
                                <option value="Income">Income</option>
                                <option value="Expense">Expense</option>
                            </select>
                        </div>
                        <input class="form-control" name="amount" id="record-amount" type="text" placeholder="Amount" aria-label="default input example"><br>
                        <textarea class="form-control" name="desc" id="record-desc" placeholder="Description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="record-btn" id="record-btn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Record Modal -->
     <!-- Update Section Modal -->
     <div class="modal fade record-modal" id="record-modal" tabindex="-1" role="dialog" aria-labelledby="record-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="record-label">Update Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="update-form">
                    <?php 
                    if(isset($_POST['update-btn'])){
                        $id = $_POST['id'];
                        echo $id;
                        $select = "SELECT * FROM records WHERE id='$id'";
                        $result = $conn->query($select);
                        $row = $result->fetch_assoc();
                    }
                    ?>
                    <div class="modal-body">
                        <?php echo $row['id'];?>
                        <div class="col-auto mb-4">
                            <select id="dropdown" name="type" class="form-select">
                                <option value="Income">Income</option>
                                <option value="Expense">Expense</option>
                            </select>
                        </div>
                        <input class="form-control" name="amount" id="record-amount" type="text" value="<?php echo $row['amount'] ?>" placeholder="Amount" aria-label="default input example"><br>
                        <textarea class="form-control" name="desc" id="record-desc" placeholder="Description" rows="3"><?php echo $row['desc']?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="update-btn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Update Modal -->
    <?php include("app/includes/html/html.foot.php") ?>
</body>

</html>