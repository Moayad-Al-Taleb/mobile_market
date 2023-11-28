<?php
session_start();
ob_start();
require "includes/main-templates/header.html";
?>
<link rel="stylesheet" href="design/css/forms.css">
</head>

<body>
    <div class="container">
        <div class="form-con login-form">
            <h2>sign up</h2>
            <p>create new account</p>
            <form action="" method="POST" class="form" autocomplete="off">
                <div class="input-field">
                    <input class="input" name="fName" type="text" placeholder="first name" autocomplete="off">
                </div>
                <div class="input-field">
                    <input class="input" name="sName" type="text" placeholder="middle name" autocomplete="off">
                </div>
                <div class="input-field">
                    <input class="input" name="lName" type="text" placeholder="last name" autocomplete="off">
                </div>
                <div class="input-field">
                    <input class="input" name="uName" type="text" placeholder="user name for website" autocomplete="off">
                </div>
                <div class="input-field">
                    <i class="fas fa-at"></i>
                    <input class="login-input" name="email" type="text" placeholder="email" autocomplete="off">
                </div>
                <div class="input-field">
                    <input class="input" name="address" type="text" placeholder="type your address" autocomplete="off">
                </div>
                <div class="input-field">
                    <i class="fas fa-key"></i>
                    <input class="login-input" name="pass" type="password" placeholder="password" autocomplete="new-password">
                </div>
                <input type="submit" name="BTN-SINUP" class="submitBtn" value="sign up">
            </form>
        </div>
        <span class="flowed-text-create">already have an account? <a href="index.php">login</a> </span>
    </div>


    <?php require "includes/main-templates/footer.html";

    if (isset($_POST['BTN-SINUP'])) {
        $fName = $_POST['fName'];
        $Sname = $_POST['sName'];
        $Lname = $_POST['lName'];
        $uName = $_POST['uName'];
        $email = $_POST['email'];
        $pass = sha1($_POST['pass']);
        $address = $_POST['address'];
        if (
            empty($fName)
            || empty($Sname)
            || empty($Lname)
            || empty($uName)
            || empty($email)
            || empty($pass)
            || empty($address)
        ) {
            echo '
        <div class="overlay"></div>
        <div class="error-message">
            all feilds are required
        </div>
        ';
            header('REFRESH:1;URL=register.php');
        } else {
            $rowCount = check_email($email);
            if ($rowCount > 0) {
                echo '
            <div class="overlay"></div>
            <div class="error-message">
                invalid email or password
            </div>
            ';
                header('REFRESH:1;URL=register.php');
            } else {
                SINUP($fName, $Sname, $Lname, $uName, $email, $pass, $address);
            }
        }
    }

    function check_email($email)
    {
        require 'connect.php';
        try {
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error :: " . $e->getMessage();
        }
    }

    function SINUP($fName, $Sname, $Lname, $uName, $email, $pass, $address)
    {
        require 'connect.php';
        try {
            $sql = "INSERT INTO users (fName, Sname, Lname,uName, email, pass, address) VALUES (:fName, :Sname, :Lname, :uName, :email, :pass, :address)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':fName', $fName, PDO::PARAM_STR);
            $stmt->bindValue(':Sname', $Sname, PDO::PARAM_STR);
            $stmt->bindValue(':Lname', $Lname, PDO::PARAM_STR);
            $stmt->bindValue(':uName', $uName, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindValue(':address', $address, PDO::PARAM_STR);
            $stmt->execute();
            $userID = $conn->lastInsertId('users');
            $sql = "SELECT * FROM users WHERE userID=$userID";
            $stmt = $conn->query($sql);
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            $_SESSION['userID'] = $row->userID;
            $_SESSION['fName'] = $row->fName;
            $_SESSION['Sname'] = $row->Sname;
            $_SESSION['Lname'] = $row->Lname;
            $_SESSION['uName'] = $row->uName;
            $_SESSION['email'] = $row->email;
            $_SESSION['pass'] = $row->pass;
            $_SESSION['address'] = $row->address;
            $_SESSION['accountType'] = $row->accountType;
            $_SESSION['accountStatus'] = $row->accountStatus;
            header('REFRESH:0;URL=check_accountType.php');
        } catch (PDOException $e) {
            echo "Error :: " . $e->getMessage();
        }
    }
    ob_end_flush();
