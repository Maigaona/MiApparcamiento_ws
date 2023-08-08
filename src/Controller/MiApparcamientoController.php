<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/miapparcamiento')]
class MiApparcamientoController {

    #route sierve para saber la ruta del endpoint
    #[Route('/login')]

    #El request sirve para obtener los parametros que envia la app
    public function loginAction (Request $request) {

        #En la variable correo guardamos el valor del parametro correo
        $correo = $request->get("correo");
        $contrasenna = $request->get("contrasenna");

        #Si correo o contraseña es nulo es porque no estan en el request y regresa un error 401
        if (is_null($correo) || is_null($contrasenna)){
            return new Response(status: 401);
        }


        #TODO: Buscar usuario y contrasenna en la base de datos
        return new JsonResponse([
                "correo" => $correo,
                "contrasenna" => $contrasenna
        ]);

    }

    #[Route('/signup', methods: ['POST'])]
    public function signUp (Request $request) {

        $correo = $request->get("correo");
        $contrasenna = $request->get("contrasenna");
        $nombre = $request->get("nombre");

        if (is_null($correo) || is_null($contrasenna) || is_null($nombre)){
            return new Response(status: 401);
        }

        return new JsonResponse([
            "correo" => $correo,
            "contrasenna" => $contrasenna,
            "nombre" => $nombre
        ]);
    }
}