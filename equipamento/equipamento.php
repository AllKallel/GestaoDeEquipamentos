<?php
    require_once "classe-equipamento.php";
    $p = new maquina("dbawsbrit","localhost","root","");
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!--CSS -->
    <link href="css/style.css " rel="stylesheet">

    <title>AWSBRIT SYSTEM</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
  </head>

  <body class="p-3 mb-2 bg-light text-dark">

  <?php
    //QUANDO A VARIÁVEL ID É ENVIADA PELO BOTÃO EXCLUIR
    if(isset($_GET['id'])){
        $idEq = addslashes($_GET['id']);        
        $p->excluirEquipamento($idEq);         
        header("Location:equipamento.php");
        exit; 
    }
    
?>

                 
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <nav class="navbar navbar-light ">
            <div class="container-fluid">
              <a class="navbar-brand">AWSBRIT</a>            
            </div>
          </nav>
      </nav>
      
      <nav class="navbar navbar-dark bg-primary">
        <!-- Navbar content -->
      </nav>
      
      <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <!-- Navbar content -->

      <!-- Corpo -->
      <div class="container-fluid">

        <!-- Linha geral -->
        <div class="row">

          <!-- Colunas -->
            <div class="col-4" style="background-color: #6c808f;">
                <div class="row">                       
                <div class="col-12" ><h2 class="text-center">CADASTRO DE EQUIPAMENTOS<h2></div>                    
            </div>
                      
              

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
              
              <!-- Formulario -->
              <form method="POST" class="row g-3">

                <!-- Campo onde é informado o ativo/placa -->
                <div class="col-md-6">
                  <label for="inputPlaca" class="form-label">PLACA</label>
                  <input type="text" class="form-control" name="inputPlaca" id="inputPlaca" placeholder="Placa / Ativo" value="<?php if(isset($res)){ echo $res['Placa'];} ?>">
                </div>

                <!-- Campo onde é informado o modelo -->
                <div class="col-md-6">
                  <label for="inputmodelo" class="form-label">MODELO</label>
                  <input type="text" class="form-control" name="inputModelo" id="inputModelo" placeholder="Modelo da Máquina" value="<?php if(isset($res)){ echo $res['Modelo'];} ?>">
                </div>

                <!-- Campo onde é informado o Serial number -->
                <div class="col-12">
                  <label for="inputSerial" class="form-label">SN</label>
                  <input type="text" class="form-control" name="inputSerial" id="inputSerial" placeholder="Serial Number" value="<?php if(isset($res)){ echo $res['sn'];} ?>">
                </div> 

                <!-- Campo onde é informado o tipo de equipamento -->
                <div class="col-6">
                  <label for="inputTipo" class="form-label">TIPO</label>
                  <select name="inputTipo" id="inputTipo" class="form-select">

                    <option value="<?php if(isset($res)){ echo $res['idTipoEquipamento'];} ?>" selected>
                      <?php 
                        if(isset($res)){ 
                          //BUSCA O TIPO DO EQUIPAMENTO PELO ID E RETORNA O NOME DO EQUIPAMENTO
                          $updateTipo = $p->buscarDadosTipoNome($res['idTipoEquipamento']);
                            foreach($updateTipo[0] as $k => $v){                            
                              echo $v;
                            }
                        } else{
                          echo 'Choose...';
                        }
                      ?>
                    </option>
                    <?php //LISTA OS TIPOS DE EQUIPAMENTOS
                        $Tipo = $p->buscarDadosTipo($res['idTipoEquipamento']);
                        for($i=0; $i<count($Tipo);$i++){
                          //seta o valor do select com o id
                          ?><option value="<?php foreach($Tipo[$i] as $k => $v){                                                             
                            if($k != "nome"){
                              echo $v;
                            }
                          }?>"><?php 
                                                                             
                          foreach($Tipo[$i] as $k => $v){
                            if($k != "Id"){
                              echo $v;
                            }
                          }
                            echo "</option>";
                        }                        
                    ?>
                   
                  </select>
                </div> 
            
                <!-- Campo onde é informado o setor de destino do equipamento -->
                <div class="col-6">
                  <label for="inputSetor" class="form-label">SETOR</label>
                  <select name="inputSetor" id="inputSetor" class="form-select" value="<?php if(isset($res)){ echo $res['idCetorDesignado'];} ?>">
                    <option value="1" selected>
                      <?php 
                        if(isset($res)){ 
                          //BUSCA O  NOME DO SETOR PELOS ID
                          $updateSetor = $p->buscarDadosSetorNome($res['idCetorDesignado']);
                            foreach($updateSetor[0] as $k => $v){                            
                              echo $v;
                            }
                        } else{
                            echo 'Choose';
                          }
                      ?>
                    </option>
                    <?php //LISTA OS TIPOS DE SETOR
                        $pSetor = $p->buscarDadosSetor();
                        
                        for($i=0; $i<count($pSetor);$i++){
                          //seta o valor do select com o id
                          ?><option value="<?php foreach($pSetor[$i] as $k => $v){                                                             
                            if($k != "nome"){
                              echo $v;
                            }
                          }?>"><?php                       
                          foreach($pSetor[$i] as $k => $v){                                                             
                            if($k != "Id"){
                              echo $v;
                            }
                          }
                            echo "</option>";
                        }                        
                    ?> 
                  </select>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit" ><?php if(isset($res)){echo "ATUALIZAR";}else{echo "CADASTRAR";} ?></button>                    
                </div>            
                
              </form>
            </div>


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
                                <td><a href="equipamento.php?id_upd=<?php echo $dados[$i]['Id'];?>" ><button type="button" class="btn btn-outline-primary">Editar</button></a>
                                <a href="equipamento.php?id=<?php echo $dados[$i]['Id'];?>" ><button type="button" class="btn btn-outline-danger">Excluir</button></a></td></tr>
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

