<!DOCTYPE html>
<html>

<head>
    <title>List of Countries and Population</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <h1>Countries List</h1>
    <?php
    require_once("config.php");

    //pagination
    $limit = 50;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $offset = ($page - 1) * $limit;
    $totalCount = "SELECT COUNT(*) FROM countries";
    $result = mysqli_query($connection, $totalCount);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $limit);

    $sql = "SELECT * FROM countries LIMIT $offset, $limit";
    $res_data = mysqli_query($connection, $sql);
    echo " <table><tr>
         <th>Country Name</th>
         <th>Iso2</th>
         <th>Iso3</th>
         <th></th>
         </tr>";
    while ($row = mysqli_fetch_assoc($res_data)) {
        echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['iso2']}</td>
        <td>{$row['iso3']}</td>
        <td><a href='fetchPopulation?code=$row[iso3]'>View population</a></td>
        </tr>";

    }
    echo "</table>";
    mysqli_close($connection);
    ?>
     <ul class="pagination">
        <a href="?page=1"><<</a>
        <a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>"><</a>
        <a href="#" class="active"><?php echo $page?></a>
        <a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">></a>
        <a href="?page=<?php echo $total_pages; ?>">>></a>
    </ul>
</body>

</html>