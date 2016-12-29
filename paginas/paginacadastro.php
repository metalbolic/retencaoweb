<?php

session_start();
session_name(hash('whirlpool', rand(-1000, 999)));

include_once '../core/protegeformularios.php';

use core\protegeformularios;

$_SESSION['host']= filter_input(INPUT_SERVER, 'HTTP_HOST');

$_SESSION['uri']= filter_input(INPUT_SERVER, 'REQUEST_URI');

/* @var $protegeFormulario string */
$protegeFormulario= new protegeformularios('paginacadastro');

/* @var $token string */
$token= $protegeFormulario->gerarToken();

$_SESSION['chaveAleatoria']= $token;

session_write_close();

?>

<!DOCTYPE html>

<html lang="pt-Br">
    <head>
        <title>Página de Cadastro Usuários</title>
        <?php require_once '../core/cabecalhointernopaginas.php'; ?>
    </head>
    
    <body class="hold-transition register-page">
        <div class="register-box">
          <div class="register-logo">
            <b>Cadastre-se</b>
          </div>

          <div class="register-box-body">
            <p class="login-box-msg">Insira seus dados para cadastro</p>

            <form action="../scripts/gravar.php" method="post" role="form">
                
              <div class="form-group has-feedback">
                  <input type="text" class="form-control" name="nomecompleto"
                        placeholder="Informe Seu Nome Completo" required>
                <span class="fa fa-user form-control-feedback"></span>
              </div>
                
              <div class="form-group has-feedback">
                  <input type="email" class="form-control" name="email" placeholder="Informe seu e-mail" required>
                <span class="fa fa-envelope form-control-feedback"></span>
              </div>
                
              <div class="form-group has-feedback">
                  <input type="password" class="form-control" name="senha" placeholder="Informe sua senha" required>
                <span class="fa fa-lock form-control-feedback"></span>
              </div>
                
              <div class="form-group has-feedback">
                  <input type="password" class="form-control" name="senha2" placeholder="Informe novamente a senha" required>
                <span class="fa fa-lock form-control-feedback"></span>
              </div>
                
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="cpf"
                        placeholder="Informe seu C.P.F ex: (111.111.111-11)" required>
                    <span class="fa fa-file form-control-feedback"></span>
                </div>
                
                <div class="form-group">
                    <input type="hidden" class="form-control" name="chaveAleatoria" value="<?php echo $token; ?>">
                </div>                
                
              <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Cadastrar</button>
                </div>
                <!-- /.col -->
              </div>          
            </form>
          <!-- /.form-box -->
          </div>
        <!-- /.register-box -->
        </div>
        
    </body>
    
</html>
