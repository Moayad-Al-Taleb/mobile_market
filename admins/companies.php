<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/cards.css">
<link rel="stylesheet" href="design/css/forms.css">
<?php
require "includes/main-templates/navbar.html";
require "init.php";

if (empty($_SESSION["userID"])) {
    header('REFRESH:0;URL=index.php');
} else {
    if ($_SESSION["accountType"] == 2) {
        $controls = isset($_GET['controls']) ? $_GET['controls'] : 'main';
        if ($controls == 'main') {
            $stmt = companies();
?>
            <div class="container">
                <div class="section-title">
                    <h2>all companies</h2>
                    <a href="?controls=add">add new company</a>
                </div>
                <div class="cards-container">
                    <?php
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <div class="company-card">
                                <div class="image">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['companyLogo']) ?>" alt="">
                                </div>
                                <div class="details">
                                    <h3><?php echo $row['companyName'] ?></h3>
                                </div>
                                <div class="card-overlay"></div>
                                <div class="ctrl-btn">
                                    <a href="company.php?companyID=<?php echo $row['companyID'] ?>" class="company-card-btn">view products</a>
                                    <a href="?controls=edit&companyID=<?php echo $row['companyID'] ?>" class="btn btn-secondary">edit company</a>
                                    <a href="?controls=delete&companyID=<?php echo $row['companyID'] ?>" class="btn btn-danger">delete</a>
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
        ?>
            <div class="container">
                <div class="form-con data-form">
                    <h2>add new company</h2>
                    <form action="" method="POST" class="form" enctype="multipart/form-data">
                        <div class="input-field">
                            <label for="">company name</label>
                            <input class="input" type="text" name="companyName">
                        </div>
                        <div class="input-field">
                            <label for="">company picture</label>
                            <input class="input" type="file" name="companyLogo">
                        </div>
                        <input type="submit" name="submit" class="submitBtn" value="add company">
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                if (!empty($_POST['companyName']) && !empty($_FILES["companyLogo"]["name"])) {
                    $companyName = $_POST['companyName'];
                    $fileName = basename($_FILES["companyLogo"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['companyLogo']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));

                        if (companies_Insert($companyName, $imgContent) == 1) {
                            header('REFRESH:0;URL=companies.php');
                        }
                    } else {
                        echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } else {
                    echo 'Please fill in all the data';
                }
            } else {
                echo "ssss";
            }
        } elseif ($controls == 'delete') {
            $companyID = intval($_GET['companyID']);
            if (companies_delete($companyID) == 1) {
                header('REFRESH:0;URL=companies.php');
            } else {
                echo 'There are products belonging to the company. It is not possible to delete a company that must be removed from the products';
            }
        } elseif ($controls == 'edit') {
            $companyID = intval($_GET['companyID']);
            $stmt = companies_companyID($companyID);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="container">
                <div class="form-con data-form">
                    <h2>Edit company</h2>
                    <form action="" method="POST" class="form" enctype="multipart/form-data">
                        <div class="input-field">
                            <label for="">company name</label>
                            <input class="input" type="text" name="companyName" value="<?php echo $row['companyName'] ?>">
                        </div>
                        <div class="input-field">
                            <label for="">company picture</label>
                            <input class="input" type="file" name="companyLogo">
                        </div>
                        <input type="submit" name="submit" class="submitBtn" value="Edit company">
                    </form>
                </div>
            </div>
<?php
            if (isset($_POST['submit'])) {
                if (!empty($_POST['companyName']) && !empty($_FILES["companyLogo"]["name"])) {
                    $companyName = $_POST['companyName'];
                    $fileName = basename($_FILES["companyLogo"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['companyLogo']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));

                        if (companies_Update($companyID, $companyName, $imgContent) == 1) {
                            header('REFRESH:0;URL=companies.php');
                        }
                    } else {
                        echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } elseif (!empty($_POST['companyName'])) {
                    $companyName = $_POST['companyName'];

                    if (companies_Update_($companyID, $companyName) == 1) {
                        header('REFRESH:0;URL=companies.php');
                    }
                } else {
                    echo 'Please fill in all the data';
                }
            } else {
                echo "ssss";
            }
        }
        require "includes/main-templates/footer.html";
    }
}
ob_end_flush();
