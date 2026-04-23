<?php 
include 'db.php'; 
include 'header.php'; 
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-primary fw-bold">Submit Assignment</h4>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Choose Assignment</label>
                            <select name="asgn_id" class="form-select" required>
                                <option value="" disabled selected>Select from list...</option>
                                <?php 
                                //Dynamically populates the dropdown with available assignments from the database
                                $res = $conn->query("SELECT * FROM assignments");
                                while($r = $res->fetch_assoc()) {
                                    echo "<option value='{$r['id']}'>{$r['title']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload File (PDF/DOCX/TXT)</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>

                        <button name="upload" class="btn btn-primary px-5">Submit My Work</button>
                    </form>

                    <?php
                    if (isset($_POST['upload'])) {
                        $folder = "uploads/";
                        //Checks for existence of the destination folder; creates it if missing
                        if (!is_dir($folder)) mkdir($folder, 0777, true);
                        
                        //Generates a unique filename using a timestamp to prevent redundancy
                        $fileName = time() . "_" . $_FILES['file']['name'];

                        //Moves the uploaded file from the temporary server location to the permanent folder
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $folder . $fileName)) {

                            //Uses Prepared Statements to safely record the file path in the database
                            $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file_name) VALUES (?, ?, ?)");
                            $stmt->bind_param("iis", $_SESSION['user_id'], $_POST['asgn_id'], $fileName);
                            
                            if($stmt->execute()) {
                                //Provides visual confirmation of a successful database transaction
                                echo "<div class='alert alert-success mt-3 shadow-sm'>Successfully Submitted!</div>";
                            } else {
                                echo "<div class='alert alert-danger mt-3'>Database Error: " . $conn->error . "</div>";
                            }
                            $stmt->close();
                        } else {
                            //Error handling for server-side permission issues
                            echo "<div class='alert alert-danger mt-3'>File Upload Error. Check folder permissions.</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include 'footer.php'; 
?>
