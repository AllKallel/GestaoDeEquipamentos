<?php
    class Maquina{
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

        //SELECT NA TABELA PESSOA 
        public function buscarDadosAnalista(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY id DESC");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //SELECT NA TABELA TIPOEQUIPAMENTO 
        public function buscarDadosTipo(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM tipoEquipamento ORDER BY id");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //BUSCA NOME DO EQUIPAMENTO PELO ID
        public function buscarDadosTipoNome($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT nome FROM tipoEquipamento WHERE Id = :i");
            $cmd->bindValue(":i",$id);
            $cmd->execute();
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            return $res;
        }

        //BUSCA NOME DO SETOR PELO ID
        public function buscarDadosSetorNome($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT nome FROM cetor WHERE Id = :i");
            $cmd->bindValue(":i",$id);
            $cmd->execute();
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            return $res;
        }

        //SELECT NA TABELA SETOR 
        public function buscarDadosSetor(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM cetor ORDER BY id");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //FUNÇÃO PARA CADASTRAR EQUIPAMENTO
        public function cadastrarEquipamento($placa, $modelo, $sn, $tEquipamento, $setor){

            //VERIFICAR ANTES SE ATIVO JÁ EXISTE
            $cmd = $this->pdo->prepare("SELECT id FROM equipamento WHERE placa = :e");
            $cmd->bindValue(":e",$placa);
            $cmd->execute();

            if($cmd->rowCount() > 0){
                return false;
               // var_dump($cmd);
            }else{
                $cmd = $this->pdo->prepare("INSERT INTO equipamento (placa, modelo, sn, idTipoEquipamento, idCetorDesignado)
                                          VALUES (:p, :m, :n, :t, :s)");
                $cmd->bindValue(":p",$placa);
                $cmd->bindValue(":m",$modelo);
                $cmd->bindValue(":n",$sn);
                $cmd->bindValue(":t",$tEquipamento);
                $cmd->bindValue(":s",$setor);
                $cmd->execute();

                return true;
            }
                        
        }

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

        /*FUNCTION PARA ATUALIZAR DADOS DO EQUIPAMENTO
        public function atualizarEquipamento($id, $placa, $modelo, $sn, $tEquipamento, $setor){
            
                $cmd = $this->pdo->prepare("UPDATE equipamento SET (placa, modelo, sn, idTipoEquipamento, idCetorDesignado)
                VALUES (:p, :m, :n, :t, :s)")
                ;
 
                $cmd->bindValue(":p",$placa);
                $cmd->bindValue(":m",$modelo);
                $cmd->bindValue(":n",$sn);
                $cmd->bindValue(":t",$tEquipamento);
                $cmd->bindValue(":s",$setor);
                $cmd->execute();

                return true;
            }

            
        }*/
    }
?>