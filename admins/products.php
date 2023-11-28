<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/cards.css">
<link rel="stylesheet" href="design/css/forms.css">
<?php
require "includes/main-templates/navbar.html";
if (empty($_SESSION["userID"])) {
    header('REFRESH:0;URL=index.php');
} else {
    if ($_SESSION["accountType"] == 2) {
        $controls = isset($_GET['controls']) ? $_GET['controls'] : 'main';
        if ($controls == 'main') {
?>
            <div class="container">
                <div class="section-title">
                    <h2>all companies</h2>
                    <div class="filter-page">
                        <form action="" class="search-form">
                            <input type="text" placeholder="search by name">
                            <select name="" id="">
                                <option value="1">mobiles</option>
                            </select>
                            <button><i class="fas fa-search"></i> search</button>
                        </form>
                    </div>
                    <a href="?controls=add">add new product</a>
                </div>
                <div class="cards-container">
                    <div class="product-card">
                        <div class="top">
                            <img src="design/142660-v2-xiaomi-mi-11-ultra-mobile-phone-medium-1.jpg" alt="">
                            <h5 class="text-center">samsung galaxy s22 ultra ultras</h5>
                            <p>1000$</p>
                        </div>
                        <div class="bottom">
                            <a href="product.php">view details</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="top">
                            <img src="design/142660-v2-xiaomi-mi-11-ultra-mobile-phone-medium-1.jpg" alt="">
                            <h5 class="text-center">samsung galaxy s22 ultra ultras</h5>
                            <p>1000$</p>
                        </div>
                        <div class="bottom">
                            <a href="product.php">view details</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="top">
                            <img src="design/142660-v2-xiaomi-mi-11-ultra-mobile-phone-medium-1.jpg" alt="">
                            <h5 class="text-center">samsung galaxy s22 ultra ultras</h5>
                            <p>1000$</p>
                        </div>
                        <div class="bottom">
                            <a href="product.php">view details</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="top">
                            <img src="design/142660-v2-xiaomi-mi-11-ultra-mobile-phone-medium-1.jpg" alt="">
                            <h5 class="text-center">samsung galaxy s22 ultra ultras</h5>
                            <p>1000$</p>
                        </div>
                        <div class="bottom">
                            <a href="product.php">view details</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="top">
                            <img src="design/142660-v2-xiaomi-mi-11-ultra-mobile-phone-medium-1.jpg" alt="">
                            <h5 class="text-center">samsung galaxy s22 ultra ultras</h5>
                            <p>1000$</p>
                        </div>
                        <div class="bottom">
                            <a href="product.php">view details</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } elseif ($controls == 'add') {
        ?>
            <div class="container">
                <div class="form-con data-form">
                    <h2>add new product</h2>
                    <form action="" class="form">
                        <div class="input-field">
                            <label for="">product name</label>
                            <input class="input" type="text">
                        </div>
                        <div class="input-field">
                            <label for="">product price</label>
                            <input class="input" type="number">
                        </div>
                        <div class="input-field">
                            <label for="">product pics</label>
                            <input class="input" multiple type="file">
                        </div>
                        <input type="submit" name="BTN-LOGIN" class="submitBtn" value="submit">
                    </form>
                </div>
            </div>
<?php
        }
        require "includes/main-templates/footer.html";
    }
}
ob_end_flush();
