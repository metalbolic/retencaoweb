<?php

namespace core;

/**
 * Classe respnsável por lidar com as configurações necessárias ao aplicativo como
 * um todo.
 * @author Anderson Souza <sakn45@bol.com.br>
 * @version Alpha
 * @since 25/12/2016
 * @package core
 */
class configuracao {
    
    private static
            /*
             * Armazena uma instancia da classe.
             * @static
             * @access private
             * @var configuracao $_instanciaConfiguracao
             */
            $_instanciaConfiguracao= null;
    /*
     * Armazena as configuracações para conexão ao banco de dados.
     * @access private
     * @const array CONFIGURACAO
     */
    const CONFIGURACAO= ['bancodedados'=>'retencaoweb', 'servidor'=>'localhost', 'usuario'=>'root',
        'senha'=>''];
    
    /**
     * Construtor privado para evitar a instanciação normal da classe.
     */
    private function __construct() {}
    
    /**
     * @access public
     * @throws \RuntimeException           Lançada caso haja um tentativa de clonagem.
     */
    public function __clone() {
        throw new \RuntimeException('Impossível clonagem');
    }
    
    /**
     * @access public
     * @throws \RuntimeException           Lançada caso haja uma tentativa de desearilização.
     */
    public function __wakeup() {
        throw new \RuntimeException('Impossivel a desearilização');
    }
    
    /**
     * Método responsável por retornar uma instância da classe.
     * @method
     * @static
     * @access public
     * @return \core\configuracao       Uma instância da classe.
     */
    public static function obterInstancia() {
        if (self::$_instanciaConfiguracao === null) {
            self::$_instanciaConfiguracao= new configuracao();
            
            return self::$_instanciaConfiguracao;
        }
        return self::$_instanciaConfiguracao;
    }
    
    /**
     * Método responsável por retornar os dados para conexão ao banco de dados.
     * @method
     * @access public
     * @return array           Retorna as dados para conexão ao banco de dados.
     */
    public function obterConfiguracaoBancoDeDados() {
        return self::CONFIGURACAO;
    }
    
    public function __destruct() {
        self::$_instanciaConfiguracao= null;
    }
    
    
}
