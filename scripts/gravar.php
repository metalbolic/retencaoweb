<?php

namespace scripts;

\session_start();
\session_name(\hash('whirlpool', 'paginacadastro'));
\session_regenerate_id(true);

require_once '../core/conectarbancodados.php';
require_once '../classes/processarregistro.php';
require_once '../classesDAO/gravarDAO.php';

use core\conectarbancodados,
classes\processarregistro,
classesDAO\gravarDAO;

/*
 * Trecho do código que impedi a submissao arbritaria dos dados, e tornando a mesma, um pouco mais seguro.
 */
if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST' && 
    $_SESSION['uri'] === '/retencaoweb/paginas/paginacadastro.php' &&
    $_SESSION['host'] === 'localhost' && $_SESSION['chaveAleatoria']
    === \filter_input(\INPUT_POST, 'chaveAleatoria')) {
    
    /* @var $dadosUsuarios array */
    $dadosUsuarios= \filter_input_array(\INPUT_POST);
    
    /* 
     * Trecho responsável por apagar a chave aleatória, por segurança.
     * @var $token string
     */
    $token= \filter_var($dadosUsuarios['chaveAleatoria']);
    unset($token);
    
    try {
        /* @var $dadosUsuariosProcessados processarregistro */
        $dadosUsuariosProcessados= new processarregistro($dadosUsuarios['nomecompleto'],
        $dadosUsuarios['email'], $dadosUsuarios['senha'], $dadosUsuarios['senha2'], $dadosUsuarios['cpf']);
        
        /* @var $conexaoBancoDeDados PDO */
        $conexaoBancoDeDados= conectarbancodados::obterInstancia()->obterConexao();
    
        /* Trecho responsável por criar tabela no banco de dados
         */
        conectarbancodados::obterInstancia()->criarTabela();
    
        /* @var $gravarDados gravarDAO */
        $gravarDados= gravarDAO::obterInstancia();
    
        $gravarDados->gravarDados($dadosUsuariosProcessados->obterDadosUsuarios('_nomeCompleto'),
        $dadosUsuariosProcessados->obterDadosUsuarios('_email'), $dadosUsuariosProcessados->obterSenhaUsuarios(),
        $dadosUsuariosProcessados->obterDadosUsuarios('_cpf'));        
        
    } catch (\UnderflowException $erroProcessarRegistro) {
        die($erroProcessarRegistro->getMessage() . ' - ' . $erroProcessarRegistro->getTraceAsString());
        
    } catch (\InvalidArgumentException $erroProcessarRegistro) {
        die($erroProcessarRegistro->getMessage() . ' - ' . $erroProcessarRegistro->getTraceAsString());
    }  
   
    /*
     * Trecho que verifica se de fato os dados foram gravados.
     */
    if ($gravarDados) {
        \header('Content-Type: text/html; charset=utf-8');
        \header('Location: ../paginas/registradosucesso.php');
        exit();
    }
    
    \header('Content-Type: text/html; charset=utf-8');
    \header('Location: ../paginas/erroregistro.php');
    exit();
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}