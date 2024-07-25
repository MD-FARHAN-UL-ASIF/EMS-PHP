<?php
    // Fetch the count of accepted projects for the current employee
    $empId = $_SESSION['eid'];
    $sql = "SELECT COUNT(*) as acceptedCount FROM project WHERE empId = :empId AND status = 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empId', $empId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $acceptedCount = $result ? $result->acceptedCount : 0;
    echo $acceptedCount;
?>
