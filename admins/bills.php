<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/forms.css">
<?php
require "includes/main-templates/navbar.html";
require "init.php";


if (empty($_SESSION["userID"])) {
    header('REFRESH:0;URL=index.php');
} else {
    if ($_SESSION["accountType"] == 2) {
        $controls = isset($_GET['controls']) ? $_GET['controls'] : 'unpaid';
        if ($controls == 'unpaid') {
            $invoice_status = 1;
            $stmt_bills_1 = bills($invoice_status);
?>
            <div class="container">
                <div class="section-title">
                    <h2>all cutsomers bills</h2>
                    <form action="?controls=searchBills" method="POST" class="search-form">
                        <input type="email" name="email" placeholder="search by email">
                        <button><i class="fas fa-search"></i> search</button>
                    </form>
                    <a href="?controls=paid">view paid bills</a>
                </div>
                <?php
                if ($stmt_bills_1->rowCount() > 0) {
                    $Counter_1 = 1;
                ?>
                    <div class="table-responsive">
                        <table class="table table-light text-center" style="width: 80%; margin: 0 auto;">
                            <thead class="table-dark">
                                <th>#</th>
                                <th>date</th>
                                <th>controls</th>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_bills_1 = $stmt_bills_1->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $Counter_1++ ?></td>
                                        <td><?php echo $row_bills_1['billDate'] ?></td>
                                        <td>
                                            <a href="bill-details.php?billID=<?php echo $row_bills_1['billID'] ?>" class="btn btn-warning">view</a>
                                        </td>

                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-info">no unpaid bill yet!</div>
                <?php
                }
                ?>
            </div>
        <?php
        } elseif ($controls == 'paid') {
            $invoice_status = 2;
            $stmt_bills_2 = bills($invoice_status);
        ?>
            <div class="container">
                <div class="section-title">
                    <h2>all cutsomers bills</h2>
                    <form action="?controls=searchBills" method="POST" class="search-form">
                        <input type="email" name="email" placeholder="search by email">
                        <button><i class="fas fa-search"></i> search</button>
                    </form>
                    <a href="?controls=unpaid">view unPaid bills</a>
                </div>
                <?php
                if ($stmt_bills_2->rowCount() > 0) {
                    $Counter_2 = 1;
                ?>
                    <div class="table-responsive">
                        <table class="table table-light text-center" style="width: 80%; margin: 0 auto;">
                            <thead class="table-dark">
                                <th>#</th>
                                <th>date</th>
                                <th>Bill_payment_date</th>
                                <th>controls</th>
                            </thead>
                            <?php
                            while ($row_bills_2 = $stmt_bills_2->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?php echo $Counter_2++ ?></td>
                                    <td><?php echo $row_bills_2['billDate'] ?></td>
                                    <td><?php echo $row_bills_2['Bill_payment_date'] ?></td>
                                    <td>
                                        <a href="bill-details.php?billID=<?php echo $row_bills_2['billID'] ?>" class="btn btn-warning">view</a>
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-info">no paid bill yet!</div>
                <?php
                }
                ?>
            </div>
            <?php
        } elseif ($controls == 'searchBills') {
            $email = $_POST['email'];
            $stmt = userID($email);
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $userID = $row['userID'];
                header('REFRESH:0;URL=users.php?controls=view&userID=' . $userID);
            } else {
            ?>
                <div class="alert alert-danger text-center" style="margin-top: 100px;">please check the email you typed</div>
<?php
                header('REFRESH:2;URL=bills.php');
            }
        }
        require "includes/main-templates/footer.html";
    }
}
ob_end_flush();
