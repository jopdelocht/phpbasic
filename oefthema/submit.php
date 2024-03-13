<?php session_start(); ?>
<?php include 'global.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Themadag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php
    // print_r($_POST);
    // assign values to variables from POST
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $tday_id = $_POST['tday_id'];

    // make some sessions of our posted data
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['tel'] = $tel;
    $_SESSION['tday_id'] = $tday_id;

    function saveStringToFile($name, $email, $tel, $locaties)
    {
        // open or create a new file and append to it
        $file = fopen("bookings.csv", "a");
        // provice a prefered format for the date object
        $currendate = date('Y-m-d H:i:s');
        // write to file and close... use "\r\n" for new line
        $string = $currendate . "," . $name . "," . $email . "," . $tel . "," . $locaties . "\r";
        fwrite($file, $string);
        fclose($file);
    }

    function get_tday_name($tday_id)
    {
        global $conn;
        $sql = "SELECT name FROM tdays WHERE id = $tday_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $tday_name = $row['name'];
        return $tday_name;
    }

    function get_tday_date($tday_id)
    {
        global $conn;
        $sql = "SELECT date FROM tdays WHERE id = $tday_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $tday_date = $row['date'];
        return $tday_date;
    }

    function get_locname($tday_id)
    {
        global $conn;
        $sql = "SELECT
        tdays.id,
        tdays.`name` AS themename,
        locations.`name` AS locname
        FROM tdays
        JOIN locations ON locations.id = tdays.location_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $locname = $row['locname'];
        return $locname;
    }



    saveStringToFile($name, $email, $tel, $tday_id);
    store($name, $email, $tel, $tday_id);

    // get themadag name from database based on tday_id;
    $tday_name = get_tday_name($tday_id);
    // store the themaday name in session
    $_SESSION['tday_name'] = $tday_name;
    // get themadag date from database based on tday_id;
    $tday_date = get_tday_date($tday_id);
    // store the date in session
    $_SESSION['tday_date'] = $tday_date;
    // get location name from database based on tday_id;
    $locname = get_locname($tday_id);
    // store the location name in session
    $_SESSION['locname'] = $locname;


    ?>
    <div class="container">
        <div class="row">
            <div class="col-md">

                <h1>Bedankt voor uw inschrijving, <?php echo $name; ?></h1>
                <h3>Wij verwachten u in <?php echo $tday_name; ?></h3>
                <p>Hier is de gegevens die u heeft ingevuld:</p>
                <ul>
                    <li>Naam: <?php echo $name; ?></li>
                    <li>Email: <?php echo $email; ?></li>
                    <li>Telefoon: <?php echo $tel; ?></li>
                    <li>Locatie: <?php echo $tday_name; ?></li>
                </ul>

                <a class='btn btn-primary' href="index.php">Nieuwe inschrijving</a>
                <a class='btn btn-dark' href="print.php">Inschrijving afdrukken</a>
                <a class='btn btn-danger' href="exportpdf.php">Export naar pdf</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>

</html>