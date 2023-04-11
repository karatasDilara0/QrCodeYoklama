<?php
session_start();
?>
<html>
    <head>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Dilara KARATAŞ</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Ana Sayfa</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Page 1-1</a></li>
                                <li><a href="#">Page 1-2</a></li>
                                <li><a href="#">Page 1-3</a></li>
                            </ul>
                    </li>
                    <li><a href="#">Page 2</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span>Giriş Yap</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span>Çıkış Yap</a></li>
                    </ul>
                </div>
                </nav>


            <div class="row">
                <div class="col-md-6">
                    <video id="preview" width="100%"></video>
                    <?php
                    if(isset($_SESSION['HATA'])){
                        echo"
                        <div class='alert alert-danger'>
                        <h4>HATA!</h4>
                        ".$_SESSION['ERROR']."
                        </div>
                        ";
                    }

                    if(isset($_SESSION['TEBRİKLER'])){
                        echo"
                        <div class='alert alert-success'>
                        <h4>Başarılıyla kaydınız alındı, iyi dersler!</h4>
                        ".$_SESSION['TEBRİKLER']."
                        </div>
                        ";
                    }
                    ?>
                    
                </div>
                <div class="col-md-6">
                    <form action="insert.php" method="post" class="form-horizontal">
                    <label>QR CODE TARAMASI</label>
                    <input type="text" name="text" id="text" readonyy="" placeholder="QR CODE taranan sonuç" class="form-control">
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>ÖĞRENCİ İD</td>
                                <td>TARİH</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $server = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "qrcodedb";
                            
                                $conn = new mysqli($server,$username,$password,$dbname);
                            
                                if($conn->connect_error){
                                    die("Bağlantı Hatalı" .$conn->connect_error);
                                }

                                $sql = "SELECT ID,STUDENTID,TIMEIN FROM veriler WHERE DATE(TIMEIN)=CURDATE()";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $row['ID'];?></td>
                                    <td><?php echo $row['STUDENTID'];?></td>
                                    <td><?php echo $row['TIMEIN'];?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
                        <!-- onclick="Export()" pull-right'ın sonuna eklenirse dosya excele iner  -->
            <button type="submit" class="btn btn-success pull-right">
                <i class="fa fa-file-excel-o fa-fw"></i> Yoklama Listesi Oluştur
            </button>
            <script>
                function Export()
            {
                var conf = confirm("Yoklama listesini excel dökümanına eklemeyi onaylıyormusunuz?");
                if(conf == true){
                    window.open("export.php",'_blank');
                }
            }
            </script>
            

        <script>
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
            Instascan.Camera.getCameras().then(function(cameras){
                if(cameras.lenght =1) {
                    scanner.start(cameras[0]);
                    
                }else {
                    alert('camera bulunamadı');
                }
            }).catch(function(e) {
                console.error(e);
            });

            scanner.addListener('scan',function(c) {
                document.getElementById('text').value=c;
                document.forms[0].submit();
            });
        </script>
    </body>
</html>