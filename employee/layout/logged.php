<?php
include('../includes/db_connection.php');
    
    $eid=$_SESSION['eid'];
    $sql = "SELECT FirstName,LastName,EmpId from  employees where id=:eid";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $cnt=1;

    if($query->rowCount() > 0){
        foreach($results as $result)
    {    ?>
        <p style="color:white;"><?php echo htmlentities($result->FirstName." ".$result->LastName);?></p>
        <span><?php echo htmlentities($result->EmpId)?></span>
<?php }
    } 
?>