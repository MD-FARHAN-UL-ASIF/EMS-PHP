<?php
    include '../../includes/db_connection.php';

    $sql = "SELECT project.id, project.title, project.description, project.starting_date, project.closing_date, project.documents,
                   project.status, project.submission_date, project.submitted_documents, employees.FirstName, employees.LastName 
            FROM project 
            JOIN employees ON project.empId = employees.id 
            WHERE project.status = 1 
            ORDER BY project.id DESC";

    // Prepare and execute the query
    $query = $dbh->prepare($sql);
    $query->execute();

    // Fetch all results
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Count the number of rows
    $rowCount = count($results);

    // Output the count
    echo htmlentities($rowCount);
?>
