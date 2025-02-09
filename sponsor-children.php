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
            <h1>Sponsor this Child</h1>

            <?php

                if(isset($_POST['submit'])) {
                    $cid = $_GET['cid'];
                    $noofyear = $_POST['noofyear'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    $amount = $_POST['amount'];
                    

                    $emailPattern = "/^[a-zA-Z][a-zA-Z0-9_" . preg_quote(".", "/") . "]{0,30}@gmail\.com$/";
                    if(!preg_match($emailPattern, $email)) {
                        echo "<script> alert('Invalid email format. Please use @gmail.com format.'); </script>";
                        return;
                    }

                    $namePattern = "/^[a-zA-Z ]{2,30}$/";
                    if(!preg_match($namePattern, $firstname)) {
                        echo "<script> alert('Invalid first name format. Only letters and spaces are allowed.'); </script>";
                        return;
                    }

                    if(!preg_match($namePattern, $lastname)) {
                        echo "<script> alert('Invalid last name format. Only letters and spaces are allowed.'); </script>";
                        return;
                    }

                    $phonePattern = "/^[0-9]{10}$/";
                    if(!preg_match($phonePattern, $phone)) {
                        echo "<script> alert('Invalid phone number format. Only numbers and 10 digits are allowed.'); </script>";
                        return;
                    }

                    $sql = "INSERT INTO sponsorer (spn_firstname,spn_lastname, spnd_date, spn_noofyears, spn_email, spn_phone, spn_bill_address, spn_amount,  cid) 
                                VALUES ('$firstname', '$lastname', NOW(), '$noofyear', '$email', '$phone', '$address', '$amount',  '$cid')";
                             
                    $sql2 = "UPDATE children SET sponsored=1 WHERE cid='$cid' ";

                    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
$unsponsored_page = './child-gallery-sponsored.php';
                            header('Location: ' . $unsponsored_page);
                            echo "<script> alert('New record created successfully'); </script>";
                    } else {
                        echo "<script> alert('Error in Insertion'); </script>";
                    }
                    $conn->close();} else {

                }

            ?>

            <form action="<?php $_PHP_SELF ?>" method="post" class="ui form">
                <h4 class="ui dividing header">Child's Details</h4>
                <img class="ui small top aligned circular image" src="img/defaultimg.png">

                <?php
                    if(isset($_GET['cid'])) {
                        $cid = $_GET['cid'];
                    } else {
                        $unsponsored_page = './child-gallery-sponsored.php';
                        header('Location: ' . $unsponsored_page);
                    }

                    $sql = "SELECT cid, cname, cdob, cyoe, cclass FROM children WHERE cid='$cid'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $dob = $row["cdob"];
                            $age = (date('Y') - date('Y',strtotime($dob)));
                ?>
<span>
                    <div class="description">
                        <div class="ui horizontal list">
                            <div class="item">
                                <div class="content">
                                    <div>Name:</div> <strong><?php echo $row["cname"]; ?></strong>
                                </div>
                            </div>
                            
                            <div class="item">
                               <div class="content">
                                <div>Class:</div> <strong><?php echo $row["cclass"]; ?></strong>
                                </div>
                            </div>
                            <div class="item">
                                <div class="content">
                                <div>Year of enroll:</div> <strong><?php echo $row["cyoe"]; ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>
                <?php
                        }
                    }
                ?>

                <h4 class="ui dividing header">Sponsor Type</h4>
                <div class="two fields">
                    <div class="field">
                        <select name="noofyear" class="ui fluid dropdown" required>
                            <option value="">Number of Years</option>
                            <option value="1">1 Year</option>
                            <option value="2">2 Years</option>
                            <option value="3">3 Years</option>
                            <option value="5">5 Years</option>
                        </select>
                    </div>
                    <div class="field">
                        * 1 year, pay Rs.4800<br>
                        * 2 year, pay Rs.9600<br>
                        * 3 year, pay Rs.15000<br>
                        * 5 year, pay Rs.25000<br>
                    </div>
                </div>

                <h4 class="ui dividing header">Personal Information</h4>
                <div class="fields">
                    <div class="eight wide field">
                        <label>First Name</label>
                        <input type="text" name="firstname" placeholder="First Name" required>
                    </div>
                    <div class="eight wide field">
                        <label>Last Name</label>
                        <input type="text" name="lastname" placeholder="Last Name" required>
                    </div>
                </div>

              <div class="fields">
                    <div class="eight wide field">
                        <label>Email</label>
                        <input type="email" id="email" name="email"
                        (!filter_var($email, FILTER_VALIDATE_EMAIL))>
                                                    </div>
                    <div class="eight wide field">
                        <label>Phone No.</label>
                        <input type="tel" name="phone" placeholder="Phone / Mobile" required>
                    </div>
                </div>

                <div class="field">
                    <label>Billing Address</label>
                    <div class="field">
                    <div class="sixteen wide field">
                        <input type="text" name="address" placeholder="Address" required>
                    </div>
                    </div>
                </div>
                <h4 class="ui dividing header">Billing Information</h4>
                <div class="field">
                    <div class="eight wide field">
                    <label>Amount</label>
                    <input type="number" name="amount" min="100" maxlength="8" placeholder="Amount" required>
                    </div>

                <h3 class="ui dividing header">Payment options:</h3>
                    <div class="field">
                        <div class="eight wide field">
                        <label for="QR CODE">QR CODE</label>
                                        <img class="ui small rounded image" src="semantic\qr.jpg.png" width="5" height="5">
                        </div>
                    </div>

                    <h4><b>OR<b></h4>

                    <div class="ui radio checkbox">
                        <input type="radio" name="Cash" tabindex="0" >
                        <label for="Cash">Cash</label>
                    </div>
                    <br>
					</br>
               <br><button name="submit" class="ui primary button" tabindex="0">Submit</button></br>
            </form>

</div>

        <span class="p-20"></span>

    </div>
</div>

<?php include './components/footer.php'; ?>