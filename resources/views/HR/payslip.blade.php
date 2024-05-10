<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="stylesheet" type="text/css" href="report/style.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>

</style>
</head>
<body>
<!-- <div class="container-fluid" style="-250px;"> -->

<?php $slvlhrs = 0 ?>
<?php $ot = 0 ?>
<?php $offset = 0 ?>
<?php $nightdif = 0 ?>
<?php $late = 0 ?>

<?php $totalearnings = 0 ?>
<?php $totalcontri= 0 ?>
<?php $totaldeduc = 0 ?>

<?php $basic= 0 ?>
<?php $basicpay = 0 ?>


<?php $net = 0 ?>

@foreach ($payslip as $data)

<?php

if ($data->basic_pay > 0 && $data->department != "Logistics and Warehouse Department") {
    $basic = $data->days - $data->slvl_hrs - $data->holiday_hrs - $data->offdays;
    $basicpay = $data->pay_rate * $basic;
    $basichrs = $basicpay / (($basicpay / $basic) / 8);
    $basicdays = $basichrs / 8;
    
} elseif ($data->basic_pay > 0 && $data->department == "Logistics and Warehouse Department") {
    $basic = $data->days - $data->slvl_hrs - $data->holiday_hrs - $data->offdays;
    $basicpay = $data->pertrip_amount;
    $basichrs = $data->per_trip;
    $basicdays = $data->per_trip;
}else{
    $basic = 0;
    $basicpay = 0;
    $basichrs = 0;
    $basicdays = 0;
}
?>



<!--=========================================================
 HEADER
=========================================================-->

<div style="position:absolute;top:-0.30in;left:3.40in;width:5.57in;line-height:0.20in;"><span style="font-style:normal;font-weight:bold;font-size:8pt;font-family:Arial Narrow;color:#101010">ELJIN CORP</span><span style="font-style:normal;font-weight:bold;font-size:14pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:-0.15in;left:2.80in;width:5.57in;line-height:0.16in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#101010">Zone 2 Sta Rosa Road, Sitio Bana, Tarlac City</span><span style="font-style:normal;font-weight:normal;font-size:11pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.02in;left:-0.3in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">EMPLOYEE NAME:<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.02in;left:0.60in;width:1.80in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->employee_name}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:-0.3in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">DEPARTMENT:<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:0.60in;width:1.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->department}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.02in;left:2.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">JOB STATUS:<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.02in;left:2.62in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->job_status}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:2.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">RANK FILE:<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:2.62in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->rank_file}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.02in;left:3.22in;width:1.00in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">PAY RATE:<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.02in;left:3.72in;width:1.00in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->pay_rate, 2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:3.22in;width:1.00in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">POSITION:<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:3.72in;width:1.00in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->job_title}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.02in;left:5.20in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">NO OF DAYS :<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.02in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->days}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:5.20in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">DATE PERIOD : <span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.11in;left:6.00in;width:1.50in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->month}}-{{$data->year}} / {{$data->period}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<!--=========================================================
TABLE HEADER
=========================================================-->
<div style="position:absolute;top:0.33in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">EARNINGS<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">--<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">HOUR(S)<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:1.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">DAY(S)<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">AMOUNT<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">DEDUCTIONS<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">AMOUNT<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">CONTRIBUTIONS<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.33in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000">AMOUNT<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<!--=========================================================
EARNINGS
=========================================================-->

<div style="position:absolute;top:0.53in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">BASIC PAY<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.53in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->pay_rate, 2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<!-- <div style="position:absolute;top:0.53in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo $basichrs?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div> -->
<div style="position:absolute;top:0.53in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">-<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.53in;left:1.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo $basicdays?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.53in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($basicpay, 2)?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>


