<?php

namespace interfaces;

/**
 * Interface responsável por fornecer os principais métodos de persistência de dados.
 * @author Anderson Souza <sakn45@bol.com.br>
 * @version Alpha
 * @since 25/12/2016
 * @package interfaces
 */
interface persistenciadados {
    
    public function gravarDados($nomeCompleto, $email, $senha, $cpf);

}
