<?php
session_start();
include("includes/db.php");
include("includes/meths.php");

if(!isset($_SESSION['c_email'])){
    echo "<script>window.open('login.php','_self')</script>";
}

$id_resenha = $_GET['id_resenha'];    
$busca_resenha = "SELECT d.nome as nome_disco, p.nota as nota, a.nome as nome_artista, p.id as id, p.texto as texto, u.nome as autor, a.id as id_artista, d.data_lancamento as data FROM discos d, artista a, post p, usuario u WHERE d.id = p.id_disco and a.id = d.id_artista and p.id_usuario = u.id and p.id='$id_resenha'";
$run_resenha = mysqli_query($con, $busca_resenha);
while($record=mysqli_fetch_array($run_resenha)){
    $text_path = $record['texto'];
    $artista = $record['nome_artista'];
    $disco = $record['nome_disco'];
    $nota = $record['nota'];
    $id_artista = $record['id_artista'];
    $autor = $record['autor'];
    $data_lancamento = $record['data'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
    	<meta charset="utf-8" />
    	<link rel="icon" type="image/png" href="img/halloween_apple_worm_-rot-512.png">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    	<title>Rotten Music - Nova Resenha</title>

    	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

        <!-- Bootstrap core CSS     -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Animation library for notifications   -->
        <link href="assets/css/animate.min.css" rel="stylesheet"/>


        <!-- Text Editor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/classic/ckeditor.js"></script>

        <!--  Light Bootstrap Table core CSS    -->
        <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>

        <!--  CSS for Demo Purpose, don't include it in your project     -->
        <link href="assets/css/demo.css" rel="stylesheet" />

        <!--     Fonts and icons     -->
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
        <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            include("commons/sidebar.php");
        ?>
        <div class="wrapper">
            <div class="main-panel">
            <?php
            include("commons/navbar_user.php")
            ?>
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">Editar resenha</h4>
                                    </div>
                                    <div class="content">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                       <label>Artista</label>
                                                                <input type="text" class="form-control" name="banda" disabled placeholder="Nome do artista" value="<?php echo $artista; ?>"><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Álbum</label>
                                                        <input type='text' class='form-control' value='<?php echo $disco; ?>' disabled>   
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>Nota</label>
                                                        <input type="text" class="form-control"  value='<?php echo $nota; ?>' name="nota" placeholder="0-5">
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="form-group">
                                                            <textarea name="content" id="editor"><?php include ($text_path); ?></textarea><br>
                                                            <script>
                                                                ClassicEditor
                                                                    .create( document.querySelector( '#editor' ) )
                                                                    .catch( error => {
                                                                        console.error( error );
                                                                    } );
                                                            </script>
                                                        <button type="submit" name="submit" class="btn btn-info btn-fill pull-right">Atualizar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                                include("commons/card_user.php")
                            ?>
                    </div>
                </div>
            </div>
            <?php
                include("commons/footer_user.php")
            ?>
        </div>
    </body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>
</html>

<?php 
    if(isset($_POST['submit'])){
       $id_usuario = retornaIdUsuario();
        $nota = $_POST['nota'];
        $id_resenha = $_GET['id_resenha'];
        $filename = generateRandomString();
        $old = "";
        $updir = 'posts_files/';

        if(!file_exists($updir . $filename . ".html")){
                $file = tmpfile();
            }
            $file = fopen($updir . $filename . ".html","a+");
            while(!feof($file)){
                $old = $old . fgets($file). "<br />";
            }
            $text = $_POST["content"];
            file_put_contents($updir . $filename . ".html", $old . $text);
            fclose($file);

        $textfile = $updir . $filename . ".html";

            $update_resenha = "update post set texto='$textfile' nota='$nota' where id='$id_resenha'";
            echo $update_resenha;
            $run_resenha = mysqli_query($con, $update_resenha);    
            if($run_resenha){
                echo"<script>alert('Resenha atualizada com sucesso')</script>";
                echo"<script>window.open('resenha.php','_self')</script>";
            }
        }
?>