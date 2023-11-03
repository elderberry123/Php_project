<?php

session_start();

include "config.php";
$password = $error = $email = $pass_er = $email_er = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = md5($_POST["pass"]);

    if (empty($_POST["email"])) {
        $email_er = " * email is required ";
    }
    if (empty($_POST["pass"])) {
        $pass_er = " * password is required ";
    }

    $query = "SELECT `id`, `email`, `pass` FROM `user_d` WHERE `email` = '$email' AND `pass` = '$password'";
    $result = $mysqli->query($query);

    if ($result) {
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $id = $row['id'];
          $email = $row['email'];
          $pass = $row['pass'];
          $rememberMe = isset($_POST['remember_me']) && $_POST['remember_me'] == 'on';
          
          if ($rememberMe) {
              setcookie("user_id", $id, time() +  (30 * 1000)); 
              setcookie("user_email", $email, time() + 10); 
            
          } else {
              $_SESSION['user_id'] = $id;
              $_SESSION['user_email'] = $email;
          }

          header("Location: home.php");
          exit();
      } else {
          $error= "Login failed. Invalid email or password.";
      }
  } 
}

$mysqli->close();





?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<section class="vh-100" style="background-color: #9A616D;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">

            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars(
                                                                            $_SERVER["PHP_SELF"]
                                                                          ); ?>">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span style="color: red;" class="h5 fw-bold mb-0"><?php if (!empty($email  &&  $password)) {
                                                                        echo $error;
                                                                      } ?></span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account
                  </h5>

                  <div class="form-outline mb-4">
                    <input type="email" id="form2Example17" name="email" class="form-control form-control-lg" value="<?php 

                       if(isset($_COOKIE["user_email"])){
                        echo $_COOKIE["user_email"];
                        } elseif(isset($_SESSION["user_email"])) {
                         echo  $_SESSION['user_email'];
                       }

                       ?>" />


                    <label class="form-label" for="form2Example17">Email address</label>
                    <p style="color: red;"><?php echo $email_er ?></p>

                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" id="form2Example27" name="pass" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example27">Password</label>
                    <p style="color:red;">
                      <pstyle="color: red;"><?php echo $pass_er ?>
                    </p>
                  </div>
                  <div class="field-group">
                  <p><input type="checkbox" name="remember" /> Remember me
	</p>
                     
                    </div>
                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" value="login">Login</button>
                    </div>

                    <a class="small text-muted" href="#!">Forgot password?</a>
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="register.php" style="color: #393f81;">Register here</a></p>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>