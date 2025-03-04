<?php

include("../database.php");
include("../helper/authorization.php");

if (!isset($access)) {
    echo "<script> window.location.href = 'http://localhost/tpc/helper/noAccess.php'; </script>";
}

if ($access == 2 || $access == 3) {
    $dept = $_SESSION["adminDept"];
}
// var_dump($_SESSION["adminId"]);
// var_dump($_SESSION);

$updateFailure = 0;
$updateSuccess = 0;

if (isset($_POST["update-pass"])) {
    $password = mysqli_real_escape_string($conn, $_POST["newPassword"]);
    $password = base64_encode(strrev(md5($password)));
    $id = $_SESSION["adminId"];

    // var_dump($password);

    if ($access == 1) {

        $updatePassword = $conn->query("UPDATE `tp0` SET `tpo_password`='$password' WHERE tpo_id = '$id'");
        if ($conn->affected_rows) {
            $updateSuccess = 1;
        } else {
            $updateFailure = 1;
        }
    }

    if ($access == 2) {

        $updatePassword = $conn->query("UPDATE `tpf` SET `tpf_password`='$password' WHERE tpf_id = '$id'");
        if ($conn->affected_rows) {
            $updateSuccess = 1;
        } else {
            $updateFailure = 1;
        }
    }

    if ($access == 3) {
        $updatePassword = $conn->query("UPDATE `tpc` SET `tpc_password`='$password' WHERE tpc_id = '$id'");
        if ($conn->affected_rows) {
            $updateSuccess = 1;
        } else {
            $updateFailure = 1;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./helper/sidebar.css">
    <?php if ($updateSuccess == 1 || $updateFailure == 1) : ?>
        <meta http-equiv="refresh" content="3;url=http://localhost/tpc/admin/settings.php" />
    <?php endif ?>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css">
    <link rel="stylesheet" href="./helper/index.css">
    <link rel="stylesheet" href="./helper/sidebar.css">
    <link rel="stylesheet" href="./helper/viewStudent.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <title>Admin | Setting</title>

    <style>
        .extra {
            font-size: 13px;
            color: #adacac;
        }

        .done {
            font-size: 14px;
            font-weight: bolder;
            color: #08b30e;
        }
    </style>
</head>

<body>
    <?php include("./helper/sidebar.php") ?>

    <main>
        <div class="container-fluid">

            <div class="page-content page-container" id="page-content">
                <div class="padding">
                    <div class="row  d-flex justify-content-center">
                        <?php if ($updateSuccess == 1) : ?>
                            <p class="bg-success text-white text-center">Successfully Updated Password </p>
                        <?php endif ?>
                        <?php if ($updateFailure == 1) : ?>
                            <p class="bg-danger text-white text-center">Error in Updating Password </p>
                        <?php endif ?>

                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-4 bg-c-lite-green user-profile">
                                    <div class="card-block text-center">
                                        <!-- <div class="m-b-25">
                                            <img src="http://localhost/tpc-main/images/Dhyey.png" class="img-radius" alt="User-Profile-Image">
                                        </div> -->
                                        <h2 class="f-w-600"><?php echo $adminUser ?></h2>
                                        <p class="f-w-600"><?php echo $_SESSION["adminEmail"] ?></p>
                                        <?php if ($access == 3) : ?>
                                            <p class="f-w-600">19CP015</p>
                                        <?php endif ?>
                                        <!-- <p class="f-w-600">Computer Department</p> -->
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Change Password</h6>
                                        <form action="./settings.php" method="post">
                                            <div class="row m-b-20">
                                                <div class="col-sm-6 ">
                                                    <p class="m-b-5 f-w-600">Current Password</p>
                                                    <input type="password" class="m-b-5 form-control" name="" id="currentPass">
                                                </div>
                                                <div class="col-sm-6 align-item-center bg-rounded">
                                                    <p class="m-b-5 f-w-600 my-6  " id="currentmsg"></p>
                                                </div>

                                                <div class="col-sm-6 ">
                                                    <p class="m-b-5 f-w-600">New Password</p>
                                                    <input type="password" class="m-b-5 form-control" onkeyup="validate_password()" name="newPassword" id="password">
                                                </div>
                                                <div class="col-sm-6 align-item-center bg-rounded">
                                                    <span class="extra" id="eightCharacter">Must be atleat 8 characters long</span><br>
                                                    <span class="extra" id="oneDigit">Must include 1 digit</span> <br>
                                                    <span class="extra" id="oneCapital">Must include 1 Capital Letter</span> <br>
                                                    <span class="extra" id="oneSpecial">Must include 1 Special Character </span>
                                                    <!-- <input type="password" class="m-b-5 form-control" name="" id="" value="m_name"> -->
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <p class="m-b-5 f-w-600">Re-Enter New Password</p>
                                                    <input type="password" class="m-b-5 form-control" onkeyup="check_password()" name="" id="cPassword">
                                                </div>
                                                <div class="col-sm-6 align-item-center bg-rounded">
                                                    <p class="m-b-5 f-w-600 my-6 " id="message"></p>
                                                    <!-- <p class="m-b-5 f-w-600  ">Password Invalid</p> -->
                                                    <!-- <input type="password" class="m-b-5 form-control" name="" id="" value="m_name"> -->
                                                </div>

                                            </div>

                                            <input type="submit" name="update-pass" id="updatePassword" class="text-center btn btn-primary" value="Update">
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </form>
    </main>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="./helper/sidebar.js"></script>

    <script>
        var finalSubmit = 0;
        var oldPass = 0;
        var newPass = 0;
        var newCpass = 0;

        function validate_password() {
            var c1, c2, c3, c4 = 0
            var eightCharacter = document.getElementById('eightCharacter');
            var oneCapital = document.getElementById('oneCapital');
            var oneDigit = document.getElementById('oneDigit');
            var oneSpecial = document.getElementById('oneSpecial');
            var pass = document.getElementById('password').value;
            // var confirm_pass = document.getElementById('cPassword').value;
            if (pass.length >= 8) {
                console.log(pass.length)
                eightCharacter.classList.remove("extra");
                eightCharacter.classList.add("done");
                c1 = 1
            }
            if (pass.length < 8) {
                eightCharacter.classList.remove("done");
                eightCharacter.classList.add("extra");
                c1 = 0
            }
            console.log(eightCharacter.classList);
            if (pass.match(/[A-Z]+/)) {
                oneCapital.classList.remove("extra");
                oneCapital.classList.add("done");
                c2 = 1;
            }
            if (!pass.match(/[A-Z]+/)) {
                oneCapital.classList.remove("done");
                oneCapital.classList.add("extra");
                c2 = 0
            }
            if (pass.match(/[0-9]+/)) {
                oneDigit.classList.remove("extra");
                oneDigit.classList.add("done");
                c3 = 1;
            }
            if (!pass.match(/[0-9]+/)) {
                oneDigit.classList.remove("done");
                oneDigit.classList.add("extra");
                c3 = 0
            }
            if (pass.match(/[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\]+/)) {
                oneSpecial.classList.remove("extra");
                oneSpecial.classList.add("done");
                c4 = 1
            }
            if (!pass.match(/[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\]+/)) {
                oneSpecial.classList.remove("done");
                oneSpecial.classList.add("extra");
                c4 = 0
            }

            if ((c1 + c2 + c3 + c4) == 4) {
                newPass = 1;
            }

            finalCheck()




        }

        function check_password() {
            var pass = document.getElementById('password').value;
            var confirm_pass = document.getElementById('cPassword').value;
            if (pass != confirm_pass) {
                // document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Password Not Matched';
                document.getElementById('message').classList.add('bg-danger')
                document.getElementById('message').classList.remove('bg-success')
                newCpass = 0;

            } else {
                // document.getElementById('message').style.color = 'green';
                // document.getElementById('message').innerHTML = '🗹 Password Matched';
                document.getElementById('message').innerHTML = 'Password Matched';
                document.getElementById('message').classList.remove('bg-danger')
                document.getElementById('message').classList.add('bg-success')
                newCpass = 1;
            }
            finalCheck()

        }

        $(function() {
            $("#currentPass").keyup(function() {
                var searchid = $(this).val();
                // console.log(searchid);
                var dataValues = {
                    password: searchid,
                    admin: <?php echo $_SESSION["access"]; ?>,
                    id: <?php echo $_SESSION["adminId"]; ?>
                }
                // console.log(dataValues);
                if (searchid != '') {
                    // console.log("yes");
                    $.ajax({
                        type: "POST",
                        url: "check.php",
                        data: dataValues,
                        cache: false,
                        success: function(response) {
                            // console.log(response);
                            if (response == 1) {
                                oldPass = 1
                                $("#currentmsg").addClass('bg-success');
                                $("#currentmsg").removeClass('bg-danger');
                                $("#currentmsg").html("Password Matched");
                                finalCheck()
                            } else {
                                oldPass = 0;
                                $("#currentmsg").addClass('bg-danger');
                                $("#currentmsg").removeClass('bg-success');
                                $("#currentmsg").html("Password Not Matched");
                                finalCheck()
                            }
                        }
                    });
                }
                return false;
            });
        })
        $(document).ready(function() {
            finalCheck()
        })

        function finalCheck() {
            console.log("oldPass : ", oldPass, " newPass", newPass, "cPass", newCpass)
            if ((oldPass + newCpass + newPass) == 3) {
                console.log("ENABLED")
                document.getElementById('updatePassword').disabled = false;

            } else {
                console.log("DISBLED")
                document.getElementById('updatePassword').disabled = true;

            }
        }
    </script>

</body>

</html>