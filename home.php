<?php

session_start();
include "config.php";

if (isset($_COOKIE["user_email"])) {
    $var = $_COOKIE["user_email"];
} elseif (isset($_SESSION["user_email"])) {
    $var = $_SESSION["user_email"];
}

if (!empty($_COOKIE["user_email"]) or $_SESSION["user_email"]) {

    $search =  $q = $link = '';

    $error = "";
    $success = "";
    $success_data = "";
    $per_page_record = 5;

    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $start_from = ($page - 1) * $per_page_record;
    $columns = array('id', 'fname', 'lname', 'dob');

    if (isset($_GET['column']) && in_array($_GET['column'], $columns)) {
        $column = $_GET['column'];
    } else {
        $column = $columns[0];
    }

    if (isset($_GET['order']) && strtolower($_GET['order']) == 'desc') {
        $sort_order = 'DESC';
    } else {
        $sort_order = 'ASC';
    }

    if (isset($_GET['query'])) {

        $search = $_GET["query"];
        $q = "WHERE fname LIKE '%" . $search . "%' OR lname LIKE '%" . $search . "%'";
        $link = "&query=";
    }


    if ($result = $mysqli->query("SELECT * FROM user_d $q ORDER BY " . $column . " " . $sort_order . " LIMIT " . $start_from . ", " . $per_page_record)) {

        $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
        $add_class = ' class="highlight"';
    }



   
    function csv_file($mysqli)
    {

        $select = "SELECT * FROM `user_d` ";
        $result_1 = $mysqli->query($select);

        if ($result_1->num_rows > 0) {
            $separator = ",";
            $filename = "Users_" . date('Y-m-d') . ".csv";
            // Set header content-type to CSV and filename
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');

            //set CSV column headers
            $fields = array('email', 'fname', 'lname', 'pass', 'numb', 'cpass', 'city', 'gender', 'departments', 'dob', 'filee');
            fputcsv($output, $fields, $separator);


            while ($row_1 = $result_1->fetch_object()) {

                $lineData = array($row_1->email, $row_1->fname, $row_1->lname, $row_1->pass, $row_1->numb, $row_1->cpass, $row_1->city, $row_1->gender, $row_1->departments, $row_1->dob, $row_1->filee);
                fputcsv($output, $lineData, $separator);
            }

            fclose($output);
            exit();
        }
    }

    if (isset($_GET['hello'])) {
        csv_file($mysqli);
    }

    // if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_FILES["upload_csv"]["error"] == 4) {
            $error .= "<li>Please select csv file to upload.</li>";
        } else {
            $file_path = pathinfo($_FILES['upload_csv']['name']);
            $file_ext = $file_path['extension'];
            $file_tmp = $_FILES['upload_csv']['tmp_name'];
            $file_size = $_FILES['upload_csv']['size'];
            
            if ($file_ext != "csv") {
                $error .= "<li>Sorry, only csv file format is allowed.</li>";
            }
        }
    
        if (empty($error)) {
      

            $file = fopen($file_tmp, "r");
            fgetcsv($file);
       
            while (($row_2 = fgetcsv($file)) !== FALSE) {
             
                $orgDate = $row_2[9];
                $newDate = date("Y-m-d", strtotime($orgDate));
            
                $sql_1 = "INSERT INTO user_d (email, fname, lname, pass, numb, cpass, city, gender, departments, dob, filee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
                if ($stmt = $mysqli->prepare($sql_1)) {
                    $stmt->bind_param(
                        "ssssissssss",
                        $row_2[0],
                        $row_2[1],
                        $row_2[2],
                        $row_2[3],
                        $row_2[4],
                        $row_2[5],
                        $row_2[6],
                        $row_2[7],
                        $row_2[8],
                        $newDate,
                        $row_2[10]
                    );
                    if ($stmt->execute()) {
                    
                        $success_data ="<li>" . $row_2[0] . " " . $row_2[1] . "</li>";
                       
                    }else{
                       echo  "<li>" . $row_2[0] . "</li>";
                         
                    }
                }
                 }  
            
        }
    }
 

