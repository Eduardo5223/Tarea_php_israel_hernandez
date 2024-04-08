<?php
include('connection.php');

$accion = $_GET['accion'];

$data = json_decode(file_get_contents('php://input'),true);



if(isset($data)){
    //Obtengo la accion
    $accion = $data["accion"];

    //Insertar
    if($accion == 'asignar'){
        $id_cliente = $data["id_cliente"];
        $id_auto = $data["id_auto"];

        $qry = "insert into dueño_cliente (id_cliente, id_auto) values('$id_cliente', '$id_auto')";
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se creo correctamente';
        }else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo guardar el registro debido a un error';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'obtener'){
        $id_cliente = $data["id_cliente"];

        $qry = "select auto.id, auto.marca, auto.modelo, auto.año, auto.VIN
                from auto
                inner JOIN dueño_cliente on auto.id = dueño_cliente.id_auto
                where dueño_cliente.id_cliente = '$id_cliente'";
        $result = $db->query($qry);

        if ($result) {
            $autos = array();
            while ($row = $result->fetch_assoc()) {
                $autos[] = $row;
            }

            $response["status"] = 'OK';
            $response["autos"] = $autos;
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'Error al obtener los autos por cliente';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}