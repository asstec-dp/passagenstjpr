<?php

session_start();
unset($_SESSION['id_usuario'], $_SESSION['nome'], $_SESSION['email']);
header("Location: index.php");