?>


    <html>

    <head>
        <title>Pagination</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />

        <style>
            .pagination {
                display: inline-block;
            }

            .pagination a {
                font-weight: bold;
                font-size: 18px;
                color: black;
                float: left;
                padding: 8px 16px;
                text-decoration: none;
                border: 1px solid black;
            }

            .pagination a.active {
                background-color: pink;
            }

            .pagination a:hover:not(.active) {
                background-color: skyblue;
            }
        </style>

    </head>

    <body>
        <nav class="navbar">
            <div class="navbar-container container">
                <input type="checkbox" name="" id="">
                <div class="hamburger-lines">
                    <span class="line line1"></span>
                    <span class="line line2"></span>
                    <span class="line line3"></span>
                </div>
                <ul class="menu-items">
                    <li><a href="logout.php">
                            <h4 class="btn btn-primary ">Logout</h2>
                        </a></li>
                </ul>
                <center>
                    <h3 class="logo"><?php echo $var; ?></h1>
                </center>
            </div>
        </nav>
        <div class="container" style="padding-top:150px; ">
            <div>
                <form action="home.php" method="GET" style=" margin-bottom:50px; float: left; display:flex;">
                    <input type="text" name="query" class="form-control" value="<?php
                                                                                echo $search;
                                                                                ?>" />
                    <input type="submit" value="Search" class="btn btn-primary" />
                </form>
                <a class="btn btn-primary" style="margin-left:10px;" href='home.php'>Reset</a>
                <a class="btn btn-primary" href='home.php?hello=true'>Download CSV File</a>
            </div>
            <div style="margin:50px; ">
                <form method="post" action="" enctype="multipart/form-data" style="float: left; display:flex;">
                    <input type="file" class="form-control" style="width: 250px;" name="upload_csv" />
                    <input type="submit" class="btn btn-primary" value="Upload CSV Data" />

                </form>
                <br>
                <br>
                <p style=""><?php echo   $success_data. $error;?></p>
                <br>
            </div>

            <div>
                <table class="table table-striped table-bordered table-sm" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">Id</th>
                            <th class="th-sm">Email</th>
                            <th class="th-sm"><a href="home.php?column=fname&order=<?php echo $asc_or_desc; ?><?php echo !empty($search) ? '&query=' . $search : ''; ?>">First Name<i style="margin: 10px;" class="fas fa-sort<?php echo $column == 'fname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                            <th class="th-sm"><a href="home.php?column=lname&order=<?php echo $asc_or_desc; ?><?php echo !empty($search) ? '&query=' . $search : ''; ?>">Last Name<i style="margin: 10px;" class="fas fa-sort<?php echo $column == 'lname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                            <th class="th-sm"><a href="home.php?column=dob&order=<?php echo $asc_or_desc; ?><?php echo !empty($search) ? '&query=' . $search : ''; ?>">Dob<i style="margin: 10px;" class="fas fa-sort<?php echo $column == 'dob' ? '-' . $up_or_down : ''; ?>"></i></a></th>

                            <th class="th-sm">Number</th>
                            <th class="th-sm">City</th>
                            <th class="th-sm">Gender</th>
                            <th class="th-sm">Departments </th>
                            <th class="th-sm">File Name </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0) { ?>
                            <?php
                            while ($row = $result->fetch_assoc()) :

                            ?>
                                <tr>
                                    <td<?php echo $column == 'id' ? $add_class : ''; ?>><?php echo $row['id']; ?></td>
                                        <td><?php echo $row["email"] ?></td>
                                        <td<?php echo $column == 'fname' ? $add_class : ''; ?>><?php echo $row['fname']; ?></td>
                                            <td<?php echo $column == 'lname' ? $add_class : ''; ?>><?php echo $row['lname']; ?></td>
                                                <td<?php echo $column == 'dob' ? $add_class : ''; ?>><?php echo $row['dob']; ?></td>
                                                    <td><?php echo $row["numb"] ?></td>
                                                    <td><?php echo $row["city"] ?></td>
                                                    <td><?php echo $row["gender"] ?></td>
                                                    <td><?php echo $row["departments"] ?></td>
                                                    <td><img src="my_directory/<?php echo $row["filee"] ?>" height="40px" width="40px"></td>
                                </tr>

                            <?php endwhile; ?>
                        <?php } else {
                        ?>
                            <tr>
                                <td colspan="10">
                                    <center>NO Data Found</center>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <center>
                    <div class="pagination">
                        <?php
                        $query = "SELECT COUNT(*) FROM user_d $q";
                        $rs_result = mysqli_query($mysqli, $query);
                        $row = mysqli_fetch_row($rs_result);
                        $total_records = $row[0];

                        $total_pages = ceil($total_records / $per_page_record);
                        $pagLink = "";

                        if ($page >= 2) {
                            echo "<a href='home.php?page=" . ($page - 1) . "$link$search&column=$column&order=$sort_order'>Prev</a>";
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                $pagLink .= "<a class='active' href='home.php?page=$i$link$search&column=$column&order=$sort_order'>$i</a>";
                            } else {
                                $pagLink .= "<a href='home.php?page=$i$link$search&column=$column&order=$sort_order'>$i</a>";
                            }
                        }

                        echo $pagLink;

                        if ($page < $total_pages) {
                            echo "<a href='home.php?page=" . ($page + 1) . " $link$search&column=$column&order=$sort_order'>Next</a>";
                        }
                        ?>
                    </div>
                </center>
            </div>
        </div>
    </body>

    </html>
<?php
    exit();
} else {
    header("location:login.php");
} ?>
