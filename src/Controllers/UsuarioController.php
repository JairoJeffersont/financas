<?php

namespace App\Financas\Controllers;

use App\Financas\Models\Usuario;
use JairoJeffSantos\EasyLogger;

class UsuarioController {
    public static function listarUsuarios(): array {
        try {
            $usuarios = Usuario::all();

            if ($usuarios->isEmpty()) {
                return ['status' => 'empty'];
            }

            return ['status' => 'success', 'data' => $usuarios->toArray()];
        } catch (\Exception $e) {
            $id = EasyLogger::newLog('error.log', $e->getMessage(), 'ERROR');
            return ['status' => 'server_error', 'error_id' => $id];
        }
    }
}
