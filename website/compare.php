<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/cards.css">
<link rel="stylesheet" href="design/css/forms.css">
<?php
require "includes/main-templates/navbar.php";
require "includes/functions/functions.php";
$controls = isset($_GET['controls']) ? $_GET['controls'] : 'main';
if ($controls == 'main') {
    $stmt = All_phones();
?>
    <div class="container">
        <div class="section-title">
            <h2>all mobiles</h2>
            <div class="filter-page">
            </div>
        </div>
        <div class="cards-container">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['product_condition'] == 1) {
            ?>
                    <div class="product-card">
                        <div class="top">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['mainPic']) ?>" alt="">
                            <h5 id="product-name" class="text-center"><?php echo  $row['name'] ?></h5>
                            <p><?php echo $row['price'] . 'S.P' ?></p>
                        </div>
                        <div class="bottom">
                            <button data-id="<?php echo $row['productID'] ?>"><i class="fas fa-plus"></i> compare</button>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

        </div>
        <div class="compareCard">
            <a style="display: none;" href="#">compare</a>
        </div>
    </div>
    <script>
        let buttons = document.querySelectorAll("[data-id]"); //get all compare buttons
        let compareCard = document.querySelector(".compareCard"); //get the empty compare card
        let a = compareCard.querySelector("a"); //get a element inside our compare card
        let counter = 0;
        for (let i = 0; i < buttons.length; i++) {
            //for clicking a specific button
            buttons[i].addEventListener("click", function() {
                counter++;
                if (counter < 5) {
                    //make the button disable to never clicking and add the same button again
                    buttons[i].setAttribute("disabled", true)
                    // get the id of our product
                    let productID = buttons[i].dataset.id;
                    //change the icon to check icon
                    buttons[i].querySelector("i").setAttribute("class", "fas fa-check");
                    //get the name of our product
                    let productName = buttons[i].closest(".product-card").querySelector("#product-name");
                    //making a new product card 
                    let productCompareCard = document.createElement("div");
                    //give the new product card class name (productCompareCard)
                    productCompareCard.classList.add("productCompareCard");
                    //give our product card the id we get
                    productCompareCard.dataset.id = productID;
                    //create a new element inour product card
                    let productCompareCardName = document.createElement("h5");
                    //give the new element our product name value 
                    productCompareCardName.innerHTML = productName.textContent;
                    //add the product compare card name to our product compare card
                    productCompareCard.prepend(productCompareCardName);
                    //add our product compare card to compare card
                    compareCard.prepend(productCompareCard);
                    //add the flex layout to our compare card
                    compareCard.style.display = 'flex';
                    //check if the products in our compare card above 2 to let the user click the button to compare this two or more devices
                    if (compareCard.children.length > 2) {
                        //call the function changeHref to let user compare
                        changeHref();
                    }
                }
            })
        }

        function changeHref() {
            let productID1 = compareCard.querySelector(".productCompareCard:nth-child(1)").dataset.id;
            let productID2 = compareCard.querySelector(".productCompareCard:nth-child(2)").dataset.id;
            let element1 = compareCard.querySelector(".productCompareCard:nth-child(3)");
            let element2 = compareCard.querySelector(".productCompareCard:nth-child(4)");

            a.setAttribute("href", `compare.php?controls=compareDevices&productID_1=${productID1}&productID_2=${productID2}`);

            if (productID1 != null && productID2 != null) {
                a.style.display = 'block';
            }
            //check if element1 is exist or not
            // if exist then we get the id for it and change the url to (3 ids)
            if (typeof(element1) != 'undefined' && element1 != null) {
                productID3 = element1.dataset.id;
                a.setAttribute("href", `compare.php?controls=compareDevices&productID_1=${productID1}&productID_2=${productID2}&productID_3=${productID3}`);
            }
            //check if element2 is exist or not
            // if exist then we get the id for it and change the url to (4 ids)
            if (typeof(element2) != 'undefined' && element2 != null) {
                productID4 = element2.dataset.id;
                a.setAttribute("href", `compare.php?controls=compareDevices&productID_1=${productID1}&productID_2=${productID2}&productID_3=${productID3}&productID_4=${productID4}`);
            }
        }
    </script>
    <?php
} elseif ($controls == 'compareDevices') {
    $productID_1 = $_GET['productID_1'];
    $productID_2 = $_GET['productID_2'];
    $productID_3 = isset($_GET['productID_3']) ? $_GET['productID_3'] : '';
    $productID_4 = isset($_GET['productID_4']) ? $_GET['productID_4'] : '';
    if ($productID_1 != null && $productID_2 != null && $productID_3 == null && $productID_4 == null) {
        $stmt_productID_1 = products_productID($productID_1);
        $stmt_details_1 = products_details($productID_1);
        $row_productID_1 = $stmt_productID_1->fetch(PDO::FETCH_ASSOC);
        $row_details_1 = $stmt_details_1->fetch(PDO::FETCH_ASSOC);
        // __________________________________________________
        $stmt_productID_2 = products_productID($productID_2);
        $stmt_details_2 = products_details($productID_2);
        $row_productID_2 = $stmt_productID_2->fetch(PDO::FETCH_ASSOC);
        $row_details_2 = $stmt_details_2->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="container">
            <div class="alert alert-warning fs-4 fw-bold text-center">
                comparision result
            </div>
            <h3 class="text-primary">dimensions</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">weight</th>
                            <td><?php echo $row_details_1['weight'] ?></td>
                            <td><?php echo $row_details_2['weight'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">Mobile Dimensions</th>
                            <td><?php echo $row_details_1['MobileDimensions'] ?></td>
                            <td><?php echo $row_details_2['MobileDimensions'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">Dimensions additions</th>
                            <td><?php echo $row_details_1['Additions_dimensions'] ?></td>
                            <td><?php echo $row_details_2['Additions_dimensions'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">screen</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">type_screen</th>
                            <td><?php echo $row_details_1['type_screen'] ?></td>
                            <td><?php echo $row_details_2['type_screen'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">size</th>
                            <td><?php echo $row_details_1['size'] ?></td>
                            <td><?php echo $row_details_2['size'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">density</th>
                            <td><?php echo $row_details_1['density'] ?></td>
                            <td><?php echo $row_details_2['density'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">protection</th>
                            <td><?php echo $row_details_1['protection'] ?></td>
                            <td><?php echo $row_details_2['protection'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">screen additions</th>
                            <td><?php echo $row_details_1['additions_screen'] ?></td>
                            <td><?php echo $row_details_2['additions_screen'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">phone system and capabilities</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">operating System</th>
                            <td><?php echo $row_details_1['operatingSystem'] ?></td>
                            <td><?php echo $row_details_2['operatingSystem'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">processor Type</th>
                            <td><?php echo $row_details_1['processorType'] ?></td>
                            <td><?php echo $row_details_2['processorType'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">GPU</th>
                            <td><?php echo $row_details_1['GPU'] ?></td>
                            <td><?php echo $row_details_2['GPU'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">sensors</th>
                            <td><?php echo $row_details_1['sensors'] ?></td>
                            <td><?php echo $row_details_2['sensors'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">processor Speed</th>
                            <td><?php echo $row_details_1['processorSpeed'] ?></td>
                            <td><?php echo $row_details_2['processorSpeed'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">battery</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">battery type</th>
                            <td><?php echo $row_details_1['type_battery'] ?></td>
                            <td><?php echo $row_details_2['type_battery'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">battery additions</th>
                            <td><?php echo $row_details_1['additions_battery'] ?></td>
                            <td><?php echo $row_details_2['additions_battery'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">camera</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">primary Camera</th>
                            <td><?php echo $row_details_1['primaryCamera'] ?></td>
                            <td><?php echo $row_details_2['primaryCamera'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">video</th>
                            <td><?php echo $row_details_1['video'] ?></td>
                            <td><?php echo $row_details_2['video'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">secondary Camera</th>
                            <td><?php echo $row_details_1['secondaryCamera'] ?></td>
                            <td><?php echo $row_details_2['secondaryCamera'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">features</th>
                            <td><?php echo $row_details_1['features'] ?></td>
                            <td><?php echo $row_details_2['features'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">network</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">second Generation</th>
                            <td><?php echo $row_details_1['seconGeneration'] ?></td>
                            <td><?php echo $row_details_2['seconGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">third Generation</th>
                            <td><?php echo $row_details_1['thirdGeneration'] ?></td>
                            <td><?php echo $row_details_2['thirdGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">fourth Generation</th>
                            <td><?php echo $row_details_1['fourthGeneration'] ?></td>
                            <td><?php echo $row_details_2['fourthGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">simCard</th>
                            <td><?php echo $row_details_1['simCard'] ?></td>
                            <td><?php echo $row_details_2['simCard'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">memory</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">internal Memory</th>
                            <td><?php echo $row_details_1['internalMemory'] ?></td>
                            <td><?php echo $row_details_2['internalMemory'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">card Slot</th>
                            <td><?php echo $row_details_1['cardSlot'] ?></td>
                            <td><?php echo $row_details_2['cardSlot'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">data</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">speed</th>
                            <td><?php echo $row_details_1['speed'] ?></td>
                            <td><?php echo $row_details_2['speed'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">WLAN</th>
                            <td><?php echo $row_details_1['WLAN'] ?></td>
                            <td><?php echo $row_details_2['WLAN'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">bluetooth</th>
                            <td><?php echo $row_details_1['bluetooth'] ?></td>
                            <td><?php echo $row_details_2['bluetooth'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">NFC</th>
                            <td><?php echo $row_details_1['NFC'] ?></td>
                            <td><?php echo $row_details_2['NFC'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">USB</th>
                            <td><?php echo $row_details_1['USB'] ?></td>
                            <td><?php echo $row_details_2['USB'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">sounds</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">loud Speaker</th>
                            <td><?php echo $row_details_1['loudSpeaker'] ?></td>
                            <td><?php echo $row_details_2['loudSpeaker'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">sound additions</th>
                            <td><?php echo $row_details_1['additions_sound'] ?></td>
                            <td><?php echo $row_details_2['additions_sound'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">productiondate</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">announce</th>
                            <td><?php echo $row_details_1['announce'] ?></td>
                            <td><?php echo $row_details_2['announce'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">releaseDate</th>
                            <td><?php echo $row_details_1['releaseDate'] ?></td>
                            <td><?php echo $row_details_2['releaseDate'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">morespecifications</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">radio</th>
                            <td><?php echo $row_details_1['radio'] ?></td>
                            <td><?php echo $row_details_2['radio'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">GPS</th>
                            <td><?php echo $row_details_1['GPS'] ?></td>
                            <td><?php echo $row_details_2['GPS'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    } elseif ($productID_1 != null && $productID_2 != null && $productID_3 != null && $productID_4 == null) {
        // __________________________________________________
        $stmt_productID_1 = products_productID($productID_1);
        $stmt_details_1 = products_details($productID_1);
        $row_productID_1 = $stmt_productID_1->fetch(PDO::FETCH_ASSOC);
        $row_details_1 = $stmt_details_1->fetch(PDO::FETCH_ASSOC);
        // __________________________________________________
        $stmt_productID_2 = products_productID($productID_2);
        $stmt_details_2 = products_details($productID_2);
        $row_productID_2 = $stmt_productID_2->fetch(PDO::FETCH_ASSOC);
        $row_details_2 = $stmt_details_2->fetch(PDO::FETCH_ASSOC);
        // __________________________________________________
        $stmt_productID_3 = products_productID($productID_3);
        $stmt_details_3 = products_details($productID_3);
        $row_productID_3 = $stmt_productID_3->fetch(PDO::FETCH_ASSOC);
        $row_details_3 = $stmt_details_3->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="container">
            <div class="alert alert-warning fs-4 fw-bold text-center">
                comparision result
            </div>
            <h3 class="text-primary">dimensions</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">weight</th>
                            <td><?php echo $row_details_1['weight'] ?></td>
                            <td><?php echo $row_details_2['weight'] ?></td>
                            <td><?php echo $row_details_3['weight'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">Mobile Dimensions</th>
                            <td><?php echo $row_details_1['MobileDimensions'] ?></td>
                            <td><?php echo $row_details_2['MobileDimensions'] ?></td>
                            <td><?php echo $row_details_3['MobileDimensions'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">Dimensions additions</th>
                            <td><?php echo $row_details_1['Additions_dimensions'] ?></td>
                            <td><?php echo $row_details_2['Additions_dimensions'] ?></td>
                            <td><?php echo $row_details_3['Additions_dimensions'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">screen</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">type_screen</th>
                            <td><?php echo $row_details_1['type_screen'] ?></td>
                            <td><?php echo $row_details_2['type_screen'] ?></td>
                            <td><?php echo $row_details_3['type_screen'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">size</th>
                            <td><?php echo $row_details_1['size'] ?></td>
                            <td><?php echo $row_details_2['size'] ?></td>
                            <td><?php echo $row_details_3['size'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">density</th>
                            <td><?php echo $row_details_1['density'] ?></td>
                            <td><?php echo $row_details_2['density'] ?></td>
                            <td><?php echo $row_details_3['density'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">protection</th>
                            <td><?php echo $row_details_1['protection'] ?></td>
                            <td><?php echo $row_details_2['protection'] ?></td>
                            <td><?php echo $row_details_3['protection'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">screen additions</th>
                            <td><?php echo $row_details_1['additions_screen'] ?></td>
                            <td><?php echo $row_details_2['additions_screen'] ?></td>
                            <td><?php echo $row_details_3['additions_screen'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">phone system and capabilities</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">operating System</th>
                            <td><?php echo $row_details_1['operatingSystem'] ?></td>
                            <td><?php echo $row_details_2['operatingSystem'] ?></td>
                            <td><?php echo $row_details_3['operatingSystem'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">processor Type</th>
                            <td><?php echo $row_details_1['processorType'] ?></td>
                            <td><?php echo $row_details_2['processorType'] ?></td>
                            <td><?php echo $row_details_3['processorType'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">GPU</th>
                            <td><?php echo $row_details_1['GPU'] ?></td>
                            <td><?php echo $row_details_2['GPU'] ?></td>
                            <td><?php echo $row_details_3['GPU'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">sensors</th>
                            <td><?php echo $row_details_1['sensors'] ?></td>
                            <td><?php echo $row_details_2['sensors'] ?></td>
                            <td><?php echo $row_details_3['sensors'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">processor Speed</th>
                            <td><?php echo $row_details_1['processorSpeed'] ?></td>
                            <td><?php echo $row_details_2['processorSpeed'] ?></td>
                            <td><?php echo $row_details_3['processorSpeed'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">battery</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">battery type</th>
                            <td><?php echo $row_details_1['type_battery'] ?></td>
                            <td><?php echo $row_details_2['type_battery'] ?></td>
                            <td><?php echo $row_details_3['type_battery'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">battery additions</th>
                            <td><?php echo $row_details_1['additions_battery'] ?></td>
                            <td><?php echo $row_details_2['additions_battery'] ?></td>
                            <td><?php echo $row_details_3['additions_battery'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">camera</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">primary Camera</th>
                            <td><?php echo $row_details_1['primaryCamera'] ?></td>
                            <td><?php echo $row_details_2['primaryCamera'] ?></td>
                            <td><?php echo $row_details_3['primaryCamera'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">video</th>
                            <td><?php echo $row_details_1['video'] ?></td>
                            <td><?php echo $row_details_2['video'] ?></td>
                            <td><?php echo $row_details_3['video'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">secondary Camera</th>
                            <td><?php echo $row_details_1['secondaryCamera'] ?></td>
                            <td><?php echo $row_details_2['secondaryCamera'] ?></td>
                            <td><?php echo $row_details_2['secondaryCamera'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">features</th>
                            <td><?php echo $row_details_1['features'] ?></td>
                            <td><?php echo $row_details_2['features'] ?></td>
                            <td><?php echo $row_details_3['features'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">network</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">second Generation</th>
                            <td><?php echo $row_details_1['seconGeneration'] ?></td>
                            <td><?php echo $row_details_2['seconGeneration'] ?></td>
                            <td><?php echo $row_details_3['seconGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">third Generation</th>
                            <td><?php echo $row_details_1['thirdGeneration'] ?></td>
                            <td><?php echo $row_details_2['thirdGeneration'] ?></td>
                            <td><?php echo $row_details_3['thirdGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">fourth Generation</th>
                            <td><?php echo $row_details_1['fourthGeneration'] ?></td>
                            <td><?php echo $row_details_2['fourthGeneration'] ?></td>
                            <td><?php echo $row_details_3['fourthGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">simCard</th>
                            <td><?php echo $row_details_1['simCard'] ?></td>
                            <td><?php echo $row_details_2['simCard'] ?></td>
                            <td><?php echo $row_details_3['simCard'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">memory</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">internal Memory</th>
                            <td><?php echo $row_details_1['internalMemory'] ?></td>
                            <td><?php echo $row_details_2['internalMemory'] ?></td>
                            <td><?php echo $row_details_3['internalMemory'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">card Slot</th>
                            <td><?php echo $row_details_1['cardSlot'] ?></td>
                            <td><?php echo $row_details_2['cardSlot'] ?></td>
                            <td><?php echo $row_details_3['cardSlot'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">data</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">speed</th>
                            <td><?php echo $row_details_1['speed'] ?></td>
                            <td><?php echo $row_details_2['speed'] ?></td>
                            <td><?php echo $row_details_3['speed'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">WLAN</th>
                            <td><?php echo $row_details_1['WLAN'] ?></td>
                            <td><?php echo $row_details_2['WLAN'] ?></td>
                            <td><?php echo $row_details_3['WLAN'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">bluetooth</th>
                            <td><?php echo $row_details_1['bluetooth'] ?></td>
                            <td><?php echo $row_details_2['bluetooth'] ?></td>
                            <td><?php echo $row_details_3['bluetooth'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">NFC</th>
                            <td><?php echo $row_details_1['NFC'] ?></td>
                            <td><?php echo $row_details_2['NFC'] ?></td>
                            <td><?php echo $row_details_3['NFC'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">USB</th>
                            <td><?php echo $row_details_1['USB'] ?></td>
                            <td><?php echo $row_details_2['USB'] ?></td>
                            <td><?php echo $row_details_3['USB'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">sounds</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">loud Speaker</th>
                            <td><?php echo $row_details_1['loudSpeaker'] ?></td>
                            <td><?php echo $row_details_2['loudSpeaker'] ?></td>
                            <td><?php echo $row_details_3['loudSpeaker'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">sound additions</th>
                            <td><?php echo $row_details_1['additions_sound'] ?></td>
                            <td><?php echo $row_details_2['additions_sound'] ?></td>
                            <td><?php echo $row_details_3['additions_sound'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">productiondate</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">announce</th>
                            <td><?php echo $row_details_1['announce'] ?></td>
                            <td><?php echo $row_details_2['announce'] ?></td>
                            <td><?php echo $row_details_3['announce'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">releaseDate</th>
                            <td><?php echo $row_details_1['releaseDate'] ?></td>
                            <td><?php echo $row_details_2['releaseDate'] ?></td>
                            <td><?php echo $row_details_3['releaseDate'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">morespecifications</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">radio</th>
                            <td><?php echo $row_details_1['radio'] ?></td>
                            <td><?php echo $row_details_2['radio'] ?></td>
                            <td><?php echo $row_details_3['radio'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">GPS</th>
                            <td><?php echo $row_details_1['GPS'] ?></td>
                            <td><?php echo $row_details_2['GPS'] ?></td>
                            <td><?php echo $row_details_3['GPS'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    } elseif ($productID_1 != null && $productID_2 != null && $productID_3 != null && $productID_4 != null) {
        // __________________________________________________
        $stmt_productID_1 = products_productID($productID_1);
        $stmt_details_1 = products_details($productID_1);
        $row_productID_1 = $stmt_productID_1->fetch(PDO::FETCH_ASSOC);
        $row_details_1 = $stmt_details_1->fetch(PDO::FETCH_ASSOC);
        // __________________________________________________
        $stmt_productID_2 = products_productID($productID_2);
        $stmt_details_2 = products_details($productID_2);
        $row_productID_2 = $stmt_productID_2->fetch(PDO::FETCH_ASSOC);
        $row_details_2 = $stmt_details_2->fetch(PDO::FETCH_ASSOC);
        // __________________________________________________
        $stmt_productID_3 = products_productID($productID_3);
        $stmt_details_3 = products_details($productID_3);
        $row_productID_3 = $stmt_productID_3->fetch(PDO::FETCH_ASSOC);
        $row_details_3 = $stmt_details_3->fetch(PDO::FETCH_ASSOC);
        // __________________________________________________
        $stmt_productID_4 = products_productID($productID_4);
        $stmt_details_4 = products_details($productID_4);
        $row_productID_4 = $stmt_productID_4->fetch(PDO::FETCH_ASSOC);
        $row_details_4 = $stmt_details_4->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="container">
            <div class="alert alert-warning fs-4 fw-bold text-center">
                comparision result
            </div>
            <h3 class="text-primary">dimensions</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">weight</th>
                            <td><?php echo $row_details_1['weight'] ?></td>
                            <td><?php echo $row_details_2['weight'] ?></td>
                            <td><?php echo $row_details_3['weight'] ?></td>
                            <td><?php echo $row_details_4['weight'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">Mobile Dimensions</th>
                            <td><?php echo $row_details_1['MobileDimensions'] ?></td>
                            <td><?php echo $row_details_2['MobileDimensions'] ?></td>
                            <td><?php echo $row_details_3['MobileDimensions'] ?></td>
                            <td><?php echo $row_details_4['MobileDimensions'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">Dimensions additions</th>
                            <td><?php echo $row_details_1['Additions_dimensions'] ?></td>
                            <td><?php echo $row_details_2['Additions_dimensions'] ?></td>
                            <td><?php echo $row_details_3['Additions_dimensions'] ?></td>
                            <td><?php echo $row_details_4['Additions_dimensions'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">screen</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">type_screen</th>
                            <td><?php echo $row_details_1['type_screen'] ?></td>
                            <td><?php echo $row_details_2['type_screen'] ?></td>
                            <td><?php echo $row_details_3['type_screen'] ?></td>
                            <td><?php echo $row_details_4['type_screen'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">size</th>
                            <td><?php echo $row_details_1['size'] ?></td>
                            <td><?php echo $row_details_2['size'] ?></td>
                            <td><?php echo $row_details_3['size'] ?></td>
                            <td><?php echo $row_details_4['size'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">density</th>
                            <td><?php echo $row_details_1['density'] ?></td>
                            <td><?php echo $row_details_2['density'] ?></td>
                            <td><?php echo $row_details_3['density'] ?></td>
                            <td><?php echo $row_details_4['density'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">protection</th>
                            <td><?php echo $row_details_1['protection'] ?></td>
                            <td><?php echo $row_details_2['protection'] ?></td>
                            <td><?php echo $row_details_3['protection'] ?></td>
                            <td><?php echo $row_details_4['protection'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">screen additions</th>
                            <td><?php echo $row_details_1['additions_screen'] ?></td>
                            <td><?php echo $row_details_2['additions_screen'] ?></td>
                            <td><?php echo $row_details_3['additions_screen'] ?></td>
                            <td><?php echo $row_details_4['additions_screen'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">phone system and capabilities</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">operating System</th>
                            <td><?php echo $row_details_1['operatingSystem'] ?></td>
                            <td><?php echo $row_details_2['operatingSystem'] ?></td>
                            <td><?php echo $row_details_3['operatingSystem'] ?></td>
                            <td><?php echo $row_details_4['operatingSystem'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">processor Type</th>
                            <td><?php echo $row_details_1['processorType'] ?></td>
                            <td><?php echo $row_details_2['processorType'] ?></td>
                            <td><?php echo $row_details_3['processorType'] ?></td>
                            <td><?php echo $row_details_4['processorType'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">GPU</th>
                            <td><?php echo $row_details_1['GPU'] ?></td>
                            <td><?php echo $row_details_2['GPU'] ?></td>
                            <td><?php echo $row_details_3['GPU'] ?></td>
                            <td><?php echo $row_details_4['GPU'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">sensors</th>
                            <td><?php echo $row_details_1['sensors'] ?></td>
                            <td><?php echo $row_details_2['sensors'] ?></td>
                            <td><?php echo $row_details_3['sensors'] ?></td>
                            <td><?php echo $row_details_4['sensors'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">processor Speed</th>
                            <td><?php echo $row_details_1['processorSpeed'] ?></td>
                            <td><?php echo $row_details_2['processorSpeed'] ?></td>
                            <td><?php echo $row_details_3['processorSpeed'] ?></td>
                            <td><?php echo $row_details_4['processorSpeed'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">battery</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">battery type</th>
                            <td><?php echo $row_details_1['type_battery'] ?></td>
                            <td><?php echo $row_details_2['type_battery'] ?></td>
                            <td><?php echo $row_details_3['type_battery'] ?></td>
                            <td><?php echo $row_details_4['type_battery'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">battery additions</th>
                            <td><?php echo $row_details_1['additions_battery'] ?></td>
                            <td><?php echo $row_details_2['additions_battery'] ?></td>
                            <td><?php echo $row_details_3['additions_battery'] ?></td>
                            <td><?php echo $row_details_4['additions_battery'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">camera</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">primary Camera</th>
                            <td><?php echo $row_details_1['primaryCamera'] ?></td>
                            <td><?php echo $row_details_2['primaryCamera'] ?></td>
                            <td><?php echo $row_details_3['primaryCamera'] ?></td>
                            <td><?php echo $row_details_4['primaryCamera'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">video</th>
                            <td><?php echo $row_details_1['video'] ?></td>
                            <td><?php echo $row_details_2['video'] ?></td>
                            <td><?php echo $row_details_3['video'] ?></td>
                            <td><?php echo $row_details_4['video'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">secondary Camera</th>
                            <td><?php echo $row_details_1['secondaryCamera'] ?></td>
                            <td><?php echo $row_details_2['secondaryCamera'] ?></td>
                            <td><?php echo $row_details_3['secondaryCamera'] ?></td>
                            <td><?php echo $row_details_4['secondaryCamera'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">features</th>
                            <td><?php echo $row_details_1['features'] ?></td>
                            <td><?php echo $row_details_2['features'] ?></td>
                            <td><?php echo $row_details_3['features'] ?></td>
                            <td><?php echo $row_details_4['features'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">network</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">second Generation</th>
                            <td><?php echo $row_details_1['seconGeneration'] ?></td>
                            <td><?php echo $row_details_2['seconGeneration'] ?></td>
                            <td><?php echo $row_details_3['seconGeneration'] ?></td>
                            <td><?php echo $row_details_4['seconGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">third Generation</th>
                            <td><?php echo $row_details_1['thirdGeneration'] ?></td>
                            <td><?php echo $row_details_2['thirdGeneration'] ?></td>
                            <td><?php echo $row_details_3['thirdGeneration'] ?></td>
                            <td><?php echo $row_details_4['thirdGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">fourth Generation</th>
                            <td><?php echo $row_details_1['fourthGeneration'] ?></td>
                            <td><?php echo $row_details_2['fourthGeneration'] ?></td>
                            <td><?php echo $row_details_3['fourthGeneration'] ?></td>
                            <td><?php echo $row_details_4['fourthGeneration'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">simCard</th>
                            <td><?php echo $row_details_1['simCard'] ?></td>
                            <td><?php echo $row_details_2['simCard'] ?></td>
                            <td><?php echo $row_details_3['simCard'] ?></td>
                            <td><?php echo $row_details_4['simCard'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">memory</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">internal Memory</th>
                            <td><?php echo $row_details_1['internalMemory'] ?></td>
                            <td><?php echo $row_details_2['internalMemory'] ?></td>
                            <td><?php echo $row_details_3['internalMemory'] ?></td>
                            <td><?php echo $row_details_4['internalMemory'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">card Slot</th>
                            <td><?php echo $row_details_1['cardSlot'] ?></td>
                            <td><?php echo $row_details_2['cardSlot'] ?></td>
                            <td><?php echo $row_details_3['cardSlot'] ?></td>
                            <td><?php echo $row_details_4['cardSlot'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">data</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">speed</th>
                            <td><?php echo $row_details_1['speed'] ?></td>
                            <td><?php echo $row_details_2['speed'] ?></td>
                            <td><?php echo $row_details_3['speed'] ?></td>
                            <td><?php echo $row_details_4['speed'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">WLAN</th>
                            <td><?php echo $row_details_1['WLAN'] ?></td>
                            <td><?php echo $row_details_2['WLAN'] ?></td>
                            <td><?php echo $row_details_3['WLAN'] ?></td>
                            <td><?php echo $row_details_4['WLAN'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">bluetooth</th>
                            <td><?php echo $row_details_1['bluetooth'] ?></td>
                            <td><?php echo $row_details_2['bluetooth'] ?></td>
                            <td><?php echo $row_details_3['bluetooth'] ?></td>
                            <td><?php echo $row_details_4['bluetooth'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">NFC</th>
                            <td><?php echo $row_details_1['NFC'] ?></td>
                            <td><?php echo $row_details_2['NFC'] ?></td>
                            <td><?php echo $row_details_3['NFC'] ?></td>
                            <td><?php echo $row_details_4['NFC'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">USB</th>
                            <td><?php echo $row_details_1['USB'] ?></td>
                            <td><?php echo $row_details_2['USB'] ?></td>
                            <td><?php echo $row_details_3['USB'] ?></td>
                            <td><?php echo $row_details_4['USB'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">sounds</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">loud Speaker</th>
                            <td><?php echo $row_details_1['loudSpeaker'] ?></td>
                            <td><?php echo $row_details_2['loudSpeaker'] ?></td>
                            <td><?php echo $row_details_3['loudSpeaker'] ?></td>
                            <td><?php echo $row_details_4['loudSpeaker'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">sound additions</th>
                            <td><?php echo $row_details_1['additions_sound'] ?></td>
                            <td><?php echo $row_details_2['additions_sound'] ?></td>
                            <td><?php echo $row_details_3['additions_sound'] ?></td>
                            <td><?php echo $row_details_4['additions_sound'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">productiondate</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">announce</th>
                            <td><?php echo $row_details_1['announce'] ?></td>
                            <td><?php echo $row_details_2['announce'] ?></td>
                            <td><?php echo $row_details_3['announce'] ?></td>
                            <td><?php echo $row_details_4['announce'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">releaseDate</th>
                            <td><?php echo $row_details_1['releaseDate'] ?></td>
                            <td><?php echo $row_details_2['releaseDate'] ?></td>
                            <td><?php echo $row_details_3['releaseDate'] ?></td>
                            <td><?php echo $row_details_4['releaseDate'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="text-primary">morespecifications</h3>
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <th class="col-1">compare</th>
                        <th class="col-3"><?php echo $row_productID_1['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_2['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_3['name'] ?></th>
                        <th class="col-3"><?php echo $row_productID_4['name'] ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="table-warning">radio</th>
                            <td><?php echo $row_details_1['radio'] ?></td>
                            <td><?php echo $row_details_2['radio'] ?></td>
                            <td><?php echo $row_details_3['radio'] ?></td>
                            <td><?php echo $row_details_4['radio'] ?></td>
                        </tr>
                        <tr>
                            <th class="table-warning">GPS</th>
                            <td><?php echo $row_details_1['GPS'] ?></td>
                            <td><?php echo $row_details_2['GPS'] ?></td>
                            <td><?php echo $row_details_3['GPS'] ?></td>
                            <td><?php echo $row_details_4['GPS'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
<?php
    }
}
require "includes/main-templates/footer.html";
ob_end_flush();
