<?php
session_start();
include "config.php";

if (isset($_COOKIE["user_email"])) {
    $var = $_COOKIE["user_email"];
} elseif (isset($_SESSION["user_email"])) {
    $var = $_SESSION["user_email"];
}
?>

<?php



$per_page_record = 5;

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
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

// Get the result...
if ($result = $mysqli->query("SELECT * FROM user_d ORDER BY $column $sort_order LIMIT $start_from, $per_page_record")) {
    // Some variables we need for the table.
    $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    $add_class = ' class="highlight"';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $search = $_POST["query"];

    $sql = "SELECT * FROM user_d  WHERE fname like '%" . $search . "%' OR lname like '%" . $search . "%'  ";

    $result = $mysqli->query($sql);
    
} 

if (!empty($_COOKIE["user_email"]) or $_SESSION["user_email"]) { ?>
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
        </div>
        <center>
            <div class="container" style="padding-top:150px;">

   
                <form action="home.php" method="post" style=" margin-bottom:50px; float: left; display:flex;">
                    <input type="text" name="query" class="form-control" value="<?php 
                if (
                    isset($_POST["submit"]) &&
                    isset($_POST["query"])
                ) {
                    echo  $search;
                } ?>"
                   />
                    <input type="submit" value="Search" class="btn btn-primary" />
                </form>
            


                <div>


                    <table class="table table-striped table-bordered table-sm" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="th-sm">Id</th>
                                <th class="th-sm">Email</th>
                                <th class="th-sm"><a href="home.php?column=fname&order=<?php echo $asc_or_desc; ?>">First Name<i style="margin: 10px;" class="fas fa-sort<?php echo $column == 'fname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="th-sm"><a href="home.php?column=lname&order=<?php echo $asc_or_desc; ?>">Last Name<i style="margin: 10px;" class="fas fa-sort<?php echo $column == 'lname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="th-sm"><a href="home.php?column=dob&order=<?php echo $asc_or_desc; ?>">Dob<i style="margin: 10px;" class="fas fa-sort<?php echo $column == 'dob' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th class="th-sm">Number</th>
                                <th class="th-sm">City</th>
                                <th class="th-sm">Gender</th>
                                <th class="th-sm">Departments </th>
                                <th class="th-sm">File Name </th>
                            </tr>
                        </thead>
                        <tbody>
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
                            <?php
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php
                        $query = "SELECT COUNT(*) FROM user_d";
                        $rs_result = mysqli_query($mysqli, $query);
                        $row = mysqli_fetch_row($rs_result);
                        $total_records = $row[0];

                        $total_pages = ceil($total_records / $per_page_record);
                        $pagLink = "";

                        if ($page >= 2) {
                            echo "<a href='home.php?page=" . ($page - 1) . "&column=$column&order=$sort_order'>Prev</a>";
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                $pagLink .= "<a class='active' href='home.php?page=$i&column=$column&order=$sort_order'>$i</a>";
                            } else {
                                $pagLink .= "<a href='home.php?page=$i&column=$column&order=$sort_order'>$i</a>";
                            }
                        }

                        echo $pagLink;

                        if ($page < $total_pages) {
                            echo "<a href='home.php?page=" . ($page + 1) . "&column=$column&order=$sort_order'>Next</a>";
                        }
                        ?>
                    </div>

                   
                </div>
            </div>
        </center>
   
    </body>

    </html>



<?php } else {
    header("location:login.php");
}

?>
