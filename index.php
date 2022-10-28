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

    <!--icons bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!--CSS -->
    <link rel="stylesheet" href="css/css1.css"> 
    
  </head>

  <body class="p-3 mb-2 bg-secondary-color text-dark">

      <!--NAVBAR------------------------------------------------------------------------------------------>
      <nav class="navbar navbar-expand-lg fixed-top bg-primary-color" id="navbar">
          <div class="container py-3">
              <a href="index.php" class="navbar-brand">
                <img src="img/logo.png" alt="logotipo">
                <span><i class="bi bi-pc-display-horizontal"></i></span>
              </a>
              <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar-items"
                aria-controls="navbar-items"
                aria-expanded="false"
                aria-label="toggle navigation"
              >
                <i class="bi bi-list"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbar-items">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                          <a href="index.php" class="nav-link active primary-color" aria-current="page">INICIO</a>
                      </li>
                      <li class="nav-item">
                          <a href="equipamento/equipamento.php" class="nav-link primary-color">CAD-EQUIPAMENTO</a>
                      </li>
                      <li class="nav-item">
                          <a href="movimentacao/movimentacao.php" class="nav-link primary-color">MOV-EQUIPAMENTO</a>
                      </li>
                  </ul>

                  <form class="d-flex" method="post">
                  <input class="form-control me-2" type="text" placeholder="Placa" aria-label="Search" id="search" name="search">
                  <button class="btn btn-outline-primary" type="submit">Search</button>
                  </form>
              </div>
            </div>
      </nav>
      


      <!-- Linha geral ----------------------------------------------------------------------------------->
      <div class="row body-line" id="body-line">

          <div class="col-4" style="background-color: #deeaf3;">
                <?php
                    if(isset($_POST['search'])){
                            
                        $search = addslashes($_POST['search']);

                        ?>
                            <table class="table">
                <thead class="table-dark">
                    <tr>                        
                        <td>PLACA</td>
                        <td>MODELO</td>
                        <td>DATA</td>
                        <td>SETOR</td>
                        <td>ANALISTA</td>
                        <td>O.S</td>
                        <td></td>
                    </tr>
                </thead>                              
                <tbody>
                 <?php //LISTA OS DADOS NA TELA
                        $dados = $p->busca();
                        if(count($dados) > 0){
                            for($i=0; $i<count($dados);$i++){                        
                                echo "<tr>";  
                                    foreach($dados[$i] as $k => $v){
                                        if($k != "id"){
                                            echo"<td>".$v."</td>";
                                        }
                                    }                       
                              ?>                              
                                <td><a href="movimentacao/movimentacao.php?idMov=<?php echo $dados[$i]['Placa'];?>" ><button type="button" class="btn btn-outline-primary">Mover</button></a></td></tr>
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

          <div class="col-8" style="background-color: #deeaf3;">
          

          
            <table class="table">
                <thead class="table-dark">
                    <tr>                        
                        <td>PLACA</td>
                        <td>MODELO</td>
                        <td>DATA</td>
                        <td>SETOR</td>
                        <td>ANALISTA</td>
                        <td>O.S</td>
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
                                        if($k != "id"){
                                            echo"<td>".$v."</td>";
                                        }
                                    }                       
                              ?>                              
                                <td><a href="movimentacao/movimentacao.php?idMov=<?php echo $dados[$i]['Placa'];?>" ><button type="button" class="btn btn-outline-primary">Mover</button></a></td></tr>
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
          </div>
      </div>
  </body>  
</html>

