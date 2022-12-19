<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Population List</h1>
    <?php
    require_once("config.php");
    $countryCode = isset($_GET['code']) ? $_GET['code'] : "";
    $sql = "SELECT * FROM countriespopulation WHERE code = '$countryCode'";
    $sqlName = "SELECT country FROM countriespopulation  WHERE code = '$countryCode'";
    $result = mysqli_query($connection, $sql);
    $resultName =mysqli_query($connection, $sqlName);
    $name = mysqli_fetch_assoc($resultName);
    echo "<h2 style='color:green; text-align:center'> country:$name[country]</h2>";
    echo "
         <table><tr>
         <th>year</th>
         <th>value</th>
         </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>   
        <td>{$row['year']}</td>
        <td>{$row['value']}</td>
        </tr>";
    }
    echo "</table>";
    mysqli_close($connection); ?>
</body>

</html>