<!-- OFFDAYS -->
<div style="position:absolute;top:0.65in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">RESTDAYS<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.65in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format(($data->pay_rate / 8) * 1.30 * ($data->offdays * 8), 2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<!-- <div style="position:absolute;top:0.65in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->offdays * 8}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div> -->
<div style="position:absolute;top:0.65in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">-<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.65in;left:1.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{($data->offdays * 8) / 8}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.65in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->offdays_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<!-- HOLIDAY -->
<?php 
if ($data->basic_pay > 0 && $data->department != "Logistics and Warehouse Department") {
    $holidayhrs= 0;
    $holidayhrs =  ($data->holiday_amount / $data->pay_rate) * 8; 

    if($data->holiday_hrs != 0){
        $ADholidays = $data->holiday_amount / $data->holiday_hrs;
    }else{
        $ADholidays = 0;
    }
}else{
    $holidayhrs= 0;
    $holidayhrs =  0; 

    if($data->holiday_hrs != 0){
        $ADholidays = 0;
    }else{
        $ADholidays = 0;
    }
}

?>
<div style="position:absolute;top:0.78in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">HOLIDAY<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.78in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($ADholidays,2) ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<!-- <div style="position:absolute;top:0.78in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo $holidayhrs ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div> -->
<div style="position:absolute;top:0.78in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">-<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.78in;left:1.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->holiday_hrs}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.78in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->holiday_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<!-- SLVL -->
<?php 

if ($data->basic_pay > 0 && $data->department != "Logistics and Warehouse Department") {
    $slvlhrs= 0;
    $slvlhrs =  ($data->slvl_amount / $data->pay_rate) * 8; 

    if($data->slvl_hrs != 0){
        $ADslvl = $data->pay_rate / $data->slvl_amount;
    }else{
        $ADslvl = 0;
    }
}else{
    $slvlhrs= 0;
    $slvlhrs =  0; 

    if($data->slvl_hrs != 0){
        $ADslvl = 0;
    }else{
        $ADslvl = 0;
    }
}

?>
<div style="position:absolute;top:0.91in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">SLVL<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.91in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->pay_rate * 1,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<!-- <div style="position:absolute;top:0.91in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo $slvlhrs ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div> -->
<div style="position:absolute;top:0.91in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">-<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.91in;left:1.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo $ADslvl ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.91in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->slvl_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>


<!-- OVERTIME -->
<?php 
if ($data->basic_pay > 0 && $data->department != "Logistics and Warehouse Department") {
    $overtimehrs= 0;
    $overtimehrs =  ($data->slvl_amount / $data->pay_rate) * 8; 

    if($data->ot_hrs != 0){
        $ADovertime = ($data->pay_rate / 8) * 1.25 * 1;
    }else{
        $ADovertime = 0;
    }
}else{
    $overtimehrs= 0;
    $overtimehrs =  0; 

    if($data->ot_hrs != 0){
        $ADovertime = 0;
    }else{
        $ADovertime = 0;
    }
}


?>  
<div style="position:absolute;top:1.04in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">OVERTIME<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#normal000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.04in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($ADovertime,2)?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<?php if($data->ot_hrs == "")
{?>
<?php }else{ ?>
<div style="position:absolute;top:1.04in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->ot_hrs}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<?php } ?>
<?php if($data->ot_amount == "")
{?>
<?php }else{ ?>
<div style="position:absolute;top:1.04in;left:1.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><hr style="width:20px !important; margin-left:-6px !important;"><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.04in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->ot_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<?php } ?>

<!-- NIGHTDIF -->
<?php 
    $nodays = $basicdays + (($data->offdays * 8) / 8) + $data->holiday_hrs + $ADslvl;
?>  
<div style="position:absolute;top:1.17in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">NIGHTDIF<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.17in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->nightdif_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.17in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->nightdif}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.10in;left:1.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo $nodays ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.17in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->nightdif_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>


<!-- LATE -->
<div style="position:absolute;top:1.30in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">LATE<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.30in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->late_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.30in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->minutes_late}} min<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.30in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->late_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<!-- UDT -->
<div style="position:absolute;top:1.43in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">UDT/HDY<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.43in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->udt_amount * -1,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.43in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->udt_hrs * -1}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.43in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->udt_amount * -1,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<!-- CTLATE -->
<div style="position:absolute;top:1.56in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">CTLATE<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.56in;left:0.31in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->ctlate_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.56in;left:0.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{$data->ctlate}} min<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.56in;left:1.70in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->ctlate_amount,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>



