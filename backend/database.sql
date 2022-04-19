CREATE DATABASE `avaliacao` DEFAULT CHARACTER SET utf8;

CREATE TABLE `avaliacao`.`produto`(
codigo INT NOT NULL,
descricao VARCHAR(50),
valor_unitario DECIMAL(10,2),
estoque INT,
data_ultima_venda DATE,
total_de_vendas INT,
PRIMARY KEY (`codigo`)
);

CREATE TABLE `avaliacao`.`venda`(
codigo INT NOT NULL,
codigo_produto INT NOT NULL,
quantidade INT,
valor_unitario DECIMAL(10,2),
PRIMARY KEY (`codigo`),
CONSTRAINT `codigo_produto`
    FOREIGN KEY (`codigo_produto`)
    REFERENCES `avaliacao`.`produto` (`codigo`)
);

CREATE TABLE `avaliacao`.`produto_excluido`(
codigo INT NOT NULL,
descricao VARCHAR(50),
valor_unitario DECIMAL(10,2),
estoque INT,
PRIMARY KEY (`codigo`)
);
