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
            <h1>Donation Application</h1>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $program = $_POST['program'];
                $amount = $_POST['amount'];

                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];

                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '@gmail.com') === false) {
                    echo "<script> alert('Error: The email address must be a valid Gmail address.'); </script>";
                } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                    echo "<script> alert('Error: Only letters and white space allowed in name.'); </script>";
                } else if (!preg_match("/^[0-9]*$/", $phone)) {
                    echo "<script> alert('Error: Only numbers allowed in phone number.'); </script>";
                } else {
                    $sql = "INSERT INTO donation (program, amount, d_name, email, phone, address) 
                            VALUES ('$program', '$amount', '$name', '$email', '$phone', '$address')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<script> alert('Successfully Donation form Submitted'); </script>";
                    } else {
                        echo "<script> alert('Error in Insertion'); </script>";
                    }

                    $conn->close();
                }
            }
            ?>

            <form action="<?php $_PHP_SELF ?>" method="post" class="ui form">

                <h4 class="ui dividing header">Select the program to sponsor</h4>
                <div class="grouped fields">
                    <label for="program"><u>Programs: </u></label>
                <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="program" tabindex="0" class="hidden" id="aakar" value="Aakar">
                        <label for="aakar">AAKAR - the first step</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="program" tabindex="0" class="hidden" id="ahar" value="Ahar">
                        <label for="ahar">AHAR APURTI</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="program" tabindex="0" class="hidden" id="avsar" value="Avsar">
                        <label for="avsar">AVSAR - a chance</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="program" tabindex="0" class="hidden" id="lakshya" value="Lakshya">
                        <label for="lakshya">Lakshya</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="program" tabindex="0" class="hidden" id="parivartan" value="Parivartan">
                        <label for="parivartan">PARIVARTAN - change of direction</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="program" tabindex="0" class="hidden" id="uphaar" value="Uphaar">
                        <label for="uphaar">UPHAAR - gift a smile</label></div>
                    </div>
                </div>

                <div class="field">
                    <label>Amount</label>
                    <input type="number" name="amount" min="50" placeholder="Amount" required>
                </div>

                <div class="field">
                    <label><h4><u>Payment options:</u></h4></label>

                    <p>QR CODE</p>
                    <div class="ui medium images">
                        <img class="ui medium rounded image" src="semantic\qr.jpg.png" width="140px" height="auto">
                    </div>

                    <p>Or</p>

                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="cash" tabindex="0" >
                            <label for="Cash">Cash</label>
                        </div>
                    </div>
                </div>

                <h4 class="ui dividing header">Personal Information</h4>
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <div class="field">
                    <label>Phone no.</label>
                    <input type="tel" name="phone" placeholder="Phone / Mobile" required>
                </div>
                <div class="field">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="Address" required>
                </div>
                <button name="submit_donation" class="ui primary button" type="submit">Submit</button>
               <button class="ui button" type="reset">Reset</button>
            </form>

            <span class="p-20"></span>
        </div>
    </div>

</div>

<?php include './components/footer.php'; ?>