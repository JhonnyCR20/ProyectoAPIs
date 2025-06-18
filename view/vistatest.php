<?php

    require_once __DIR__.'/../controller/ClientesController.php';


    $controller = new ClientesController();

    $datos = $controller->obtenerDatos();
    $ids = $controller->obtenerPorId("1");
    print_r($datos);
    echo "<br><br><br>";
    print_r($ids);

?>