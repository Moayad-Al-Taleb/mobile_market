<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
require "connect.php";
require "includes/functions/functions.php";
?>
<link rel="stylesheet" href="design/css/cards.css">
<link rel="stylesheet" href="design/css/forms.css">
<?php
require "includes/main-templates/navbar.php";

$controls = isset($_GET['controls']) ? $_GET['controls'] : 'main';
if ($controls == 'main') {
    $companyID = intval($_GET['companyID']);
    $stmt = products($companyID);
?>
    <div class="container">
        <div class="section-title">
            <h2>samsung mobiles smart phones</h2>
            <a href="?controls=add&companyID=<?php echo $companyID ?>">add new product</a>
        </div>
        <div class="cards-container">
            <?php
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="product-card">
                        <div class="top">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['mainPic']) ?>" alt="">
                            <h5 class="text-center"><?php echo  $row['name'] ?></h5>
                            <p><?php echo $row['price'] . ' S.P' ?></p>
                        </div>
                        <div class="bottom">
                            <a href="product.php?productID=<?php echo $row['productID'] ?>">view details</a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
<?php
} elseif ($controls == 'add') {
    $companyID = intval($_GET['companyID']);
?>
    <div class="container">
        <div class="form-con data-form">
            <h2>add new product</h2>
            <form action="" class="form" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <label for="">product name</label>
                    <input name="name" type="text" class="input">
                </div>
                <div class="input-field">
                    <label for="">product price</label>
                    <input name="price" class="input" type="number">
                </div>
                <div class="input-field">
                    <label for="">product pics</label>
                    <input name="mainPic" class="input" type="file">
                </div>
                <input type="submit" name="submit" class="submitBtn" value="submit">
            </form>
        </div>
    </div>
<?php
    if (isset($_POST['submit'])) {
        if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_FILES["mainPic"]["name"])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $fileName = basename($_FILES["mainPic"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['mainPic']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));

                if (products_Insert($name, $price, $companyID, $imgContent) == 1) {
                    header('REFRESH:0;URL=company.php?box=main&companyID=' . $companyID);
                }
            } else {
                echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            }
        } else {
            echo 'Please fill in all the data';
        }
    }
}

require "includes/main-templates/footer.html";
ob_end_flush();
