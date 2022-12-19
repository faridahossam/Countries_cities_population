<?php
require_once("config.php");

$citiesPopulation = "https://countriesnow.space/api/v0.1/countries/population/cities";
$countryPopulation = "https://countriesnow.space/api/v0.1/countries/population";
$countries = "https://countriesnow.space/api/v0.1/countries/iso";
//get countries 
$data = file_get_contents($countries);
$results = json_decode($data, true);
foreach ($results['data'] as $result) {
    $name = $result['name'];
    $iso2 = $result['Iso2'];
    $iso3 = $result['Iso3'];
     //insert
        $sql = "INSERT INTO countries(name,iso2,iso3)
        VALUES('$name', '$iso2','$iso3')
        ON DUPLICATE KEY UPDATE
        name = '$name',
        iso2 = '$iso2',
        iso3 = '$iso3'";
        $response = mysqli_query($connection, $sql);
}

if (!mysqli_query($connection, $sql)) {
    die('Error : Cannot add city data:' . mysqli_error($connection));
}

//get cities population data
$population = array();
$data = file_get_contents($citiesPopulation);
$results = json_decode($data, true);
foreach ($results['data'] as $result) {
    $country = $result['country'];
    $city = $result['city'];
    $population = $result['populationCounts'];
    foreach ($population as $row) {
        $year = $row['year'];
        $value = $row['value'];
        $sex = $row['sex'];
        $reliabilty = $row['reliabilty'];
        //insert
        $sql = "INSERT INTO citiespopulation(country,city,year,value,reliabilty,sex)
        VALUES('$country', '$city','$year','$value','$reliabilty','$sex')
        ON DUPLICATE KEY UPDATE
        country = '$country',
        city = '$city',
        year = '$year',
        value ='$value',
        reliabilty = '$reliabilty',
        sex ='$sex'";
        $response = mysqli_query($connection, $sql);
    }
}

if (!mysqli_query($connection, $sql)) {
    die('Error : Cannot add city data:' . mysqli_error($connection));
}

//get countries population data
$population_array = array();
$countryData = file_get_contents($countryPopulation);
$resultsCountry = json_decode($countryData, true);
foreach ($resultsCountry['data'] as $result) {
    $country = $result['country'];
    $code = $result['code'];
    $iso3 = $result['iso3'];
    $population_array = $result['populationCounts'];
    foreach ($population_array as $row) {
        $year = $row['year'];
        $value = $row['value'];
        //insert
        $sql2 = "INSERT INTO countriespopulation(country,code,iso3,year,value)
        VALUES('$country','$code','$iso3','$year','$value')
        ON DUPLICATE KEY UPDATE
        country = '$country',
        code = '$code',
        iso3 = '$iso3',
        year = '$year',
        value ='$value'";
        $response = mysqli_query($connection, $sql2);
    }
}
if (!mysqli_query($connection, $sql2)) {
    die('Error : Cannot add country data:' . mysqli_error($connection));
}

if (!mysqli_query($connection, $sql)) {
    die('Error : Cannot add data ');
}