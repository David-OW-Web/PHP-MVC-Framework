<?php /** @var $data array */ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- On Home PC<link rel="stylesheet" href="http://localhost/MVC_Projects/MVC_News_App/News-App-Single-Language/public/styles/style.css"> -->
    <link rel="stylesheet" rel="stylesheet" href="http://localhost/mvc_projects/MVC_News_App_/News-App-Single-Language/public/styles/style.css">
    <title><?php echo $data['title']; ?></title>
</head>
<body>
<div class="wrapper">
    <?php require 'navbar.php'; ?>