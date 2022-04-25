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