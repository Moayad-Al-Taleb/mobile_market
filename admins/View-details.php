<?php
ob_start();

if ($_GET['box'] == 'Export-to-pdf-file') {
    require "init.php";

    $billID = intval($_GET['billID']);
    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();

    $mpdf->WriteHTML('<h2><u>Invoice has been paid</u></h2>');
    $mpdf->WriteHTML('<hr>');
    $mpdf->WriteHTML('<h2>Invoice details</h2>');
    $mpdf->WriteHTML('<br>');

    $stmt = bills_billID($billID);
    if ($stmt->rowCount() > 0) {
        $mpdf->WriteHTML('<table border="1" style="width: 50%;" align="center">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<th>name</th>');
        $mpdf->WriteHTML('<th>price</th>');
        $mpdf->WriteHTML('<th>companyName</th>');
        $mpdf->WriteHTML('<th>colorName</th>');
        $mpdf->WriteHTML('<th>productCount</th>');
        $mpdf->WriteHTML('<th>total</th>');
        $mpdf->WriteHTML('</tr>');
        $fName = '';
        $Sname = '';
        $Lname = '';
        $billDate;
        $college_bill_amount = 0;

        $Bill_payment_date;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<th>' . $row["name"] . '</th>');
            $mpdf->WriteHTML('<th>' . $row["price"] . '</th>');
            $mpdf->WriteHTML('<th>' . $row["companyName"] . '</th>');
            $mpdf->WriteHTML('<th>' . $row["colorName"] . '</th>');
            $mpdf->WriteHTML('<th>' . $row["productCount"] . '</th>');
            $mpdf->WriteHTML('<th>' . ($row["price"] * $row["productCount"]) . '</th>');
            $mpdf->WriteHTML('</tr>');

            $fName = $row["fName"];
            $Sname = $row["Sname"];
            $Lname = $row["Lname"];
            $billDate = $row["billDate"];

            $college_bill_amount += ($row["price"] * $row["productCount"]);

            $Bill_payment_date = $row["Bill_payment_date"];
        }
        $mpdf->WriteHTML('</table>');
        $mpdf->WriteHTML('</br>');
        $mpdf->WriteHTML('<h3><u>Bill holder information</u></h3>');
        $mpdf->WriteHTML('<h4><u>Full Name: </u>' . $fName . ' ' . $Sname . ' ' . $Lname);
        $mpdf->WriteHTML('<h4><u>total bill total: </u>' . $college_bill_amount);
        $mpdf->WriteHTML('<h4><u>Invoice booking date: </u>' . $billDate);
        $mpdf->WriteHTML('<h4><u>The date on which the invoice was paid: </u>' . $Bill_payment_date);
        $mpdf->WriteHTML('<hr>');
    }
    $mpdf->Output();
}
ob_end_flush();