<!--=========================================================
DEDUCTIONS
=========================================================-->    
<div style="position:absolute;top:0.53in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">UNIFORM<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.53in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->uniform,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.65in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">ADVANCE<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.65in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->advance,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.78in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">BOND DEPOSIT<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.78in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->bond_deposit,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.91in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">CHARGE<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.91in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->charge,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:1.04in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">MISC<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.04in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->misc,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:1.17in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">MEAL<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.17in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->meal,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:1.30in;left:2.58in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">MUTUAL CHARGE<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.30in;left:3.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->mutual_charge,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>



<!--=========================================================
BENEFITS
=========================================================-->
<div style="position:absolute;top:0.53in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">SSS LOAN<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.53in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->sss_loan,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.65in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">PHILHEALTH<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.65in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->philhealth,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.78in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">SSS PREM<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.78in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->sss_prem,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.91in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">MUTUAL LOAN<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.91in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->mutual_loan,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:1.04in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">PAGIBIG LOAN<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.04in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->pag_ibig_loan,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:1.17in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">PAGIBIG PREM<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.17in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->pag_ibig_prem,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:1.30in;left:5.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">MUTUAL SHARE<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.30in;left:6.00in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">{{number_format($data->mutual_share,2)}}<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>






<?php $totalcontri = $data->sss_loan + $data->sss_prem + $data->pag_ibig_loan + $data->pag_ibig_prem + $data->philhealth + $data->mutual_loan + $data->mutual_share ?>
<?php $totaldeduc = $data->advance + $data->charge + $data->uniform + $data->bond_deposit + $data->meal + $data->misc + $data->mutual_charge ?>
<?php $totalearnings = ($basicpay + $data->ot_amount + $data->holiday_amount + $data->nightdif_amount + $data->offdays_amount + $data->slvl_amount + $data->late_amount + $data->ctlate_amount + ($data->udt_amount * -1))?>
<?php $otherdeduc = $data->late_amount + $data->ctlate_amount + ($data->udt_amount * -1) ?>
<?php $net = $totalearnings - ($otherdeduc + $totalcontri + $totaldeduc) ?>
<div style="position:absolute;top:1.74in;left:-0.25in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">GROSS EARNINGS : <span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:0.55in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($totalearnings,2) ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:1.10in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">RETRO : <span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:1.45in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">0.00<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:1.90in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">OTHER DEDUCTIONS : <span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:2.80in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($otherdeduc,2) ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:3.20in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">TOTAL DEDUCTIONS : <span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:4.10in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($totaldeduc,2) ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:4.55in;width:1.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">TOTAL CONTRIBUTIONS : <span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:5.60in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($totalcontri,2) ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:6.20in;width:1.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">NET PAY : <span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.74in;left:6.63in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000"><?php echo number_format($net,2) ?><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:0.25in;left:-0.32in;width:7.95in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000"><hr><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:0.45in;left:-0.32in;width:7.95in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000"><hr><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.66in;left:-0.32in;width:7.95in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000"><hr><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:1.86in;left:-0.32in;width:7.95in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000"><hr><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

<div style="position:absolute;top:2.12in;left:6.30in;width:0.90in;line-height:0.13in;"><span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:Arial Narrow;color:#000000">SIGNATURE<span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>
<div style="position:absolute;top:2.06in;left:5.63in;width:1.80in;line-height:0.13in;"><span style="font-style:normal;font-weight:bold;font-size:6pt;font-family:Arial Narrow;color:#000000"><hr><span style="font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial Narrow;color:#000000"> </span><br/></SPAN></div>

@endforeach


<script type="text/javascript">

$(document).ready(function () {
    window.print();
});

</script>


<!-- </div> -->
</body>
</html>