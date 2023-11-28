<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/cards.css">
<?php
require "includes/main-templates/navbar.html";
require "init.php";


if (empty($_SESSION["userID"])) {
    header('REFRESH:0;URL=index.php');
} else {
    if ($_SESSION["accountType"] == 2) {
        $controls = isset($_GET['controls']) ? $_GET['controls'] : 'view';
        if ($controls == 'view') {
            $billID = intval($_GET['billID']);
            $invoice_status = bills_invoice_status($billID);
            if ($invoice_status == 1) {
                $stmt = bills_billID($billID);
                if ($stmt->rowCount() > 0) {
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
                        <h3 class="text-center">confirm the order bill <a class="confirm-btn" href="?controls=confirm&billID=<?php echo $billID ?>">confirm</a></h3>
                    </div>
                <?php
                }
            } elseif ($invoice_status == 2) {
                $stmt = bills_billID($billID);
                if ($stmt->rowCount() > 0) {
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

                                    $Bill_payment_date;
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

                                        $Bill_payment_date = $row['Bill_payment_date'];
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
                        <h3 class="text-center">print as PDF <a class="confirm-btn" href="?controls=Export-to-pdf-file&billID=<?php echo $billID ?>">print</a></h3>
                    </div>
<?php
                }
            }
        } elseif ($controls == 'confirm') {
            $billID = intval($_GET['billID']);
            $userID = isset($_GET['userID']) ? intval($_GET['userID']) : null;
            $invoice_status = 2;
            if ($userID === null) {
                $Bill_payment_date = date("Y-m-d");
                if (bills_Edit($billID, $invoice_status, $Bill_payment_date) == 1) {
                    header('REFRESH:0;URL=bill-details.php?billID=' . $billID);
                }
            } else {
                $Bill_payment_date = date("Y-m-d");
                if (bills_Edit($billID, $invoice_status, $Bill_payment_date) == 1) {
                    header('REFRESH:0;URL=users.php?controls=view&userID=' . $userID);
                }
            }
        } elseif ($controls == 'Export-to-pdf-file') {
            $billID = intval($_GET['billID']);
            header('REFRESH:0;URL=View-details.php?box=Export-to-pdf-file&billID=' . $billID);

            // $mpdf->WriteHTML('<h2><u>Invoice has been paid</u></h2>');
            // $mpdf->WriteHTML('<hr>');
            // $mpdf->WriteHTML('<h2>Invoice details</h2>');
            // $mpdf->WriteHTML('<br>');

            // $stmt = bills_billID($billID);
            // if ($stmt->rowCount() > 0) {
            //     $mpdf->WriteHTML('<table border="1" style="width: 50%;" align="center">');
            //     $mpdf->WriteHTML('<tr>');
            //     $mpdf->WriteHTML('<th>name</th>');
            //     $mpdf->WriteHTML('<th>price</th>');
            //     $mpdf->WriteHTML('<th>companyName</th>');
            //     $mpdf->WriteHTML('<th>colorName</th>');
            //     $mpdf->WriteHTML('<th>productCount</th>');
            //     $mpdf->WriteHTML('<th>total</th>');
            //     $mpdf->WriteHTML('</tr>');
            //     $fName = '';
            //     $Sname = '';
            //     $Lname = '';
            //     $billDate;
            //     $college_bill_amount = 0;

            //     $Bill_payment_date;
            //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //         $mpdf->WriteHTML('<tr>');
            //         $mpdf->WriteHTML('<th>' . $row["name"] . '</th>');
            //         $mpdf->WriteHTML('<th>' . $row["price"] . '</th>');
            //         $mpdf->WriteHTML('<th>' . $row["companyName"] . '</th>');
            //         $mpdf->WriteHTML('<th>' . $row["colorName"] . '</th>');
            //         $mpdf->WriteHTML('<th>' . $row["productCount"] . '</th>');
            //         $mpdf->WriteHTML('<th>' . ($row["price"] * $row["productCount"]) . '</th>');
            //         $mpdf->WriteHTML('</tr>');

            //         $fName = $row["fName"];
            //         $Sname = $row["Sname"];
            //         $Lname = $row["Lname"];
            //         $billDate = $row["billDate"];

            //         $college_bill_amount += ($row["price"] * $row["productCount"]);

            //         $Bill_payment_date = $row["Bill_payment_date"];
            //     }
            //     $mpdf->WriteHTML('</table>');
            //     $mpdf->WriteHTML('</br>');
            //     $mpdf->WriteHTML('<h3><u>Bill holder information</u></h3>');
            //     $mpdf->WriteHTML('<h4><u>Full Name: </u>' . $fName . ' ' . $Sname . ' ' . $Lname);
            //     $mpdf->WriteHTML('<h4><u>total bill total: </u>' . $college_bill_amount);
            //     $mpdf->WriteHTML('<h4><u>Invoice booking date: </u>' . $billDate);
            //     $mpdf->WriteHTML('<h4><u>The date on which the invoice was paid: </u>' . $Bill_payment_date);
            //     $mpdf->WriteHTML('<hr>');
            // }
            // $mpdf->Output();


        }

        require "includes/main-templates/footer.html";
    }
}
ob_end_flush();
