<?php session_start() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAIR'Y/contact</title>
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

        <div class="contact_us">
            <h1 class="contact_title">Contact us</h1>
            <p class="contact_message">A question ? A remark ? A opinion ? You can tell us as you want and we will get
                back tou you as soon as possible.</p>
            <form action="/page-traitement-donnees" method="post" class="contact">
                <div>
                    <label for="name">Your name</label>
                    <input type="text" id="name" name="name" placeholder="you" required>
                </div>
                <div>
                    <label for="email">Your e-mail</label>
                    <input type="email" id="email" name="email" placeholder="my_email@mail.com" required>
                </div>
                <div>
                    <label for="subject">What do you want to talk about ?</label>
                    <select name="subject" id="subject" required>
                        <option value="" disabled selected hidden>Choose the subject</option>
                        <option value="probleme-compte">A problem with your account</option>
                        <option value="question-produit">A question about a product</option>
                        <option value="suivi-commande">Commande order</option>
                        <option value="autre">Other...</option>
                    </select>
                </div>
                <div>
                    <label for="message">Your message</label>
                    <textarea id="message" name="message"
                              placeholder="Hi. I just want to say that Alexandra and Vincent are wonderful"
                              required></textarea>
                </div>
                <div>
                    <button type="submit" name="send_button">Send my message</button>
                    <?php
                    if ($_POST("send_button")) {
                        header("Refresh: 5; url:http://localhost:8000/index.php");
                        exit();
                    }
                    ?>
                </div>
            </form>
        </div>

    </section>

</div>

<footer>

</footer>
</body>
</html>





