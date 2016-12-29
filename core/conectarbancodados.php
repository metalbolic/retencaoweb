<?php

namespace core;

require_once '../core/configuracao.php';

use core\configuracao;

/**
 * Classe responsável por manipular a conexão ao banco de dados.
 * @author Anderson Souza <sakn45@bol.com.br>
 * @version Alpha
 * @since 25/12/2016
 * @package core
 */
class conectarbancodados {
   
    private static 
            /*
             * Armazena uma instância da classe.
             * @access private
             * @var conectarbancodados
             */
            $_instanciaConectarBancoDados= null;
    
    private
            /*
             * @access private
             * @var \PDO    Armazena uma conexão ao banco de dados.
             */
            $_conexao= null,
            /*
             * @access private
             * @var array $_dadosConfiguracao   Armazena os dados de configuração para conexao ao banco de dados.
             */
            $_dadosConfiguracao= null;
    
    /**
     * Construtor privado, para evitar a instanciação da classe de forma normal.
     */
    private function __construct() {
        $this->_dadosConfiguracao= configuracao::obterInstancia()->obterConfiguracaoBancoDeDados();
    }
    
    /**
     * @access public
     * @throws \RuntimeException        Lançada caso haja uma tentativa de clonagem.
     */
    public function __clone() {
        throw new \RuntimeException('Impossível clonagem');
    }
    
    /**
     * @access public
     * @throws \RuntimeException        Lançada caso haja uma tentativa de clonagem.
     */
    public function __wakeup() {
        throw new \RuntimeException('Impossível desearilização');
    }
    
    /**
     * Método responsável por retorna uma instância da classe.
     * @method
     * @static
     * @access public
     * @return \core\conectarbancodados      Retorna uma instância da classe.
     */
    public static function obterInstancia() {
        if (self::$_instanciaConectarBancoDados === null) {
            self::$_instanciaConectarBancoDados= new conectarbancodados();
            
            return self::$_instanciaConectarBancoDados;
        }
        return self::$_instanciaConectarBancoDados;
    }
    
    /**
     * Método responsável por retornar uma conexão ao banco de dados.
     * @method
     * @access public
     * @return \PDO             Retorna uma conexão ao banco de dados.
     */
    public function obterConexao() {
        if ($this->_conexao === null) {
            try {
                /*
                 * Trecho que cria o banco de dados, antes de tentar conectar novamente.
                 * @var $instanciaPDOTemporaria PDO   Utilizada somente para criar o banco de dados.
                 */
                $instanciaPDOTemporaria= new \PDO('mysql:host=' . $this->_dadosConfiguracao['servidor'],
                    $this->_dadosConfiguracao['usuario'], $this->_dadosConfiguracao['senha']);
                $instanciaPDOTemporaria
                    ->exec('CREATE DATABASE retencaoweb CHARACTER SET utf8'
                        .  ' COLLATE utf8_unicode_ci');
                unset($instanciaPDOTemporaria);
                
                $this->_conexao= new \PDO('mysql:host=' . $this->_dadosConfiguracao['servidor']
                . ';dbname=' . $this->_dadosConfiguracao['bancodedados'], $this->_dadosConfiguracao['usuario'],
                $this->_dadosConfiguracao['senha']);
                $this->_conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);              
                
            } catch (\PDOException $erroPDO) {                
                die($erroPDO->getMessage() . ' - ' . $erroPDO->getTraceAsString());
            }        
        }
        return $this->_conexao;
    }
        
    /**
     * Método responsável por criar a tabela da aplicação.
     * @method
     * @access public
     * @return void              Não retorna nenhum valor.
     */
    public function criarTabela() {
        /* @var $conexaoBancoDados PDO */
        $conexaoBancoDados= $this->obterConexao();
        $conexaoBancoDados->exec('CREATE TABLE IF NOT EXISTS usuarios'
                    . ' ('
                    . 'id INT(11) AUTO_INCREMENT PRIMARY KEY,'
                    . 'nomeCompleto VARCHAR(255) NOT NULL,'
                    . 'email VARCHAR(255) NOT NULL,'
                    . 'senha VARCHAR(255) NOT NULL,'
                    . 'cpf VARCHAR(255) NOT NULL'
                    . ' );');
    }

    public function __destruct() {
        unset($this->_conexao, $this->_dadosConfiguracao);
        self::$_instanciaConectarBancoDados= null;
    }
}







