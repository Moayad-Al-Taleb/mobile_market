<?php
// users
function companies()
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM companies";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

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

function products_companyID($companyID)
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM products WHERE companyID = :companyID LIMIT 6";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':companyID', $companyID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function All_phones()
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function products_name($name)
{

    require 'connect.php';
    try {
        $sql = "SELECT * FROM products WHERE products.name LIKE '%$name%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function products_price($Min_value, $Max_value)
{

    require 'connect.php';
    try {
        $sql = "SELECT * FROM products WHERE products.price BETWEEN '$Min_value' AND '$Max_value'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
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

function reservations($userID, $productID, $productCount, $colorID)
{

    require 'connect.php';
    try {
        $sql = "INSERT reservations(userID, productID, productCount, colorID) VALUES (:userID, :productID, :productCount, :colorID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindValue(':productCount', $productCount, PDO::PARAM_INT);
        $stmt->bindValue(':colorID', $colorID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function reservations_userID($userID)
{

    require 'connect.php';
    try {
        $sql = "SELECT reservations.*, products.name, products.price, companies.companyName, users.fName, users.Sname, users.Lname, productcolors.colorName FROM reservations INNER JOIN users ON reservations.userID = users.userID INNER JOIN products ON reservations.productID = products.productID INNER JOIN companies ON products.companyID = companies.companyID INNER JOIN productcolors ON reservations.colorID = productcolors.colorID WHERE reservations.userID = :userID AND reservations.billID IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function reservations_Cancel($reserveID)
{

    require 'connect.php';
    try {
        $sql = "DELETE FROM reservations WHERE reservations.reserveID = :reserveID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':reserveID', $reserveID, PDO::PARAM_INT);
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
function bills()
{

    require 'connect.php';
    try {
        $sql = "INSERT INTO bills () VALUES()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $billID = $conn->lastInsertId('bills');
        return $billID;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function reservations_billID($userID, $billID)
{

    require 'connect.php';
    try {
        $sql = "UPDATE reservations SET billID = :billID WHERE userID = :userID AND billID IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
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
