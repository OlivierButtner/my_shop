<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAIR'Y/admin</title>
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
        <form action="admin.php" method="post" class="search">
            <label for="search_product"></label>
            <input type="text" id="search_product" placeholder="ex:kamoulox">
        </form>
    </div>
    <div class="cart"><a href="cart"><img src="ressources/images/Cart_Button_white.png" alt="cart_picture"></a></div>

    <?php
    if (!isset($_SESSION['user']) || !isset($_COOKIE['userlogged'])) {
        echo '<div class="sign-in"><a href="sign-in.php" class="link">SIGN-IN</a></div>';
    } else {
        echo '<div class="logout"><a href="deletecookie.php" id="logout" class="link">LOGOUT</a></div>';
    }
    ?>
</header class=admin_page>
<div class="entire_page_admin">
<div class="plain_page_admin">
    <div class="product_row">
        <div class="creating_product">Register your furniture</div>
        <div class="new_product">
            <form action="admin.php" class="empty-form" method="post">
                <div>
                    <label for="product_url"></label>
                    <input type="text" id="product_url" name="product_url" placeholder="ressources/pictures/name.png"
                           required>
                </div>
                <div>
                    <label for="product_name"></label>
                    <input type="text" id="product_name" name="product_name" placeholder="name" required>
                </div>
                <div>
                    <label for="product_price"></label>
                    <input type="text" id="product_price" name="product_price" placeholder="price" required>
                </div>
                <div>
                    <label for="product_desc"></label>
                    <input type="text" id="product_desc" name="product_desc" placeholder="description" required>
                </div>
                <div>
                    <label for="product_category"></label>
                    <input type="number" id="product_category" name="product_category"
                           placeholder="category" required>
                </div>
                <div>
                    <button type="submit" name="product_send">Create your product</button>
                </div>
            </form>
        </div>
            <?php
            define("ERROR_LOG_FILE", "./error_log_file");
            if (isset($_POST["product_send"])) {

                $productName = $_POST['product_name'];
                $productPrice = $_POST['product_price'];
                $productDesc = $_POST['product_desc'];
                $productUrl = $_POST['product_url'];
                $productCategory = $_POST['product_category'];

                try {
                    $connexion_sendProduct = new PDO('mysql:host:localhost; my_shop.sql', "xavier", "xavier");

                    $envoi = $connexion_sendProduct->prepare('INSERT INTO my_shop.products (name, price, description, image_url, category_id) VALUES(:product_name, :product_price, :product_desc, :product_url, :product_category)');
                    $envoi->bindParam(':product_name', $productName, PDO::PARAM_STR);
                    $envoi->bindParam(':product_price', $productPrice, PDO::PARAM_INT);
                    $envoi->bindParam(':product_desc', $productDesc, PDO::PARAM_STR);
                    $envoi->bindParam(':product_url', $productUrl, PDO::PARAM_STR);
                    $envoi->bindParam(':product_category', $productCategory, PDO::PARAM_INT);
                    $envoi->execute();
                    echo 'Produit enregistré !';

                } catch (Exception $e) {
                    error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
                }
            }
            ?>
        </div>
        <div class="edit-product">
            <form action="" class="empty-form" method="post">
                <div>
                    <label for="product_id_edit"></label>
                    <input type="number" id="product_id_edit" name="product_id_edit" placeholder="id"
                           required>
                </div>
                <div>
                    <label for="product_image_url_edit"></label>
                    <input type="text" id="product_image_url_edit" name="product_image_url_edit" placeholder="product image url"
                           required>
                </div>
                <div>
                    <label for="product_name_edit"></label>
                    <input type="text" id="product_name_edit" name="product_name_edit" placeholder="product name"
                           required>
                </div>
                <div>
                    <label for="product_price_edit"></label>
                    <input type="text" id="product_price_edit" name="product_price_edit" placeholder="product price"
                           required>
                </div>
                <div>
                    <label for="product_desc_edit"></label>
                    <input type="text" id="product_desc_edit" name="product_desc_edit" placeholder="product description"
                           required>
                </div>
                <div>
                    <label for="product_category_edit"></label>
                    <input type="number" id="product_category_edit" name="product_category_edit"
                           placeholder="product category" required>
                </div>
                <div>
                    <button type="submit" name="product_edited">Edit product</button>
                </div>
            </form>
            <?php
            $productId_edit = $_POST['product_id_edit'];
            $productImage_url_edit = $_POST['product_image_url_edit'];
            $productName_edit = $_POST['product_name_edit'];
            $productPrice_edit = $_POST['product_price_edit'];
            $productDesc_edit = $_POST['product_desc_edit'];
            $productCategory_edit = $_POST['product_category_edit'];


            if (isset($_POST["product_edited"]) && !empty($_POST['product_id_edit'])) {
                // TODO comment appliquer la vérif que ça se termine par .jepg
                if (!$productImage_url_edit) {
                    echo "Invalid product image url";
                }
                if (!$productName_edit || !is_string($productName_edit) || strlen($productName_edit) > 50) {
                    echo "Invalid product name";
                }
                if (!$productPrice_edit) {
                    echo "Invalid product price";
                }
                if (strlen($productDesc_edit) > 500) {
                    echo "Invalid product description";
                }
                if (!$productCategory_edit) {
                    echo "Invalid product category";
                } else
                    try {
                        $connexion_editProduct = new PDO('mysql:host:localhost; my_shop.sql', "xavier", "xavier");
                        $envoi_product_edit = $connexion_editProduct->prepare("UPDATE my_shop.products SET name= :product_name, price=:product_price, description=:product_description, category_id=:product_category_id, image_url=:product_image_url WHERE id=:product_id");
                        $envoi_product_edit->bindParam(':product_id', $productId_edit, PDO::PARAM_INT);
                        $envoi_product_edit->bindParam(':product_name', $productName_edit, PDO::PARAM_STR);
                        $envoi_product_edit->bindParam(':product_price', $productPrice_edit, PDO::PARAM_INT);
                        $envoi_product_edit->bindParam(':product_description', $productDesc_edit, PDO::PARAM_STR);
                        $envoi_product_edit->bindParam(':product_category_id', $productCategory_edit, PDO::PARAM_INT);
                        $envoi_product_edit->bindParam(':product_image_url', $productImage_url_edit, PDO::PARAM_STR);
                        $envoi_product_edit->execute();
                        $count_product_edit = $envoi_product_edit->rowCount();
                        if ($count_product_edit > 0) {
                            echo "Product edited";
                        } else
                            echo 'Invalid product id';
                    } catch (Exception $e) {
                        error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
                    }
            }
            ?>
        </div>
        <div class="display_product">
            <?php
            try {
                $connexion_displayProduct = new PDO('mysql:host:localhost; my_shop.sql', "xavier", "xavier");
                $envoi_D_product = $connexion_displayProduct->prepare('SELECT id,name FROM my_shop.products');
                $envoi_D_product->execute();
                $resProduct = $envoi_D_product->fetchAll(PDO::FETCH_ASSOC);
                $outputProduct = '<table>';
                foreach ($resProduct as $keyProduct => $varProduct) {
                    $outputProduct .= '<tr>';
                    foreach ($varProduct as $kProduct => $vProduct) {
                        if ($keyProduct === 0) {
                            $outputProduct .= '<td><strong>' . $kProduct . '</strong></td>';
                        } else {
                            $outputProduct .= '<td>' . $vProduct . '</td>';
                        }
                    }
                    $outputProduct .= '</tr>';
                }
                $outputProduct .= '</table>';
                echo $outputProduct;
            } catch (Exception $e) {
                error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
            }
            //        }
            ?>
        </div>
    </div>
    <div class="delete_product">
        <form action="" class="empty-form" method="post">
            <div>
                <label for="delete_product_id"></label>
                <input type="number" id="delete_product_id" name="delete_product_id"
                       placeholder="product id" required>
            </div>
            <div>
                <button type="submit" name="product_deleted">Delete product</button>
            </div>
        </form>
        <?php
        if (isset($_POST["product_deleted"]) && !empty($_POST['delete_product_id'])) {
            $productId_delete = $_POST['delete_product_id'];

            try {

                $connexion_deleteProduct = new PDO('mysql:host:localhost; my_shop.sql', "xavier", "xavier");
                $envoi_product_delete = $connexion_deleteProduct->prepare("DELETE FROM my_shop.products WHERE id=:delete_product_id");
                $envoi_product_delete->bindParam(':delete_product_id', $productId_delete, PDO::PARAM_INT);
                $envoi_product_delete->execute();
                $count_product_delete = $envoi_product_delete->rowCount();
                if ($count_product_delete > 0) {
                    echo "Product deleted";
                } else
                    echo 'Invalid product id';
            } catch (Exception $e) {
                error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
            }
        }
        ?>
    </div>
    <div class="edit-user">

        <form action="" class="empty-form" method="post">
            <div>
                <label for="user_id"></label>
                <input type="number" id="user_id" name="user_id" placeholder="id"
                       required>
            </div>
            <div>
                <label for="user_name"></label>
                <input type="text" id="user_name" name="user_name" placeholder="username"
                       required>
            </div>
            <div>
                <label for="user_password"></label>
                <input type="text" id="user_password" name="user_password" placeholder="password" required>
            </div>
            <div>
                <label for="user_email"></label>
                <input type="text" id="user_email" name="user_email" placeholder="email" required>
            </div>
            <div>
                <label for="user_admin"></label>
                <input type="number" min="0" max="1" id="user_admin" name="user_admin"
                       placeholder="admin" required>
            </div>
            <div>
                <button type="submit" name="user_edited">Edit user</button>
            </div>
        </form>
        <?php
        $userId = $_POST['user_id'];
        $userName = $_POST['user_name'];
        $userPassword = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
        $userEmail = $_POST['user_email'];
        $userAdmin = $_POST['user_admin'];


        if (isset($_POST["user_edited"]) && !empty($_POST['user_id'])) {
            if (!$userName || !is_string($userName) || strlen($userName) > 20) {
                echo "Invalid name";
            }
            if (!$userEmail || !preg_match("/^([a-z0-9+_\-]+)(\.[a-z0-9+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $userEmail)) {
                echo "Invalid email";
            }
            if (strlen($userPassword) < 3 || strlen($userPassword) > 100) {
                echo "Invalid password";
            } else
                try {
                    $connexion_editUser = new PDO('mysql:host:localhost; my_shop.sql', "olivier", "olivier");
                    $envoi_user_edit = $connexion_editUser->prepare("UPDATE my_shop.users SET username= :user_name, password=:user_password, email=:user_email, admin=:user_admin WHERE id=:user_id");
                    $envoi_user_edit->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $envoi_user_edit->bindParam(':user_name', $userName, PDO::PARAM_STR);
                    $envoi_user_edit->bindParam(':user_password', $userPassword, PDO::PARAM_STR);
                    $envoi_user_edit->bindParam(':user_email', $userEmail, PDO::PARAM_STR);
                    $envoi_user_edit->bindParam(':user_admin', $userAdmin, PDO::PARAM_INT);
                    $envoi_user_edit->execute();
                    $count = $envoi_user_edit->rowCount();
                    if ($count > 0) {
                        echo "User edited";
                    } else
                        echo 'Invalid id';
                } catch (Exception $e) {
                    error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
                }
        }
        ?>
    </div>
    <div class="user_display">
        <?php
        try {
            $connexion_displayUser = new PDO('mysql:host:localhost; my_shop.sql', "olivier", "olivier");
            $envoi_D_user = $connexion_displayUser->prepare('SELECT * FROM my_shop.users');
            $envoi_D_user->execute();
            $res = $envoi_D_user->fetchAll(PDO::FETCH_ASSOC);

            $output = '<table>';
            foreach ($res as $key => $var) {
                $output .= '<tr>';
                foreach ($var as $k => $v) {
                    if ($key === 0) {
                        $output .= '<td><strong>' . $k . '</strong></td>';
                    } else {
                        $output .= '<td>' . $v . '</td>';
                    }
                }
                $output .= '</tr>';
            }
            $output .= '</table>';
            echo $output;
        } catch (Exception $e) {
            error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
        }
        ?>
    </div>
</div>

    <div class="delete_user">
        <form action="" class="empty-form" method="post">
            <div>
                <label for="delete_id"></label>
                <input type="number" id="delete_id" name="delete_id"
                       placeholder="id" required>
            </div>
            <div>
                <button type="submit" name="user_deleted">Delete user</button>
            </div>
        </form>
        <?php
        if (isset($_POST["user_deleted"]) && !empty($_POST['delete_id'])) {
            $userId = $_POST['delete_id'];

            try {
                $connexion_deleteUser = new PDO('mysql:host:localhost; my_shop.sql', "olivier", "olivier");
                $envoi_user_delete = $connexion_deleteUser->prepare("DELETE FROM my_shop.users WHERE id=:delete_id");
                $envoi_user_delete->bindParam(':delete_id', $userId, PDO::PARAM_INT);
                $envoi_user_delete->execute();
                $count = $envoi_user_delete->rowCount();
                if ($count > 0) {
                    echo "User deleted";
                } else
                    echo 'Invalid id';
            } catch (Exception $e) {
                error_log("PDO ERROR: " . $e->getMessage() . " storage in " . ERROR_LOG_FILE . "\n", 3, ERROR_LOG_FILE);
            }
        }
        ?>
    </div>
</div>

<footer>

</footer>
</body>
</html>

