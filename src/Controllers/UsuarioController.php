<?php

namespace App\Financas\Controllers;

use App\Financas\Models\Usuario;
use App\Financas\Helpers\Logger;

class UsuarioController {
    public static function listarUsuarios(): array {
        try {
            $usuarios = Usuario::all();

            if ($usuarios->isEmpty()) {
                return ['status' => 'empty'];
            }

            return ['status' => 'success', 'data' => $usuarios->toArray()];
        } catch (\Exception $e) {
            $id = Logger::newLog('error', $e->getMessage(), 'ERROR');
            return ['status' => 'server_error', 'error_id' => $id];
        }
    }
}
