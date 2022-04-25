CREATE DATABASE `avaliacao` DEFAULT CHARACTER SET utf8;

CREATE TABLE `avaliacao`.`produto`(
codigo INT NOT NULL,
descricao VARCHAR(50)  NOT NULL,
valor_unitario DECIMAL(10,2)  NOT NULL,
codigo_barras VARCHAR(30) NOT NULL,
estoque INT DEFAULT 0,
ativo BOOLEAN DEFAULT 1,
PRIMARY KEY (`codigo`)
);

CREATE TABLE `avaliacao`.`venda`(
codigo INT NOT NULL,
codigo_produto INT NOT NULL,
quantidade INT  NOT NULL,
valor_unitario DECIMAL(10,2) NOT NULL,
data_venda DATE NOT NULL,
PRIMARY KEY (`codigo`),
CONSTRAINT `codigo_produto`
    FOREIGN KEY (`codigo_produto`)
    REFERENCES `avaliacao`.`produto` (`codigo`)
);

INSERT INTO avaliacao.produto (codigo, descricao, valor_unitario, codigo_barras, estoque, ativo) VALUES (1,'açucar',5.49,'3628503789567',100,1);
INSERT INTO avaliacao.produto (codigo, descricao, valor_unitario, codigo_barras, estoque, ativo) VALUES (2,'farinha',9.79,'6928406563945',200,1);
INSERT INTO avaliacao.venda (codigo, codigo_produto, quantidade, valor_unitario, data_venda) VALUES (1,1,2,5.49,'2022-04-22');
INSERT INTO avaliacao.venda (codigo, codigo_produto, quantidade, valor_unitario, data_venda) VALUES (2,1,3,5.49,'2022-04-22');
INSERT INTO avaliacao.venda (codigo, codigo_produto, quantidade, valor_unitario, data_venda) VALUES (3,2,2,9.79,'2022-04-22');
INSERT INTO avaliacao.venda (codigo, codigo_produto, quantidade, valor_unitario, data_venda) VALUES (4,2,3,9.79,'2022-04-22');