CREATE DATABASE dbawsbrit
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;


CREATE TABLE Pessoa(  
 	Id INT NOT NULL primary key auto_increment,
 	nome VARCHAR(30) NOT NULL
); 


insert into Pessoa (nome)
VALUES 	('Allan Ramos'),
 		('Junior Bataglioni'),
 		('Pedro Matos'),
 	    ('Ricardo Alvim');

CREATE TABLE permissao( 
 id INT NOT NULL primary key auto_increment,   
 nome VARCHAR(45)
);

insert into permissao (nome)
VALUES 	('GOD'),
		('ANALISTA'),
		('DEFAULT');


CREATE TABLE user ( 
 	Id INT NOT NULL primary key auto_increment,  
 	senha VARCHAR(20),  
 	idPessoa int NOT NULL,
 	idPermissao int NOT NULL DEFAULT (1),

	 FOREIGN KEY (idPessoa) references pessoa(id) ON UPDATE CASCADE ON DELETE RESTRICT,
	 FOREIGN KEY (idPermissao) references permissao(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

insert into user (senha, idPessoa, idPermissao)
VALUES 	('ALLAN123', 1, 1);


CREATE TABLE Cetor(
	Id INT NOT NULL primary key auto_increment,
 	nome VARCHAR(45) NOT NULL UNIQUE);
);

--CREATE TABLE Função ( 
-- 	Id INT NOT NULL primary key auto_increment,  
-- 	nome VARCHAR (45) NOT NULL UNIQUE,  
--	idCetor INT, 
-- 	FOREIGN KEY (idCetor) references cetor(id) ON UPDATE CASCADE ON DELETE RESTRICT);
--);

insert into CETOR (nome)
VALUES 	('Posto de enfermagem térreo'),
		('Posto de enfermagem 1'),
		('Posto de enfermagem 2'),
		('Posto de enfermagem 3'),
		('Posto de enfermagem 4'),
		('Posto de enfermagem 5'),
		('Posto de enfermagem 6'),
		('Posto de enfermagem 7');

CREATE TABLE TipoEquipamento ( 
 	Id INT NOT NULL primary key auto_increment,  
 	nome VARCHAR(45) NOT NULL
); 		

insert into TipoEquipamento (nome)
VALUES 	('Desktop'),
		('Notebook'),
		('Telefone');

CREATE TABLE equipamento(
	Id INT NOT NULL primary key auto_increment,
	Placa VARCHAR(11) NOT NULL UNIQUE,
 	Modelo VARCHAR(30),
	sn VARCHAR(15) NOT NULL UNIQUE,
 	idTipoEquipamento INT NOT NULL,
 	idCetorDesignado INT NOT NULL,

	FOREIGN KEY (idTipoEquipamento) references TipoEquipamento(id) ON UPDATE CASCADE ON DELETE RESTRICT,
	FOREIGN KEY (idCetorDesignado) references Cetor(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

insert into equipamento (placa, modelo, sn, idTipoEquipamento, idCetorDesignado)
VALUES 	('UMC-OO1212','all IN ONE 1030','A1sdW1dK',1,1);

CREATE TABLE movimentacao (
 	Id INT NOT NULL primary key auto_increment,
	data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 	chamado VARCHAR(6) NOT NULL,
 	idPessoa INT NOT NULL,
 	idEquipamento INT NOT NULL,
 	idCetor INT NOT NULL,
	
	FOREIGN KEY (idPessoa) references pessoa(id) ON UPDATE CASCADE ON DELETE RESTRICT,
	FOREIGN KEY (idEquipamento) references equipamento(id) ON UPDATE CASCADE ON DELETE RESTRICT,
	FOREIGN KEY (idCetor) references cetor(id) ON UPDATE CASCADE ON DELETE RESTRICT
); 

insert into movimentacao (chamado, idPessoa, idEquipamento, idCetor)
VALUES 	('28468','1','1',1);

SELECT *
FROM equipamento
WHERE placa like 'U%';

select max(id) from movimentacao
GROUP BY idEquipamento;

SELECT * FROM movimentacao
WHERE Marks IN (SELECT Marks 
       FROM Students 
       ORDER BY Marks DESC
       LIMIT 10)

SELECT * FROM movimentacao 
WHERE id IN (select max(id) from movimentacao
GROUP BY idEquipamento);

SELECT * FROM movimentacao
WHERE id IN (select max(id) from movimentacao
GROUP BY idEquipamento);

SELECT * FROM (SELECT * FROM movimentacao As T2
WHERE id IN (select max(id) from movimentacao as T1
GROUP BY idEquipamento)) as ress
WHERE idCetor = 8;

SELECT cetor.nome as snome,  movimentacao.data, pessoa.nome, movimentacao.chamado, equipamento.placa FROM movimentacao
                                      INNER JOIN pessoa ON pessoa.id = movimentacao.idPessoa
                                      INNER JOIN equipamento ON equipamento.id = movimentacao.idEquipamento
                                      INNER JOIN cetor ON cetor.id = movimentacao.idCetor                                   
                                      ORDER BY movimentacao.id desc
                                      LIMIT 10

SELECT data, equipamento.Placa AS equipamento, equipamento.Modelo As modelo
FROM (SELECT * FROM movimentacao As T2
WHERE id IN (select max(id) from movimentacao as T1
GROUP BY idEquipamento)) as ress
INNER JOIN equipamento ON equipamento.id = ress.idEquipamento
WHERE idCetor = 8;