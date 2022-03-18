<?php
define("ERROR_LOG_FILE", "./error_log_file");
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST["email"];

if (isset($_POST["login"])) {
    if (!$email || !preg_match("/^([a-z0-9+_\-]+)(\.[a-z0-9+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
        echo "Invalid email";
    }
    if (strlen($password) < 3 || strlen($password) > 100) {
        echo "Invalid password";
    } else {
        try {
            $db_my_shop = new PDO("mysql:host=localhost;dbname=my_shop", 'xavier', 'xavier');
            $stmt = $db_my_shop->prepare("SELECT COUNT(*) AS count FROM my_shop.users WHERE email=?");
            $stmt->execute(array($email));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $email_count = $row["count"];
            }
            if ($email_count == 0) {
//                header("URL=http://localhost:8000/sing-in.php", false, 302);
                echo "There is no user whith that email address\n";
            }

            $stmt = $db_my_shop->prepare("SELECT password FROM my_shop.users WHERE email = '$email'");
            $stmt->execute();
            $rep = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_db = $rep["password"];

            if (password_verify($password, $password_db) == false) {
                echo "Wrong password\n";

            } else if ($email_count == 1) {
                session_start();
                ini_set('session.cookie_httponly', 1);
                ini_set('session.use_only_cookies', 1);
                ini_set('session.cookie_secure', 1);
                if (!isset($_SESSION["user"])) {
                    $_SESSION["user"] = $email;
                } else
                    $_SESSION["count"]++;


                if (isset($_REQUEST["remember"]) && $_REQUEST["remember"] == 1) {
                    setcookie("userlogged", $email);
                } else {
                    setcookie("userlogged", $email, time() + 3600);
                }

                $stmt = $db_my_shop->prepare("SELECT admin FROM my_shop.users WHERE email = '$email'");
                $stmt->execute();
                $rep = $stmt->fetch(PDO::FETCH_ASSOC);
                $admin_check = $rep["admin"];
                echo $admin_check;

                if ($admin_check == 1)
                    header("Location: http://localhost:8000/admin.php", true, 302);
                else
                    header("Location: http://localhost:8000/index.php", true, 302);
            }
        } catch
        (PDOException $e) {
            error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
            exit();
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAIR'Y sign-in</title>
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
    <div class="cart"><a href="cart.php"><img src="ressources/images/Cart_Button_white.png" alt="cart_picture"></a>
    </div>
    <div class="sign-in"><a href="sign-in.php" class="link">SIGN-IN</a></div>
</header>
<div class="entire_page">

    <section class="login-page">
        <h1>Login page</h1>


        <form action="sign-in.php" method="post" class="form-sign-in">
            <fieldset>
                <label>Your email : <input type="email" name="email" placeholder="email" required/></label><br><br>
                <label>Your password : <input type="password" name="password" placeholder="Password"
                                              required/></label><br><br>
                <label>Keep me login :<input type="checkbox" value="1" name="remember"></label><br><br>
                <p><input type="submit" name="login" value="Login"></p><br>
                <label><a href="sign-up.php">If you are not yet registered</a></label>
            </fieldset>
        </form>
    </section>
</body>
</html>