<?php session_start(); ?>

<html>

<head>
    <title>Online Examination System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<?php
if (isset($_POST['login'])) {
    if (isset($_POST['usertype']) && isset($_POST['username']) && isset($_POST['pass'])) {
        require_once 'sql.php';
        $conn = mysqli_connect($host, $user, $ps, $project);
        if (!$conn) {
            echo "<script>alert(\"Database error retry after some time !\")</script>";
        }
        $type = mysqli_real_escape_string($conn, $_POST['usertype']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);

        $sql = "SELECT * FROM " . $type . " WHERE mail='{$username}'";
        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            global $dbmail, $dbpw;
            while ($row = mysqli_fetch_array($res)) {
                $dbpw = $row['pw'];
                $dbmail = $row['mail'];
                $_SESSION["name"] = $row['name'];
                $_SESSION["type"] = $type;
                $_SESSION["username"] = $dbmail;
            }
            if ($dbpw === $password) {
                if ($type === 'student') {
                    header("location:homestud.php");
                } elseif ($type === 'staff') {
                    header("Location: homestaff.php");
                }
            } elseif ($dbpw !== $password && $dbmail === $username) {
                echo "<script>alert('Password is wrong');</script>";
            } elseif ($dbpw !== $password && $dbmail !== $username) {
                echo "<script>alert('Username not found, sign up');</script>";
            }
        }
    }
}
?>

<style>
    /* @media screen and (max-width: 620px) {
        input {
            height: 6vw !important;
        }

        .seluser {
            display: grid;
        }

        .sub {
            width: 20vw !important;
        }
    } */

    .inp {
        box-sizing: content-box !important;
        width: 30vw;
        height: 3vw;
        border-radius: 10px;
        border: 1px solid black;
        padding-left: 2vw;
        font-weight: bolder;
        outline: none;
    }

    ::placeholder {
        font-weight: bold;
        font-family: 'Courier New', Courier, monospace;
    }

    label {
        font-weight: bolder;
        font-size: 1.5vw;
    }

    form {
        font-size: 1.5vw;
        margin: 0;
    }

    button:hover {
        background-color: #fff !important;
    }

    .bg {
        background-size: 100%;
        background-color: ;
    }

    a {
        color: #042A38;
    }

    .login {
        max-height: 70vh;
    }
</style>

<body style="background-color:aliceblue">
    <div class="bg"
        style="font-weight: bolder;background-image: url(./images/bg.jpg);background-repeat: no-repeat;padding: 0;margin: 0;background-size: cover;font-family: 'Arial black', monospace;opacity: 0.9;height: 100%;">
        <center>
            <h1 class="w3-container"
                style=" color:black; text-transform: uppercase; width: auto; background:white;background-size: cover;font-family: 'Arial black'; padding: 1vw;">
                <marquee direction="left">ONLINE Examination System</h1>
            </marquee>
        </center>
        <left>
            <div class="w3-card" class="login"
                style="color: black;width: 35vw;background-color: #white;border: 1px solid black;padding: 2vw;font-weight: bolder;margin-top: 3vh;border-radius: 10px;">
                <form method="POST">
                    <div class="seluser">
                        <input type="radio" name="usertype" value="student" required>STUDENT
                        <input type="radio" name="usertype" value="staff" required>STAFF
                    </div><br><br>
                    <div class="signin">

                        <label for="username" style="text-transform: uppercase;">Username</label><br><br>
                        <input type="email" name="username" placeholder=" Email" class="inp" required>
                        <br><br>
                        <label for="password" style="text-transform: uppercase;">Password</label><br><br>
                        <input type="password" name="pass" placeholder="****" class="inp" required>
                        <br><br>
                        <input name="login" class="sub" type="submit" value="Login"
                            style="height: 3vw;width: 10vw;font-family: 'times new roman', monospace;font-weight: bolder;border-radius: 10px;border: 1px solid black;background-color:#caaa94"><br>

                </form><br>
                <!-- <a href="reset.php">Forgot password?</a>--> &nbsp; New user! <a href="signup.php">SIGN UP</a>
            </div>
        </div>
    </left>
    </div>
    <?php require("footer.php"); ?>
</body>

</html>