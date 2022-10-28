<?php
    class Movimentacao{
        private $pdo;

        //CONSTRUTOR
        //CONEXÃO COM O BANCO
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

        //SELECT NA TABELA EQUIPAMENTO
        public function buscarDados(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM equipamento ORDER BY id");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        
        //SELECT NA TABELA EQUIPAMENTO PARA LISTAGEM DAS 
        public function buscarDadosEQP($id){
            $resList = array();
            $cmd = $this->pdo->prepare("SELECT ress.id AS id, ress.data AS data, equipamento.Placa AS equipamento, equipamento.Modelo As modelo
                                        FROM (SELECT * FROM movimentacao As T2
                                        WHERE id IN (select max(id) from movimentacao as T1
                                        GROUP BY idEquipamento)) as ress
                                        INNER JOIN equipamento ON equipamento.id = ress.idEquipamento
                                        WHERE idCetor = :i;");
            $cmd->bindValue(":i",$id);
            $cmd->execute();
            $resList = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $resList;
        }
        

        //SELECT NA TABELA MOVIMENTACAO*****************************************************************************
        public function buscarDadosMov(){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT cetor.nome as snome,  movimentacao.data, pessoa.nome, movimentacao.chamado, equipamento.placa FROM movimentacao
                                      INNER JOIN pessoa ON pessoa.id = movimentacao.idPessoa
                                      INNER JOIN equipamento ON equipamento.id = movimentacao.idEquipamento
                                      INNER JOIN cetor ON cetor.id = movimentacao.idCetor                                   
                                      ORDER BY movimentacao.id desc
                                      LIMIT 10");
            $cmd->execute();
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        
        //SELECT NA TABELA PESSOA 
        public function buscarDadosAnalista(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY id");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }      
        
        public function buscarDadosTipoNome($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT pessoa FROM tipoEquipamento WHERE Id = :i");
            $cmd->bindValue(":i",$id);
            $cmd->execute();
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            return $res;
        }
        /***************************************BUSCA NOME DO SETOR PELO ID*******************************************************/
        public function buscarDadosSetorNome($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT nome FROM cetor WHERE Id = :i");
            $cmd->bindValue(":i",$id);
            $cmd->execute();
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            return $res;
        }

        //SELECT PELO NOME NA TABELA EQUIPAMENTO RETORNANDO O ID******************************************************************        
        public function buscarIdEquipamento($ativo){
            $resId = array();
            $cmd = $this->pdo->prepare("SELECT id FROM equipamento WHERE Placa LIKE :i");
            $cmd->bindValue(":i",$ativo);
            $cmd->execute();
            $resId = $cmd->fetchAll(PDO::FETCH_ASSOC);  

            return $resId;
        }

        //SELECT NA TABELA SETOR*************************************************************************************************
        public function buscarDadosSetor(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM cetor ORDER BY id");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        /*******************************************FUNÇÃO PARA MOVIMENTAR EQUIPAMENTO******************************************/
        public function movimentarEquipamento($chamado, $pessoa, $ativo, $setor){
                       
                $cmd = $this->pdo->prepare("INSERT INTO movimentacao (chamado, idPessoa, idEquipamento, idCetor)
                                          VALUES (:c, :p, :a, :s)");
                $cmd->bindValue(":c",$chamado);
                $cmd->bindValue(":p",$pessoa);
                $cmd->bindValue(":a",$ativo);
                $cmd->bindValue(":s",$setor);
                $cmd->execute();

                return true;                        
        }
        /***********************************************************************************************************************/

        //FUNCTION PARA EXCUIR EQUIPMENTO
        public function excluirEquipamento($id){
            $cmd = $this->pdo->prepare("DELETE FROM equipamento WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();           
        }

        //FUNCTION PARA BUSCAR OS DADOS DA MAQUINA
        public function buscarDadosEquipamento($id){
            $resultado = array();
            $cmd = $this->pdo->prepare("SELECT * FROM equipamento WHERE id = :id");
            $cmd->bindValue(':id',$id);
            $cmd->execute();
            $resultado = $cmd->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        //FUNCTION PARA ATUALIZAR DADOS DO EQUIPAMENTO
        public function atualizarEquipamento($id, $placa, $modelo, $sn, $tEquipamento, $setor){

           $cmd = $this->pdo->prepare("UPDATE equipamento SET placa = :p, modelo = :m, sn = :n, idTipoEquipamento = :t, idCetorDesignado = :s WHERE id = :i");
                
                $cmd->bindValue(":i",$id);
                $cmd->bindValue(":p",$placa);
                $cmd->bindValue(":m",$modelo);
                $cmd->bindValue(":n",$sn);
                $cmd->bindValue(":t",$tEquipamento);
                $cmd->bindValue(":s",$setor);
                $cmd->execute();

                return true;
                        
        }
        
    }
?>