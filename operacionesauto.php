<?php
include('connection.php');

$accion = $_GET['accion'];

$data = json_decode(file_get_contents('php://input'),true);

//CRUD
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    //leer los datos de la tabla auto
    if($accion == 'leer'){
        $sql = "select * from auto where 1";
        $result = $db->query($sql);

        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id'];
                $item['marca'] = $fila['marca'];
                $item['modelo'] = $fila['modelo'];
                $item['año'] = $fila['año'];
                $item['VIN'] = $fila['VIN'];
                $arrAuto[] = $item;
            }
            $response["status"] = "OK";
            $response["mensaje"] = $arrAuto;
        }else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay autos resgistrados";
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}


if(isset($data)){
    //Obtengo la accion
    $accion = $data["accion"];

    //Insertar
    if($accion == 'insertar'){
        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $año = $data["año"];
        $VIN = $data["VIN"];

        $qry = "insert into auto (marca, modelo, año, VIN) values('$marca', '$modelo', '$año', '$VIN')";
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

    //Modificar
    if($accion == 'modificar'){
        //Obtener los demas datos del body
        $id = $data["id"];
        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $año = $data["año"];
        $VIN = $data["VIN"];

        $qry = "update auto set marca = '$marca', modelo = '$modelo', año = '$año', VIN = '$VIN' where id = '$id'";
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se modifico correctamente';
        }else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo guardar el registro debido a un error';
        }
        header('Content-Type: application/json');
        echo json_encode($response);

    }

    //Eliminar
    //Modificar
    if($accion == 'eliminar'){
        //Obtener los demas datos del body
        $id = $data["id"];

        $qry = "delete from auto where id = '$id'";
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se elimino correctamente';
        }else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo eliminarr el registro debido a un error';
        }
        header('Content-Type: application/json');
        echo json_encode($response);

    }
}