<?php

namespace classesDAO;

require_once '../interfaces/persistenciadados.php';
require_once '../core/conectarbancodados.php';

use interfaces\persistenciadados,
    core\conectarbancodados;

class gravarDAO implements persistenciadados {
    
    private
            /*
             * Armazena uma conexão ao banco de dados.
             * @access private
             * @var conectarbancodados $_conexaoBancoDados
             */
            $_conexaoBancoDados= null;
    
    private static 
            /*
             * Armazena uma instância da classe.
             * @static
             * @access private
             * @var gravarDAO $_instanciaGravarDAO
             */
            $_instanciaGravarDAO= null;

    /**
     * Construtor privado, para evitar a instanciação da classe de forma normal.
     * Também o mesmo, inicializa a conexão ao banco de dados, necessária para suas operações.
     */
    private function __construct() {
        $this->_conexaoBancoDados= conectarbancodados::obterInstancia()->obterConexao();
    }
    
    /**
     * @access public
     * @throws \RuntimeException         Lançada, caso haja uma tentativa de clonagem.
     */
    public function __clone() {
        throw new \RuntimeException('Impossível clonagem');
    }
    
    /**
     * @access public
     * @throws \RuntimeException         Lançada, caso haja uma tentativa de desearilização.
     */
    public function __wakeup() {
        throw new \RuntimeException('Impossível desearilização');
    }
    
    /**
     * Método responsável por retornar um instância da classe.
     * @method
     * @access public
     * @return \classesDAO\gravarDAO       Uma instância da classe.
     */
    public static function obterInstancia() {
        if (self::$_instanciaGravarDAO === null) {
            self::$_instanciaGravarDAO= new gravarDAO();
            
            return self::$_instanciaGravarDAO;
        }
        return self::$_instanciaGravarDAO;
    }

    /**
     * Método responsável por gravar dos dados do usuário na tabela.
     * @method
     * @access public
     * @param string $nomeCompleto           Armazena o nome do usuário a ser gravado.
     * @param string $email                  Armazena o e-mail a ser gravado.
     * @param string $senha                  Armazena o senha a ser gravado.
     * @param string $cpf                    Armazena o CPF a ser gravado.
     * @return bool                          True, caso caso de gravação bem sucedida, false, do contrário.
     * @throws \UnderflowException           Lançada, caso um valor vazio seja informado.
     * @throws \InvalidArgumentException     Lançada, caso um valor do tipo string não seja informado.
     */    
    public function gravarDados($nomeCompleto, $email, $senha, $cpf) {
        if (\is_string($nomeCompleto) && \is_string($email) && \is_string($senha) && \is_string($cpf)) {
            if (!empty($nomeCompleto) && !empty($email) && !empty($senha) && !empty($cpf)) {
                /* @var $gravarDados string */
                $gravarDados= "INSERT INTO usuarios (nomecompleto, email, cpf, senha) VALUES "
                    . "(HEX(AES_ENCRYPT(:nomeCompleto, 'retencaoweb')),"
                    . " HEX(AES_ENCRYPT(:email, 'retencaoweb')),"
                    . " HEX(AES_ENCRYPT(:cpf, 'retencaoweb')), :senha)";

                /* @var $conexao PDO */
                $conexao= $this->_conexaoBancoDados;

                /* @var $preparar PDOStatement */
                $preparar= $conexao->prepare($gravarDados);
                $preparar->bindValue(':nomeCompleto', $nomeCompleto, \PDO::PARAM_STR);
                $preparar->bindValue(':email', $email, \PDO::PARAM_STR);
                $preparar->bindValue(':senha', $senha, \PDO::PARAM_STR);
                $preparar->bindValue(':cpf', $cpf, \PDO::PARAM_STR);

                return $preparar->execute();

            } else {
                throw new \UnderflowException('Obrigatório informar um valor');
            }
            
        } else {
            throw new \InvalidArgumentException('Tipo string é obrigatório');
        }
    }

}










