<?php

namespace Financas\Controllers;

use Financas\Helpers\Logger;
use Financas\Models\UsuarioModel;

class UsuarioController {

    public static function listarUsuarios(int $itens = 10, int $pagina = 1): array {
        try {
            $skip = ($pagina - 1) * $itens;

            $usuarios = UsuarioModel::skip($skip)->take($itens)->get();

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

        $colunasPermitidas = ['id', 'email', 'nome'];

        if (!in_array($coluna, $colunasPermitidas)) {
            return ['status' => 'bad_request', 'message' => 'Coluna de busca não permitida.'];
        }

        try {

            $usuario = UsuarioModel::where($coluna, $valor)->first();

            if (!$usuario) {
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
            return ['status' => 'success'];
        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'FOREIGN KEY') !== false) {
                return ['status' => 'not_permitted'];
            }

            $id = Logger::newLog('error', $e->getMessage(), 'ERROR');
            return ['status' => 'server_error', 'error_id' => $id];
        }
    }

    public static function novoUsuario(array $dados): array {
        try {

            $usuario = UsuarioModel::where('email', $dados['email'])->first();

            if ($usuario) {
                return ['status' => 'duplicated'];
            }

            $usuario = UsuarioModel::create($dados);

            return ['status' => 'success', 'data' => $usuario->toArray()];
        } catch (\Exception $e) {
            $idLog = Logger::newLog('error', $e->getMessage(), 'ERROR');
            return ['status' => 'server_error', 'error_id' => $idLog];
        }
    }

    public static function atualizarUsuario(int $id, array $dados): array {
        try {
            $usuario = UsuarioModel::find($id);

            if (!$usuario) {
                return ['status' => 'not_found'];
            }

            if (isset($dados['email'])) {
                $emailExistente = UsuarioModel::where('email', $dados['email'])
                    ->where('id', '<>', $id)
                    ->first();

                if ($emailExistente) {
                    return ['status' => 'duplicated'];
                }
            }

            $usuario->update($dados);

            return ['status' => 'success', 'data' => $usuario->toArray()];
        } catch (\Exception $e) {
            $idLog = Logger::newLog('error', $e->getMessage(), 'ERROR');
            return ['status' => 'server_error', 'error_id' => $idLog];
        }
    }
}
