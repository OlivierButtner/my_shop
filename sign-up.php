<?php
define("ERROR_LOG_FILE", "./error_log_file");
$username = $_POST['username'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);
$password_confirmation = $_POST['password_confirmation'];
$email = $_POST["email"];

if (isset($_POST["register"])) {
    if (!$username || !is_string($username) || strlen($username) > 20) {
        echo "Invalid name";
    }
    if (!$email || !preg_match("/^([a-z0-9+_\-]+)(\.[a-z0-9+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
        echo "Invalid email";
    }
    if (password_verify($password_confirmation, $hash) == false || strlen($password) < 3 || strlen($password) > 100) {
        echo "Invalid password or password confirmation";
    } else {
        try {
            $db_my_shop = new PDO("mysql:host=localhost;dbname=my_shop", 'xavier', 'xavier');

            $stmt = $db_my_shop->prepare("SELECT COUNT(*) AS count FROM my_shop.users WHERE username=?");
            $stmt->execute(array($username));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $username_count = $row["count"];
            }
            if ($username_count == 1) {
                echo "That username is already taken" . PHP_EOL;
            }

            $stmt = $db_my_shop->prepare("SELECT COUNT(*) AS count FROM my_shop.users WHERE email=?");
            $stmt->execute(array($email));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $email_count = $row["count"];
            }
            if ($email_count == 1) {
                echo "That email address is already in use\n"; // TODO réussir à appliquer un retour à la ligne
            }

            if ($username_count == 0 && $email_count == 0) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $db_my_shop->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $db_my_shop->prepare("INSERT INTO my_shop.users (username, password, email) VALUES (:username, :password, :email)");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
                echo "User created";
                header("Refresh: 5;URL=http://localhost:8000/sign-in.php", true, 302);
            }
        } catch (PDOException $e) {
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
    <title>CHAIR'Y sign-up</title>
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

    <section class="sign-up">
        <h1>Register page</h1>

<form action="sign-up.php" method="post">
    <fieldset>
        <label>Your username : <input type="text" name="username" placeholder="Username" required/></label><br><br>
        <label>Your email : <input type="email" name="email" placeholder="Email" required/></label><br><br>
        <label>Your password : <input type="password" name="password" placeholder="Password" required/></label><br><br>
        <label>Your password confirmation : <input type="password" name="password_confirmation" placeholder="Password"
                                                   required/></label><br><br>
        <p><input type="submit" name="register" value="Register"></p><br>
    </fieldset>
</form>
</body>
</html>