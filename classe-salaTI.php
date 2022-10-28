<?php
    class Maquina{
        private $pdo;

        //CONSTRUTOR //CONEXÃO COM O BANCO
        public function __construct($dbname, $host, $user, $senha){
            try{
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
            }catch(PDOException $e){
                echo "Erro com o banco de dados".$e->getMessage();
                exit();
            }catch(Exception $e){
                echo "Erro com o banco de dados".$e->getMessage();
                exit();
            }
        }

        //SELECT QUE RESULTA NAS MÁQUINAS QUE ESTÃO NA SALA DE TI
        public function buscarDados(){
            $res = array();
            $cmd = $this->pdo->query("SELECT ress.Id As id, equipamento.Placa AS Placa, equipamento.Modelo As Modelo, data AS Data, cetor.nome AS Setor, pessoa.nome AS Analista, chamado as O_S
                                      FROM (SELECT * FROM movimentacao As T2
                                      WHERE id IN (select max(id) from movimentacao as T1
                                      GROUP BY idEquipamento)) as ress
                                      INNER JOIN equipamento ON equipamento.id = ress.idEquipamento
                                      INNER JOIN cetor ON cetor.id = ress.idCetor
                                      INNER JOIN pessoa ON pessoa.id = ress.idPessoa
                                      WHERE idCetor = 9;");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //SELECT NA TABELA EQUIPAMENTO PELA PLACA
        public function busca($placa){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM equipamento WHERE placa = :p");
            $cmd->bindValue(":p",$placa);
            $cmd->execute();
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);

                if($res != true){
                    echo "Equipamento inexistente no sistema";
                }else{
                    $resultado = array();
                    $cmd = $this->pdo->prepare("SELECT ress.Id As id, equipamento.Placa AS Placa, equipamento.Modelo As Modelo, data AS Data, cetor.nome AS Setor, pessoa.nome AS Analista, chamado as O_S
                    FROM (SELECT * FROM movimentacao As T2
                    WHERE id IN (select max(id) from movimentacao as T1
                    GROUP BY idEquipamento)) as ress
                    INNER JOIN equipamento ON equipamento.id = ress.idEquipamento
                    INNER JOIN cetor ON cetor.id = ress.idCetor
                    INNER JOIN pessoa ON pessoa.id = ress.idPessoa
                    WHERE idCetor = :p;");
                    $cmd->bindValue(":p",$placa);
                    $cmd->execute();
                    $resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
                };
        }

    }
?>