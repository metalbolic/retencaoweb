<?php

namespace classes;

require_once '../classemodelo/validardadosusuarios.php';

use classemodelo\validardadosusuarios;

/**
 * Classe responsável por processar todos os dados recebidos do formulário de cadastro.
 * @author Anderson Souza <sakn45@bol.com.br>
 * @version Alpha
 * @since 24/12/2016
 * @package classes
 */
class processarregistro extends validardadosusuarios {
    
    private
            /*
             * @access private
             * @var string $_nomeCompleto representa o nome completo do usuário.
             */
            $_nomeCompleto= null,
            /*
             * @access private
             * @var string $_email representa o e-mail do usuário.
             */
            $_email= null,
            /*
             * @access private
             * @var string $_senha representa a senha do usuário.
             */
            $_senha= null,
            /*
             * @access private
             * @var string $_senha2 representa a contra senha do usuário.
             */
            $_senha2= null,
            /*
             * @access private
             * @var string $_cpf representa o C.P.F do usuário.
             */
            $_cpf= null;
    
    /**
     * @access public
     * @param string $nomeCompleto        Representa o nome completo do usuário.
     * @param string $email               Representa o e-mail do usuário.
     * @param string $senha               Representa a senha do usuário.
     * @param string $senha2              Representa a contra senha do usuário.
     * @param string $cpf                 Representa o cpf do usuário.
     * @throws \UnderflowException        Lançada, caso um valor vazio seja informado.
     * @throws \InvalidArgumentException  Lançada, caso um valor do tipo string não seja informado.
     */
    public function __construct($nomeCompleto, $email, $senha, $senha2, $cpf) {
        if (\is_string($nomeCompleto) && \is_string($email) && \is_string($senha) && \is_string($senha2)
            && \is_string($cpf)) {        
            if (!empty($nomeCompleto) && !empty($email) && !empty($senha) && !empty($senha2) && !empty($cpf)) {
                $this->_nomeCompleto= \filter_var($nomeCompleto, \FILTER_SANITIZE_STRING,
                    \FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->_email= \filter_var($email, \FILTER_SANITIZE_EMAIL, \FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->_senha= \filter_var($senha, \FILTER_SANITIZE_STRING, \FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->_senha2= \filter_var($senha2, \FILTER_SANITIZE_STRING, \FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->_cpf= \filter_var($cpf, \FILTER_SANITIZE_STRING, \FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            } else {
                throw new \UnderflowException('Obrigatório informar um valor');
            }
            
        } else {
            throw new \InvalidArgumentException('Tipo String é obrigatório');
        }
    }
    
    /**
     * @access public
     * @throws \RuntimeException       Lançada, caso haja uma tentativa de clonagem da classe.
     */
    public function __clone() {
        throw new \RuntimeException('Impossível clonagem');
    }
    
    /**
     * Método responsável por validar todos os dados do usuário.
     * @method
     * @access private
     * @return bool                 Caso todos os dados sejam válidos.
     */
    private function validarTodosDados() {
        if (parent::validarCPF($this->_cpf) && parent::validarEmail($this->_email)
            && parent::validarNome($this->_nomeCompleto) && parent::validarSenha($this->_senha)
            && parent::validarSenha($this->_senha2) && parent::verificarIgualdade($this->_senha, $this->_senha2)) {
            return true;
        }
        return false;
    }

    /**
     * Método responsável por retornar um determinado dado do usuário.
     * @method
     * @access pubblic
     * @param string $dado                     O dado que deseja-se recuperar.
     * @return string                          Retorna o dado desejado.
     * @throws \UnexpectedValueException       Lançada caso haja tentativa de acessar um dado inexistente.
     * @throws \ErrorException                 Lançada caso haja tentativa de acessar um dado inacessível.
     * @throws \UnderflowException             Lançada caso um valor vazio seja informado.
     * @throws \InvalidArgumentException       Lançadda, caso um valor do tipo String não seja finromado.
     * @throws \UnexpectedValueException       Lançada, caso um dado seja inválido.
     */
    public function obterDadosUsuarios($dado) {
        if ($this->validarTodosDados()) {
            if (\is_string($dado)) {
                if (!empty($dado)) {
                    if ($dado !== '_senha' || $dado !== '_senha2') {
                        if (property_exists(processarregistro::class, $dado)) {
                            return $this->$dado;

                        } else {
                            throw new \UnexpectedValueException('Dado inexistente');
                        }

                    } else {
                        throw new \ErrorException('Impossível acessar');
                    }

                } else {
                    throw new \UnderflowException('Obrigatório informar um valor');
                }

            } else {
                throw new \InvalidArgumentException('Tipo string é obrigatório');
            }
            
        } else {
            throw new \UnexpectedValueException('Dados inválidos');
        }
    }
    
    /**
     * Método responsável por retornar a senha do usuário.
     * @method
     * @access public
     * @return string                           A senha.
     * @throws \UnexpectedValueException        Lançada caso um problema na validação da senha.
     */
    public function obterSenhaUsuarios() {
        if (parent::validarSenha($this->_senha) && parent::verificarIgualdade($this->_senha, $this->_senha2)) {
            return password_hash($this->_senha, \PASSWORD_DEFAULT);
            
        } else {
            throw new \UnexpectedValueException('Senha inválida');
        }
        
    }

    public function __destruct() {
        unset($this->_cpf, $this->_email, $this->_nomeCompleto, $this->_senha, $this->_senha2);
    }

}
