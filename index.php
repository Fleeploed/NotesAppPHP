<?php
require_once 'SelectDB.php';
session_start();

$selectDB = new SelectDB();
$resVypis = $selectDB->getNote();


$updateNote = [
    'id_seznam' => '',
    'title' => '',
    'popis' => ''
];

if (isset($_GET['id_seznam'])) {
    $updateNote = $selectDB->getNoteById($_GET['id_seznam']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Muj seznam</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/note.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>

<?php if (isset($_SESSION['login'])) : ?>
    <div style="text-align: center">
        <br>
        <h1>Dobrý den, <?php echo $_SESSION['jmeno']; ?></h1>
        <form class="new-note" action="create.php" method="post">
            <input type="hidden" name="id_seznam" value="<?php echo $updateNote['id_seznam'] ?>"><br>
            <input class="title-seznam"  type="text" name="title" placeholder="Název poznámky" autocomplete="off"
                   value="<?php echo $updateNote['title'] ?>"><br>
            <textarea class="popis-seznam" name="popis" cols="40" rows="10"
                      placeholder="Popis"><?php echo $updateNote['popis'] ?></textarea><br>
            <input type="hidden" value=" <?php echo $_SESSION['id']; ?>">
            <button id="submit">
                <?php if ($updateNote['id_seznam']): ?>
                    Update
                <?php else: ?>
                    Nová poznámka
                <?php endif ?>
            </button><br>
            <a id="logout" href="logout.php" >Odhlásit se</a>
        </form>
    </div>
<br>
    <div class="notes">
        <?php while ($note = mysqli_fetch_assoc($resVypis)) : ?>
            <div class="note">
                <div class="title">
                    <a><?php echo $note['title'] ?></a>
                </div>
                <div class="popis">
                    <a><?php echo $note['popis'] ?></a>
                </div>
                <small><?php echo date('H:i, d M Y', strtotime($note['datum'])) ?></small>
                <div>
                    <a href="?id_seznam=<?php echo $note['id_seznam'] ?>">
                        <button class="edit"><i class="fa fa-edit"></i></button>
                    </a>
                </div>
                <div>
                    <form action="delete.php" method="post">
                        <input type="hidden" name="id_seznam" value="<?php echo $note['id_seznam'] ?>">
                        <button class="close"><i class="fa fa-close"></i></button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

<?php else : ?>
    <div id="logout-main" align="center">
        <button class="btn-signin" onclick="window.location.href='login.php';">Přihlásit se</button>
        <br>
        <button class="btn-signup" onclick="window.location.href='signup.php';">Registrace</button>
    </div>
<?php endif; ?>
</body>
</html>

