<?php
session_start();
include "mydb.php";
if (isset($_SESSION["userName"])) {
    $name = $mess =  "";
    $name = $_SESSION["userName"];
    $mess = "Welcome " . $name;
} else {
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Tagesschrift&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Tagesschrift", system-ui;
            text-decoration: none;
            color: #3D0301;
        }
        body {
            background: hsla(176, 61%, 87%, 1);
            background: linear-gradient(90deg, #caf2ef 0%, #c8efdb 9%, #f2baf1 100%);
            background: -moz-linear-gradient(90deg, #caf2ef 0%, #c8efdb 9%, #f2baf1 100%);
            background: -webkit-linear-gradient(90deg, #caf2ef 0%, #c8efdb 9%, #f2baf1 100%);
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr="#CAF2EF", endColorstr="#C9EFDC", GradientType=1);
            font-family: "Tagesschrift", system-ui;

        }
        h1{
            text-align: center;
            padding: 20px 0px;
        }
        a{
            display: block;
            text-align: center;

        }
    </style>
</head>

<body>
    <br>
    <h1><?php if (isset($mess)) echo htmlspecialchars($mess, ENT_QUOTES, 'UTF-8'); ?> 
    <img src="cute.jpeg" alt="" width="100px" style="border-radius: 50%; vertical-align:middle; ">
</h1>
    <a style="color: #c8efdb ;" href="logout.php">Deconnexion</a>
</body>

</html>