<?php include './admin_components/admin_header.php' ?>

<div class="ui container">

    <!-- Top Navigation Bar -->
    <?php include './admin_components/admin_top-menu.php' ?>

    <!-- BODY Content -->
    <div class="ui grid">
        <!-- Left menu -->
        <?php include './admin_components/admin_side-menu.php' ?>

        <!-- right content -->
        <div class="twelve wide column">
            <h1>Create New Programme Details</h1>

            <?php
                if(isset($_POST['submit_program'])) {
                    $title = $_POST['title'];
                    $desc = $_POST['desc'];

                    $sql = "INSERT INTO programs (program_title, program_desc) VALUES ('$title', '$desc')";

                    if ($conn->query($sql) === TRUE) {
                            echo "<script> alert('New Program created successfully'); </script>";
                    } else {
                        echo "<script> alert('Error in Insertion'); </script>";
                    }
                }
            ?>
			<?php
          if(isset($_POST['delete_programs'])) {
    $programs = $_POST['programs'];

    foreach($programs as $program) {
        $sql = "DELETE FROM programs WHERE program_id = $program";

        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Program deleted successfully'); </script>";
        } else {
            echo "<script> alert('Error in deletion: " . $conn->error . "');</script>";
        }
    }

    // $conn->close(); // Remove this line
}
           ?>

<script>
document.getElementById("select-all").addEventListener("click", function() {
    var checkboxes = document.getElementsByName("programs[]");
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = this.checked;
    }
});
</script>

            <form action="<?php $_PHP_SELF ?>" method="post" class="ui form">

                <div class="field">
                    <label>Title</label>
                    <div class="eight wide field">
                        <input type="text" name="title" placeholder="Program Title">
                    </div>
                </div>

                <div class="field">
                    <label>Description</label>
                    <textarea type="text" name="desc" rows="2"></textarea>
              </div>

                <button name="submit_program" type="submit" class="ui primary button">Submit</button>
                <button type="reset" class="ui button">Reset</button>
            </form>

            <h2>Delete Programs</h2>
            <form action="" method="post">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Title</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM programs";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><input type='checkbox' name='programs[]' value='" . $row["program_id"] . "'></td>";
                                    echo "<td>" . $row["program_title"] . "</td>";
                                    echo "<td>" . $row["program_desc"] . "</td>";
                                   echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No programs found</td></tr>";
                            }
                            // $conn->close(); // Remove this line
                        ?>
                    </tbody>
                    <tfoot>
                <tr><td colspan="3">
                                <button name="delete_programs" type="submit" class="ui primary button">Delete Selected</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
        <span class="p-20"></span>
    </div>

</div>

<?php include './admin_components/admin_footer.php' ?>

<?php $conn->close(); // Move this line to the very end of the script ?>