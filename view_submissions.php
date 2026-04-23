<?php 
include 'db.php'; 
include 'header.php'; 
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-primary fw-bold">Assignment Submissions</h4>
                </div>
                <div class="card-body p-4">
                    <div class="list-group">
                        <?php
                        // Retrieves the current user's ID from the session for filtering
                        $uid = $_SESSION['user_id'];

                        //Combines 'submissions', 'users', and 'assignments' tables to display full details
                        if ($_SESSION['role'] == 'admin') {
                            //Admin view. Retrieves all submissions from all students
                            $sql = "SELECT s.*, u.name, a.title 
                                    FROM submissions s 
                                    JOIN users u ON s.user_id = u.id 
                                    JOIN assignments a ON s.assignment_id = a.id";
                        } else {
                            //Student view. Restricts retrieval to only their own submitted records
                            $sql = "SELECT s.*, u.name, a.title 
                                    FROM submissions s 
                                    JOIN users u ON s.user_id = u.id 
                                    JOIN assignments a ON s.assignment_id = a.id 
                                    WHERE s.user_id = $uid";
                        }
                        
                        //Executes the query and checks for valid results
                        $res = $conn->query($sql);

                        if ($res && $res->num_rows > 0):
                            // Loops through the result set to generate list items for the UI
                            while($row = $res->fetch_assoc()): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($row['title']); ?></h6>
                                        <small class="text-muted">
                                            File: <?php echo htmlspecialchars($row['file_name']); ?> 
                                            
                                            <?php if($_SESSION['role'] == 'admin') echo " | Submitted by: " . htmlspecialchars($row['name']); ?>
                                        </small>
                                    </div>
                                    <a href="uploads/<?php echo $row['file_name']; ?>" class="btn btn-sm btn-primary" download>
                                        Download
                                    </a>
                                </div>
                            <?php endwhile; 
                        else: ?>
                            <div class="text-center py-4 text-muted">
                                No submissions found.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include 'footer.php'; 
?>
