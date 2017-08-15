<?php
$csv = array_map('str_getcsv', file('spreadsheets_schema.csv'));
shuffle($csv);
$pg = (isset($_POST['pg'])) ? intval($_POST['pg']) : 0;

$resultado = $csv[$pg];

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
<div style = "width:100%; font: 16px Georgia;">

    <div id="pageHeader" style = "background-color:#D2F8D8; width:100%; height:100px;">
        <h2>Biodiversity Spreadsheet Survey</h2>
    </div>


    <div id="pageLeft" style = "background-color:#888; height:750px; width:10%; float:left;">

    </div>

    <div id="pageCenter" style = "background-color:#F7F7F7; height:750px; width:80%; float:left;">
        <form method="post">
            <br>
            <div >
                <div style="padding: 0 0 0 10px;">
                    <p>The spreadsheet header below is usually used to register data about: <label style="color: red"> * </label></p>


                    <?php
                    foreach ($resultado as $row) {
                        echo "<div style = \"overflow-x:scroll;\">";
                        echo "<input type=\"hidden\" name=\"spread_name\" value=\"$row[0]\">";
                        echo "<br>";
                        echo "<table>";
                        echo "<tr>";
                        for ($j = 1; $j < count($row); $j++) {
                            echo "<td>" . $row[$j] . "</td>";
                        }
                        echo "</tr>";
                        echo "</table>";
                        echo "<br>";
                        echo "</div>";
                        //echo "<hr>";
                        echo "<div>";
                    }
                    ?>
                </div>
                <br>


                <hr>
                <input type="hidden" name="pg" value="<?php echo $pg;?>">
                <div style="padding: 10px">
                    <input type="submit" name="submit" value="Next">
                </div>



        </form>
    </div>
    <br>

    <br>

</div>

<div id="pageRight" style = "background-color:#888; height:750px; width:10%; float:right;">

</div>

<div id="pageFooter" style = "background-color:#D2F8D8; height:10px; clear:both">

</div>

</div>
</body>
</html>
