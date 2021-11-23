<?php
include_once('../lib/database.php');
class Model{
    public function __construct()
    {
        $this->db = new Database();
    }
}
?>