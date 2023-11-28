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

        $controls = isset($_GET['controls']) ? $_GET['controls'] : 'active';
        if ($controls == 'active') {
            $stmt = users(1, 1);
?>
            <div class="container">
                <div class="section-title">
                    <h2>all active accounts</h2>
                    <a href="?controls=disabled">disabled accounts</a>
                </div>
                <div class="cards-container">
                    <?php
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <div class="user-card">
                                <div class="top">
                                    <div class="dottes">
                                        <div class="dott"></div>
                                        <div class="dott"></div>
                                        <div class="dott"></div>
                                    </div>
                                    <div class="controllers">
                                        <a href="?controls=deActivite&userID=<?php echo $row['userID'] ?>">disable</a>
                                    </div>
                                    <svg width="17px" height="17px" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-person">
                                        <title>866</title>
                                        <defs></defs>
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(1.000000, 1.000000)" fill="#434343">
                                                <path d="M11.518,9 C11.116,9.548 10.619,10.62 10.039,11.593 C9.402,12.667 8.672,9.994 7.873,9.994 C7.052,9.994 6.285,12.618 5.621,11.518 C5.049,10.571 4.555,9.551 4.165,9.027 C0.122,9.027 0,14.914 0,14.914 L15.745,14.914 C15.745,14.915 16.063,9 11.518,9 L11.518,9 Z" class="si-glyph-fill"></path>
                                                <path d="M10.895,3.3720005 C10.895,5.2330005 9.577,8.7940005 7.947,8.7940005 C6.319,8.7940005 5,5.2330005 5,3.3720005 C5,1.5090005 6.319,4.96730683e-07 7.947,4.96730683e-07 C9.577,-0.000999503269 10.895,1.5080005 10.895,3.3720005 L10.895,3.3720005 Z" class="si-glyph-fill"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <h5><?php echo $row['uName'] ?></h5>
                                    <p><?php echo $row['email'] ?></p>
                                </div>
                                <div class="bottom">
                                    <a href="?controls=view&userID=<?php echo $row['userID'] ?>">view details</a>
                                </div>
                            </div>

                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
        } elseif ($controls == 'disabled') {
            $stmt = users(1, 2);
        ?>
            <div class="container">
                <div class="section-title">
                    <h2>all disabled accounts</h2>
                    <a href="?controls=active">active accounts</a>
                </div>
                <div class="cards-container">
                    <?php
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <div class="user-card">
                                <div class="top">
                                    <div class="dottes">
                                        <div class="dott"></div>
                                        <div class="dott"></div>
                                        <div class="dott"></div>
                                    </div>
                                    <div class="controllers">
                                        <a href="?controls=activite&userID=<?php echo $row['userID'] ?>">activite</a>
                                    </div>
                                    <svg width="17px" height="17px" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-person">
                                        <title>866</title>
                                        <defs></defs>
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(1.000000, 1.000000)" fill="#434343">
                                                <path d="M11.518,9 C11.116,9.548 10.619,10.62 10.039,11.593 C9.402,12.667 8.672,9.994 7.873,9.994 C7.052,9.994 6.285,12.618 5.621,11.518 C5.049,10.571 4.555,9.551 4.165,9.027 C0.122,9.027 0,14.914 0,14.914 L15.745,14.914 C15.745,14.915 16.063,9 11.518,9 L11.518,9 Z" class="si-glyph-fill"></path>
                                                <path d="M10.895,3.3720005 C10.895,5.2330005 9.577,8.7940005 7.947,8.7940005 C6.319,8.7940005 5,5.2330005 5,3.3720005 C5,1.5090005 6.319,4.96730683e-07 7.947,4.96730683e-07 C9.577,-0.000999503269 10.895,1.5080005 10.895,3.3720005 L10.895,3.3720005 Z" class="si-glyph-fill"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <h5><?php echo $row['uName'] ?></h5>
                                    <p><?php echo $row['email'] ?></p>
                                </div>
                                <div class="bottom">
                                    <a href="?controls=view&userID=<?php echo $row['userID'] ?>">view details</a>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
        } elseif ($controls == 'view') {
            $userID = intval($_GET['userID']);

            $stmt = users_userID($userID);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // accountStatus
            if ($row['accountStatus'] == 1) {
                $accountStatus = 'active';
                $accountStatusBTN = 'deActivite';
                $accountStatusLink = '?controls=deActivite&userID=';
            } elseif ($row['accountStatus'] == 2) {
                $accountStatus = 'disabled';
                $accountStatusBTN = 'activite';
                $accountStatusLink = '?controls=activite&userID=';
            }
        ?>
            <div class="container">
                <div class="full-user-card">
                    <div class="image">
                        <svg width="17px" height="17px" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-person">
                            <title>866</title>
                            <defs></defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(1.000000, 1.000000)" fill="#434343">
                                    <path d="M11.518,9 C11.116,9.548 10.619,10.62 10.039,11.593 C9.402,12.667 8.672,9.994 7.873,9.994 C7.052,9.994 6.285,12.618 5.621,11.518 C5.049,10.571 4.555,9.551 4.165,9.027 C0.122,9.027 0,14.914 0,14.914 L15.745,14.914 C15.745,14.915 16.063,9 11.518,9 L11.518,9 Z" class="si-glyph-fill"></path>
                                    <path d="M10.895,3.3720005 C10.895,5.2330005 9.577,8.7940005 7.947,8.7940005 C6.319,8.7940005 5,5.2330005 5,3.3720005 C5,1.5090005 6.319,4.96730683e-07 7.947,4.96730683e-07 C9.577,-0.000999503269 10.895,1.5080005 10.895,3.3720005 L10.895,3.3720005 Z" class="si-glyph-fill"></path>
                                </g>
                            </g>
                        </svg>
                        <div class="name"><?php echo $row['uName'] ?></div>
                    </div>
                    <div class="details">
                        <span class="accountState"><?php echo $accountStatus ?></span>
                        <h2 class="section-title">details</h2>
                        <div class="detail-column"><span>first name:</span><br> <?php echo $row['fName'] ?></div>
                        <div class="detail-column"><span>middle name:</span><br> <?php echo $row['Sname'] ?></div>
                        <div class="detail-column"><span>last name:</span><br> <?php echo $row['Lname'] ?></div>
                        <div class="detail-column"><span>user name:</span><br> <?php echo $row['uName'] ?></div>
                        <div class="detail-column"><span>email:</span><br> <?php echo $row['email'] ?></div>
                        <div class="detail-column"><span>address:</span><br> <?php echo  $row['address']  ?></div>
                        <div class="detail-column column-ctrl"><a href="<?php echo $accountStatusLink . $row['userID'] ?>" class="btn btn-danger"><?php echo $accountStatusBTN ?></a></div>
                    </div>
                </div>
                <div class="section-title">
                    <h2>unpaid bills</h2>
                </div>
                <?php
                $invoice_status_1 = 1;
                $stmt_bills_1 = bills_userID($userID, $invoice_status_1);
                if ($stmt_bills_1->rowCount() > 0) {
                    $Counter_1 = 1;
                ?>
                    <div class="table-responsive">
                        <table class="table table-hover bills-table">
                            <thead class="table-dark">
                                <th class="col-2">#</th>
                                <th class="col-6">bill date</th>
                                <th class="col-4">bill controls</th>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_bills_1 = $stmt_bills_1->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $Counter_1++ ?></td>
                                        <td><?php echo $row_bills_1['billDate'] ?></td>
                                        <td>
                                            <a href="bill-details.php?billID=<?php echo $row_bills_1['billID'] ?>" class="btn btn-warning text-light">view</a>
                                            <a href="bill-details.php?controls=confirm&billID=<?php echo $row_bills_1['billID'] ?>&userID=<?php echo $userID ?>" class="btn btn-danger text-light">Confirmation</a>
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
                    <div class="alert alert-info">
                        no unpaid bills yet!
                    </div>
                <?php
                }
                ?>
                <div class="section-title">
                    <h2>paid bills</h2>
                </div>
                <?php
                $invoice_status_2 = 2;
                $stmt_bills_2 = bills_userID($userID, $invoice_status_2);
                if ($stmt_bills_2->rowCount() > 0) {
                    $Counter_2 = 1;
                ?>
                    <div class="table-responsive">
                        <table class="table table-hover bills-table">
                            <thead class="table-dark">
                                <th>#</th>
                                <th>bill date</th>
                                <th>payment bill date</th>
                                <th>bill controls</th>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_bills_2 = $stmt_bills_2->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?php echo $Counter_2++ ?></td>
                                        <td><?php echo $row_bills_2['billDate'] ?></td>
                                        <td><?php echo $row_bills_2['Bill_payment_date'] ?></td>
                                        <td>
                                            <a href="bill-details.php?billID=<?php echo $row_bills_2['billID'] ?>" class="btn btn-warning text-light">view</a>
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
                    <div class="alert alert-info">
                        no paid bills yet!
                    </div>
                <?php
                }
                ?>
            </div>
<?php
        } elseif ($controls == 'activite') {
            $userID = intval($_GET['userID']);
            // 2
            if (users_accountStatus(1, $userID) == 1) {
                header('REFRESH:0;URL=users.php?controls=disabled');
            }
        } elseif ($controls == 'deActivite') {
            $userID = intval($_GET['userID']);
            // 2
            if (users_accountStatus(2, $userID) == 1) {
                header('REFRESH:0;URL=users.php');
            }
        }
        require "includes/main-templates/footer.html";
    }
}
ob_end_flush();
