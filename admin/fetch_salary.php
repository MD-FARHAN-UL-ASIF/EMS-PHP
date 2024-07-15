<?php
include('../includes/db_connection.php');

if (!empty($_POST['empId'])) {
    $empId = filter_input(INPUT_POST, 'empId', FILTER_SANITIZE_NUMBER_INT);
    
    // Fetch the salary from the employees table
    $sql = "SELECT salary FROM employees WHERE id = :empId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empId', $empId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    $salary_in = $result ? $result->salary : 0;

    // Fetch the previous balance from the employee_salary table
    $sql = "SELECT balance FROM employee_salary WHERE empId = :empId ORDER BY payout_date DESC LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empId', $empId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $previous_balance = $result ? $result->balance : 0;

    $balance = $previous_balance + $salary_in;

    echo json_encode(array('salary_in' => $salary_in, 'balance' => $balance));
}
?>
