<?php
    // Fetch the count of accepted leaves for the current employee
    $empId = $_SESSION['eid'];
    $sql = "SELECT COUNT(*) as acceptedCount FROM leaves WHERE empid = :empId AND Status = 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empId', $empId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $acceptedCount = $result ? $result->acceptedCount : 0;
    echo $acceptedCount;
?>
