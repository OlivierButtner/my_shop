<?php session_start() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAIR'Y/products</title>
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
    <div class="cart"><a href="cart"><img src="ressources/images/Cart_Button_white.png" alt="cart_picture"</a></div>
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
        <h1>FIND YOUR CHAIR</h1>


        <!--     <div class="left-menu">
                 <form action="select.htm">
                     <p>
                         <select name="category" size="4" multiple>
                             <option>Chair</option>
                             <option>Armchair</option>
                             <option>Stool</option>
                             <option>Pouf</option>

                         </select>
                     </p>
                 </form>
             </div>  -->
        <div class='show_product'>
        <?php

        try {
            $co_displayProduct = new PDO('mysql:host:localhost; my_shop.sql', "xavier", "xavier");
     //       echo "connected";

            $reception_displayProduct = $co_displayProduct->prepare('SELECT * FROM my_shop.products');

            $reception_displayProduct->execute();

            $reception_allDisplayProduct = $reception_displayProduct->fetchAll();
        //    var_dump($reception_allDisplayProduct);
         //   echo "!\n";
        //    var_dump($reception_displayProduct);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


foreach ($reception_allDisplayProduct as $value){
   // echo "<div>" . $value[1] . "</div>"; // nom
  //  echo "<div>" . $value[2] . "</div>"; // prix
  //  echo "<div>" . $value[3] . "</div>"; // catégorie
  //  echo "<div>" . $value[4] . "</div>"; // url image
  //  echo "<div>" . $value[5] . "</div>";  // description

echo "
            <div class='product_box'>
                <div class='box_image'><img src=" . $value[4] . "></div>
                <div class='box_name'>" . $value[1] . "</div>
                <div class='box_price'>$ " . $value[2] . "</div>
                <div class='box_desc'>" . $value[5] . "</div>
                <div class='image_cart'><img src='ressources/images/cart.jpg'></div>
            </div>
      ";
}
        ?>
        </div>
    </section>

</div>

<footer>

</footer>
</body>
</html>