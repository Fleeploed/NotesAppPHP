<?php
ini_set('display_errors', 0);

class SelectDB
{
    public $conn = null;

    public function __construct()
    {
        $this->conn = mysqli_connect("localhost","id16643611_alisher","4q@^RT-_+qY#X*0L","id16643611_zapocetvima");
    }

    public function getNote()
    {
        return $this->conn->query("select * from seznam natural join zapis where id_uzivatele='" . $_SESSION['id'] . "' order by datum desc");
    }

    public function addNote($note)
    {
        session_start();
        $this->conn->query("insert into seznam (title, popis, datum) values ('" . $note['title'] . "', '" . $note['popis'] . "','" . date("Y-m-d H:i:s") . "')");
        $sql = $this->conn->query("select id_seznam from seznam where title ='" . $note['title'] . "'");
        $res = mysqli_fetch_assoc($sql);
        $this->conn->query("insert into zapis (id_uzivatele, id_seznam) values ('" . $_SESSION['id'] . "', '" . $res['id_seznam'] . "')");

        return $this->getNote();
    }

    public function deleteNote($id_seznam)
    {
        $this->conn->query("delete from seznam where id_seznam = '" . $id_seznam . "'");
        return $this->getNote();
    }

    public function updateNote($id_seznam, $note)
    {
        $this->conn->query("update seznam set title = '" . $note['title'] . "', popis = '" . $note['popis'] . "', datum = '" . date("Y-m-d H:i:s") . "' where id_seznam = '" . $id_seznam . "'");
        return $this->getNote();
    }

    public function getNoteById($id_seznam)
    {
        $res = $this->conn->query("select * from seznam where id_seznam = '" . $id_seznam . "'");
        return mysqli_fetch_assoc($res);
    }
}

return new SelectDB();