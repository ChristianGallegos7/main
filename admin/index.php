<?php

  session_start();

  $auth = $_SESSION['login'];

  if(!$auth){
    header("Location: ../index.php");
  }

  include("./templates/header.php");
?>

<main class="alto">
  <h1>Administrador de la Clinica</h1>
  <a href=""></a>
</main>

