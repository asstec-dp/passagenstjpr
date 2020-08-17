<?php

session_start();
unset($_SESSION['id_usuario'], $_SESSION['nome']);
header("Location: inicio.php");
?>