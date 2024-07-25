<?php
    include '../../includes/db_connection.php';

    $sql = "SELECT id from departments";
    $query = $dbh -> prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $depcount=$query->rowCount();

    echo htmlentities($depcount);
?>