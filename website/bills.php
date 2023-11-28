<?php

use Mpdf\Tag\P;

session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/forms.css">
<link rel="stylesheet" href="design/css/cards.css">
<?php
require "includes/main-templates/navbar.php";
require "includes/functions/functions.php";
if (empty($_SESSION["userID"])) {
?>
    <div class="container">
        <div class="alert alert-info">
            You can't log in please
        </div>
    </div>
    <?php
} else {
    if ($_SESSION["accountType"] == 1 && $_SESSION["accountStatus"] == 1) {
        $controls = isset($_GET['controls']) ? $_GET['controls'] : 'unPaidBills';
        if ($controls == 'unPaidBills') {
            $invoice_status_1 = 1;
            $stmt_bills_1 = bills_userID($_SESSION['userID'], $invoice_status_1);
            $Counter_1 = 1;
    ?>
            <div class="container">
                <div class="section-title">
                    <h2>all unpaid cutsomers bills</h2>
                    <a href="?controls=paidBills">all paid bills</a>
                </div>
                <?php
                if ($stmt_bills_1->rowCount() > 0) {
                ?>
                    <div class="table-responsive">
                        <table class="table table-light text-center" style="width: 60%; margin: 0 auto;">
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
                                        <td><?php echo $Counter_1++  ?></td>
                                        <td><?php echo $row_bills_1['billDate'] ?></td>
                                        <td>
                                            <a href="?controls=viewBill&billID=<?php echo $row_bills_1['billID'] ?>" class="btn btn-warning">view</a>
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
                }
                ?>

            </div>
        <?php
        }
        if ($controls == 'paidBills') {
            $invoice_status_2 = 2;
            $stmt_bills_2 = bills_userID($_SESSION['userID'], $invoice_status_2);
            $Counter_1 = 1;
        ?>
            <div class="container">
                <div class="section-title">
                    <h2>all paid cutsomers bills</h2>
                    <a href="?controls=unPaidBills">all unpaid bills</a>
                </div>
                <?php
                if ($stmt_bills_2->rowCount() > 0) {
                ?>
                    <div class="table-responsive">
                        <table class="table table-light text-center" style="width: 60%; margin: 0 auto;">
                            <thead class="table-dark">
                                <th>#</th>
                                <th>date</th>
                                <th>controls</th>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_bills_2 = $stmt_bills_2->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $Counter_1++  ?></td>
                                        <td><?php echo $row_bills_2['billDate'] ?></td>
                                        <td>
                                            <a href="?controls=viewBill&billID=<?php echo $row_bills_2['billID'] ?>" class="btn btn-warning">view</a>
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
                }
                ?>

            </div>
            <?php
        } elseif ($controls == 'viewBill') {
            $billID = $_GET['billID'];
            $invoice_status = bills_invoice_status($billID);
            if ($invoice_status == 1) {
                $stmt = bills_billID($billID);
            ?>
                <div class="container">
                    <div class="section-title">
                        <h2>bills details</h2>
                    </div>
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
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $counter++ ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['price'] ?></td>
                                        <td><?php echo $row['companyName'] ?></td>
                                        <td><?php echo $row['colorName'] ?></td>
                                        <td><?php echo $row['productCount'] ?></td>
                                        <td><?php echo ($row['price'] * $row['productCount']) . ' S.P' ?></td>
                                    </tr>
                                <?php
                                    $fName = $row['fName'];
                                    $Sname = $row['Sname'];
                                    $Lname = $row['Lname'];
                                    $billDate = $row['billDate'];

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
                            <p>Invoice booking date: <span><?php echo $billDate ?></span></p>
                            <p>The date on which the invoice was paid: <span>The bill has not been paid</span></p>
                        </div>
                        <div class="bill-count-info">
                            <p class="total-product">total product quantity: <span><?php echo $sum_ProductCount; ?></span></p>
                            <p>total value: <span><?php echo $college_bill_amount . ' S.P' ?></span></p>
                        </div>
                    </div>
                </div>
            <?php
            } elseif ($invoice_status == 2) {
                $stmt = bills_billID($billID);
            ?>
                <div class="container">
                    <div class="section-title">
                        <h2>bills details</h2>
                    </div>
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
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $counter++ ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['price'] ?></td>
                                        <td><?php echo $row['companyName'] ?></td>
                                        <td><?php echo $row['colorName'] ?></td>
                                        <td><?php echo $row['productCount'] ?></td>
                                        <td><?php echo ($row['price'] * $row['productCount']) . ' S.P' ?></td>
                                    </tr>
                                <?php
                                    $fName = $row['fName'];
                                    $Sname = $row['Sname'];
                                    $Lname = $row['Lname'];
                                    $billDate = $row['billDate'];
                                    $Bill_payment_date = $row['Bill_payment_date'];
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
                            <p>Invoice booking date: <span><?php echo $billDate ?></span></p>
                            <p>The date on which the invoice was paid: <span><?php echo $Bill_payment_date ?></span></p>
                        </div>
                        <div class="bill-count-info">
                            <p class="total-product">total product quantity: <span><?php echo $sum_ProductCount; ?></span></p>
                            <p>total value: <span><?php echo $college_bill_amount . ' S.P' ?></span></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } elseif ($controls == 'addReserve') {
            $productID = intval($_GET['productID']);
            if (!empty($_SESSION['userID'])) {
                if ($_SESSION['accountStatus'] == 1) {
                    $stmt = productcolors_productID($productID);
                ?>
                    <div class="container">
                        <div class="alert alert-primary text-center fs-4">please specify the color that you want and product count</div>
                        <div style="margin: 0 auto; width: 450px;" class="filter-products">
                            <div class="filter-products-form-con">
                                <h4 class="text-center fs-3">product color and count</h4>
                                <form action="" method="POST" class="search-filter">
                                    <input class="search-input" name="productCount" type="number" placeholder="product count" required>
                                    <select class="search-input" name="colorID" id="" required>
                                        <option value="">please choose a color</option>
                                        <?php
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <option value="<?php echo $row['colorID'] ?>"><?php echo $row['colorName'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <button class="search-input-btn mt-1" style="width: 120px;" name="add">add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['add'])) {
                        if (!empty($_POST['productCount']) && !empty($_POST['colorID'])) {
                            $productCount = $_POST['productCount'];
                            $colorID = $_POST['colorID'];
                            $userID = $_SESSION['userID'];
                            if (reservations($userID, $productID, $productCount, $colorID) == 1) {
                                header('REFRESH:0;URL=cart.php');
                            }
                        }
                    }
                } else {
                    ?>
                    <div class="container">
                        <div class="alert alert-info">
                            Sorry, your account is stuck
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="container">
                    <div class="alert alert-info">
                        You can't log in please
                    </div>
                </div>
        <?php
            }
        }
        require "includes/main-templates/footer.html";
        ob_end_flush();
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
