<?php $optionErr="";

if(@$_POST['submit'])
{
    if (empty($_POST['survey_cons'])) {
        $optionErr = "* Please, choose an option.";
    } else{

        if ($_POST['survey_cons'] == 'yes') {
            header('Location: userInfo.php');
            exit();
        } else {
            header('Location: thanks.php');
            exit();
        }
    }
}?>

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
        text-decoration-color: #888;
    }
</style>
<body>
<div style = "width:100%; font-family: Georgia; font-size: 16px">

    <div id="pageHeader" style = "background-color:#D2F8D8; width:100%; height:100px; vertical-align: middle; padding: 15px 0;">
        <h2>Biodiversity Spreadsheet Survey</h2>
        <h2>Survey Information</h2>
    </div>

    <div id="pageLeft" style = "background-color:#888; height:650px; width:10%; float:left;">

    </div>


    <div id="pageCenter" style = "background-color:#F7F7F7; height:650px; width:80%; float:left;">
        <br>


    <form method="post" style='padding: 10px; text-align: justify'>

    <p> CONSENT APPLY - Resolution nº 196/96 - National Health Council of Brazil</p>

    <hr>

    <p>In Biology, there are many initiatives to promote ways to turn data accessible, interoperable, findable, and reusable. Darwin Core  - http://rs.tdwg.org/dwc/ - a body of standards built by the biodiversity informatics community , is an example of this effort</p>

    <p>The focus of this research project is on biodiversity spreadsheets, which do not fit in a standard data model as DWC.
        According to some experiments conducted by us, implicit patterns contained if such biodiversity spreadsheets can potentially be recognized and mapped to a standard data model.</p>

    <p>The goal of this survey is to validate the research cited above. Thus, you will receive some headers of biodiversity
        spreadsheets and you may choose the purpose for which the spreadsheet was designed based on its header. The answer is by multiple choices or you can textually specify one by yourself.</p>

    <p>The prerequisite to participating in this survey is to be a biology student, biologist or be in a related area.
        Your answers are anonymous and confidential, i.e., the data will store without individual identification.</p>

    <p>We know your time is valuable. This survey should take about 10 minutes to classify 15 spreadsheet headers, however you can stop the survey at any time.</p>

    <p> Your participation is voluntary, which means that you can refuse to answer any question. Your refusal will have no impairment in the relationship with the researcher or the institution
        that asked you to answer this survey. This survey will benefit the scientific knowledge related to the biodiversity spreadsheet recognition.
    </p>

    <p> Thanks in advance for your help!<p>


    <hr>


    <label><span><span></span></span>Do you want to participate of this survey?</label><br>
        <span class="error" style="color: red"><?php echo $optionErr;?></span>
    <div style="padding: 15px 0 15px 0;">
    <input type="radio" id="yes" name="survey_cons" value="yes">
    <label for="yes"><span><span></span></span>Yes</label><br>

    <input type="radio" id="no" name="survey_cons" value="no">
    <label for="no"><span><span></span></span>No</label><br>
    </div>
    <hr>

    <br>

    <input type="submit" name="submit" value="Next">
    </form>

</div>

<div id="pageRight" style = "background-color:#888; height:650px; width:10%; float:right;">

</div>

<div id="pageFooter" style = "background-color:#D2F8D8; height:10px; clear:both">

</div>

</div>
</body>
</html>
