<?php
session_start()
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAIR'Y</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<header class="header_bar">
    <a href="index.php"><img src="ressources/images/logo_225*225_white.png" alt="logo" class="logo"></a>
    <ul class="links_on_top">
        <li><a href="products.php" title="products" class="link">PRODUCTS</a></li>
        <li><a href="history.php" title="history" class="link">OUR HISTORY</a></li>
        <li><a href="contact.php" title="contact" class="link">CONTACT</a></li>

    </ul>
    <div class="search_bar">
        <form action="" method="post" class="search">
            <label for="search_product"></label>
            <input type="text" id="search_product" placeholder="ex:kamoulox">
        </form>
    </div>
    <div class="cart"><a href="cart.php"><img src="ressources/images/Cart_Button_white.png" alt="cart_picture"></a></div>
    <?php
    if (!isset($_SESSION['user']) || !isset($_COOKIE['userlogged'])) {
        echo '<div class="sign-in"><a href="sign-in.php" class="link">SIGN-IN</a></div>';
    } else {
        echo '<div class="logout"><a href="deletecookie.php" id="logout" class="link">LOGOUT</a></div>';
    }
    ?>
</header>
<div class="entire_page">


    <section class="plain_page">
        <h1>WELCOME to CHAIR'Y !</h1>
        <div class="index_picture">
            <img src="ressources/images/image_index.jpg" alt="armchair" class="picture">
        </div>

    </section>

</div>

<footer>

</footer>
</body>
</html>


