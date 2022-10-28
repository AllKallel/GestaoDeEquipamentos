<?php
    require_once "classe-sala.php";
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

    <title>Sala TI</title>
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
      
      <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <!-- Navbar content -->

          <div class="col-12" style="background-color: #deeaf3;">
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

