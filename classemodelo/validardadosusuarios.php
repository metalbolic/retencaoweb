<?php

namespace classemodelo;

/**
 * @author Anderson Souza <sakn45@bol.com.br>
 * @abstract
 * @version Alpha
 * @since 24//12/2016
 * @package classemodelo
 */
abstract class validardadosusuarios {
    
    /**
     * Método é responsável por validar o padrão exigido para o nome do usuário.
     * @method
     * @access protected
     * @param string $nomeUsuario    Representa o nome do usuário, a ser validado.
     * @return bool                  Caso o padrão exigido seja respeitado.
     */
    protected function validarNome($nomeUsuario) {        
        return preg_match('/[a-z0-9 ]+/', $nomeUsuario);
    }
    
    /**
     * Método é responsável por validar o padrão exigido para o e-mail do usuário.
     * @method
     * @access protected
     * @param string $email          Representa o e-mail do usuário a ser validado.
     * @return bool                  Caso o padrão exigido seja respeitado.
     */
    protected function validarEmail($email){
        return preg_match('/[a-z0-9\._-]+@{1}[a-z]+\.{1}[a-z]{2,3}\.?[a-z]{0,2}$/', $email);
    }
    
    /**
     * Metodo é responsável por validar o padrão exigido para o CPF do usuário.
     * @method
     * @access protected
     * @param string $cpf            Representa o C.P.F a ser validado.
     * @return bool                  Caso o padrão exigido seja respeitado.
     */
    protected function validarCPF($cpf) {
        return preg_match('/([0-9]+\.{1})([0-9]+\.{1})([0-9]+-{1})([0-9]{2}$)/', $cpf);
    }
    
    /**
     * Método e responsável por validar o padrão exigido para a senha e contra senha do usuário.
     * @method
     * @access protected
     * @param string $senha         Representa a senha a ser validada.
     * @return bool                 Caso o padrão exigido seja respeitado.
     */
    protected function validarSenha($senha) {
        return preg_match('/[a-zA-Z0-9!@#$%¨&*]{8,}/', $senha);
    }
    
    /**
     * Método responsável por verificar a igualdade das senhas informadas pelo usuário.
     * @method
     * @access protected
     * @param string $senha          Representa a senha informada pelo usuário.
     * @param string $senha2         Representa a contra senha informada pelo usuário.
     * @return bool                  Caso o padrão exigido seja respeitado.
     */
    protected function verificarIgualdade($senha, $senha2) {
        return \strcasecmp($senha2, $senha) === 0 ? true : false;
    }    
}
