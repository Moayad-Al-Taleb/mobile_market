<?php
// users
function users($accountType, $accountStatus)
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM users WHERE accountType = :accountType AND accountStatus = :accountStatus";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':accountType', $accountType, PDO::PARAM_INT);
        $stmt->bindValue(':accountStatus', $accountStatus, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function users_userID($userID)
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM users WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function users_accountStatus($accountStatus, $userID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE users SET accountStatus = :accountStatus WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':accountStatus', $accountStatus, PDO::PARAM_INT);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
// companies
function companies()
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM companies ORDER BY companyID DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function companies_Insert($companyName, $imgContent)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO companies(companyName,companyLogo) VALUES (:companyName, '$imgContent')";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':companyName', $companyName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function companies_Update($companyID, $companyName, $imgContent)
{
    require 'connect.php';
    try {
        $sql = "UPDATE companies SET companyName = :companyName, companyLogo = '$imgContent' WHERE companyID = :companyID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':companyID', $companyID, PDO::PARAM_INT);
        $stmt->bindValue(':companyName', $companyName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function companies_Update_($companyID, $companyName)
{
    require 'connect.php';
    try {
        $sql = "UPDATE companies SET companyName = :companyName WHERE companyID = :companyID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':companyID', $companyID, PDO::PARAM_INT);
        $stmt->bindValue(':companyName', $companyName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function companies_delete($companyID)
{
    require 'connect.php';
    try {
        $sql = "DELETE FROM companies WHERE companyID = :companyID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':companyID', $companyID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function companies_companyID($companyID)
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM companies WHERE companyID = :companyID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':companyID', $companyID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

//products 
function products($companyID)
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM products WHERE companyID = :companyID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':companyID', $companyID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function products_Insert($name, $price, $companyID, $imgContent)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO products(name, price, companyID, mainPic) VALUES (:name, :price, :companyID, '$imgContent')";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_INT);
        $stmt->bindValue(':companyID', $companyID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function products_details($productID)
{
    require 'connect.php';
    try {
        $sql = "
        SELECT battery.*, camera.*, data.*, dimensions.*, memory.*, morespecifications.*, network.*, phonesystemandcapabilities.*, productiondate.*, screen.*, sound.*
        FROM products INNER JOIN battery
        ON products.productID = battery.productID
        INNER JOIN camera
        ON products.productID = camera.productID
        INNER JOIN data
        ON products.productID = data.productID
        INNER JOIN dimensions
        ON products.productID = dimensions.productID
        INNER JOIN memory
        ON products.productID = memory.productID
        INNER JOIN morespecifications
        ON products.productID = morespecifications.productID
        INNER JOIN network
        ON products.productID = network.productID
        INNER JOIN phonesystemandcapabilities
        ON products.productID = phonesystemandcapabilities.productID
        INNER JOIN productiondate
        ON products.productID = productiondate.productID
        INNER JOIN screen
        ON products.productID = screen.productID
        INNER JOIN sound
        ON products.productID = sound.productID
        WHERE products.productID = :productID
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function products_productID($productID)
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM products WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function products_Edit($name, $price, $imgContent, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE products SET name = :name, price = :price, mainPic = '$imgContent' WHERE productID = :productID ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_INT);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function products_Edit_mainPic($name, $price, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE products SET name = :name, price = :price WHERE productID = :productID ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_INT);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function productpics_productID($productID)
{

    require 'connect.php';
    try {
        $sql = "SELECT * FROM productpics WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function productpics_productPicID($productPicID)
{
    require 'connect.php';
    try {
        $sql = "DELETE FROM productpics WHERE productPicID = :productPicID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productPicID', $productPicID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function productpics($imgContent, $productID)
{

    require 'connect.php';
    try {
        $sql = "INSERT INTO productpics(productPicture, productID) VALUES ('$imgContent', :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function phonesystemandcapabilities($operatingSystem, $processorType, $GPU, $sensors, $processorSpeed, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO phonesystemandcapabilities(operatingSystem, processorType, GPU, sensors, processorSpeed, productID) VALUES (:operatingSystem, :processorType, :GPU, :sensors, :processorSpeed, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':operatingSystem', $operatingSystem, PDO::PARAM_STR);
        $stmt->bindValue(':processorType', $processorType, PDO::PARAM_STR);
        $stmt->bindValue(':GPU', $GPU, PDO::PARAM_STR);
        $stmt->bindValue(':sensors', $sensors, PDO::PARAM_STR);
        $stmt->bindValue(':processorSpeed', $processorSpeed, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function dimensions($weight, $MobileDimensions, $Additions_dimensions, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO dimensions(weight, MobileDimensions, Additions_dimensions, productID) VALUES (:weight, :MobileDimensions, :Additions_dimensions, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':weight', $weight, PDO::PARAM_STR);
        $stmt->bindValue(':MobileDimensions', $MobileDimensions, PDO::PARAM_STR);
        $stmt->bindValue(':Additions_dimensions', $Additions_dimensions, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function sound($loudSpeaker, $additions_sound, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO sound(loudSpeaker, additions_sound, productID) VALUES (:loudSpeaker, :additions_sound, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':loudSpeaker', $loudSpeaker, PDO::PARAM_STR);
        $stmt->bindValue(':additions_sound', $additions_sound, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function screen($type_screen, $size, $density, $protection, $additions_screen, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO screen(type_screen, size, density, protection, additions_screen, productID) VALUES (:type_screen, :size, :density, :protection, :additions_screen ,:productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':type_screen', $type_screen, PDO::PARAM_STR);
        $stmt->bindValue(':size', $size, PDO::PARAM_STR);
        $stmt->bindValue(':density', $density, PDO::PARAM_STR);
        $stmt->bindValue(':protection', $protection, PDO::PARAM_STR);
        $stmt->bindValue(':additions_screen', $additions_screen, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function productiondate($announce, $releaseDate, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO productiondate(announce, releaseDate, productID) VALUES ('$announce', '$releaseDate' ,:productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function data($speed, $WLAN, $bluetooth, $NFC, $USB, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO data(speed, WLAN, bluetooth, NFC, USB, productID) VALUES (:speed, :WLAN, :bluetooth, :NFC, :USB, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':speed', $speed, PDO::PARAM_STR);
        $stmt->bindValue(':WLAN', $WLAN, PDO::PARAM_STR);
        $stmt->bindValue(':bluetooth', $bluetooth, PDO::PARAM_STR);
        $stmt->bindValue(':NFC', $NFC, PDO::PARAM_STR);
        $stmt->bindValue(':USB', $USB, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function battery($type_battery, $additions_battery, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO battery(type_battery, additions_battery, productID) VALUES (:type_battery, :additions_battery, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':type_battery', $type_battery, PDO::PARAM_STR);
        $stmt->bindValue(':additions_battery', $additions_battery, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function morespecifications($radio, $GPS, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO morespecifications(radio, GPS, productID) VALUES (:radio, :GPS, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':radio', $radio, PDO::PARAM_STR);
        $stmt->bindValue(':GPS', $GPS, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function camera($primaryCamera, $video, $secondaryCamera, $features, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO camera(primaryCamera, video, secondaryCamera, features, productID) VALUES (:primaryCamera, :video, :secondaryCamera, :features ,:productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':primaryCamera', $primaryCamera, PDO::PARAM_STR);
        $stmt->bindValue(':video', $video, PDO::PARAM_STR);
        $stmt->bindValue(':secondaryCamera', $secondaryCamera, PDO::PARAM_STR);
        $stmt->bindValue(':features', $features, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function network($seconGeneration, $thirdGeneration, $fourthGeneration, $simCard, $productID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO network(seconGeneration, thirdGeneration, fourthGeneration, simCard, productID) VALUES (:seconGeneration, :thirdGeneration, :fourthGeneration, :simCard ,:productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':seconGeneration', $seconGeneration, PDO::PARAM_STR);
        $stmt->bindValue(':thirdGeneration', $thirdGeneration, PDO::PARAM_STR);
        $stmt->bindValue(':fourthGeneration', $fourthGeneration, PDO::PARAM_STR);
        $stmt->bindValue(':simCard', $simCard, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function memory($internalMemory, $cardSlot, $productID)
{

    require 'connect.php';
    try {
        $sql = "INSERT INTO memory(internalMemory, cardSlot, productID) VALUES (:internalMemory, :cardSlot, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':internalMemory', $internalMemory, PDO::PARAM_STR);
        $stmt->bindValue(':cardSlot', $cardSlot, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function product_condition($product_condition, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE products SET product_condition = :product_condition WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':product_condition', $product_condition, PDO::PARAM_INT);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function productcolors($colorName, $productID)
{

    require 'connect.php';
    try {
        $sql = "INSERT INTO productcolors(colorName, productID) VALUES (:colorName, :productID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':colorName', $colorName, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function productcolors_productID($productID)
{

    require 'connect.php';
    try {
        $sql = "SELECT * FROM productcolors WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function productcolors_colorID($colorID)
{

    require 'connect.php';
    try {
        $sql = "DELETE FROM productcolors WHERE colorID = :colorID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':colorID', $colorID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function bills_userID($userID, $invoice_status)
{
    require 'connect.php';
    try {
        $sql = "SELECT bills.* FROM bills INNER JOIN reservations ON bills.billID = reservations.billID WHERE reservations.userID = :userID AND bills.invoice_status = :invoice_status GROUP BY bills.billID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindValue(':invoice_status', $invoice_status, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function bills_Edit($billID, $invoice_status, $Bill_payment_date)
{
    require 'connect.php';
    try {
        $sql = "UPDATE bills SET bills.invoice_status = :invoice_status, bills.Bill_payment_date = '$Bill_payment_date' WHERE bills.billID = :billID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':invoice_status', $invoice_status, PDO::PARAM_INT);
        $stmt->bindValue(':billID', $billID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function bills_invoice_status($billID)
{
    require 'connect.php';
    try {
        $sql = "SELECT invoice_status FROM bills WHERE billID = :billID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':billID', $billID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['invoice_status'];
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function bills_billID($billID)
{
    require 'connect.php';
    try {
        $sql = "SELECT reservations.*, bills.*, products.name, products.price, companies.companyName, users.fName, users.Sname, users.Lname, productcolors.colorName FROM reservations INNER JOIN bills ON reservations.billID = bills.billID INNER JOIN users ON reservations.userID = users.userID INNER JOIN products ON reservations.productID = products.productID INNER JOIN companies ON products.companyID = companies.companyID INNER JOIN productcolors ON reservations.colorID = productcolors.colorID WHERE reservations.billID = :billID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':billID', $billID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function bills($invoice_status)
{
    require 'connect.php';
    try {
        if ($invoice_status == 1) {
            $sql = "SELECT bills.* FROM bills INNER JOIN reservations ON bills.billID = reservations.billID WHERE bills.invoice_status = :invoice_status GROUP BY bills.billID ORDER BY billDate DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':invoice_status', $invoice_status, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } elseif ($invoice_status == 2) {
            $sql = "SELECT bills.* FROM bills INNER JOIN reservations ON bills.billID = reservations.billID WHERE bills.invoice_status = :invoice_status GROUP BY bills.billID ORDER BY Bill_payment_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':invoice_status', $invoice_status, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function userID($email)
{
    require 'connect.php';
    try {
        $sql = "SELECT userID FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

//edit product details
function phonesystemandcapabilities_edit($operatingSystem, $processorType, $GPU, $sensors, $processorSpeed, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE phonesystemandcapabilities SET operatingSystem = :operatingSystem, processorType = :processorType, GPU = :GPU, sensors = :sensors, processorSpeed = :processorSpeed WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':operatingSystem', $operatingSystem, PDO::PARAM_STR);
        $stmt->bindValue(':processorType', $processorType, PDO::PARAM_STR);
        $stmt->bindValue(':GPU', $GPU, PDO::PARAM_STR);
        $stmt->bindValue(':sensors', $sensors, PDO::PARAM_STR);
        $stmt->bindValue(':processorSpeed', $processorSpeed, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function dimensions_edit($weight, $MobileDimensions, $Additions_dimensions, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE dimensions SET weight = :weight, MobileDimensions = :MobileDimensions, Additions_dimensions = :Additions_dimensions WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':weight', $weight, PDO::PARAM_STR);
        $stmt->bindValue(':MobileDimensions', $MobileDimensions, PDO::PARAM_STR);
        $stmt->bindValue(':Additions_dimensions', $Additions_dimensions, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function sound_edit($loudSpeaker, $additions_sound, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE sound SET loudSpeaker = :loudSpeaker, additions_sound = :additions_sound WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':loudSpeaker', $loudSpeaker, PDO::PARAM_STR);
        $stmt->bindValue(':additions_sound', $additions_sound, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function screen_edit($type_screen, $size, $density, $protection, $additions_screen, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE screen SET type_screen = :type_screen, size = :size, density = :density, protection = :protection, additions_screen = :additions_screen WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':type_screen', $type_screen, PDO::PARAM_STR);
        $stmt->bindValue(':size', $size, PDO::PARAM_STR);
        $stmt->bindValue(':density', $density, PDO::PARAM_STR);
        $stmt->bindValue(':protection', $protection, PDO::PARAM_STR);
        $stmt->bindValue(':additions_screen', $additions_screen, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function productiondate_edit($announce, $releaseDate, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE productiondate SET announce = '$announce', releaseDate = '$releaseDate' WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function data_edit($speed, $WLAN, $bluetooth, $NFC, $USB, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE data SET speed = :speed, WLAN = :WLAN, bluetooth = :bluetooth, NFC = :NFC, USB = :USB WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':speed', $speed, PDO::PARAM_STR);
        $stmt->bindValue(':WLAN', $WLAN, PDO::PARAM_STR);
        $stmt->bindValue(':bluetooth', $bluetooth, PDO::PARAM_STR);
        $stmt->bindValue(':NFC', $NFC, PDO::PARAM_STR);
        $stmt->bindValue(':USB', $USB, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function battery_edit($type_battery, $additions_battery, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE battery SET type_battery = :type_battery, additions_battery = :additions_battery WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':type_battery', $type_battery, PDO::PARAM_STR);
        $stmt->bindValue(':additions_battery', $additions_battery, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function morespecifications_edit($radio, $GPS, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE morespecifications SET radio = :radio, GPS = :GPS WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':radio', $radio, PDO::PARAM_STR);
        $stmt->bindValue(':GPS', $GPS, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function camera_edit($primaryCamera, $video, $secondaryCamera, $features, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE camera SET primaryCamera = :primaryCamera, video = :video, secondaryCamera = :secondaryCamera, features = :features WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':primaryCamera', $primaryCamera, PDO::PARAM_STR);
        $stmt->bindValue(':video', $video, PDO::PARAM_STR);
        $stmt->bindValue(':secondaryCamera', $secondaryCamera, PDO::PARAM_STR);
        $stmt->bindValue(':features', $features, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function network_edit($seconGeneration, $thirdGeneration, $fourthGeneration, $simCard, $productID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE network SET seconGeneration = :seconGeneration, thirdGeneration = :thirdGeneration , fourthGeneration = :fourthGeneration, simCard = :simCard WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':seconGeneration', $seconGeneration, PDO::PARAM_STR);
        $stmt->bindValue(':thirdGeneration', $thirdGeneration, PDO::PARAM_STR);
        $stmt->bindValue(':fourthGeneration', $fourthGeneration, PDO::PARAM_STR);
        $stmt->bindValue(':simCard', $simCard, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function memory_edit($internalMemory, $cardSlot, $productID)
{

    require 'connect.php';
    try {
        $sql = "UPDATE memory SET internalMemory = :internalMemory, cardSlot = :cardSlot WHERE productID = :productID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':internalMemory', $internalMemory, PDO::PARAM_STR);
        $stmt->bindValue(':cardSlot', $cardSlot, PDO::PARAM_STR);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}