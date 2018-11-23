<?php

$c_email = $_SESSION['c_email'];    
$busca_perfil = "select * from usuario where email='$c_email'";
$run_perfil = mysqli_query($con, $busca_perfil);

while($record=mysqli_fetch_array($run_perfil)){
    $c_nome = $record['nome'];
    $c_user = $record['user'];
    $c_email = $record['email'];
    $c_foto = $record['foto'];
    $c_facebook = $record['facebook'];
    $c_instagram = $record['instagram'];
}
?>
<nav class="navbar navbar-default navbar-fixed">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://localhost/rottenmusic/user.php">Bem vindo (a), <?php echo $c_nome; ?></a>
        </div>
        <form method="post" enctype="multipart/form-data">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-globe"></i>
                        <b class="caret hidden-sm hidden-xs"></b>
                        <span class="notification hidden-sm hidden-xs number-counting"></span>
						<p class="hidden-lg hidden-md">
							5 Notifications
							<b class="caret"></b>
						</p>
                    </a>
                    <ul class="dropdown-menu drop-notes">
<!--                         <li><a href="#">Notification 1</a></li>
                        <li><a href="#">Notification 2</a></li>
                        <li><a href="#">Notification 3</a></li>
                        <li><a href="#">Notification 4</a></li>
                        <li><a href="#">Another notification</a></li> -->
                    </ul>
                </li>
                <li>
                    <input type="text" name="banda_busca" class="form-control nav navbar-nav navbar-right" placeholder="Buscar banda">
                </li>
                <li>
                    <button type="submit" name="submit" class="btn btn-primary"></button>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="./logout.php">
                        <p>Logout</p>
                    </a>
                </li>
				<li class="separator hidden-lg hidden-md"></li>
            </ul>
        </div>
    </form>
    </div>
</nav>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        function callAjax(){
            $.ajax({
                type: 'GET',
                url: 'http://localhost/rottenmusic/retorna_notificacoes.php',
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    $('.number-counting').text(data.length/5);
                    for (var i = 0; i < data.length; ){
                        $('.drop-notes').append(
                            '<li><a href="#">Notification 1</a></li>');
                        i = i + 5;
                    }
                },
                error: function(jqXHR,error, errorThrown, data) {
                    if(jqXHR.status&&jqXHR.status==400){
                        console.log(error);
                    }else{
                        console.log(data);
                                                console.log(errorThrown);

                    }
                }
            });

            $.ajax({
                type: 'GET',
                url: 'http://localhost/rottenmusic/retorna_notificacoes.php',
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    $('.number-counting').text(data.length/5);
                    for (var i = 0; i < data.length; ){
                        $('.drop-notes').append(
                            '<li><a href="#">Notification 1</a></li>');
                        i = i + 5;
                    }
                },
                error: function(jqXHR,error, errorThrown, data) {
                    if(jqXHR.status&&jqXHR.status==400){
                        console.log(error);
                    }else{
                        console.log(data);
                                                console.log(errorThrown);

                    }
                }
            });
        };

        // setTimeout(c, 10000)

        // function c () {
        //     callAjax()
        //     setTimeout(c2, 10000);
        // }

        // function c2 () {
        //     callAjax()
        //     setTimeout(c, 10000);
        // }
    });

</script>


<?php 
    if(isset($_POST['submit']) && isset($_POST['banda_busca'])){
        $string_busca = $_POST['banda_busca'];
        echo "<script>window.location = 'busca_banda.php?banda_busca=$string_busca'</script>";
    }
?>