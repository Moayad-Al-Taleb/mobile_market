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
?>
    <div class="container">
        <div class="main-product-container">
            <div class="filter-products">
                <div class="section-title">
                    <h2>filter devices</h2>
                </div>
                <div class="filter-products-form-con">
                    <h4 class="text-dark">filter by company</h4>
                    <form action="companies.php?controls=search_company" method="POST" class="search-filter">
                        <select class="search-input" name="companyID" id="" required>
                            <option value="">select a company</option>
                            <?php
                            $stmt_companies = companies();
                            while ($row_companies = $stmt_companies->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row_companies['companyID'] . "'>" . $row_companies['companyName'] . "</option>";
                            }
                            ?>
                        </select>
                        <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                    </form>
                    <h4 class="text-dark">filter by price</h4>
                    <form action="products.php?controls=searchPrice" method="POST" class="search-filter">
                        <input class="search-input" name="Min_value" type="number" placeholder="min price" required>
                        <input class="search-input" name="Max_value" type="number" placeholder="max price" required>
                        <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                    </form>
                    <h4 class="text-dark">filter by device name</h4>
                    <form action="products.php?controls=searchName" method="POST" class="search-filter">
                        <input class="search-input" name="productName" type="text" placeholder="search by device name" required>
                        <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                    </form>
                </div>
            </div>
            <?php
            $stmt = All_phones();
            if ($stmt->rowCount() > 0) {
            ?>
                <div class="products">
                    <div class="section-title">
                        <h2>all devices</h2>
                    </div>
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
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
} elseif ($controls == 'searchPrice') {
    if ($_POST['Min_value'] != null && $_POST['Max_value'] != null) {
        $Min_value = $_POST['Min_value'];
        $Max_value = $_POST['Max_value'];
        $stmt = products_price($Min_value, $Max_value);
    ?>
        <div class="container">
            <div class="main-product-container">
                <div class="filter-products">
                    <div class="section-title">
                        <h2>filter devices</h2>
                    </div>
                    <div class="filter-products-form-con">
                        <h4 class="text-dark">filter by company</h4>
                        <form action="companies.php?controls=search_company" method="POST" class="search-filter">
                            <select class="search-input" name="companyID" id="" required>
                                <option value="">select a company</option>
                                <?php
                                $stmt_companies = companies();
                                while ($row_companies = $stmt_companies->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row_companies['companyID'] . "'>" . $row_companies['companyName'] . "</option>";
                                }
                                ?>
                            </select>
                            <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                        </form>
                        <h4 class="text-dark">filter by price</h4>
                        <form action="products.php?controls=searchPrice" method="POST" class="search-filter">
                            <input class="search-input" name="Min_value" type="number" placeholder="min price" required>
                            <input class="search-input" name="Max_value" type="number" placeholder="max price" required>
                            <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                        </form>
                        <h4 class="text-dark">filter by device name</h4>
                        <form action="products.php?controls=searchName" method="POST" class="search-filter">
                            <input class="search-input" name="productName" type="text" placeholder="search by device name" required>
                            <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                        </form>
                    </div>
                </div>
                <?php
                if ($stmt->rowCount() > 0) {
                ?>
                    <div class="products">
                        <div class="section-title">
                            <h2>all devices</h2>
                        </div>
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
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-warning text-center" style="width: 70%; height: 70px; vertical-align: middle;">sorry, there is no devices for the search you typed</div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    }
} elseif ($controls == 'searchName') {
    if ($_POST['productName'] != null) {
        $productName = $_POST['productName'];
        $stmt = products_name($productName);
    ?>
        <div class="container">
            <div class="main-product-container">
                <div class="filter-products">
                    <div class="section-title">
                        <h2>filter devices</h2>
                    </div>
                    <div class="filter-products-form-con">
                        <h4 class="text-dark">filter by company</h4>
                        <form action="companies.php?controls=search_company" method="POST" class="search-filter">
                            <select class="search-input" name="companyID" id="" required>
                                <option value="">select a company</option>
                                <?php
                                $stmt_companies = companies();
                                while ($row_companies = $stmt_companies->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row_companies['companyID'] . "'>" . $row_companies['companyName'] . "</option>";
                                }
                                ?>
                            </select>
                            <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                        </form>
                        <h4 class="text-dark">filter by price</h4>
                        <form action="products.php?controls=searchPrice" method="POST" class="search-filter">
                            <input class="search-input" name="Min_value" type="number" placeholder="min price" required>
                            <input class="search-input" name="Max_value" type="number" placeholder="max price" required>
                            <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                        </form>
                        <h4 class="text-dark">filter by device name</h4>
                        <form action="products.php?controls=searchName" method="POST" class="search-filter">
                            <input class="search-input" name="productName" type="text" placeholder="search by device name" required>
                            <button class="search-input-btn"><i class="fas fa-search"></i> search</button>
                        </form>
                    </div>
                </div>
                <?php
                if ($stmt->rowCount() > 0) {
                ?>
                    <div class="products">
                        <div class="section-title">
                            <h2>all devices</h2>
                        </div>
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
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-warning text-center" style="width: 70%; height: 70px; vertical-align: middle;">sorry, there is no devices for the search you typed</div>
                <?php
                }
                ?>
            </div>
        </div>
<?php
    }
}
require "includes/main-templates/footer.html";
ob_end_flush();
