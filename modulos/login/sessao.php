<?php
session_start();
    if (empty($_SESSION['user'])) {
        header('Location: ' . arquivo('modulos/login/login.php'));
        exit;
    }