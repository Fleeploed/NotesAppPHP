<?php
require_once("db.php");
session_start();
$error = "Chybně zadané heslo nebo login!";
if (isset($_POST['prihlasit'])) {
    $login = trim($_POST['login']);
    $heslo = trim($_POST['heslo']);
    $res = mysqli_query($conn, "select * from uzivatel where login='$login'");
    $numRows = mysqli_num_rows($res);
    if ($numRows == 1) {
        while ($row = mysqli_fetch_assoc($res)) {
            if (password_verify($heslo, $row['heslo'])) {
                $_SESSION['jmeno'] = $row['jmeno'];
                $_SESSION['login'] = $row['login'];
                $_SESSION['id'] = $row['id'];
                header('Location: index.php');
            }
        }
    } else echo '<div class="error">' . $error . '</div><hr>';

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registrace</title>
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
<div class="main">
    <p class="p-signin" style="text-align: center">Sign in</p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="text-align: center">
        <input class="login" type="text" name="login" value="" placeholder="Login"><br>
        <input class="heslo" type="password" name="heslo" value="" placeholder="Heslo"><br>
        <input class="submit" name="prihlasit" type="submit" value="Přihlásit se"/>
        <p class="p-signup">Pokud ještě nemáte účet, tady si ho <a href="signup.php">vytvoříte</a>.</p>
    </form>
</div>
</body>
</html>

