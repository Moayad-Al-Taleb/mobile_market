<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
require "connect.php";
require "includes/functions/functions.php";
?>
<link rel="stylesheet" href="design/css/cards.css">
<link rel="stylesheet" href="design/css/product.css">
<link rel="stylesheet" href="design/css/forms.css">
<?php
require "includes/main-templates/navbar.html";

if (empty($_SESSION["userID"])) {
    header('REFRESH:0;URL=index.php');
} else {
    if ($_SESSION["accountType"] == 2) {
        $controls = isset($_GET['controls']) ? $_GET['controls'] : 'main';
        if ($controls == 'main') {
            $productID = intval($_GET['productID']);

            $stmt = products_details($productID);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt_productpics = productpics_productID($productID);

            $stmt_productID = products_productID($productID);
            $row_productID = $stmt_productID->fetch(PDO::FETCH_ASSOC);
?>
            <div class="container">
                <div class="section-title">
                    <h2><?php echo $row_productID['name'] ?></h2>
                    <a href="?controls=edit&productID=<?php echo $productID ?>">edit product</a>
                    <a href="?controls=add-pic&productID=<?php echo $productID ?>">add new picture</a>
                </div>
                <div class="product-container">
                    <div class="full-user-card">
                        <div class="carousel-images" data-carousel>
                            <button class="carousel-button prev" data-carousel-button="prev"><i class='fas fa-angle-double-left'></i></button>
                            <button class="carousel-button next" data-carousel-button="next"><i class='fas fa-angle-double-right'></i></button>
                            <ul data-slides>
                                <li class="slide" data-active>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_productID['mainPic']) ?>" alt="">
                                </li>
                                <?php
                                if ($stmt_productpics->rowCount() > 0) {
                                    while ($row_productpics = $stmt_productpics->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <li class="slide">
                                            <a class="product-delete-btn btn btn-danger" href="?controls=delete-pic&productID=<?php echo $productID ?>&picID=<?php echo $row_productpics['productPicID'] ?>">delete</a>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_productpics['productPicture']) ?>" alt="">
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="details">
                            <h2 class="section-title">important details</h2>
                            <div class="detail-column">
                                <span>CPU:</span><br>
                                <?php
                                if ($stmt->rowCount() > 0) {
                                    echo $row['processorType'];
                                }
                                ?>
                            </div>
                            <div class="detail-column">
                                <span>display:</span><br>
                                <?php
                                if ($stmt->rowCount() > 0) {
                                    echo $row['size'];
                                }
                                ?>
                            </div>
                            <div class="detail-column">
                                <span>battery:</span><br>
                                <?php
                                if ($stmt->rowCount() > 0) {
                                    echo $row['type_battery'];
                                }
                                ?>
                            </div>
                            <div class="detail-column">
                                <span>storage and ram:</span><br>
                                <?php
                                if ($stmt->rowCount() > 0) {
                                    echo $row['internalMemory'];
                                }
                                ?>
                            </div>
                            <div class="detail-column">
                                <?php
                                if ($row_productID['product_condition'] == 1) {
                                    $product_condition = 'Product status visible';
                                ?>
                                    <span>visibility:</span><br>
                                <?php
                                    echo $product_condition;
                                } elseif ($row_productID['product_condition'] == 2) {
                                    $product_condition = 'Product status hidden';
                                ?>
                                    <span>visibility:</span><br>
                                <?php
                                    echo $product_condition;
                                } ?>
                            </div>
                        </div>
                    </div>

                    <div class="full-details">
                        <div class="section-title">
                            <h2>full details</h2>
                            <?php
                            if ($stmt->rowCount() > 0) {
                            ?>
                                <a href="?controls=editDetails&productID=<?php echo $productID ?>">edit details</a>
                            <?php
                            } else { ?>
                                <a href="?controls=addDetails&productID=<?php echo $productID ?>">add details</a>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        if ($stmt->rowCount() > 0) {
                        ?>
                            <div class="details-row">
                                <div class="row-name">battery</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">battery type</td>
                                            <td class="row-table-data"><?php echo $row['type_battery'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">battery additions</td>
                                            <td class="row-table-data"><?php echo $row['additions_battery'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">camera</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">primary Camera</td>
                                            <td class="row-table-data"><?php echo $row['primaryCamera'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">video</td>
                                            <td class="row-table-data"><?php echo $row['video'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">secondary Camera</td>
                                            <td class="row-table-data"><?php echo $row['secondaryCamera'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">features</td>
                                            <td class="row-table-data"><?php echo $row['features'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">data</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">speed</td>
                                            <td class="row-table-data"><?php echo $row['speed'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">WLAN</td>
                                            <td class="row-table-data"><?php echo $row['WLAN'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">bluetooth</td>
                                            <td class="row-table-data"><?php echo $row['bluetooth'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">NFC</td>
                                            <td class="row-table-data"><?php echo $row['NFC'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">USB</td>
                                            <td class="row-table-data"><?php echo $row['USB'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">dimensions</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">weight</td>
                                            <td class="row-table-data"><?php echo $row['weight'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">Mobile Dimensions</td>
                                            <td class="row-table-data"><?php echo $row['MobileDimensions'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">Additions dimensions</td>
                                            <td class="row-table-data"><?php echo $row['Additions_dimensions'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">memory</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">internal Memory</td>
                                            <td class="row-table-data"><?php echo $row['internalMemory'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">cardSlot</td>
                                            <td class="row-table-data"><?php echo $row['cardSlot'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">more specifications</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">radio</td>
                                            <td class="row-table-data"><?php echo $row['radio'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">GPS</td>
                                            <td class="row-table-data"><?php echo $row['GPS'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">network</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">second Generation</td>
                                            <td class="row-table-data"><?php echo $row['seconGeneration'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">third Generation</td>
                                            <td class="row-table-data"><?php echo $row['thirdGeneration'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">fourth Generation</td>
                                            <td class="row-table-data"><?php echo $row['fourthGeneration'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">sim Card</td>
                                            <td class="row-table-data"><?php echo $row['simCard'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">phone system and capabilities</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">operating System</td>
                                            <td class="row-table-data"><?php echo $row['operatingSystem'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">processor Type</td>
                                            <td class="row-table-data"><?php echo $row['processorType'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">GPUn</td>
                                            <td class="row-table-data"><?php echo $row['GPU'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">sensors</td>
                                            <td class="row-table-data"><?php echo $row['sensors'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">processor Speed</td>
                                            <td class="row-table-data"><?php echo $row['processorSpeed'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">production date</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">announce</td>
                                            <td class="row-table-data"><?php echo $row['announce'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">releaseDate</td>
                                            <td class="row-table-data"><?php echo $row['releaseDate'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">screen</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">screen type</td>
                                            <td class="row-table-data"><?php echo $row['type_screen'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">size</td>
                                            <td class="row-table-data"><?php echo $row['size'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">density</td>
                                            <td class="row-table-data"><?php echo $row['density'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">protection</td>
                                            <td class="row-table-data"><?php echo $row['protection'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">scren additions</td>
                                            <td class="row-table-data"><?php echo $row['additions_screen'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="details-row">
                                <div class="row-name">sound</div>
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td class="row-table-title">loud Speaker</td>
                                            <td class="row-table-data"><?php echo $row['loudSpeaker'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="row-table-title">sound additions </td>
                                            <td class="row-table-data"><?php echo $row['additions_sound'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="alert alert-info">no details yet! </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="section-title">
                        <h2>product colors</h2>
                        <a href="?controls=addColor&productID=<?php echo $productID ?>">add new color</a>
                    </div>
                    <?php
                    $stmt_productcolors = productcolors_productID($productID);
                    $counter = 0;
                    if ($stmt_productcolors->rowCount() > 0) {
                    ?>
                        <table class="table table-hover mt-5 text-center" style="width: 60%; margin: 0 auto;">
                            <thead class="table-dark">
                                <th>#</th>
                                <th>color</th>
                                <th>control</th>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_productcolors = $stmt_productcolors->fetch(PDO::FETCH_ASSOC)) {
                                    $counter++;
                                ?>
                                    <tr>
                                        <td><?php echo $counter ?></td>
                                        <td><?php echo $row_productcolors['colorName'] ?></td>
                                        <td>
                                            <a href="?controls=deleteColor&productID=<?php echo $productID ?>&colorID=<?php echo $row_productcolors['colorID'] ?>" class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <div class="alert alert-info">no colors yet!</div>
                        </tr>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        } elseif ($controls == 'edit') {
            $productID = intval($_GET['productID']);
            $stmt = products_productID($productID);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
            <div class="container">
                <div class="form-con data-form">
                    <h2>edit <?php echo $row['name'] ?></h2>
                    <form action="" class="form" method="post" enctype="multipart/form-data">
                        <div class="input-field">
                            <label for="">product name</label>
                            <input name="name" type="text" class="input" value="<?php echo $row['name'] ?>">
                        </div>
                        <div class="input-field">
                            <label for="">product price</label>
                            <input name="price" class="input" type="number" value="<?php echo $row['price'] ?>">
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

                        if (products_Edit($name, $price, $imgContent,  $productID) == 1) {
                            header('REFRESH:0;URL=product.php?control=main&productID=' . $row['productID']);
                        }
                    } else {
                        echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } elseif (!empty($_POST['name']) && !empty($_POST['price'])) {
                    $name = $_POST['name'];
                    $price = $_POST['price'];

                    if (products_Edit_mainPic($name, $price, $productID) == 1) {
                        header('REFRESH:0;URL=product.php?control=main&productID=' . $row['productID']);
                    }
                } else {
                    echo 'Please fill in all the data';
                }
            }
        } elseif ($controls == 'addDetails') {
            $productID = intval($_GET['productID']);
            ?>
            <div class="container">
                <div class="form-con details-form">
                    <h2>add product details</h2>
                    <p class="alert alert-warning text-center" style="padding: 10px;">please fill all the fields bellow, if you don't have any info please type (-)</p>
                    <form action="" class="form" method="POST">
                        <div class="fields-con">
                            <div class="field">

                                <h4 style="color:#333; margin: 0;">screen</h4>
                                <div class="input-field">
                                    <label for="">screen type</label>
                                    <input class="input" name="type_screen" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">size</label>
                                    <input class="input" name="size" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">density</label>
                                    <input class="input" name="density" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">protection</label>
                                    <input class="input" name="protection" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">screen additions</label>
                                    <input class="input" name="additions_screen" type="text" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">production date</h4>
                                <div class="input-field">
                                    <label for="">announce</label>
                                    <input class="input" name="announce" type="date" required>
                                </div>
                                <div class="input-field">
                                    <label for="">release Date</label>
                                    <input class="input" name="releaseDate" type="date" required>
                                </div>
                                <h4 style="color: #333; margin: 0;">memory</h4>
                                <div class="input-field">
                                    <label for="">internal Memory</label>
                                    <input class="input" name="internalMemory" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">card Slot</label>
                                    <input class="input" name="cardSlot" type="text" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">network</h4>
                                <div class="input-field">
                                    <label for="">second Generation</label>
                                    <input class="input" name="seconGeneration" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">third Generation</label>
                                    <input class="input" name="thirdGeneration" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">fourth Generation</label>
                                    <input class="input" name="fourthGeneration" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">simCard</label>
                                    <input class="input" name="simCard" type="text" required>
                                </div>

                            </div>

                            <div class="field">

                                <h4 style="color: #333; margin: 0;">phone system and capabilities</h4>
                                <div class="input-field">
                                    <label for="">operating System</label>
                                    <input class="input" name="operatingSystem" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">pprocessor Type</label>
                                    <input class="input" name="processorType" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">GPU</label>
                                    <input class="input" name="GPU" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">sensors</label>
                                    <input class="input" name="sensors" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">processor Speed</label>
                                    <input class="input" name="processorSpeed" type="text" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">dimensions</h4>
                                <div class="input-field">
                                    <label for="">weight</label>
                                    <input class="input" name="weight" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">Mobile Dimensions</label>
                                    <input class="input" name="MobileDimensions" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">Additions dimensions</label>
                                    <input class="input" name="Additions_dimensions" type="text" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">sound</h4>
                                <div class="input-field">
                                    <label for="">loud Speaker</label>
                                    <input class="input" name="loudSpeaker" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">additions sound</label>
                                    <input class="input" name="additions_sound" type="text" required>
                                </div>

                            </div>

                            <div class="field">

                                <h4 style="color: #333; margin: 0;">more specifications</h4>
                                <div class="input-field">
                                    <label for="">radio</label>
                                    <input class="input" name="radio" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">GPS</label>
                                    <input class="input" name="GPS" type="text" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">camera</h4>
                                <div class="input-field">
                                    <label for="">primary Camera</label>
                                    <input class="input" name="primaryCamera" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">video</label>
                                    <input class="input" name="video" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">secondary Camera</label>
                                    <input class="input" name="secondaryCamera" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">features</label>
                                    <input class="input" name="features" type="text" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">data</h4>
                                <div class="input-field">
                                    <label for="">speed</label>
                                    <input class="input" name="speed" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">WLAN</label>
                                    <input class="input" name="WLAN" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">bluetooth</label>
                                    <input class="input" name="bluetooth" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">NFC</label>
                                    <input class="input" name="NFC" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">USB</label>
                                    <input class="input" name="USB" type="text" required>
                                </div>
                                <h4 style="color: #333; margin: 0;">battery</h4>
                                <div class="input-field">
                                    <label for="">battey type</label>
                                    <input class="input" name="type_battery" type="text" required>
                                </div>
                                <div class="input-field">
                                    <label for="">battery additions</label>
                                    <input class="input" name="additions_battery" type="text" required>
                                </div>

                            </div>
                        </div>
                        <input type="submit" name="submit" value="submit" style="padding: 10px 20px; margin: 10px auto; background-color: #ea7186;">
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                if (
                    !empty($_POST['operatingSystem'])
                    &&  !empty($_POST['processorType'])
                    &&  !empty($_POST['GPU'])
                    &&  !empty($_POST['sensors'])
                    &&  !empty($_POST['processorSpeed'])

                    &&  !empty($_POST['weight'])
                    &&  !empty($_POST['MobileDimensions'])
                    &&  !empty($_POST['Additions_dimensions'])

                    &&  !empty($_POST['loudSpeaker'])
                    &&  !empty($_POST['additions_sound'])

                    &&  !empty($_POST['type_screen'])
                    &&  !empty($_POST['size'])
                    &&  !empty($_POST['density'])
                    &&  !empty($_POST['protection'])
                    &&  !empty($_POST['additions_screen'])

                    &&  !empty($_POST['announce'])
                    &&  !empty($_POST['releaseDate'])

                    &&  !empty($_POST['speed'])
                    &&  !empty($_POST['WLAN'])
                    &&  !empty($_POST['bluetooth'])
                    &&  !empty($_POST['NFC'])
                    &&  !empty($_POST['USB'])

                    &&  !empty($_POST['type_battery'])
                    &&  !empty($_POST['additions_battery'])

                    &&  !empty($_POST['radio'])
                    &&  !empty($_POST['GPS'])

                    &&  !empty($_POST['primaryCamera'])
                    &&  !empty($_POST['video'])
                    &&  !empty($_POST['secondaryCamera'])
                    &&  !empty($_POST['features'])

                    &&  !empty($_POST['seconGeneration'])
                    &&  !empty($_POST['thirdGeneration'])
                    &&  !empty($_POST['fourthGeneration'])
                    &&  !empty($_POST['simCard'])

                    &&  !empty($_POST['internalMemory'])
                    &&  !empty($_POST['cardSlot'])
                ) {
                    // phonesystemandcapabilities
                    $operatingSystem = $_POST['operatingSystem'];
                    $processorType = $_POST['processorType'];
                    $GPU = $_POST['GPU'];
                    $sensors = $_POST['sensors'];
                    $processorSpeed = $_POST['processorSpeed'];

                    // dimensions
                    $weight = $_POST['weight'];
                    $MobileDimensions = $_POST['MobileDimensions'];
                    $Additions_dimensions = $_POST['Additions_dimensions'];

                    // sound
                    $loudSpeaker = $_POST['loudSpeaker'];
                    $additions_sound = $_POST['additions_sound'];

                    // screen
                    $type_screen = $_POST['type_screen'];
                    $size = $_POST['size'];
                    $density = $_POST['density'];
                    $protection = $_POST['protection'];
                    $additions_screen = $_POST['additions_screen'];

                    // productiondate
                    $announce = $_POST['announce'];
                    $releaseDate = $_POST['releaseDate'];

                    // data
                    $speed = $_POST['speed'];
                    $WLAN = $_POST['WLAN'];
                    $bluetooth = $_POST['bluetooth'];
                    $NFC = $_POST['NFC'];
                    $USB = $_POST['USB'];

                    // battery
                    $type_battery = $_POST['type_battery'];
                    $additions_battery = $_POST['additions_battery'];

                    // morespecifications
                    $radio = $_POST['radio'];
                    $GPS = $_POST['GPS'];

                    // camera
                    $primaryCamera = $_POST['primaryCamera'];
                    $video = $_POST['video'];
                    $secondaryCamera = $_POST['secondaryCamera'];
                    $features = $_POST['features'];

                    // network
                    $seconGeneration = $_POST['seconGeneration'];
                    $thirdGeneration = $_POST['thirdGeneration'];
                    $fourthGeneration = $_POST['fourthGeneration'];
                    $simCard = $_POST['simCard'];

                    // memory
                    $internalMemory = $_POST['internalMemory'];
                    $cardSlot = $_POST['cardSlot'];

                    if (
                        phonesystemandcapabilities($operatingSystem, $processorType, $GPU, $sensors, $processorSpeed, $productID) == 1
                        &&
                        dimensions($weight, $MobileDimensions, $Additions_dimensions, $productID) == 1
                        &&
                        sound($loudSpeaker, $additions_sound, $productID) == 1
                        &&
                        screen($type_screen, $size, $density, $protection, $additions_screen, $productID)
                        &&
                        productiondate($announce, $releaseDate, $productID) == 1
                        &&
                        data($speed, $WLAN, $bluetooth, $NFC, $USB, $productID) == 1
                        &&
                        battery($type_battery, $additions_battery, $productID) == 1
                        &&
                        morespecifications($radio, $GPS, $productID) == 1
                        &&
                        camera($primaryCamera, $video, $secondaryCamera, $features, $productID) == 1
                        &&
                        network($seconGeneration, $thirdGeneration, $fourthGeneration, $simCard, $productID) == 1
                        &&
                        memory($internalMemory, $cardSlot, $productID) == 1
                    ) {
                        header('REFRESH:0;URL=?controls=main&productID=' . $productID);
                    }
                }
            }
        } elseif ($controls == 'editDetails') {
            $productID = intval($_GET['productID']);
            $stmt = products_details($productID);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="container">
                <div class="form-con details-form">
                    <h2>edit product details</h2>
                    <p class="alert alert-warning text-center" style="padding: 10px;">please fill all the fields bellow, if you don't have any info please type (-)</p>
                    <form action="" method="POST" class="form">
                        <div class="fields-con">
                            <div class="field">

                                <h4 style="color:#333; margin: 0;">screen</h4>
                                <div class="input-field">
                                    <label for="">screen type</label>
                                    <input class="input" name="type_screen" type="text" value="<?php echo $row['type_screen'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">size</label>
                                    <input class="input" name="size" type="text" value="<?php echo $row['size'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">density</label>
                                    <input class="input" name="density" type="text" value="<?php echo $row['density'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">protection</label>
                                    <input class="input" name="protection" type="text" value="<?php echo $row['protection'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">screen additions</label>
                                    <input class="input" name="additions_screen" type="text" value="<?php echo $row['additions_screen'] ?>" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">production date</h4>
                                <div class="input-field">
                                    <label for="">announce</label>
                                    <input class="input" name="announce" type="date" value="<?php echo $row['announce'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">release Date</label>
                                    <input class="input" name="releaseDate" type="date" value="<?php echo $row['releaseDate'] ?>" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">memory</h4>
                                <div class="input-field">
                                    <label for="">internal Memory</label>
                                    <input class="input" name="internalMemory" type="text" value="<?php echo $row['internalMemory'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">card Slot</label>
                                    <input class="input" name="cardSlot" type="text" value="<?php echo $row['cardSlot'] ?>" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">network</h4>
                                <div class="input-field">
                                    <label for="">second Generation</label>
                                    <input class="input" name="seconGeneration" type="text" value="<?php echo $row['seconGeneration'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">third Generation</label>
                                    <input class="input" name="thirdGeneration" type="text" value="<?php echo $row['thirdGeneration'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">fourth Generation</label>
                                    <input class="input" name="fourthGeneration" type="text" value="<?php echo $row['fourthGeneration'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">simCard</label>
                                    <input class="input" name="simCard" type="text" value="<?php echo $row['simCard'] ?>" required>
                                </div>

                            </div>

                            <div class="field">

                                <h4 style="color: #333; margin: 0;">phone system and capabilities</h4>
                                <div class="input-field">
                                    <label for="">operating System</label>
                                    <input class="input" name="operatingSystem" type="text" value="<?php echo $row['operatingSystem'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">pprocessor Type</label>
                                    <input class="input" name="processorType" type="text" value="<?php echo $row['processorType'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">GPU</label>
                                    <input class="input" name="GPU" type="text" value="<?php echo $row['GPU'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">sensors</label>
                                    <input class="input" name="sensors" type="text" value="<?php echo $row['sensors'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">processor Speed</label>
                                    <input class="input" name="processorSpeed" type="text" value="<?php echo $row['processorSpeed'] ?>" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">dimensions</h4>
                                <div class="input-field">
                                    <label for="">weight</label>
                                    <input class="input" name="weight" type="text" value="<?php echo $row['weight'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">Mobile Dimensions</label>
                                    <input class="input" name="MobileDimensions" type="text" value="<?php echo $row['MobileDimensions'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">Additions dimensions</label>
                                    <input class="input" name="Additions_dimensions" type="text" value="<?php echo $row['Additions_dimensions'] ?>" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">sound</h4>
                                <div class="input-field">
                                    <label for="">loud Speaker</label>
                                    <input class="input" name="loudSpeaker" type="text" value="<?php echo $row['loudSpeaker'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">additions sound</label>
                                    <input class="input" name="additions_sound" type="text" value="<?php echo $row['additions_sound'] ?>" required>
                                </div>

                            </div>

                            <div class="field">

                                <h4 style="color: #333; margin: 0;">more specifications</h4>
                                <div class="input-field">
                                    <label for="">radio</label>
                                    <input class="input" name="radio" type="text" value="<?php echo $row['radio'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">GPS</label>
                                    <input class="input" name="GPS" type="text" value="<?php echo $row['GPS'] ?>" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">camera</h4>
                                <div class="input-field">
                                    <label for="">primary Camera</label>
                                    <input class="input" name="primaryCamera" type="text" value="<?php echo $row['primaryCamera'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">video</label>
                                    <input class="input" name="video" type="text" value="<?php echo $row['video'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">secondary Camera</label>
                                    <input class="input" name="secondaryCamera" type="text" value="<?php echo $row['secondaryCamera'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">features</label>
                                    <input class="input" name="features" type="text" value="<?php echo $row['features'] ?>" required>
                                </div>

                                <h4 style="color: #333; margin: 0;">data</h4>
                                <div class="input-field">
                                    <label for="">speed</label>
                                    <input class="input" name="speed" type="text" value="<?php echo $row['speed'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">WLAN</label>
                                    <input class="input" name="WLAN" type="text" value="<?php echo $row['WLAN'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">bluetooth</label>
                                    <input class="input" name="bluetooth" type="text" value="<?php echo $row['bluetooth'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">NFC</label>
                                    <input class="input" name="NFC" type="text" value="<?php echo $row['NFC'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">USB</label>
                                    <input class="input" name="USB" type="text" value="<?php echo $row['USB'] ?>">
                                </div>
                                <h4 style="color: #333; margin: 0;">battery</h4>
                                <div class="input-field">
                                    <label for="">battey type</label>
                                    <input class="input" name="type_battery" type="text" value="<?php echo $row['type_battery'] ?>" required>
                                </div>
                                <div class="input-field">
                                    <label for="">battery additions</label>
                                    <input class="input" name="additions_battery" type="text" value="<?php echo $row['additions_battery'] ?>" required>
                                </div>

                            </div>
                        </div>
                        <input type="submit" name="submit" value="edit data" style="padding: 10px 20px; margin: 10px auto; background-color: #ea7186;">
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                if (
                    !empty($_POST['operatingSystem'])
                    &&  !empty($_POST['processorType'])
                    &&  !empty($_POST['GPU'])
                    &&  !empty($_POST['sensors'])
                    &&  !empty($_POST['processorSpeed'])

                    &&  !empty($_POST['weight'])
                    &&  !empty($_POST['MobileDimensions'])
                    &&  !empty($_POST['Additions_dimensions'])

                    &&  !empty($_POST['loudSpeaker'])
                    &&  !empty($_POST['additions_sound'])

                    &&  !empty($_POST['type_screen'])
                    &&  !empty($_POST['size'])
                    &&  !empty($_POST['density'])
                    &&  !empty($_POST['protection'])
                    &&  !empty($_POST['additions_screen'])

                    &&  !empty($_POST['announce'])
                    &&  !empty($_POST['releaseDate'])

                    &&  !empty($_POST['speed'])
                    &&  !empty($_POST['WLAN'])
                    &&  !empty($_POST['bluetooth'])
                    &&  !empty($_POST['NFC'])
                    &&  !empty($_POST['USB'])

                    &&  !empty($_POST['type_battery'])
                    &&  !empty($_POST['additions_battery'])

                    &&  !empty($_POST['radio'])
                    &&  !empty($_POST['GPS'])

                    &&  !empty($_POST['primaryCamera'])
                    &&  !empty($_POST['video'])
                    &&  !empty($_POST['secondaryCamera'])
                    &&  !empty($_POST['features'])

                    &&  !empty($_POST['seconGeneration'])
                    &&  !empty($_POST['thirdGeneration'])
                    &&  !empty($_POST['fourthGeneration'])
                    &&  !empty($_POST['simCard'])

                    &&  !empty($_POST['internalMemory'])
                    &&  !empty($_POST['cardSlot'])
                ) {
                    // phonesystemandcapabilities
                    $operatingSystem = $_POST['operatingSystem'];
                    $processorType = $_POST['processorType'];
                    $GPU = $_POST['GPU'];
                    $sensors = $_POST['sensors'];
                    $processorSpeed = $_POST['processorSpeed'];

                    // dimensions
                    $weight = $_POST['weight'];
                    $MobileDimensions = $_POST['MobileDimensions'];
                    $Additions_dimensions = $_POST['Additions_dimensions'];

                    // sound
                    $loudSpeaker = $_POST['loudSpeaker'];
                    $additions_sound = $_POST['additions_sound'];

                    // screen
                    $type_screen = $_POST['type_screen'];
                    $size = $_POST['size'];
                    $density = $_POST['density'];
                    $protection = $_POST['protection'];
                    $additions_screen = $_POST['additions_screen'];

                    // productiondate
                    $announce = $_POST['announce'];
                    $releaseDate = $_POST['releaseDate'];

                    // data
                    $speed = $_POST['speed'];
                    $WLAN = $_POST['WLAN'];
                    $bluetooth = $_POST['bluetooth'];
                    $NFC = $_POST['NFC'];
                    $USB = $_POST['USB'];

                    // battery
                    $type_battery = $_POST['type_battery'];
                    $additions_battery = $_POST['additions_battery'];

                    // morespecifications
                    $radio = $_POST['radio'];
                    $GPS = $_POST['GPS'];

                    // camera
                    $primaryCamera = $_POST['primaryCamera'];
                    $video = $_POST['video'];
                    $secondaryCamera = $_POST['secondaryCamera'];
                    $features = $_POST['features'];

                    // network
                    $seconGeneration = $_POST['seconGeneration'];
                    $thirdGeneration = $_POST['thirdGeneration'];
                    $fourthGeneration = $_POST['fourthGeneration'];
                    $simCard = $_POST['simCard'];

                    // memory
                    $internalMemory = $_POST['internalMemory'];
                    $cardSlot = $_POST['cardSlot'];

                    phonesystemandcapabilities_edit($operatingSystem, $processorType, $GPU, $sensors, $processorSpeed, $productID);
                    dimensions_edit($weight, $MobileDimensions, $Additions_dimensions, $productID);
                    sound_edit($loudSpeaker, $additions_sound, $productID);
                    screen_edit($type_screen, $size, $density, $protection, $additions_screen, $productID);
                    productiondate_edit($announce, $releaseDate, $productID);
                    data_edit($speed, $WLAN, $bluetooth, $NFC, $USB, $productID);
                    battery_edit($type_battery, $additions_battery, $productID);
                    morespecifications_edit($radio, $GPS, $productID);
                    camera_edit($primaryCamera, $video, $secondaryCamera, $features, $productID);
                    network_edit($seconGeneration, $thirdGeneration, $fourthGeneration, $simCard, $productID);
                    memory_edit($internalMemory, $cardSlot, $productID);
                    header('REFRESH:0;URL=?controls=main&productID=' . $productID);
                }
            }
        } elseif ($controls == 'add-pic') {
            $productID = intval($_GET['productID']);
            ?>
            <div class="container">
                <div class="form-con data-form">
                    <form action="" class="form" method="post" enctype="multipart/form-data">
                        <div class="input-field">
                            <label for="">product pics</label>
                            <input name="productPicture" class="input" type="file">
                        </div>
                        <input type="submit" name="submit" class="submitBtn" value="submit">
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                if (!empty($_FILES["productPicture"]["name"])) {
                    $fileName = basename($_FILES["productPicture"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['productPicture']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));

                        if (productpics($imgContent, $productID) == 1) {
                            header('REFRESH:0;URL=product.php?controls=main&productID=' . $productID);
                        }
                    } else {
                        echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } else {
                    echo 'Please fill in all the data';
                }
            }
        } elseif ($controls == 'delete-pic') {
            $picID = intval($_GET['picID']);
            $productID = intval($_GET['productID']);
            if (productpics_productPicID($picID) == 1) {
                header('REFRESH:0;URL=?control=main&productID=' . $productID);
            } else {
                echo "hhhh";
            }
        } elseif ($controls == 'addColor') {
            $productID = intval($_GET['productID']);
            ?>
            <div class="container">
                <div class="form-con data-form">
                    <form action="" class="form" method="post" enctype="multipart/form-data">
                        <div class="input-field">
                            <label for="">product color</label>
                            <input name="colorName" class="input" type="text">
                        </div>
                        <input type="submit" name="submit" class="submitBtn" value="submit">
                    </form>
                </div>
            </div>
<?php
            if (isset($_POST['submit'])) {
                if (!empty($_POST['colorName'])) {
                    $colorName = $_POST['colorName'];
                    if (productcolors($colorName, $productID) == 1) {
                        header('REFRESH:0;URL=product.php?productID=' . $productID);
                    }
                } else {
                    echo 'Please fill in all the data';
                }
            }
        } elseif ($controls == 'deleteColor') {
            $colorID = intval($_GET['colorID']);
            $productID = intval($_GET['productID']);

            if (productcolors_colorID($colorID) == 1) {
                header('REFRESH:0;URL=product.php?productID=' . $productID);
            }
        }
        require "includes/main-templates/footer.html";
        ob_end_flush();
    }
}
