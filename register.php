<?php
    include "config.php";
    $fname = $fnameErr = $lnameErr = $lname = $pass = $cpass = $gender = $email = $dptErr = $emailErr = $genderErr = $dob = $city = $departments = $numb_er = $numb_em = $imageFileType = $target_file = $filee = $dob_er = $pass_er = $dob_er = $departments = $email_m = $dob_em = $cpass_er = $pass_m = $city_er = $file_er = $pass_er2 = $success = $numb =
        "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $fname = test_input($_POST["fname"]);
        $lname = test_input($_POST["lname"]);
        $email = test_input($_POST["email"]);
        $numb = test_input($_POST["numb"]);
        $pass = test_input($_POST["pass"]);
        $cpass = test_input($_POST["cpass"]);
        $dob = test_input($_POST["dob"]);
        $city = test_input($_POST["city"]);
        $filee = time() . $_FILES["filee"]["name"];

        if (empty($_POST["fname"])) {
            $fnameErr = " * Name is required ";
        } elseif (!preg_match("/[a-zA-Z][a-zA-Z ]+/", $fname)) {
            $fnameErr = "Only alphabets and whitespace are allowed.";
        } elseif (!preg_match("~^\p{Lu}~u", $fname)) {
            $fnameErr = "* Should starts with uppercase.";
        }

        if (empty($_POST["dob"])) {
            $dob_er = " * date is required ";
        }

        if (empty($_POST["city"])) {
            $city_er = " * city is required ";
        }

        if (empty($_POST["numb"])) {
            $numb_er = "Mobile no is required";
        } else {
            if (!preg_match("/^[0-9]*$/", $numb)) {
                $numb_er = "Only numeric value is allowed.";
            }

            if (strlen($numb) != 10) {
                $numb_er = "Mobile no must contain 10 digits.";
            }
        }

        if (empty($_POST["lname"])) {
            $lnameErr = " * Name is required ";
        } elseif (!preg_match("/[a-zA-Z][a-zA-Z ]+/", $lname)) {
            $lnameErr = "Only alphabets and whitespace are allowed.";
        } elseif (!preg_match("~^\p{Lu}~u", $lname)) {
            $lnameErr = "* Should starts with uppercase.";
        }

        if (empty($_POST["gender"])) {
            $genderErr = "* Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }

        $query = "SELECT * FROM user_d WHERE email = '$email'";
        $result = $mysqli->query($query);
        if (empty($_POST["email"])) {
            $emailErr = "* Email is required";
        } elseif (is_numeric($email[0])) {
            $emailErr = "* Email should not start with number";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "* Email is not valid";
        }elseif ($result) {
          if (mysqli_num_rows($result) > 0) {
            $emailErr = 'found!';
         } 
       }   

        if (empty($_POST["pass"])) {
            $pass_er = "* Password is required";
        } elseif (
            !preg_match("@[A-Z]@", $pass) ||
            !preg_match("@[a-z]@", $pass) ||
            !preg_match("@[0-9]@", $pass) ||
            !preg_match("@[^\w]@", $pass) ||
            strlen($pass) < 8
        ) {
            $pass_er =
                "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        }

        if (empty($_POST["cpass"])) {
            $cpass_er = "* Confirm Password is required";
        } elseif ($_POST["cpass"] != $_POST["pass"]) {
            $cpass_er = "* Password should be match";
        }

        if (empty($_POST["departments"])) {
            $dptErr = "* departments is required";
        } else {
            $departments = implode(",", $_POST["departments"]);
        }

        if (empty($_FILES["filee"]["name"])) {
            $file_er = "* file is required";
        }

        if (
            $fnameErr == "" &&
            $lnameErr == "" &&
            $genderErr == "" &&
            $city_er == "" &&
            $numb_er == "" &&
            $dob_er == "" &&
            $pass_er == "" &&
            $emailErr == "" &&
            $dptErr == "" &&
            $cpass_er == "" &&
            $pass_m == "" &&
            $city_er == ""
        ) {
            $dir_name = "my_directory";
            $target_dir = "my_directory/";
            $target_file =
                $target_dir . basename(time() . $_FILES["filee"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image

            //Check if the directory with the name already exists
            if (!is_dir($dir_name)) {
                //Create our directory if it does not exist
                mkdir($dir_name);

                $check = getimagesize($_FILES["filee"]["tmp_name"]);
                if ($check == false) {
                    $file_er = "* file is not a image ";
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $file_er = "*Sorry, file already exists";
            }

            // Check file size
            if ($_FILES["filee"]["size"] > 500000) {
                $file_er = "Sorry, your file is too large";
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" &&
                $imageFileType != "png" &&
                $imageFileType != "jpeg" &&
                $imageFileType != "gif"
            ) {
                $file_er = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
            }

            if (
                move_uploaded_file($_FILES["filee"]["tmp_name"], $target_file)
            ) {
                // Prepare and execute the SQL statement
                $pass = md5($_POST["pass"]);
                $sql_1 =
                    "INSERT INTO user_d (email, fname, lname, pass, numb, cpass, city, gender, departments, dob, filee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = $mysqli->prepare($sql_1)) {
                    $stmt->bind_param(
                        "ssssissssss",
                        $email,
                        $fname,
                        $lname,
                        $pass,
                        $numb,
                        $cpass,
                        $city,
                        $gender,
                        $departments,
                        $dob,
                        $filee
                    );
                    if ($stmt->execute()) {
                        $success = "Data inserted successfully.";
                        $_POST = [];
                    } else {
                           

                    }
                }
            } else {
                $file_er = "* Sorry, there was an error uploading your file";
            }
        }
    }


  
    // 

    $mysqli->close();
    ?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <form class="m-36" enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars(
            $_SERVER["PHP_SELF"]
        ); ?>">

        <div class=" relative z-0 w-full mb-6 group">
            <input type="text" name="email" id="floating_email"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " value="<?php if (
                    isset($_POST["submit"]) &&
                    isset($_POST["email"])
                ) {
                    echo $email;
                } ?>" />
            <label for="floating_email"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                address</label><span class="" style="color:red;"> <?php echo $email_m .
                    $emailErr; ?></span>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <input type="password" name="pass" id="floating_password"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " value="<?php if (
                    isset($_POST["submit"]) &&
                    isset($_POST["pass"])
                ) {
                    echo $pass;
                } ?>" />
            <label for="floating_password"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label><span
                class="" style="color:red;"> <?php echo $pass_er2 .
                    $pass_er; ?></span>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <input type="password" name="cpass" id="floating_repeat_password"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " value="<?php if (
                    isset($_POST["submit"]) &&
                    isset($_POST["cpass"])
                ) {
                    echo $cpass;
                } ?>" />
            <label for="floating_repeat_password"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm
                password</label><span class="" style="color:red;"> <?php echo $cpass_er; ?></span>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="fname" id="floating_first_name"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " value="<?php if (
                        isset($_POST["submit"]) &&
                        isset($_POST["fname"])
                    ) {
                        echo $fname;
                    } ?>" />
                <label for="floating_first_name"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                    name</label><span class="" style="color:red;"> <?php echo $fnameErr; ?></span>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="lname" id="floating_last_name"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " value="<?php if (
                        isset($_POST["submit"]) &&
                        isset($_POST["lname"])
                    ) {
                        echo $lname;
                    } ?>" />
                <label for="floating_last_name"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                    name</label><span class="" style="color:red;"> <?php echo $lnameErr; ?></span>
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="number" name="numb" id="floating_phone"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " value="<?php if (
                        isset($_POST["submit"]) &&
                        isset($_POST["numb"])
                    ) {
                        echo $numb;
                    } ?>" />
                <label for="numb"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                    number (+91)</label> <span class="" style="color:red;"> <?php echo $numb_er .
                        $numb_em; ?></span>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <select id="city"
                    class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                    name="city" placeholder="Select City">
                    <option value="<?php if (
                            isset($_POST["submit"]) &&
                            isset($_POST["city"])
                        ) {
                            echo $city;
                        } ?>"><?php if (
    isset($_POST["submit"]) &&
    isset($_POST["city"])
) {
    echo $city;
} else {
    echo "Select City";
} ?></option>
                    <option value="Indore">Indore</option>
                    <option value="Bhopal">Bhopal</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Goa">Goa</option>
                </select>

                <span class="" style="color:red;"> <?php echo $city_er; ?></span>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="dob">Birthday</label>
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    type="date" id="dob" name="dob" value="<?php if (
                        isset($_POST["submit"]) &&
                        isset($_POST["dob"])
                    ) {
                        echo $dob;
                    } ?>"><span class="" style="color:red;"> <?php echo $dob_er; ?></span>
            </div>
            <div>

                <label for="gender">Gender</label>
                <ul
                    class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="gender" type="radio" value="male" name="gender"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" <?php if (
                                    isset($gender) &&
                                    $gender == "male"
                                ) {
                                    echo "checked";
                                } ?>>
                            <label for="gender"
                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="horizontal-list-radio-id" type="radio" value="female" name="gender"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" <?php if (
                                    isset($gender) &&
                                    $gender == "female"
                                ) {
                                    echo "checked";
                                } ?>>
                            <label for="female"
                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="horizontal-list-radio-millitary" type="radio" value="others" name="gender"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" <?php if (
                                    isset($gender) &&
                                    $gender == "others"
                                ) {
                                    echo "checked";
                                } ?>>
                            <label for="gender"
                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Others</label>
                        </div>
                    </li>

                </ul>
                <span class="" style="color:red;"> <?php echo $genderErr; ?></span>

            </div>

        </div>

        <fieldset class="relative z-0 w-full mb-6 group mt-6">
            <label for="checkbox-2" class="text-sm font-medium text-gray-900 dark:text-gray-300">Departments</label>
            <div class="flex items-center mb-4 mt-4">
                <input id="checkbox-2" type="checkbox" value="hindi" name="departments[]"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php if (
                        isset($_POST["departments"]) &&
                        in_array("hindi", $_POST["departments"])
                    ) {
                        echo "checked";
                    } ?>>
                <label for="checkbox-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hindi</label>
            </div>

            <div class="flex items-center mb-4">
                <input id="checkbox-3" type="checkbox" value="marathi" name="departments[]"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php if (
                        isset($_POST["departments"]) &&
                        in_array("marathi", $_POST["departments"])
                    ) {
                        echo "checked";
                    } ?>>
                <label for="checkbox-3"
                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Marathi</label>
            </div>

            <div class="flex items-center mb-4">
                <input id="checkbox-4" type="checkbox" value="english" name="departments[]"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php if (
                        isset($_POST["departments"]) &&
                        in_array("english", $_POST["departments"])
                    ) {
                        echo "checked";
                    } ?>>
                <label for="checkbox-4"
                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">English</label>
            </div>
            <p class="" style="color:red;"> <?php echo $dptErr; ?></p>
        </fieldset>

        <div class="mb-3">
            <label for="formFile" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">Default file input
                example</label>
            <input
                class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                type="file" name="filee" id="formFile" id="fileToUpload"> <span class="" style="color:red;">
                <?php echo $file_er; ?></span>
        </div>


        <p>Already have an account? <a href="login.php">Login here</a>.
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                value="submit" name="submit">Submit</button>
    </form>
</body>

</html>