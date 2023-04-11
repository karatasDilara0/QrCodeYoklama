<?php 
    //session_start();
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "qrcodedb";

    $conn = new mysqli($server,$username,$password,$dbname);

    if($conn->connect_error){
        die("Bağlantı Hatalı" .$conn->connect_error);
    }

    $filename ='YoklamaListesi-'.date('Y-m-d').'.csv'; 

    $query ="SELECT * FROM veriler";
    $result =mysqli_query($conn,$query);

    $array = array();

    $file = fopen($filename,"w");
    $array = array("ID","ÖĞRENCİ İD","GİRİŞ ZAMANI");
    fputcsv($file,$array);

    while($row = mysqli_fetch_array($result)){
        $ID =$row['ID'];
        $STUDENTID =$row['STUDENTID'];
        $TIMEIN =$row['TIMEIN'];

        $array = array($ID,$STUDENTID,$TIMEIN);
        fputcsv($file,$array);
    }
    fclose($file);

    header("Bağlantı açıklaması: dosya transferi.");
    header("Bağlantı açıklaması: EK; dosya ismi=$filename");
    header("Bağlantı tipi:application/csv;");
    readfile($filename);
    unlink($filename);
    exit();
    ?>