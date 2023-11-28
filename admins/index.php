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
            <h2>sign in</h2>
            <p>login to manage your account</p>
            <form action="" method="POST" class="form " autocomplete="off">
                <div class="input-field">
                    <i class="fas fa-at"></i>
                    <input class="login-input" name="email" type="text" placeholder="email" autocomplete="off">
                </div>
                <div class="input-field">
                    <i class="fas fa-key"></i>
                    <input class="login-input" name="pass" type="password" placeholder="password" autocomplete="new-password">
                </div>
                <input type="submit" name="BTN-LOGIN" class="submitBtn" value="login">
            </form>
        </div>
        <span class="flowed-text">don't have an account <a href="register.php">register!</a> </span>
    </div>
    <?php require "includes/main-templates/footer.html";

    if (isset($_POST['BTN-LOGIN'])) {
        $email = $_POST['email'];
        $pass = sha1($_POST['pass']);
        if (
            empty($email)
            || empty($pass)
        ) {
            echo '
            <div class="overlay"></div>
            <div class="error-message">
                all feilds are required
            </div>
        ';
            header('REFRESH:1;URL=index.php');
        } else {
            LOGIN($email, $pass);
        }
    }

    function LOGIN($email, $pass)
    {
        require 'connect.php';

        try {
            $sql = "SELECT * FROM users WHERE email=:email AND pass=:pass";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
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
            } else {
                echo '
            <div class="overlay"></div>
            <div class="error-message">
                invalid email or password
            </div>
            ';
                header('REFRESH:1;URL=index.php');
            }
        } catch (PDOException $e) {
            echo "Error :: " . $e->getMessage();
        }
    }
    ob_end_flush();
    ?>