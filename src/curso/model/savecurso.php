<?php

    // Obter a nossa conexão com o banco de dados
    include('../../conexao/conn.php');

    // Obter os dados enviados do formulário via $_REQUEST
    $requestData = $_REQUEST;

    // Verificação de campo obrigatórios do formulário
    if(empty($requestData['nome'])){
        // Caso a variável venha vazia eu gero um retorno de erro do mesmo
        $dados = array(
            "tipo" => 'error',
            "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
        );
    } else {
        // Caso não exista campo em vazio, vamos gerar a requisição
        $id = isset($requestData['idcurso']) ? $requestData['idcurso'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

        // Verifica se é para cadastra um nvo registro
        if($operacao == 'insert'){
            // Prepara o comando INSERT para ser executado
            try{
                $stmt = $pdo->prepare('INSERT INTO curso (nome, eixo_ideixo) VALUES (:a, :b)');
                $stmt->execute(array(
                    ':a' => utf8_decode($requestData['nome']),
                    ':b' => $requestData['eixo_ideixo']
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Curso cadastrado com sucesso.'
                );
            } catch(PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o cadastro do curso.'
                );
            }
        } else {
            // Se minha variável operação estiver vazia então devo gerar os scripts de update
            try{
                $stmt = $pdo->prepare('UPDATE curso SET nome = :a, eixo_ideixo = :b WHERE idcurso = :id');
                $stmt->execute(array(
                    ':id' => $id,
                    ':a' => utf8_decode($requestData['nome']),
                    ':b' => $requestData['eixo_ideixo']
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Curso atualizado com sucesso.'
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o alteração do curso.'
                );
            }
        }
    }

    // Converter um array ded dados para a representação JSON
    echo json_encode($dados);