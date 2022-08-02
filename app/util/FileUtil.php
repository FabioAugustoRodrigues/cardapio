<?php

namespace app\util;

use app\domain\exception\DomainException;

class FileUtil
{

    public function insereImagem(array $dadosDoArquivo, string $path): string
    {
        $extensoesValidas = array("jpeg", "jpg", "png");
        $temporario = explode(".", $dadosDoArquivo["name"]);
        $extensao_arquivo = end($temporario);
        if ((($dadosDoArquivo["type"] == "image/png") || ($dadosDoArquivo["type"] == "image/jpg") || ($dadosDoArquivo["type"] == "image/jpeg")) && ($dadosDoArquivo["size"] < 10000000000) //Aprox. 100kb pode ser carregado
            && in_array($extensao_arquivo, $extensoesValidas)
        ) {
            if ($dadosDoArquivo["error"] > 0) {
                throw new DomainException("Houve um erro ao tentar fazer o upload da imagem");
            } else {
                $nomeImagem = md5(time()) . "." . $extensao_arquivo;
                $sourcePath = $dadosDoArquivo["tmp_name"];
                $targetPath = $path . $nomeImagem;
                move_uploaded_file($sourcePath, $targetPath);

                return $nomeImagem;
            }
        }

        throw new DomainException("Tipo inválido");
    }

    public function excluiArquivo(string $arquivo): bool
    {
        if (file_exists($arquivo)) {
            return unlink($arquivo);
        }

        return true;
    }
}
