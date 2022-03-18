<?php
setcookie("userlogged", null);
session_destroy();
header("Location: http://localhost:8000/index.php", true, 302);
?>