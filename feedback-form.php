<?php include './components/header.php'; ?>

<div class="ui container">

    <!-- Top Navigation Bar -->
    <?php include './components/top-menu.php'; ?>

    <!-- BODY Content -->
    <div class="ui grid">
        <!-- Left menu -->
        <?php include './components/side-menu.php'; ?>

        <!-- right content -->
        <div class="twelve wide column">
            <h1>Feed Back</h1>

            <?php
            if (isset($_POST['submit_feedback'])) {
                $name = $_POST['full_name'];
                $address = $_POST['full_address'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $comment = $_POST['comment'];

                // Use regular expressions to check if the name, phone number, and email are in the correct format
                $namePattern = "/^[a-zA-Z ]{2,30}$/";
                if(!preg_match($namePattern, $name)) {
                    echo "<script> alert('Invalid name format. Only letters and spaces are allowed.'); </script>";
                    return;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '@gmail.com') === false) {
                    echo "<script> alert('Error: The email address must be a valid Gmail address.'); </script>";
                } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                    echo "<script> alert('Error: Only letters and white space allowed in name.'); </script>";
                } else if (!preg_match("/^[0-9]{10}$/", $phone)) {
                    echo "<script> alert('Error: Only numbers allowed in phone number.'); </script>";
                } 

                $sql = "INSERT INTO feedback (full_name, full_address, phone, email, comment) 
                        VALUES ('$name', '$address', '$phone', '$email', '$comment')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script> alert('Feedback successfully sent'); </script>";
                } else {
                    echo "<script> alert('Error in Insertion'); </script>";
                }

                $conn->close();
            }
           ?>

            <form action="<?php $_PHP_SELF ?>" method="post" class="ui form">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="full_name" placeholder="Full Name" required>
                </div>
                <div class="field">
                    <label>Address</label>
                    <div class="field">
                      <div class="sixteen wide field">
                        <input type="text" name="full_address" placeholder="Address" required>
                      </div>
                    </div>
                </div>
                <div class="field">
                    <label>Phone No.</label>
                    <div class="field">
                      <div class="eight wide field">
                        <input type="Phone" name="phone" placeholder="Phone / Mobile" required>
                      </div>
                    </div>
                </div>
                <div class="field">
                    <label>Email Address</label>
                    <div class="field">
                      <div class="eight wide field">
                        <input type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required>
                      </div>
                      <div id="email-error" class="error"></div>
                    </div>
                </div>
                <div class="field">
                    <label>Comments</label>
                    <textarea rows="2" name="comment" required></textarea>
                </div>
                <button name="submit_feedback" class="ui primary button" type="submit">Submit</button>
                <button class="ui button" type="reset">Reset</button>
            </form>

            <script>
            // Select the email input element and the error message element
            const emailInput = document.querySelector('#email');
            const emailError = document.querySelector('#email-error');

            // Add an event listener to the email input element to check the email address when it is changed
            emailInput.addEventListener('input', function() {
              // If the email address is not in the correct format, show an error message
              if (!emailInput.validity.valid) {
                emailError.textContent = 'Please enter avalid email address in the format @gmail.com';
              } else {
                // If the email address is in the correct format, hide the error message
                emailError.textContent = '';
              }
            });

            // Add an event listener to the form element to check the email address when the form is submitted
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
              // If the email address is not in the correct format, prevent the form from being submitted
              if (!emailInput.validity.valid) {
                event.preventDefault();
                emailError.textContent = 'Please enter a valid email address in the format @gmail.com';
              }
            });
            </script><span class="p-20"></span>

        </div>
    </div>

</div>
<?php include './components/footer.php'; ?>