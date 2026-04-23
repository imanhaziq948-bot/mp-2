<?php
include 'db.php';

//Retrieves the search term from the GET request sent by the JavaScript fetch function
//If empty, it defaults to a wildcard '%%' to display all records
$q = isset($_GET['q']) ? "%" . $_GET['q'] . "%" : "%%";

//Implementation of Prepared Statements to prevent SQL Injection attacks
$stmt = $conn->prepare("SELECT * FROM assignments WHERE title LIKE ?");
$stmt->bind_param("s", $q);
$stmt->execute();
$res = $stmt->get_result();

//Checks if the database returned any records for the search query
if($res->num_rows > 0) {
    while($row = $res->fetch_assoc()){
        //Outputs dynamic HTML content to be injected into the dashboard without a page refresh
        echo "
        <div class='col-md-6 mb-3'>
            <div class='card h-100 border-start border-primary border-4 shadow-sm'>
                <div class='card-body'>
                    <h5 class='card-title fw-bold text-dark'>".htmlspecialchars($row['title'])."</h5>
                    <p class='card-text text-muted small'>".htmlspecialchars($row['description'])."</p>
                    <a href='submit_assignment.php?id=".$row['id']."' class='btn btn-sm btn-primary'>View & Submit</a>
                </div>
            </div>
        </div>";
    }
} else {
    //Provides feedback to the user if no search results match the input
    echo "<div class='col-12 text-center py-4'>
            <p class='text-muted'>No assignments found. Please try a different search or add assignments in the database.</p>
          </div>";
}
?>
