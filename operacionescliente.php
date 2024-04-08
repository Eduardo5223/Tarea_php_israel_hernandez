<?php
include('connection.php');

$accion = $_GET['accion'];

$data = json_decode(file_get_contents('php://input'),true);

//CRUD
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    //leer los datos de la tabla auto
    if($accion == 'leer'){
        $sql = "select * from clientes where 1";
        $result = $db->query($sql);

        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id'];
                $item['nombre'] = $fila['nombre'];
                $item['email'] = $fila['email'];
                $arrCliente[] = $item;
            }
            $response["status"] = "OK";
            $response["mensaje"] = $arrCliente;
        }else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay clientes resgistrados";
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
        $nombre = $data["nombre"];
        $email = $data["email"];

        $qry = "insert into clientes (nombre, email) values('$nombre', '$email')";
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
        $nombre = $data["nombre"];
        $email = $data["email"];

        $qry = "update clientes set nombre = '$nombre', email = '$email' where id = '$id'";
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

        $qry = "delete from clientes where id = '$id'";
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