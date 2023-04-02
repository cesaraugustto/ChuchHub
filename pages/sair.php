<?php
session_start();
unset($_SESSION['id']); //Finalizando variável de verificação de login
header('Location: ../index.php'); //Redirecionando ao site
?>