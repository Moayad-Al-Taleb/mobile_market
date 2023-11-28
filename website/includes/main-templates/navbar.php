<link rel="stylesheet" href="design/css/navbar.css">
</head>

<body>
    <nav class="main-nav">
        <div class="logo">
            <i class="fas fa-mobile"></i>
            <span>starMobile</span>
        </div>
        <ul class="list">
            <a href="companies.php" class="navbar-link" data-name="admins">
                <li class="navbar-item">
                    <span>companies</span>
                </li>
            </a>
            <a href="products.php" class="navbar-link" data-name="comments">
                <li class="navbar-item">
                    <span>products</span>
                </li>
            </a>
            <a href="compare.php" class="navbar-link" data-name="comments">
                <li class="navbar-item">
                    <span>compare devices</span>
                </li>
            </a>
            <?php
            if (!empty($_SESSION['userID'])) {
            ?>
                <a href="bills.php" class="navbar-link" data-name="home">
                    <li class="navbar-item">
                        <span> my bills</span>
                    </li>
                </a>
            <?php
            }
            ?>
        </ul>
        <div class="controls">
            <?php
            if (!empty($_SESSION['userID'])) {
            ?>
                <a href="cart.php" class="cart">
                    <span>my cart</span>
                    <i class="fas fa-shopping-cart cart-icon"></i>
                </a>
                <a href="logout.php"> <i class="fas fa-sign-out-alt"></i></a>
            <?php
            } else {
            ?>
                <a href="../admins/index.php" class="cart">
                    <span>login | register</span>
                </a>
            <?php
            }
            ?>
            <i id="bars" class="fas fa-bars"></i>
        </div>
    </nav>