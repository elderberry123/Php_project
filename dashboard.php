<?php
session_start();
include "config.php";

if (isset($_COOKIE["user_email"])) {
    echo $_COOKIE["user_email"];
} elseif (isset($_SESSION["user_email"])) {
    echo $_SESSION["user_email"];
}
?>

<?php if (!empty($_COOKIE["user_email"]) or $_SESSION["user_email"]) { ?>
    <html>

    <head>
        <title>Pagination</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li> <a href="logout.php"> logout </a>
                    </li>

                </ul>
            </div>
        </nav>
        <center>
            <?php
            $per_page_record = 5; 

            if (isset($_GET["page"])) {
                $page  = $_GET["page"];
            } else {
                $page = 1;
            }

            $start_from = ($page - 1) * $per_page_record;
            $query = "SELECT * FROM user_d LIMIT $start_from, $per_page_record";
            $rs_result = mysqli_query($mysqli, $query);
            ?>

            <div class="container">
                <br>
                <div>

                    <table class="table table-striped table-bordered table-sm" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="th-sm">Id</th>
                                <th class="th-sm">Email</th>
                                <th class="th-sm">First Name </th>
                                <th class="th-sm">Last Name </th>
                                <th class="th-sm">Date of Birth</th>
                                <th class="th-sm">Number</th>
                                <th class="th-sm">City</th>
                                <th class="th-sm">Gender</th>
                                <th class="th-sm">Departments </th>
                                <th class="th-sm">File Name </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($rs_result)) {
                              
                            ?>
                                <tr>
                                    <td><?php echo $row["id"] ?></td>
                                    <td><?php echo $row["email"] ?></td>
                                    <td><?php echo $row["fname"] ?></td>
                                    <td><?php echo $row["lname"] ?></td>
                                    <td><?php echo $row["dob"] ?></td>
                                    <td><?php echo $row["numb"] ?></td>
                                    <td><?php echo $row["city"] ?></td>
                                    <td><?php echo $row["gender"] ?></td>
                                    <td><?php echo $row["departments"] ?></td>
                                    <td><?php echo $row["filee"] ?></td>

                                </tr>
                            <?php
                            };
                            ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php
                        $query = "SELECT COUNT(*) FROM user_d";
                        $rs_result = mysqli_query($mysqli, $query);
                        $row = mysqli_fetch_row($rs_result);
                        $total_records = $row[0];

                        echo "</br>";

                        $total_pages = ceil($total_records / $per_page_record);
                        $pagLink = "";

                        if ($page >= 2) {
                            echo "<a href='home.php?page=" . ($page - 1) . "'>  Prev </a>";
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                $pagLink .= "<a class = 'active' href='home.php?page="
                                    . $i . "'>" . $i . " </a>";
                            } else {
                                $pagLink .= "<a href='home.php?page=" . $i . "'>   
                                                " . $i . " </a>";
                            }
                        };
                        echo $pagLink;

                        if ($page < $total_pages) {
                            echo "<a href='home.php?page=" . ($page + 1) . "'>  Next </a>";
                        }

                        ?>
                    </div>
                    <div class="inline">
                        <input id="page" type="number" min="1" max="<?php echo $total_pages ?>" placeholder="<?php echo $page . "/" . $total_pages; ?>" required>
                        <button onClick="go2Page();">Go</button>
                    </div>
                </div>
            </div>
        </center>
        <script>
            function go2Page() {
                var page = document.getElementById("page").value;
                page = ((page > <?php echo $total_pages; ?>) ? <?php echo $total_pages; ?> : ((page < 1) ? 1 : page));
                window.location.href = 'home.php?page=' + page;
            }
        </script>
    </body>
    </html>

<?php } else {
    header("location:login.php");
}

?>
