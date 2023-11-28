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
require "includes/main-templates/navbar.php";

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
                </div>
            </div>

            <div class="full-details">
                <div class="section-title">
                    <h2>full details</h2>
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
            </div>
            <?php
            $stmt_productcolors = productcolors_productID($productID);
            $counter = 0;
            if ($stmt_productcolors->rowCount() > 0) {
            ?>
                <table class="table table-hover mt-5 text-center" style="width: 30%; margin: 0 auto;">
                    <thead class="table-dark">
                        <th>#</th>
                        <th>color</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($row_productcolors = $stmt_productcolors->fetch(PDO::FETCH_ASSOC)) {
                            $counter++;
                        ?>
                            <tr>
                                <td><?php echo $counter ?></td>
                                <td><?php echo $row_productcolors['colorName'] ?></td>
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
}
require "includes/main-templates/footer.html";
ob_end_flush();
