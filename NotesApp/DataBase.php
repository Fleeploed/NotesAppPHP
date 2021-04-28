<?php

class DataBase
{
    public $conn = null;

    function __construct()
    {
        $this->conn = mysqli_connect("localhost", "id16643611_alisher", "4q@^RT-_+qY#X*0L", "id16643611_zapocetvima");
    }

    public function signIn($login, $heslo)
    {
        $res = $this->conn->query("select * from uzivatel where login='$login'");
        $numRows = mysqli_num_rows($res);
        if ($numRows == 1) {
            while ($row = mysqli_fetch_assoc($res)) {
                if (password_verify($heslo, $row['heslo'])) {
                    $upload['message'] = "Super!";
                    $upload['success'] = true;
                    $upload['jmeno'] = $row['jmeno'];
                    $upload['id_user'] = $row['id'];
                } else {
                    $upload['message'] = "Chybně zadané heslo nebo login!";
                    $upload['success'] = false;
                }
            }
        } else {
            $upload['message'] = "Chybně zadané heslo nebo login!";
            $upload['success'] = false;
        }
        return json_encode($upload);
    }

    public function signUp($jmeno, $login, $email, $heslo)
    {
        $options = array("cost" => 4);
        $hashHeslo = password_hash($heslo, PASSWORD_BCRYPT, $options);
        $res = $this->conn->query("select login from uzivatel where login='$login' LIMIT 1");

        $queryBool = true;
        while ($row_log = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            if ($row_log['login'] == $login) {
                $upload['message'] = "Login uz existuje!";
                $upload['success'] = false;
                $queryBool = false;
            }
        }

        $res_email = $this->conn->query("select email from uzivatel where email='$email' LIMIT 1");
        while ($row_email = mysqli_fetch_array($res_email, MYSQLI_ASSOC)) {
            if ($row_email['email'] == $email) {
                $upload['message'] = "E-mail uz existuje!";
                $upload['success'] = false;
                $queryBool = false;
            }
        }

        if (mb_strlen($login) < 5 || mb_strlen($login) > 90) {
            $upload['message'] = "Zadejte login od 5 do 90 symbolu";
            $queryBool = false;
            $upload['success'] = false;
        }

        if (mb_strlen($heslo) < 5) {
            $upload['message'] = "Zadejte heslo od 5 symbolu";
            $queryBool = false;
            $upload['success'] = false;
        }

        if ($queryBool) {
            if ($this->conn->query("insert into uzivatel (jmeno, login, email, heslo) values ( '" . $jmeno . "','" . $login . "','" . $email . "', '" . $hashHeslo . "') ")) {
                $upload['message'] = "Super! Muzete se prihlasit!";
                $upload['success'] = true;
            }
        }
        return json_encode($upload);
    }

    public function saveNote($id_user, $title, $popis)
    {
        if ($this->conn->query("insert into seznam (title, popis,datum) values ('" . $title . "','" . $popis . "','" . date("Y-m-d H:i:s") . "')")) {
            $sql = $this->conn->query("select id_seznam from seznam where title ='" . $title . "'");
            $res = mysqli_fetch_assoc($sql);
            $this->conn->query("insert into zapis (id_uzivatele, id_seznam) values ('" . $id_user . "', '" . $res['id_seznam'] . "')");
            $upload['message'] = "Super!";
            $upload['success'] = true;
        } else {
            $upload['message'] = "Chyba!";
            $upload['success'] = false;
        }
        return json_encode($upload);
    }

    public function showNote($id)
    {
        header("Content-type:application/json");
        $updateNote = array();
        $res = $this->conn->query("select * from seznam natural join zapis where id_uzivatele='" . $id . "' order by datum desc");
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($updateNote, array(
                'id_seznam' => $row['id_seznam'],
                'title' => $row['title'],
                'popis' => $row['popis'],
                'datum' => date('H:i, d M Y', strtotime($row['datum']))
            ));
        }
        return json_encode($updateNote);
    }

    public function updateNote($id_seznam, $title, $popis)
    {
        if ($this->conn->query("update seznam set title='" . $title . "', popis='" . $popis . "', datum = '" . date("Y-m-d H:i:s") . "' where id_seznam='" . $id_seznam . "'")) {
            $upload['message'] = "Update!";
            $upload['success'] = true;
        } else {
            $upload['message'] = "Chyba!";
            $upload['success'] = false;
        }
        return json_encode($upload);
    }

    public function deleteNote($id_seznam)
    {
        if ($this->conn->query("delete from seznam where id_seznam='" . $id_seznam . "'")) {
            $upload['message'] = "Delete!";
            $upload['success'] = true;
        } else {
            $upload['message'] = "Chyba!";
            $upload['success'] = false;
        }
        return json_encode($upload);
    }
}