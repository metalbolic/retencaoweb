<?php

namespace core;

/**
 * Classe responsável por gerenciar a proteção da submissão de todos os formulários da aplicação.
 * @author Anderson Souza <sakn45@bol.com.br>
 * @version Alpha
 * @since 25/12/2016
 * @package core
 */
class protegeformularios {
    
    private
            /*
             * Armazena o nome do formulário a ser protegido.
             * @access private
             * @var private string
             */
            $_formulario= null,
            /*
             * @access private
             * @var string $_chaveAleatoria   Armazena a chave aleatória gerada.
             */
            $_chaveAleatoria= null;
    
    /**
     * @access public
     * @param string $formulario           Armazena o nome do formulário a ser protegido.
     * @throws \UnderflowException         Lançada, caso um valor vazio seja informado.
     * @throws \InvalidArgumentException   Lançada, caso um tipo string não seja informado. 
     */
    public function __construct($formulario) {
        if (\is_string($formulario)) {
            if (!empty($formulario)) {
                $this->_formulario= \filter_var($formulario, \FILTER_SANITIZE_STRING,
                    \FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            } else {
                throw new \UnderflowException('Obrigatório informar um valor');
            }
            
        } else {
            throw new \InvalidArgumentException('Tipo string é obrigatório');
        }
    }
    
    /**
     * @access public
     * @throws \RuntimeException        Lançada, caso haja tentativa de clonagem.
     */
    public function __clone() {
        throw new \RuntimeException('Impossível Clonagem');
    }
    
    /**
     * Método responsável por gera um token aleatório.
     * @method
     * @access public
     * @return string         Retorna a string aleatória desejada.
     */    
    public function gerarToken() {
        /* @var $horaCriacao DateTime */
        $horaCriacao= new \DateTime('now');
        $horaCriacao->add(new \DateInterval('P1M'));
        
        if ($horaCriacao->diff(new \DateTime('now')) === 1) {
            $this->_chaveAleatoria= \hash('whirlpool', \rand(-1000, 999));
            
            return $this->_chaveAleatoria;
        }
        return $this->_chaveAleatoria= \hash('whirlpool', \rand(-1000, 999));
    }
    
    public function __destruct() {
        unset($this->_chaveAleatoria, $this->_formulario);
    }
    
    
    
    
    
    
}