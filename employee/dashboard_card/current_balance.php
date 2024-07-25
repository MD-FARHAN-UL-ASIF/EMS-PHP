<?php
    // Fetch the latest balance for the current employee
    $empId = $_SESSION['eid'];
    $sql = "SELECT balance FROM employee_salary WHERE empId = :empId ORDER BY id DESC LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empId', $empId, PDO::PARAM_INT);
    $query->execute();
    $latestBalance = $query->fetch(PDO::FETCH_OBJ);
    $balance = $latestBalance ? $latestBalance->balance : 0; // Set to 0 if no records found
    echo $balance;
?>
