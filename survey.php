<?php
session_start();

$csv = $_SESSION['csv'];
$pg = $_SESSION['pg'];

$servername = "10.1.1.126";
$username = "user";
$password = "user";
$dbname = "biodiversity_spreadsheets";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ansErr = $typeErr = $notKnowErr = $aux = "";

$error = False;
$pg = (isset($_POST['pg'])) ? intval($_POST['pg']) : 0;
$total = 15;
$percent = ($pg/$total) * 100;

$obs = "Observations about the spreadsheet header (OPTIONAL): ";

@$spread_name=$_POST['spread_name'];
@$spread_type=(!empty($_POST['spread_type'])) ? $_POST['spread_type'] : '';

@$spread_obs=(!empty($_POST['obs'])) ? $_POST['obs'] : '';
@$answer_confidence=(!empty($_POST['confidence'])) ? $_POST['confidence'] : '';

$user_id = $_SESSION['id'];

if(@$_POST['submit']) {
   if (empty($spread_type)) {
        $typeErr = "* Please, choose an option.";
        $error = True;

    } else if (empty($answer_confidence)) {
        $ansErr = "* Please, choose an option.";
        $error = True;
    } else {

        if ($spread_type =='other'){
            $spread_type = $_POST['txt_other'];
        }else if ($spread_type == 'notKnow'){
            if ($spread_obs == ""){
                $notKnowErr  = "* Please, field required when the option above is \"Unknown spreadsheet header\".";
                $obs = "Observations about the spreadsheet header: ";
                $error = True;
            }
        }
        $s = "insert into spreadsheets_user_classification(user_id, spreadsheet_name,user_classification,notes,confidence_level) values('$user_id','$spread_name','$spread_type','$spread_obs','$answer_confidence')";

        if ($conn->query($s) === FALSE) {
            echo "Error: " . $s . "<br>" . $conn->error;
        }

        $conn->close();

        if(!$error){
           $pg = $pg + 1;
        }

        $spread_type = "";
        $spread_obs = "";
        $answer_confidence = "";

        if($pg == 15){
            header('Location: thanks.php'); exit();
        }
    }
}
if(@$_POST['finish'])
{
    header('Location: thanks.php'); exit();
}

