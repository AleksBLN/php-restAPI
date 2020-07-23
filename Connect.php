<?php 

class Connect {
    public static function getConnect() {
        return mysqli_connect("localhost", "root", "root", "mvc");
    }
}

?>
