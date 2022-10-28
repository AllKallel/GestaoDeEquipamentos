create database unisys;

use unisys;

create table Categoria(
	idCategoria int not null primary key auto_increment,
	nomeCategoria varchar(30) unique) type=InnoDB;
	
create table Produto(
	idProduto int not null primary key auto_increment,
	nomeProduto varchar(30) unique,
	idCategoria int,	
	preco numeric(10,2) check (preco >= 0),
	estoque int check(estoque >= 0),
	FOREIGN KEY (idCategoria) references Categoria(idCategoria) ON UPDATE CASCADE ON DELETE RESTRICT) type=InnoDB;

create table Vendedor(
	idVendedor int not null primary key auto_increment,
	nomeVendedor varchar(30),
	comissao numeric(10,2)) type=InnoDB;
	
create table Cliente(
	idCliente int not null primary Key auto_increment,
	nomeCliente varchar(30),
	cpf char(11) unique,
	telefone varchar(12),
	sexo char(1) check(sexo='M' or sexo='F')) type=InnoDB;

create table Venda(
	idVenda int not null primary Key auto_increment,
	idCliente int,
	idVendedor int,
	dataVenda datetime,
	FOREIGN KEY (idCliente) references Cliente(idCliente) ON UPDATE RESTRICT ON DELETE RESTRICT,
	FOREIGN KEY (idVendedor) references Vendedor(idVendedor) ON UPDATE RESTRICT ON DELETE RESTRICT) type=InnoDB;

create table ItemVenda(
	idItemVenda int not null primary Key auto_increment,
	idVenda int,
	idProduto int,
	quant int,
	precoVenda numeric(10,2),
	desconto numeric(10,2),
	FOREIGN KEY (idVenda) references Venda(idVenda)	ON UPDATE RESTRICT ON DELETE RESTRICT,
	FOREIGN KEY (idProduto) references Produto(idProduto) ON UPDATE RESTRICT ON DELETE RESTRICT) type=InnoDB;
	
--Insert

insert into Categoria(nomeCategoria) values('Bebidas');	
insert into Categoria(nomeCategoria) values('Brinquedos');	

insert into Produto(nomeProduto,idCategoria, preco, estoque) values('Coca-Cola',1,5.50,100);	
insert into Produto(nomeProduto,idCategoria, preco, estoque) values('Bola Jabulani',2,100,10);	

insert into Vendedor(nomeVendedor,comissao) values('Juvenal',3.5);
insert into Vendedor(nomeVendedor,comissao) values('Mesquita',2.5);
insert into Vendedor(nomeVendedor,comissao) values('Raphael Dias Oliveira',3.5);	
insert into Vendedor(nomeVendedor,comissao) values('Adibe Dias Martins',2.5);	

insert into Cliente(nomeCliente,cpf,telefone,sexo) values('Maria Clara','93135505633','96310205','F');	
insert into Cliente(nomeCliente,cpf,telefone,sexo) values('Jorge Ribeiro','93135505634','99919876','M');
insert into Cliente(nomeCliente,cpf,telefone,sexo) values('Raphael Dias Oliveira','08588427699','03432248887','M');	
insert into Cliente(nomeCliente,cpf,telefone,sexo) values('Gabriela Caetano Gontijo','12345678911','03499939984','F');	

create table usuario(
	idUsuario int primary key auto_increment,
	nomeUsuario varchar(15),
	senha varchar(150) 
)type=InnoDB;


CREATE TABLE logradouro(
	idLogradouro int primary key auto_increment,
	cep char(8),
	tipo varchar(10),
	logradouro varchar(45),
	bairro varchar(75),
	cidade varchar(60),
	uf char(2)
)  type=InnoDB;

select idVenda,dataVenda,nomeVendedor,nomeCliente
from venda,cliente,vendedor
where venda.idCliente = cliente.idCliente and
      venda.idVendedor = vendedor.idVendedor
order by dataVenda,nomeVendedor,nomeCliente desc;	  
	  

select idVenda,dataVenda,nomeVendedor,nomeCliente
from venda inner join cliente on venda.idCliente = cliente.idCliente
        inner join vendedor on venda.idVendedor = vendedor.idVendedor
order by dataVenda,nomeVendedor,nomeCliente desc	  
	  

insert into itemVenda(idVenda,idProduto,precoVenda,quant,desconto)
values(1,1,4.5,10,5);





create table usuario(
	id int not null primary key auto_increment,
	nome varchar(30) unique,
	estado varchar(30));

INSERT INTO usuario VALUES('DEFAULT','KALLEL','Na Ativa');
INSERT INTO usuario VALUES('DEFAULT','DEUS','Na Ativa');
INSERT INTO usuario VALUES('DEFAULT','ALLAN','Na Ativa');


SELECT movimentacao.data, movimentacao.chamado, pessoa.nome, equipamento.placa, cetor.nome FROM movimentacao 
INNER JOIN pessoa ON pessoa.id = movimentacao.idPessoa
INNER JOIN equipamento ON equipamento.id = movimentacao.idEquipamento
INNER JOIN cetor ON cetor.id = movimentacao.idCetor
ORDER BY movimentacao.id desc;

SELECT * FROM (SELECT * FROM movimentacao ORDER BY movimentacao.id DESC) AS select1

SELECT MAX(id) As id, data, chamado, analista, placa, setor FROM (SELECT movimentacao.id AS id, movimentacao.data AS data, movimentacao.chamado AS chamado, pessoa.nome AS analista, 
equipamento.placa AS placa, cetor.nome AS setor FROM movimentacao 
INNER JOIN pessoa ON pessoa.id = movimentacao.idPessoa
INNER JOIN equipamento ON equipamento.id = movimentacao.idEquipamento
INNER JOIN cetor ON cetor.id = movimentacao.idCetor) AS select1
GROUP BY placa;


GROUP BY idEquipamento
WHERE id = (select max(id) from movimentacao);


select max(id) from movimentacao
    GROUP BY idEquipamento;

SELECT * FROM movimentacao
WHERE id = (select max(id) from movimentacao
    GROUP BY idEquipamento);

                                 

