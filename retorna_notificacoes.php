<?php
session_start();
include("includes/db.php");
include("includes/meths.php");

$id_usuario = retornaIdUsuario();
$busca_notificacoes = "select * from notificacoes_usuario where id_usuario='$id_usuario' and visualizado = 'FALSE';";
$run_busca = mysqli_query($con, $busca_notificacoes);
$notificacoes_check = mysqli_num_rows($run_busca);
if($notificacoes_check > 0){
    while($record=mysqli_fetch_array($run_busca)){
        $id_notificacao = $record['id_notificacao'];
        $get_note="select * from notificacoes where id ='$id_notificacao'";
        $run_note = mysqli_query($con, $get_note);
        $note_array = array();
        while($record=mysqli_fetch_array($run_note)){
            $note_array[] = $record['id'];
            $note_array[] = $record['mensagem'];
            $note_array[] = $record['id_banda'];
            $note_array[] = $record['id_resenha'];
            $note_array[] = $record['id_denuncia'];

        }
    }
}
print json_encode($note_array)
?>