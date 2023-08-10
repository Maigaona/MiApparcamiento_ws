<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/miapparcamiento')]
class MiApparcamientoController {

    #route sirve para saber la ruta del endpoint
    #[Route('/login')]

    #El request sirve para obtener los parametros que envia la app
    public function loginAction (Request $request) {

        #En la variable correo guardamos el valor del parametro correo
        $correo = $request->get("correo");
        $contrasenna = $request->get("contrasenna");

        #Si correo o contraseña es nulo es porque no estan en el request y regresa un error 401
        if (is_null($correo) || is_null($contrasenna)){
            return new Response(status: 400);
        }


        #TODO: Buscar usuario y contrasenna en la base de datos
        return new JsonResponse([
                "correo" => $correo,
                "contrasenna" => $contrasenna
        ]);

    }

    #[Route('/signup', methods: ['POST'])]
    public function signUpAction (Request $request) {

        $correo = $request->get("correo");
        $contrasenna = $request->get("contrasenna");
        $nombre = $request->get("nombre");

        if (is_null($correo) || is_null($contrasenna) || is_null($nombre)){
            return new Response(status: 400);
        }

        return new JsonResponse([
            "correo" => $correo,
            "contrasenna" => $contrasenna,
            "nombre" => $nombre
        ]);
    }

    #[Route('/registervehicle', methods: ['POST'])]
    public function registerVehicleAction (Request $request) {
        $marca = $request->get("marca");
        $modelo = $request->get("modelo");
        $longitud_del_carro = $request->get("longitud_del_carro");
        $id = $request->get("id");

        if (is_null($marca) || is_null($modelo) || is_null($longitud_del_carro) || is_null($id)){
            return new Response(status: 400);
        }

        return new JsonResponse([
            "marca" => $marca,
            "modelo" => $modelo,
            "longitud_del_carro" => $longitud_del_carro,
            "id" => $id
        ]);
    }

    #[Route('/buymembership', methods: ['POST'])]
    public function buyMembership (Request $request) {
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
            return new Response(status: 400);
        }

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
    public function parkingSpace (Request $request) {
        $latitud = $request->get("latitud");
        $longitud = $request->get("longitud");
        $id = $request->get("id");

        if (is_null($latitud) || is_null($longitud) || is_null($id)){
            return new Response(status: 400);
        }

        return new JsonResponse([
            "latitud " => $latitud,
            "longitud" => $longitud,
            "id" => $id,
        ]);
    }

    #[Route('/parkingspaceplace')]
    public function parkingSpacePlace(Request $request) {
        $lugar = $request->get("lugar");
        $id = $request->get("id");

        if (is_null($lugar) || is_null($id)){
            return new Response(status: 400);
        }

        return new JsonResponse([
            "lugar" => $lugar,
            "id" =>$id
        ]);
    }

    #[Route('/userinfo')]
    public function userInfo(Request $request) {
        $id = $request->get("id");

        if (is_null($id)){
            return new Response(status: 400);
        }

        return new JsonResponse([
            "id" => $id,
        ]);
    }


}