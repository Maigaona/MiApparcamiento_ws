<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/miapparcamiento')]
class MiApparcamientoController extends AbstractController {

    #route sirve para saber la ruta del endpoint
    #[Route('/login')]

    #El request sirve para obtener los parametros que envia la app
    public function loginAction (Request $request,
                                LoggerInterface $logger,
                                    EntityManagerInterface $entityManager){

        #En la variable correo guardamos el valor del parametro correo
        $correo = $request->get("correo");
        $contrasenna = $request->get("contrasenna");

        #Si correo o contraseña es nulo es porque no estan en el request y regresa un error 401
        if (is_null($correo) || is_null($contrasenna)){
            $logger->error("No envio correo o contraseña!");
            return new Response(status: 400);
        }

        $conn = $entityManager->getConnection();

        $res = $conn->fetchAllAssociative("
            select id
            from usuario
            where correo = :correo
            and contrasenna = :contrasenna",
        ["correo" => $correo, "contrasenna" => $contrasenna]);

        if (count($res) == 0){
            return new Response(status: 404);
        }
        else {
            $id = $res[0]['id'];
        }


        $logger->debug("el usuario $correo inicio sesion!");




        return new JsonResponse([
                "id" => $id
        ]);

    }

    #[Route('/signup', methods: ['POST'])]
    public function signUpAction (Request $request,
                                  LoggerInterface $logger,
                                        EntityManagerInterface $entityManager) {

        $correo = $request->get("correo");
        $contrasenna = $request->get("contrasenna");
        $nombre = $request->get("nombre");

        if (is_null($correo) || is_null($contrasenna) || is_null($nombre)){
            $logger->error("No envio correo, contraseña o nombre!");
            return new Response(status: 400);
        }

        $conn = $entityManager->getConnection();

        $conn->executeQuery("
        insert into usuario (correo, contrasenna, nombre)
        values (:correo, :contrasenna, :nombre)",
        ["correo" => $correo, "contrasenna" => $contrasenna, "nombre" => $nombre]);

        $id = $conn->lastInsertId();


        $logger->debug("el usuario $correo ha sido registrado!");

        return new JsonResponse([
            "id" => $id,
        ]);
    }

    #[Route('/registervehicle', methods: ['POST'])]
    public function registerVehicleAction (Request $request,
                                                LoggerInterface $logger,
                                                    EntityManagerInterface $entityManager) {
        $marca = $request->get("marca");
        $modelo = $request->get("modelo");
        $longitud_del_carro = $request->get("longitud_del_carro");
        $id = $request->get("id");

        if (is_null($marca) || is_null($modelo) || is_null($longitud_del_carro) || is_null($id)){
            $logger->error("No envio marca, modelo, longitud_del_carro o id!");
            return new Response(status: 400);
        }

        $conn = $entityManager->getConnection();

        $conn->executeQuery("
        update usuario
        set marca = :marca, modelo = :modelo, longitud_del_carro = :longitud_del_carro
        where id = :id",
        ["marca" => $marca, "modelo" => $modelo, "longitud_del_carro" => $longitud_del_carro, "id" => $id]);

        $logger->debug("El usuario $id envio su marca, modelo y longitud de su carro!");

        return new Response(status: 200);
    }

    #[Route('/buymembership', methods: ['POST'])]
    public function buyMembership (Request $request,
                                        LoggerInterface $logger,
                                            EntityManagerInterface $entityManager) {
        $membresia = $request->get("membresia");
        $nombre = $request->get("nombre");
        $numero = $request->get("numero");
        $mes = $request->get("mes");
        $anno = $request->get("anno");
        $cvv = $request->get("cvv");
        $id = $request->get("id");

        if (is_null($membresia) || is_null($nombre) ||
            is_null($numero) || is_null($mes) || is_null($anno) ||
        is_null($cvv) || is_null($id)){
            $logger->error("No envio membresia, nombre, numero, mes, anno, ccvv o id!");
            return new Response(status: 400);
        }

        $conn = $entityManager->getConnection();

        $conn ->executeQuery("
        ");

        $logger->debug("El usuario $id quiere comprar la membresia $membresia, nombre, numero, mes, anno y cvv!");

        return new JsonResponse([
            "membresia" => $membresia,
            "nombre" => $nombre,
            "numero" => $numero,
            "mes" => $mes,
            "anno" => $anno,
            "cvv" => $cvv,
            "id" => $id,
        ]);
    }

    #[Route('/parkingspace')]
    public function parkingSpace (Request $request,
                                        LoggerInterface $logger,
                                                EntityManagerInterface $entityManager) {
        $latitud = $request->get("latitud");
        $longitud = $request->get("longitud");
        $id = $request->get("id");

        if (is_null($latitud) || is_null($longitud) || is_null($id)){
            $logger->error("No envio lalitud, longitud o id!");
            return new Response(status: 400);
        }

        $conn = $entityManager->getConnection();

        #TODO: Buscar solo los cajones a 500m del usuario

        $res = $conn ->fetchAllAssociative("
        select cajon.id as id, direccion, latitud, longitud, ocupado, distancia_libre
        from cajon join sensor
        on cajon.sensor_id = sensor.id
        ");

        $num_cajones = count($res);

        $logger->debug("Resultado tiene $num_cajones cajones!");

        $logger->debug("El usuario $id envio la latitud y longitud de su ubicación!");

        #TODO: Calcular colores de los cajones

        return new JsonResponse([
            "cajones" => $res,
        ]);
    }

    #[Route('/parkingspaceplace')]
    public function parkingSpacePlace(Request $request,
                                            LoggerInterface $logger,
                                                EntityManagerInterface $entityManager) {
        $lugar = $request->get("lugar");
        $id = $request->get("id");

        if (is_null($lugar) || is_null($id)){
            $logger->error("No envio lugar o id!");
            return new Response(status: 400);
        }

        $conn = $entityManager->getConnection();

        #TODO: Obtener las coordenadas del lugar
        #TODO: Buscar solo los cajones a 500m de la ubicación que ingreso el usuario

        $res = $conn ->fetchAllAssociative("
        select cajon.id as id, direccion, latitud, longitud, ocupado, distancia_libre
        from cajon join sensor
        on cajon.sensor_id = sensor.id
        ");

        $num_cajones = count($res);

        $logger->debug("Resultado tiene $num_cajones cajones!");

        $logger->debug("El usuario $id envio el lugar de la ubicacion!");

        #TODO: Calcular colores de los cajones

        return new JsonResponse([
            "cajones" => $res,
        ]);
    }

    #[Route('/userinfo')]
    public function userInfo(Request $request,
                                    LoggerInterface $logger) {
        $id = $request->get("id");

        if (is_null($id)){
            $logger->error("No envio id");
            return new Response(status: 400);
        }

        $logger->debug("Regresando informacion del usuario $id");

        return new JsonResponse([
            "id" => $id,
        ]);
    }


}