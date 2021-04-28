<?php
require_once("db.php");

if (isset($_POST['registrovat'])) {
    $errors = array();
    $login = $_POST['login'];
    $jmeno = $_POST['jmeno'];
    $email = $_POST['email'];
    $heslo = $_POST['heslo'];

    if (trim($_POST['login']) == '') {
        $errors[] = "Zadejte login!";
    }

    if (trim($_POST['jmeno']) == '') {
        $errors[] = "Zadejte jmeno!";
    }

    if (trim($_POST['email']) == '') {
        $errors[] = "Zadejte e-mail!";
    }
    if (trim($_POST['heslo']) == '') {
        $errors[] = "Zadejte znovu heslo!";
    }
    if ($_POST['heslo_znovu'] != $_POST['heslo']) {
        $errors[] = "Zadejte znovu heslo!";
    }

    $res_log = mysqli_query($conn, "select login from uzivatel where login='$login' LIMIT 1");
    while ($row_log = mysqli_fetch_array($res_log, MYSQLI_NUM)) {
        if ($row_log[0] == $_POST['login']) {
            $errors[] = "Login uz existuje";
        }
    }

    $res_email = mysqli_query($conn, "select email from uzivatel where email='$email' LIMIT 1");
    while ($row_email = mysqli_fetch_array($res_email, MYSQLI_NUM)) {
        if ($row_email[0] == $_POST['email']) {
            $errors[] = "E-mail uz existuje";
        }
    }

    if (mb_strlen($_POST['login']) < 5 || mb_strlen($_POST['login']) > 90) {
        $errors[] = "Zadejte login od 5 do 90 symbolu";
    }

    if (mb_strlen($_POST['heslo']) < 5) {
        $errors[] = "Zadejte heslo od 5 symbolu";
    }

//    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email'])) {
//        $errors[] = 'E-mail neni spravny';
//    }

    if (empty($errors)) {
        $options = array("cost" => 4);
        $hashHeslo = password_hash($heslo, PASSWORD_BCRYPT, $options);
        $sql = "insert into uzivatel (login, jmeno, email, heslo) value ('" . $login . "', '" . $jmeno . "','" . $email . "', '" . $hashHeslo . "')";
        $result = mysqli_query($conn, $sql);
        if ($result) echo '<div class="super">Super! Můžete se <a href="login.php">přihlásit</a>.</div><hr>';
    } else {
        echo '<div class="error" >' . array_shift($errors) . '</div><hr>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registrace</title>
    <link rel="stylesheet" href="css/signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body> 
<div class="main">
    <p class="p-signup" >Sign up</p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="text-align: center">
        <input class="login" type="text" name="login" value="" placeholder="Login"><br>
        <input class="jmeno" type="text" name="jmeno" value="" placeholder="Jmeno"><br>
        <input class="email" type="text" name="email" value="" placeholder="E-mail"><br>
        <input class="heslo" type="password" name="heslo" value="" placeholder="Heslo"><br>
        <input class="heslo-znovu" type="password" name="heslo_znovu" value="" placeholder="Heslo jeste jednou"><br>
        <input class="submit" name="registrovat" type="submit" value="Registrovat"/>
        <p class="p-signin">Pokud už účet máte, stačí se <a href="login.php">přihlásit</a>.</p>
    </form>
</div>
</body>
</html>
