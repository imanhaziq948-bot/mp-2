<?php
include 'db.php'; 
include 'header.php';

//Restricts the access to authenticated users only. Unauthorized users are redirected back to login
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-primary">Assignment Dashboard</h4>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Welcome, <span class="text-secondary"><?php echo htmlspecialchars($_SESSION['name']); ?></span> (<?php echo ucfirst($_SESSION['role']); ?>)</h5>
                    
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light">🔍</span>
                            <input type="text" id="searchBox" class="form-control" placeholder="Search Assignments (Live)..." onkeyup="search()">
                        </div>
                    </div>

                    <div id="results" class="row"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function search() {
    //Captures user input for real-time filtering
    let q = document.getElementById('searchBox').value;
    
    //Uses Fetch API to communicate with the backend server asynchronously
    fetch('ajax_search.php?q=' + encodeURIComponent(q))
    .then(res => res.text())
    .then(data => {
        //Updates the document with retrieved data. Avoiding reloading the entire page
        document.getElementById('results').innerHTML = data;
    });
}
//Initial execution to populate data upon page load
search(); 
</script>
</body>
</html>
