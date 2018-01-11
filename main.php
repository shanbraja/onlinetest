<?php
$prefix = '';
include_once $prefix . 'db.php';
if (isset($_COOKIE["tnpsc_mobile"])) {
    $mobile_number = $_COOKIE["tnpsc_mobile"];
    $cookie = 1;
} else {
    $mobile_number = '';
    $cookie = 0;
}
if ($mobile_number) {
    
} else {
    if (isset($_SESSION['tnpsc_mobile'])) {
        $mobile_number = $_SESSION['tnpsc_mobile'];
    }else{
        $mobile_number = '';
    }
}
$day_test = $date = $count_down = '';
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="HandheldFriendly" content="true"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--This is a style sheet from w3-schools see this link for more customization http://www.w3schools.com/w3css/-->
    <link rel="stylesheet" href="w3.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
    <title>Nithra TNPSC</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link rel="shortcut icon" type="image/png" href="144.png"/>
    <style>
        .w3-theme-l5 {color:#000 !important; background-color:#e9fffd !important}
        .w3-theme-l4 {color:#000 !important; background-color:#b7fff8 !important}
        .w3-theme-l3 {color:#000 !important; background-color:#6efff1 !important}
        .w3-theme-l2 {color:#000 !important; background-color:#26ffe9 !important}
        .w3-theme-l1 {color:#fff !important; background-color:#00dcc6 !important}
        .w3-theme-d1 {color:#fff !important; background-color:#008578 !important}
        .w3-theme-d2 {color:#fff !important; background-color:#00766a !important}
        .w3-theme-d3 {color:#fff !important; background-color:#00685d !important}
        .w3-theme-d4 {color:#fff !important; background-color:#005950 !important}
        .w3-theme-d5 {color:#fff !important; background-color:#004a43 !important}

        .w3-theme-light {color:#000 !important; background-color:#e9fffd !important}
        .w3-theme-dark {color:#fff !important; background-color:#004a43 !important}
        .w3-theme-action {color:#fff !important; background-color:#004a43 !important}

        .w3-theme {color:#fff !important; background-color:#009688 !important}
        .w3-text-theme {color:#009688 !important}
        .w3-theme-border {border-color:#009688 !important}
        .w3-hover-theme:hover {color:#fff !important; background-color:#009688 !important}
        @font-face { font-family:'bamini'; src: url('http://www.nithra.mobi/bharathgcm/baamini.ttf') }
    </style>   
</head>

<body style="padding: 1%">
    <div class="w3-container">
        <a href="index.php"><img style="display: inline;margin-top: -11px" src="home.png" width="30" height="30"></a><img style="width: 200px;display: inline;margin-left: 50px;margin-right: auto; padding-bottom: 10px" src="nithra.png" class="w3-hover-opacity" alt="Nithra Edu Solutions">
        <h4 style="text-align: center;font-weight: bold">இன்றைய தேர்வு </h4>
        <?php
        $i = 0;
        $sql = "SELECT * FROM `test` where `active` = '0' and course = 'CCSE_IV_2018' and date = '$ymd' ";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error());
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $val = $i % 4;
            if ($val == 0) {
                $color = "w3-deep-orange";
            } else if ($val == 1) {
                $color = "w3-blue";
            } else if ($val == 2) {
                $color = "w3-pink";
            } else if ($val == 3) {
                $color = "w3-amber";
            }
            if ((strtotime($datetime) - strtotime($row['date'] . ' ' . $row['starttime'])) < 0) {
                $active = "in-active";
            } else {
                $active = "";
            }
            ?>
            <a href="showquiz.php?cat=<?php echo $row['testid']; ?>" style="text-decoration: none;"class="<?php
            if (!$cookie) {
                echo 'view_dash ';
            } echo $active;
            ?> w3-medium w3-center">
                <div class="w3-card-12">
                    <header class="w3-container <?php echo $color; ?>">
                        <h2 class="w3-center"><?php echo date("d M Y", strtotime($row['date'])); ?></h2>
                    </header>

                    <div class="w3-container">
                        <p class="w3-center w3-text-red"><b><?php echo $row['title']; ?></b></p>
                        <p class="w3-center"><?php echo $row['description']; ?></p>
                    </div>

                    <footer class="w3-container <?php echo $color; ?>">
                        <?php
                        $mtest = 'm' . $row['testid'];
                        $sql1 = "SELECT `rank` FROM `$mtest` where `registrationid` = '$mobile_number' LIMIT 1";
                        $result1 = mysqli_query($mysqli, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: " . mysqli_error());
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                                <h4 style="float: left" class="w3-btn w3-black"><?php echo $row1['rank']; ?></h4>
                                <h4 style="float: right" class="w3-btn w3-black">Try Now</h4>
                                <?php
                            }
                        } else {
                            ?>
                            <h4 style="text-align: center"><button class="w3-btn w3-black">Attend Now</button></h4>
                        <?php }
                        ?>
                    </footer>
                </div></a><br><br>
            <?php
            $i++;
        }
        ?>
                <h4 style="text-align: center;font-weight: bold">முந்தைய தேர்வுகள்</h4>
        <?php
        $i = 0;
        $sql = "SELECT * FROM `test` where `active` = '0' and course = 'CCSE_IV_2018' and date < '$ymd' order by date asc, starttime desc";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error());
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $val = $i % 4;
            if ($val == 0) {
                $color = "w3-blue";
            } else if ($val == 1) {
                $color = "w3-deep-orange";
            } else if ($val == 2) {
                $color = "w3-pink";
            } else if ($val == 3) {
                $color = "w3-amber";
            }
            if ((strtotime($datetime) - strtotime($row['date'] . ' ' . $row['starttime'])) < 0) {
                $active = "in-active";
            } else {
                $active = "";
            }
            ?>
            <a href="showquiz.php?cat=<?php echo $row['testid']; ?>" style="text-decoration: none;"class="<?php
            if (!$cookie) {
                echo 'view_dash ';
            } echo $active;
            ?> w3-medium w3-center">
                <div class="w3-card-12">
                    <header class="w3-container <?php echo $color; ?>">
                        <h2 class="w3-center"><?php echo date("d M Y", strtotime($row['date'])); ?></h2>
                    </header>

                    <div class="w3-container">
                        <p class="w3-center w3-text-red"><b><?php echo $row['title']; ?></b></p>
                        <p class="w3-center"><?php echo $row['description']; ?></p>
                    </div>

                    <footer class="w3-container <?php echo $color; ?>">
                        <?php
                        $mtest = 'm' . $row['testid'];
                        $sql1 = "SELECT `rank` FROM `$mtest` where `registrationid` = '$mobile_number' LIMIT 1";
                        $result1 = mysqli_query($mysqli, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: " . mysqli_error());
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                                <h4 style="float: left" class="w3-btn w3-black"><?php echo $row1['rank']; ?></h4>
                                <h4 style="float: right" class="w3-btn w3-black">Try Now</h4>
                                <?php
                            }
                        } else {
                            ?>
                            <h4 style="text-align: center"><button class="w3-btn w3-black">Attend Now</button></h4>
                        <?php }
                        ?>
                    </footer>
                </div></a><br><br>
            <?php
            $i++;
        }
        ?>
                <h4 style="text-align: center;font-weight: bold">வரவிருக்கும் தேர்வுகள்</h4>
        <?php
        $i = 0;
        $sql = "SELECT * FROM `test` where `active` = '0' and course = 'CCSE_IV_2018' and date > '$ymd' order by date asc, starttime desc";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error());
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $val = $i % 4;
            if ($val == 0) {
                $color = "w3-blue";
            } else if ($val == 1) {
                $color = "w3-deep-orange";
            } else if ($val == 2) {
                $color = "w3-pink";
            } else if ($val == 3) {
                $color = "w3-amber";
            }
            if ((strtotime($datetime) - strtotime($row['date'] . ' ' . $row['starttime'])) < 0) {
                $active = "in-active";
            } else {
                $active = "";
            }
            ?>
            <a href="showquiz.php?cat=<?php echo $row['testid']; ?>" style="text-decoration: none;"class="<?php
            if (!$cookie) {
                echo 'view_dash ';
            } echo $active;
            ?> w3-medium w3-center">
                <div class="w3-card-12">
                    <header class="w3-container <?php echo $color; ?>">
                        <h2 class="w3-center"><?php echo date("d M Y", strtotime($row['date'])); ?></h2>
                    </header>

                    <div class="w3-container">
                        <p class="w3-center w3-text-red"><b><?php echo $row['title']; ?></b></p>
                        <p class="w3-center"><?php echo $row['description']; ?></p>
                    </div>

                    <footer class="w3-container <?php echo $color; ?>">
                        <?php
                        $mtest = 'm' . $row['testid'];
                        $sql1 = "SELECT `rank` FROM `$mtest` where `registrationid` = '$mobile_number' LIMIT 1";
                        $result1 = mysqli_query($mysqli, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: " . mysqli_error());
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                                <h4 style="float: left" class="w3-btn w3-black"><?php echo $row1['rank']; ?></h4>
                                <h4 style="float: right" class="w3-btn w3-black">Try Now</h4>
                                <?php
                            }
                        } else {
                            ?>
                            <h4 style="text-align: center"><button class="w3-btn w3-black">Not Started</button></h4>
                        <?php }
                        ?>
                    </footer>
                </div></a><br><br>
            <?php
            $i++;
        }
        ?>

    </div>
// <?php include_once 'js.php'; ?>
</body>

</html>
