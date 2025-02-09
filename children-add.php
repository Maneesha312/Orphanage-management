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
            <h1>Child Registration Form</h1>

            <?php

                if(isset($_POST['submit_child'])) {
                    $child_name = $_POST['child_name'];
                    $child_dob = $_POST['child_dob'];
                    $child_yoe = $_POST['child_yoe'];
                    $child_class = $_POST['child_class'];
                    $pname = $_POST['name'];
                    $ap = $_POST['place'];

                    // Validate child name
                    if(!preg_match("/^[a-zA-Z ]*$/", $child_name)) {
                        echo "<script> alert('Only letters and white space allowed in child name'); </script>";
                        exit();
                    }

                    // Validate date of birth format and year
                    $current_year = date('Y');
                    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $child_dob)) {
                        echo "<script> alert('Invalid date of birth format. Please use YYYY-MM-DD format.'); </script>";
                        exit();
                    }
                    $dob_year = date('Y', strtotime($child_dob));
                    if ($dob_year > $current_year) {
                        echo "<script> alert('Date of birth cannot be in the future.'); </script>";
                        exit();
                    }

                    // Validate name
                    if(!preg_match("/^[a-zA-Z ]*$/", $pname)) {
                        echo "<script> alert('Only letters and white space allowed in name'); </script>";
                        exit();
                    }

                    // Prepare the SQL statement
                    $stmt = $conn->prepare("INSERT INTO children (cname, cdob, cyoe, cclass, pname, ap) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssisss", $child_name, $child_dob, $child_yoe, $child_class, $pname, $ap);

                    if ($stmt->execute()) {
                        echo "<script> alert('New record created successfully'); </script>";
                    } else {
                        echo "<script> alert('Error in Insertion'); </script>";
                    }

                    $stmt->close();
                    $conn->close();

               }

            ?>

                <form action="<?php $_PHP_SELF ?>" method="post" class="ui form" enctype="multipart/form-data">
                    <div class="seven wide field">
                        <label>Child Name<span class="required">*</span></label>
                        <input type="text" name="child_name" placeholder="Child's Name" required>
                    </div>
                    <div class="seven wide field">
                        <label>Date of Birth<span class="required">*</span></label>
                        <input type="date" name="child_dob" required>

                    </div>
                    <div class="seven wide field">
                        <label>Year of Entry<span class="required">*</span></label><input type="number" name="child_yoe" min="1900" max="2024" required>
                    </div>
                    <div class="seven wide field">
                        <label>Class<span class="required">*</span></label>
                        <input type="text" name="child_class" placeholder="Class" required>
                    </div>
					<p><h2>Details of person who brought the child</h2></p>
                    <div class="seven wide field">
                        <label>Person Name<span class="required">*</span></label>
                        <input type="text" name="name" placeholder="Name" required>
                    </div>
                    <div class="seven wide field">
                        <label>Person Place & contact<span class="required">*</span></label>
                        <input type="text" name="place" placeholder="Place" required>
                    </div>
                    
                    
                    <div class="ui small buttons">
                        <button type="submit" name="submit_child" class="ui primary button">Submit</button>
                        <div class="or"></div>
                        <button type="reset" class="ui button">Reset</button>
                    </div>
                </form>

        </div>
    </div>
</div>

<?php include './admin_components/admin_footer.php' ?>