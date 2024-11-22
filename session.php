<?php
    session_start();
    echo json_encode($_SESSION['user_role'] );
    echo json_encode($_SESSION['user_nom'] );
    echo json_encode($_SESSION['user_prenom'] );
    ?>