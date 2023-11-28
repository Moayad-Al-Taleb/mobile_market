<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/cards.css">
<link rel="stylesheet" href="design/css/forms.css">
<?php
require "includes/main-templates/navbar.php";
require "init.php";
$controls = isset($_GET['controls']) ? $_GET['controls'] : 'main';
if ($controls == 'main') {
    $stmt_companies = companies();
?>
    <div class="container">
        <div class="section-title">
            <h2>all companies</h2>
            <div class="filter-page">
                <form action="?controls=search_company" method="POST" class="search-form">
                    <select name="companyID" required>
                        <option value="">select a company</option>
                        <?php
                        while ($row_companies = $stmt_companies->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row_companies['companyID'] . "'>" . $row_companies['companyName'] . "</option>";
                        }
                        ?>
                    </select>
                    <button name="company-search"><i class="fas fa-search"></i> search</button>
                </form>
            </div>
        </div>
        <?php
        $stmt_companies = companies();
        if ($stmt_companies->rowCount() > 0) {
            while ($row = $stmt_companies->fetch(PDO::FETCH_ASSOC)) {
                $companyID = $row['companyID'];
                $companyName = $row['companyName'];
        ?>
                <div class="section-title">
                    <h2><?php echo  $companyName  . ' company' ?></h2>
                </div>
                <div class="cards-container">
                    <?php
                    $stmt_2 = products_companyID($companyID);
                    if ($stmt_2->rowCount() > 0) {
                        while ($row_2 = $stmt_2->fetch(PDO::FETCH_ASSOC)) {
                            if ($row_2['product_condition'] == 1) {
                    ?>
                                <div class="product-card">
                                    <div class="top">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_2['mainPic']) ?>" alt="">
                                        <h5 class="text-center"><?php echo $row_2['name'] ?></h5>
                                        <p><?php echo $row_2['price'] . ' S.P' ?></p>
                                    </div>
                                    <div class="bottom">
                                        <a href="product.php?productID=<?php echo $row_2['productID'] ?>">view</a>
                                        <a href="bills.php?controls=addReserve&productID=<?php echo $row_2['productID'] ?>"><i class="fas fa-plus"></i> add to cart</a>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                </div>

    <?php
                    }
                }
            }
    ?>

    </div>
    <?php
} elseif ($controls == 'search_company') {
    if ($_POST['companyID'] != null) {
        $companyID = $_POST['companyID'];
        $stmt = products($companyID);
        if ($stmt->rowCount() > 0) {
    ?>
            <div class="container">
                <div class="section-title">
                    <h2>all companies</h2>
                    <div class="filter-page">
                        <form action="?controls=search_company" method="POST" class="search-form">
                            <select name="companyID" required>
                                <option value="">select a company</option>
                                <?php
                                $stmt_companies = companies();
                                while ($row_companies = $stmt_companies->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row_companies['companyID'] . "'>" . $row_companies['companyName'] . "</option>";
                                }
                                ?>
                            </select>
                            <button name="company-search"><i class="fas fa-search"></i> search</button>
                        </form>
                    </div>
                </div>
                <?php
                if ($stmt->rowCount() > 0) {
                ?>
                    <div class="cards-container">
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            if ($row['product_condition'] == 1) {
                        ?>
                                <div class="product-card">
                                    <div class="top">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['mainPic']) ?>" alt="">
                                        <h5 class="text-center"><?php echo $row['name'] ?></h5>
                                        <p><?php echo $row['price'] . ' S.P' ?></p>
                                    </div>
                                    <div class="bottom">
                                        <a href="product.php?productID=<?php echo $row['productID'] ?>">view</a>
                                        <a href="bills.php?controls=addReserve&productID=<?php echo $row['productID'] ?>"><i class="fas fa-plus"></i> add to cart</a>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                <?php
                }
                ?>
            </div>
<?php
        } else {
        }
    }
}
require "includes/main-templates/footer.html";
ob_end_flush();
