<?php
	require('connectdb.php');
	require_once("inc/functions.php");


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>

	<style type="text/css">
		.section{
    margin: 0px;
    margin-top: 20px;
}
.main_title{    
    font-size: 16px;
}
.box{
    padding: 10px 15px;
}
.box:first-child{
    border-top-left-radius:5px;
    border-bottom-left-radius:5px;
}
.box:last-child {
    border-top-right-radius:5px;
    border-bottom-right-radius:5px;
}
.boxtwo-img{
    width: 150px;
    height: 150px;
}
#example_wrapper{
    width: 100%;
}

.form-group.logouplodicon {
    margin-top: 10px;
    margin-bottom: 10px;
}
	</style>