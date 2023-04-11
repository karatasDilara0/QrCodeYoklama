<?php 
    session_start();
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "qrcodedb";

    $conn = new mysqli($server,$username,$password,$dbname);

    if($conn->connect_error){
        die("Bağlantı Hatalı" .$conn->connect_error);
    }
    if(isset($_POST['text'])){

        $text = $_POST['text'];

        $sql = "INSERT INTO veriler(STUDENTID,TIMEIN) VALUES('$text',NOW())";
        if($conn->query($sql) == TRUE){
            $_SESSION['TEBRİKLER'] = 'Başarılıyla ekleme yapıldı.';
        } else {
            $_SESSION['HATA'] = $conn->error;
        }
        header("location: index.php");

    }
    $conn->close();
?>