<?php

namespace Financas\Controllers;

use Financas\Helpers\Logger;
use Financas\Models\UsuarioModel;

class UsuarioController {
    public static function listarUsuarios(): array {
        try {
            $usuarios = UsuarioModel::all();

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
