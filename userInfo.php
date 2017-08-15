<?php
    session_start();

    $optionErr = $countryErr = $profileErr = $researchErr = $frequencyErr = "";

    $csv = array_map('str_getcsv', file('spreadsheets_schema.csv'));
    shuffle($csv);

    $pg = 0;

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

        @$user_country = (!empty($_POST['country'])) ? $_POST['country'] : '';
        @$user_profile=(!empty($_POST['role'])) ? $_POST['role'] : '';
        @$user_research_field=(!empty($_POST['researchF'])) ? $_POST['researchF'] : '';
        @$user_keyword=(!empty($_POST['keywords'])) ? $_POST['keywords'] : '';
        @$user_expertise=(!empty($_POST['expertise'])) ? $_POST['expertise'] : '';
        @$frequency=(!empty($_POST['frequency'])) ? $_POST['frequency'] : '';

        if(@$_POST['submit'])
        {
            if(empty($user_country)){
                $countryErr = "* Please, field required.";
            }else if(empty($user_profile)){
                $profileErr = "* Please, field required.";
            }else if(empty($user_research_field)){
                $researchErr = "* Please, field required.";
            }else if(empty($user_expertise)){
                $optionErr = "* Please, choose an option.";
            }else if(empty($frequency)){
                $frequencyErr = "* Please, choose an option.";

            }else {
                $id = uniqid();
                $_SESSION['id'] = $id;
                $_SESSION['csv'] = $csv;
                $_SESSION['pg'] = $pg;


                $s = "insert into spreadsheets_user_information(id, user_country,user_role,user_expertise,user_keywords,user_expertise_level,frequency_use_spreadsheet) values('$id','$user_country','$user_profile','$user_research_field','$user_keyword','$user_expertise','$frequency')";

                if ($conn->query($s) === FALSE) {
                    echo "Error: " . $s . "<br>" . $conn->error;
                }

                $conn->close();

                header('Location: survey.php');

                exit();
            }
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
</style>
<body>
<div style = "width:100%; font: 16px Georgia;">

    <div id="pageHeader" style = "background-color:#D2F8D8; width:100%; height:100px;">
        <h2>Biodiversity Spreadsheet Survey</h2>

    </div>

    <div id="pageLeft" style = "background-color:#888; height:700px; width:10%; float:left;">

    </div>

    <div id="pageCenter" style = "background-color:#F7F7F7; height:700px; width:80%; float:left;">
        <br>
        <form method="post">
            <div style="padding: 10px; color: red"><label>Fields Required *</label></div>
         <div style="padding: 10px"><label for="country"><span><span></span></span>What is your country? <label style="color: red"> * </label></label></div>
            <span class="error" style="color: red"><?php echo $countryErr;?></span>
            <div style="padding: 10px"><input type="text" name="country" size="50" value="<?php echo $user_country ?>"/><br></div>
            <hr>
        <div style="padding: 10px"><label for="role"><span><span></span></span>What is your main activity? <label style="color: red"> * </label></label></div>
             <span class="error" style="color: red"><?php echo $profileErr;?></span>
            <div style="padding: 10px"><input type="text" name="role" size="50" value="<?php echo $user_profile ?>"/><br></div>
            <hr>
        <div style="padding: 10px"><label for="researchF"><span><span></span></span>What is your expertise? <label style="color: red"> * </label></label></div>
                <span class="error" style="color: red"><?php echo $researchErr;?></span>
            <div style="padding: 10px"><input type="text" name="researchF" size="50" value="<?php echo $user_research_field ?>"/><br></div>
            <hr>
        <div style="padding: 10px"><label for="keywords"><span><span></span></span>What are the three keywords (separated by comma) that best characterize your expertise? </label>
        </div><div style="padding: 10px"><input type="text" name="keywords" size="50" value="<?php echo $user_keyword ?>"/><br></div>
            <hr>
            <div style="padding: 10px"><label for="expertise"><span><span></span></span>In a range of 1 to 3, do you consider yourself as an expert in biodiversity area? <label style="color: red"> * </label><br>
                    (1 if you know nothing about biodiversity area  -  3 if you are an expert)
                </label></div>
            <span class="error" style="color: red"><?php echo $optionErr;?></span>
            <div style="padding: 0px 15px 0px 18px;">
                <input type="radio" id="expertise1" name="expertise" value="1" <?php echo ($user_expertise == "1") ? "checked" : null; ?>>
                <label for="expertise1">1</label>
                <input type="radio" id="expertise2" name="expertise" value="2" <?php echo ($user_expertise == "2") ? "checked" : null; ?>>
                <label for="expertise2">2</label>
                <input type="radio" id="expertise3" name="expertise" value="3" <?php echo ($user_expertise == "3") ? "checked" : null; ?>>
                <label for="expertise3"> 3</label>

            </div>
            <hr>
            <div style="padding: 10px"><label for="frequency"><span><span></span></span>How often you use spreadsheets (like excel) in your activities?<label style="color: red"> * </label></label>
            </div><div style="padding: 10px">
                <input list="frequecy" name="frequency">
                <span class="error" style="color: red"><?php echo $frequencyErr;?></span>
                <datalist id="frequecy">
                    <option value="always">
                    <option value="usually">
                    <option value="often">
                    <option value="sometimes">
                    <option value="never">
                </datalist>
                <br></div>
            <hr>

            <div style="padding: 10px"><input type="submit" name="submit" value="Next"></div>

        </form>
        <br>


    </div>

    <div id="pageRight" style = "background-color:#888; height:700px; width:10%; float:right;">

    </div>

    <div id="pageFooter" style = "background-color:#D2F8D8; height:10px; clear:both">

    </div>

</div>
</body>
</html>