if(@$_POST['back'])
{
    header('Location: userInfo.php'); exit();
}


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
    .outter{
        height: 10px;
        width: 100%;
        border:solid 1px #000;
    }
    .inner{
        height: 10px;
        width: <?php echo $percent ?>%;
        border-right: solid 1px #000;
        background: -moz-linear-gradient(top, #005700 -1%, #b4ddb4 0%, #005700 0%, #83c783 13%, #52b152 34%, #008a00 48%, #005700 68%, #005700 68%, #002400 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #005700 -1%,#b4ddb4 0%,#005700 0%,#83c783 13%,#52b152 34%,#008a00 48%,#005700 68%,#005700 68%,#002400 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #005700 -1%,#b4ddb4 0%,#005700 0%,#83c783 13%,#52b152 34%,#008a00 48%,#005700 68%,#005700 68%,#002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#005700', endColorstr='#002400',GradientType=0 ); /* IE6-9 */
    }
</style>
<body>
<div style = "width:100%; font: 16px Georgia;">

    <div id="pageHeader" style = "background-color:#D2F8D8; width:100%; height:100px;">
        <h2>Biodiversity Spreadsheet Survey</h2>
         <label style="padding-left: 10px;">Classified Spreadsheets: <?php echo $pg ?> of 15</label>
    </div>
    <div class="outter">
        <div class="inner"></div>
    </div>

        <div id="pageLeft" style = "background-color:#888; height:750px; width:10%; float:left;">

        </div>

        <div id="pageCenter" style = "background-color:#F7F7F7; height:750px; width:80%; float:left;">
            <form method="post">
        <br>
                <div >
                    <div style="padding: 0 0 0 10px;">
                    <label style="color: red">Fields Required *</label>
                    <p>The spreadsheet header below is usually used to register data about: <label style="color: red"> * </label></p>


                    <?php
                    $qtde = 1;
                    $atual = $pg;
                    $pagArquivo = array_chunk($csv, $qtde);
                    $contar = count($pagArquivo);
                    $resultado = $pagArquivo[$atual];

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
                    <span class="error" style="color: red"><?php echo $typeErr;?></span>
                    <div style="padding: 5px;">
                    <input type="radio" id="spMonitoring" name="spread_type" value="spMonitoring" <?php echo ($spread_type == "spMonitoring") ? "checked" : null; ?>>
                        <label for="spMonitoring"><span><span></span></span>Species Monitoring</label><span><span> </span></span>
                        <img src="duvida.jpg" width="1%" title="Data collected over time in order to understand the impacts of changes on the status of a set of living organisms."/>
                    </div>
                    <div style="padding: 5px;">
                    <input type="radio" id="spOccurrence" name="spread_type" value="spOccurrence" <?php echo ($spread_type == "spOccurrence") ? "checked" : null; ?>>
                    <label for="spOccurrence"><span><span></span></span>Species Occurrence</label><span><span> </span></span>
                        <img src="duvida.jpg" alt="HTML5 Icon" width="1%" title="Data about a specimen observation in nature."/>
                    </div>
                    <div style="padding: 5px;">
                    <input type="radio" id="taxonIdentification" name="spread_type" value="taxonIdentification" <?php echo ($spread_type == "taxonIdentification") ? "checked" : null; ?>>
                    <label for="taxonIdentification"><span><span></span></span>Species Catalog</label><span><span> </span></span>
                        <img src="duvida.jpg" alt="HTML5 Icon" width="1%" title="Data about a specimen registered in a museum or collection."/>
                    </div>
                    <div style="padding: 5px;">
                    <input type="radio" id="expObservation" name="spread_type" value="expObservation" <?php echo ($spread_type == "expObservation") ? "checked" : null; ?>>
                    <label for="expObservation"><span><span></span></span>Experimental Observation</label><span><span> </span></span>
                        <img src="duvida.jpg" alt="HTML5 Icon" width="1%" title="Data obtained by some experimental method under controlled or non-controlled conditions, usually applying treatments to a group and recording the effects."/>
                    </div>
                    <div style="padding: 5px;">
                    <input type="radio" id="geneData" name="spread_type" value="geneData" <?php echo ($spread_type == "geneData") ? "checked" : null; ?>>
                    <label for="geneData"><span><span></span></span>Genetic Data</label><span><span> </span></span>
                        <img src="duvida.jpg" title="Data of  genes, genetic variation, and heredity in living organisms." width="1%"/>
                    </div>
                    <div style="padding: 5px;">
                    <input type="radio" id="other" name="spread_type" value="other" <?php echo ($spread_type == "other") ? "checked" : null; ?>>
                    <label for="other"><span><span></span></span>Other: </label><input type="text" name="txt_other" size='50'>
                    </div>
                    <div style="padding: 5px;">
                    <input type="radio" id="notKnow" name="spread_type" value="notKnow" <?php echo ($spread_type == "notKnow") ? "checked" : null; ?>>
                    <label for="notKnow"><span><span></span></span>Unknown spreadsheet header</label>
                    </div>
                    </div>
                    <hr>
                    <div style="padding: 10px">
                    <label for="confidence">In a range of 1 to 3, what is your confidence in your choice?: <label style="color: red"> * </label><br>
                    (1 I am not sure  -  3 I am totally sure) </label></div>
                    <span class="error" style="color: red"><?php echo $ansErr;?></span>
                    <div style="padding: 0px 15px 0px 18px;">
                        <input type="radio" id="confidence1" name="confidence" value="1" <?php echo ($answer_confidence == "1") ? "checked" : null; ?>>
                    <label for="confidence1">1</label>
                        <input type="radio" id="confidence2" name="confidence" value="2" <?php echo ($answer_confidence == "2") ? "checked" : null; ?>>
                    <label for="confidence2">2</label>
                        <input type="radio" id="confidence3" name="confidence" value="3" <?php echo ($answer_confidence == "3") ? "checked" : null; ?>>
                    <label for="confidence3">3</label>

                    </div>

                    <hr>
                    <div style="padding: 10px;">
                        <label for="obs"><span><span></span></span><?php echo $obs;?></label><span class="error" style="color: red"><?php echo $notKnowErr;?></span></div>

                    <div style="padding: 0 0 0 10px;">
                    <textarea rows="4" cols="70" name="obs"></textarea>
                    </div>
                    <hr>
                    <input type="hidden" name="pg" value="<?php echo $pg;?>">
                    <div style="padding: 10px">
                        <input type="submit" name="submit" value="Next">

                        <div style="padding: 10px; float: right">
                            <input type="submit" name="finish" value="Finish">
                        </div>
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
