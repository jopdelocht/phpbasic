<?php
session_start();
ob_end_clean();
require  'vendor/autoload.php';

/* Assignment:
Try using styling, like font names and colors
try using tables to display the data
Resize the logo
Header/footer on every page? and forced page break... do research!
Include the QR code */

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$tel = $_SESSION['tel'];
$tday_name = $_SESSION['tday_name'];
$tday_date = $_SESSION['tday_date'];
$locname = $_SESSION['locname'];

// Create a new instance of DOMPDF class and allow remote images in content !!! very important when handling images in our dompdf! 
$dompdf  =  new \Dompdf\Dompdf(array('enable_remote'  =>  true));

$options = new \Dompdf\Options();
$options->set('chroot', realpath(''));
$dompdf = new \Dompdf\Dompdf($options);
// $dompdf->loadHtml('<img src="assets/code.jpeg" alt="qrcode" style="width: 180px;">');

// Define the HTML content  
$html = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    <style>
    @page {
        margin: 0;
    }
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 18px;

    }
    .header {
        width: 100%;
        height: 300px;
        background-image: url('assets/zuidafrika.jpg');
        background-size: cover;
        background-position: center;
    }
    .h3-colored-box {
        background-color: #FF9A44; 
        padding: 20px; 
        text-align: center;
    }    
    h3 {
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        font-size: 36px;
        text-transform: uppercase;
        font-weight: 700;
    }
    h4 {
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        font-size: 20px;
    }
    .dateloc {
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        font-size: 28px;
        text-transform: uppercase;
        font-weight: 700;
    }
    p {
        text-align: center;
    }
    th {
        text-align: left;
    }
    .center-table {
        margin-left: auto;
        margin-right: auto;
        width: 65%; 
    }    
    .logo {
        text-align: center;
        margin-top: 80px;
    }
    </style>
</head>
<body>
    <div class='header'>
    </div>
    <div class='day'>
        <h3 class='h3-colored-box'>$tday_name</h3>
    </div>
    <div class='dateloc'>
        $tday_date<br>$locname
    </div>
    <br>
    <br>
    <h4>Beste $name, <br>bedankt voor uw boeking!</h4>
    <h4>Details:</h4>
    <div class='details center-table'>
        <table>
             <tr>
                <td rowspan='6'>
                <img src='assets/code.jpeg' alt='qrcode' style='width: 120px; margin-right: 20px;'>
                </td>
                <th>Themadag</th>
                <td>$tday_name</td>
            </tr>       
            <tr>
                <th>Naam</th>
                <td>$name</td>
            </tr>
            <tr>
                <th>Datum</th>
                <td>$tday_date</td>
            </tr>
            <tr>
                <th width='140px'>Locatienaam</th>
                <td>$locname</td>
            </tr>
            <tr>
                <th>E-mail</th>
                <td>$email</td>
            </tr>
            <tr>
                <th>Telefoon</th>
                <td>$tel</td>
            </tr>
        </table>
    </div>
    <div class='logo'>
        <img src='assets/logo.svg' alt='logo' style='width: 180px;'></p> 
    </div>
</body>
</html>
";
// Load the HTML content to DOMPDF
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
// generate random filename
$filename = md5(microtime()) . '_themadag.pdf';
$dompdf->stream($filename,  array("Attachment"  =>  0));
