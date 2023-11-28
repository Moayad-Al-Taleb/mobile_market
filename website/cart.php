<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/cards.css">
<link rel="stylesheet" href="design/css/product.css">
<?php
require "includes/main-templates/navbar.php";
require "includes/functions/functions.php";
if (empty($_SESSION["userID"])) {
    header('REFRESH:0;URL=index.php');
} else {
    if ($_SESSION["accountType"] == 1) {
        if ($_SESSION['accountStatus'] == 1) {
            $controls = isset($_GET['controls']) ? $_GET['controls'] : 'cart';
            if ($controls == 'cart') {
                $stmt_reservations_userID = reservations_userID($_SESSION['userID']);
?>
                <div class="container">
                    <div class="section-title">
                        <h2>my cart</h2>
                    </div>
                    <?php
                    if ($stmt_reservations_userID->rowCount() > 0) {
                    ?>
                        <div class="table table-responsive">
                            <table class="table table-hover bills-table">
                                <thead class="table-dark">
                                    <th>#</th>
                                    <th>name</th>
                                    <th>price</th>
                                    <th>companyName</th>
                                    <th>colorName</th>
                                    <th>productCount</th>
                                    <th>total</th>
                                    <th>controls</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $fName = '';
                                    $Sname = '';
                                    $Lname = '';
                                    $billDate;
                                    $college_bill_amount = 0;
                                    $sum_ProductCount = 0;
                                    $counter = 1;
                                    while ($row = $stmt_reservations_userID->fetch(PDO::FETCH_ASSOC)) {
                                        if ($row['billID'] == null) {
                                    ?>
                                            <tr>
                                                <td><?php echo $counter++ ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['price'] ?></td>
                                                <td><?php echo $row['companyName'] ?></td>
                                                <td><?php echo $row['colorName'] ?></td>
                                                <td><?php echo $row['productCount'] ?></td>
                                                <td><?php echo ($row['price'] * $row['productCount']) . ' S.P' ?></td>
                                                <td><a href="?controls=Cancel-product-order&reserveID=<?php echo $row['reserveID'] ?>" class="btn btn-danger">cancel product</a></td>
                                            </tr>
                                    <?php
                                        }
                                        $fName = $row['fName'];
                                        $Sname = $row['Sname'];
                                        $Lname = $row['Lname'];

                                        $college_bill_amount += ($row['price'] * $row['productCount']);
                                        $sum_ProductCount += $row['productCount'];
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="section-title">
                            <h2>Bill holder information</h2>
                        </div>
                        <div class="bill-info">
                            <div class="bill-user-info">
                                <p>user Full Name: <span><?php echo $fName . ' ' . $Sname . ' ' . $Lname ?></span></p>
                            </div>
                            <div class="bill-count-info">
                                <p class="total-product">total product quantity: <span><?php echo $sum_ProductCount; ?></span></p>
                                <p>total value: <span><?php echo $college_bill_amount . ' S.P' ?></span></p>
                            </div>
                        </div>
                        <h3 class="text-center">confirm and request this order <a class="confirm-btn" href="?controls=Confirmation">confirm</a></h3>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-info">no added products yet!</div>
                    <?php
                    }
                    ?>

                </div>
            <?php
            } elseif ($controls == 'Cancel-product-order') {
                $reserveID = intval($_GET['reserveID']);

                if (reservations_Cancel($reserveID) == 1) {
                    header('REFRESH:0;URL=cart.php');
                }
            } elseif ($controls == 'Confirmation') {
                $billID = bills();
                if (reservations_billID($_SESSION['userID'], $billID) > 0) {
                    header('REFRESH:0;URL=bills.php');
                }
            }
            require "includes/main-templates/footer.html";
        } else {
            ?>
            <div class="container">
                <div class="alert alert-info">
                    Sorry, your account is stuck
                </div>
            </div>
<?php
        }
    }
}
ob_end_flush();
