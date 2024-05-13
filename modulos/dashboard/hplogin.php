<?php
session_start();

    include('../../assets/bd/conexao.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Dashboard - Gerenciador de Finanças</title>
</head>
<body>
    <div class="navLoginSucess">
        <a id="btn_logout" href="../login/logout.php">Logout</a>
    </div>
	<div>
        <div class="container_hplogin" onclick="window.location='../../modulos/dashboard/dashboard.php'">
            <img src="../../assets/imgs/img_background_card_to_dashboard.png">
            <div class="text_card">
                <p>Dashboard</p>
            </div>
        </div>
        
	</div>
</body>
</html>