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

    public static function buscarUsuario(string $valor, string $coluna = 'id'): array {
        try {
            $usuario = UsuarioModel::where($coluna, $valor)->get();

            if ($usuario->isEmpty()) {
                return ['status' => 'not_found'];
            }

            return ['status' => 'success', 'data' => $usuario->toArray()];
        } catch (\Exception $e) {
            $id = Logger::newLog('error', $e->getMessage(), 'ERROR');
            return ['status' => 'server_error', 'error_id' => $id];
        }
    }

    public static function apagarUsuario(string $id): array {
        try {
            $usuario = UsuarioModel::find($id);

            if (!$usuario) {
                return ['status' => 'not_found'];
            }

            $usuario->delete();
            return ['status' => 'deleted'];
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'FOREIGN KEY') !== false) {
                return ['status' => 'not_permitted'];
            }
            $id = Logger::newLog('error', $e->getMessage(), 'ERROR');
            return ['status' => 'server_error', 'error_id' => $id];
        }
    }
}
