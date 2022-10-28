
<?php
    require_once "classe-movimentacao.php";
    $p = new Movimentacao("dbawsbrit","localhost","root","");
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

    <title>Movimentação</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
  </head>

  <body class="p-3 mb-2 bg-light text-dark">    
    
    <!--"SALA TI" MOSTRA TODAS AS MÁQUINAS QUE ESTÃO NA SALA E DÁ A OPÇÃO DE VIMENTAÇÃO PARA CADA UMA DELAS-->
    
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

      </div>
            <!-- captura o ativo para ser setado no camp ativo -->
            <?php
                if(isset($_GET['idMov'])){
                  $setV = addslashes($_GET['idMov']);
                }             
            ?>           

            <?php
              if(isset($_POST['inputOS'])){
                
                $os = addslashes($_POST['inputOS']);
                $analista = addslashes($_POST['selectAnalista']);
                $ativo = addslashes($_POST['inputAtivo']);
                $setor = addslashes($_POST['inputSetor']); 
                          
                $resId = $p->buscarIdEquipamento($ativo); //Busca o ID e retorna na varialvel $resId

                  if(!empty($os) && !empty($analista) && !empty($ativo) && !empty($setor)){
                  
                      if($move = $p->movimentarEquipamento($os, $analista, $resId[0]['id'], $setor)){

                      }else{
                          echo "Erro com a inserção no banco";
                      }

                  }
              }

            ?>

      <div class="row">
          
          <!-- Coluna da esquerda - formulário -->
          <div class="col-6">

              <!-- Formulario -->
            <form method="POST" class="row g-3">

                <!-- Campo onde é informado a ordem de serviço que deve estar aberta e que justifique a movimentação -->
                <div class="col-md-6">
                  <label for="inputOS" class="form-label">ORDEM DE SERVIÇO</label>
                  <input type="text" class="form-control" name="inputOS" id="inputOS" placeholder="Ordem de serviço" value="">
                </div>

                <!-- Select onde é informado o analista responsável pela movimentação do equipamento -->
                <div class="col-6">
                  <label for="selectAnalista" class="form-label">ANALISTA RESPONSÁVEL</label>
                  <select name="selectAnalista" id="selectAnalista" class="form-select">

                    <option value="<?php if(isset($res)){ echo $res['idTipoEquipamento'];} ?>" selected>

                      <!-- Se o botão mover for acionado que foi enviado -->
                      <?php 
                        if(isset($res)){ 
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
                        $Tipo = $p->buscarDadosAnalista();
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
                
                <!-- Campo onde é informado o ativo da máquina a ser movimentada -->
                <div class="col-12">
                  <label for="inputAtivo" class="form-label">ATIVO DO EQUIPAMENTO</label>
                  <input type="text" class="form-control" name="inputAtivo" id="inputAtivo" 
                  placeholder="Informe a PLACA do equipamento" value="<?php if(isset($setV)){ echo $setV;} ?>">
                </div>                

                <!-- Campo onde é informado o setor de destino do equipamento -->
                <div class="col-12">
                  <label for="inputSetor" class="form-label">SETOR PARA ONDE SERÁ MOVIDO</label>
                  <select name="inputSetor" id="inputSetor" class="form-select" value="">
                    <option value="" selected>
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
                    <button class="btn btn-primary" type="submit" >MOVER EQUIPAMENTO</button>                    
                </div>            

            </form>
          </div>
         
          <!-- Coluna da direita - listagem das máquinas do setor ---------------------------------------------------------------------------------------->
          <div class="col-6">
            <form method="POST" class="row g-3">
              <!-- select para listar os setores -->
              <div class="col-8">
                    <label for="inputSetorList" class="form-label">LISTAGEM DE EQUIPAMENTOS QUE ESTÃO NO SETOR</label>
                    <select name="inputSetorList" id="inputSetorList" class="form-select" value="">
                      <option value="" selected>
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
                      <?php //LISTA TODOS OS SETORES
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
                    
                    <button type="submit" class="btn btn-outline-primary"> LISTAR EQUIPAMENTOS</button>
            </form>
          </div>

            <div class="col-12" style="background-color: #deeaf3;">
                <table class="table">
                  <thead class="table-dark">
                      <tr>                        
                          <td>DATA</td>
                          <td>EQUIPAMENTO</td>
                          <td>MODELO</td>
                          <td></td>
                          <td></td>
                      </tr>
                  </thead>                              
                  <tbody>
                      <!-- captura o ativo para listar máquinas -->
                      <?php
                          if(isset($_POST['inputSetorList'])){
                            $EQP = addslashes($_POST['inputSetorList']);                  
                            if($listEQP = $p->buscarDadosEQP($EQP)){
                              if(count($listEQP) > 0){
                                for($i=0; $i<count($listEQP);$i++){                       
                                    echo "<tr>";  
                                        foreach($listEQP[$i] as $k => $v){
                                            if($k != "id"){
                                                echo"<td>".$v."</td>";
                                            }
                                        } 

                                        ?>                              
                                        <td><a href="movimentacao.php?idMov=<?php echo $listEQP[$i]['equipamento'];?>" >
                                        <button type="button" class="btn btn-outline-primary">MOVER</button></a><td><tr>
                                      <?php  
                                }
                              }
                            }
                          }        
                      ?>                  
                  </tbody>

                </table>
              </div>

            </div>
          </div>
      </div> 

      <div class="row">
          <div class="col-12">
            
              <?php
                  if(isset($move)){
                    ?>
                      <table class="table">
                          <thead class="table-dark">
                              <tr>                        
                                  <td>MOVIDO PARA</td>
                                  <td>DATA</td>
                                  <td>ANALISTA</td>
                                  <td>CHAMADO</td>
                                  <td>ATIVO</td>                              
                              </tr>
                          </thead>                          
                      <tbody>
                        <?php //LISTA OS DADOS NA TELA
                          $dadosMov = $p->buscarDadosMov();
                          //var_dump($dadosMov);
                          if(count($dadosMov) > 0){
                              for($i=0; $i<count($dadosMov);$i++){                        
                                  echo "<tr>";  
                                      foreach($dadosMov[$i] as $k => $v){
                                          if($k != "id"){
                                              echo"<td>".$v."</td>";
                                          }
                                      }                       
                                ?>                              
                                <?php
                              }
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
                  <?php
                  }
              ?>
        
                         
          </div>
      </div>
  </body>

  
</html>