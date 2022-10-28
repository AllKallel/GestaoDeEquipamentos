<?php
    require_once "classe-salaTI.php";
    $p = new maquina("dbawsbrit","localhost","root","");
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <title>AWSBRIT SYSTEM</title>
     
     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" 
    integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" 
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!--CSS -->
    <link rel="stylesheet" href="css/styleaws.css"> 
    
  </head>

  <body class="p-3 mb-2 bg-light text-dark">

            <?php
              //QUANDO A VARIÁVEL ID É ENVIADA PELO BOTÃO EXCLUIR
              if(isset($_GET['id'])){
                  $idEq = addslashes($_GET['id']);        
                  $p->excluirEquipamento($idEq);         
                  header("Location:index.php");
                  exit; 
              }
              
            ?>
      <header class="fixed-top">  
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  <img id="logo" src="img/logoawsbrit.png" alt="logo awsbrit">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <a class="nav-link" href="#">SALA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">MOVER</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">CADASTRAR</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>                   
      </header>            

        <!-- Linha geral -->
        <div class="row">

                
              

              <?php
                //QUANDO CLICOU NO BOTÃO EDITAR OU CADASTRAR

                  if(isset($_POST['inputPlaca'])){
                    /** -------------------------------------UPDATE DE EQUIPAMENTO --------------------------------*/
                    if(isset($_GET['id_upd']) && !empty($_GET['id_upd'])){

                      $idUpd = addslashes($_GET['id_upd']);
                      $ativo = addslashes($_POST['inputPlaca']);
                      $modelo = addslashes($_POST['inputModelo']);
                      $serial = addslashes($_POST['inputSerial']);
                      $tipoEquipamento = addslashes($_POST['inputTipo']);
                      $setor = addslashes($_POST['inputSetor']);

                        if(!empty($ativo) && !empty($modelo) && !empty($serial) && !empty($tipoEquipamento) && !empty($setor)){
                                        
                            if($p->atualizarEquipamento($idUpd, $ativo, $modelo, $serial, $tipoEquipamento, $setor)){
                              header("location: index.php");
                            }else {
                              ?>
                            <div class="row">                            
                                <button type="button" class="btn btn-danger">ERRO NO RETORNO DO BANCO</button>
                             </div>
                            <?php
                            }
                        }else {                 
                            ?>
                            <div class="row">                            
                                <button type="button" class="btn btn-danger">PREENCHA TODOS OS CAMPOS</button>
                             </div>
                            <?php
                        }
                    }else { /** -------------------------------------INSERT DE EQUIPAMENTO --------------------------------*/
                      $ativo = addslashes($_POST['inputPlaca']);
                      $modelo = addslashes($_POST['inputModelo']);
                      $serial = addslashes($_POST['inputSerial']);
                      $tipoEquipamento = addslashes($_POST['inputTipo']);
                      $setor = addslashes($_POST['inputSetor']);

                        if(!empty($ativo) && !empty($modelo) && !empty($serial) && !empty($tipoEquipamento) && !empty($setor)){
                                //ATUALIZANDO DADOS PESSOA                
                          $p->cadastrarEquipamento($ativo, $modelo, $serial, $tipoEquipamento, $setor);
                          header("location: index.php");                          
                            
                        }else {                      
                            ?>
                            <div class="row">                            
                                <button type="button" class="btn btn-danger">PREENCHA TODOS OS CAMPOS</button>
                             </div>
                            <?php
                        }
                    }

                    
                  }
              ?>

              <!-- função que busca os valores e seta nos campos quando o botão EDITAR é acionado -->
              <?php         
                if(isset($_GET['id_upd'])){
                  $id_update = addslashes($_GET['id_upd']);
                  $res = $p->buscarDadosEquipamento($id_update);
                }
              ?>

          <div class="col-8" style="background-color: #deeaf3;">
            <table class="table">
                <thead class="table-dark">
                    <tr>                        
                        <td>PLACA</td>
                        <td>MODELO</td>
                        <td>SERIAL</td>
                        <td>TIPO</td>
                        <td>SETOR</td>
                        <td></td>
                    </tr>
                </thead>                              
                <tbody>
                 <?php //LISTA OS DADOS NA TELA
                        $dados = $p->buscarDados();
                        if(count($dados) > 0){
                            for($i=0; $i<count($dados);$i++){                        
                                echo "<tr>";  
                                    foreach($dados[$i] as $k => $v){
                                        if($k != "Id"){
                                            echo"<td>".$v."</td>";
                                        }
                                    }                       
                              ?>                              
                                <td><a href="index.php?id_upd=<?php echo $dados[$i]['Id'];?>" ><button type="button" class="btn btn-outline-primary">Editar</button></a>
                                <a href="index.php?id=<?php echo $dados[$i]['Id'];?>" ><button type="button" class="btn btn-outline-danger">Excluir</button></a></td></tr>
                              <?php
                            }

                          //AREA DE TEST
                          //$Tipo = $p->buscarDadosTipo();
                          //$pSetor = $p->buscarDadosSetor();                
                          //var_dump($updateTipo);
                          //$i = 1;
                            //foreach($Tipo[$i] as $k => $v){                                                             
                            //  if($k != "nome"){
                            //    echo $v;
                            //  }
                          // }
                        }else{
                          ?>                         
                          <div class="d-grid gap-10">
                              <button type="button" class="btn btn-danger">AINDA NÃO HÁ MAQUINAS CADASTRADAS</button>                   
                          </div> 
                          <?php
                        }                      
                        
                    ?> 
                </tbody>

            </table>
          </div>

        </div>
        

      </div>


  </body>

  
</html>

