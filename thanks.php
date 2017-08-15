<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spreadsheet Classification Survey</title>
</head>
<style>
    td {
        padding: 7px;
        background-color: lightgray;
    }
    table {
        border: 3px solid grey;
        width: 160px;
        margin: 0px auto 0px auto;
    }
    h2 {
        text-align: center;
        vertical-align: middle;
        padding: 15px 0;
    }
</style>
<body>
<div style = "width:100%; font: 14px Georgia;">

    <div id="pageHeader" style = "background-color:#D2F8D8; width:100%; height:100px;">
        <h2>Biodiversity Spreadsheet Survey</h2>

        <br>
    </div>

    <div id="pageLeft" style = "background-color:#888; height:500px; width:10%; float:left;">

    </div>

    <div id="pageCenter" style = "background-color:#F7F7F7; height:500px; width:80%; float:left; ">
        <br>
        <h2>Your answers were saved with sucess!</h2>
        <br><br>
            <h2>Thank you for your time!</h2>
        <br><br><br><br><br><br><br><br><br><br>
        <div style="padding: 10px;text-align: center;">
        <p style="font-size: large;">Click on the "Back" button to keep classifying the spreadsheets!</p>
        <form method="post"><input type="submit" name="back" value="Back"></form></div>

        <?php
        if(@$_POST['back'])
        {
        $csv = array_map('str_getcsv', file('spreadsheets_schema.csv'));
        shuffle($csv);
        $_SESSION['csv'] = $csv;
        header('Location: survey.php'); exit();
        }

        ?>

    </div>

    <div id="pageRight" style = "background-color:#888; height:500px; width:10%; float:right;">

    </div>

    <div id="pageFooter" style = "background-color:#D2F8D8; height:10px; clear:both">

    </div>

</div>
</body>
</html>