create schema athernos;
use athernos;

create table usuarios(
	id int primary key auto_increment,
    nome varchar(45) not null,
    email varchar(45)unique not null,
    senha char(32) not null,
    nivel tinyint default 0
);

create table categoria(
    id int primary key auto_increment,
    nome varchar (45) not null
);

create table produtos(  
    id int primary key auto_increment,
	codigo varchar(20),
	nome varchar(45) not null,
    id_categoria int,
    data_cadastro datetime default now(),
    foreign key (id_categoria) references categoria(id)
);

create table lotes(
    codigo int primary key auto_increment,
    id_produto int,
	custo_unit float not null,  
    quantidade int not null,    
    validade date,
    data_entrada datetime default now(),
    foreign key (id_produto) references produtos(id)
);

create view listProd as 
SELECT
    produtos.id, 
    produtos.codigo,
    produtos.nome,
    categoria.nome as categoria,
    SUM(lotes.quantidade) as total,
    MIN(lotes.validade) as menor_validade,
    MAX(lotes.validade) as maior_validade,
    (select custo_unit from lotes WHERE lotes.id_produto = produtos.id order by codigo desc limit 1 ) as custo
FROM produtos
LEFT JOIN lotes on lotes.id_produto = produtos.id
JOIN categoria on categoria.id = produtos.id_categoria
GROUP BY produtos.codigo;

create table log_lotes(
    id int primary key auto_increment,
    tipo varchar(45),
    id_produto int,
    nome_produto varchar(45),
    id_lotes int,
    quantidade int,
    data_manipulacao datetime
);

Delimiter $

create trigger entrada_lotes
    after insert on lotes
    for each row 
    begin 
    declare nome_prod varchar(45);
        select nome into nome_prod from produtos where id = new.id_produto;

        insert into log_lotes(id_produto,nome_produto,id_lotes,tipo,quantidade,data_manipulacao) 
        values(new.id_produto,nome_prod,new.codigo,"Entrada",new.quantidade,now());
end $

CREATE PROCEDURE registrar_saida(
    IN codigo_id INT,
    IN quantidade_saida INT
)
BEGIN
    DECLARE quantidade_atual INT;
    DECLARE id_prod int;
    DECLARE nome_prod varchar(45);


    -- Obtém a quantidade atual do produto
    SELECT quantidade,id_produto INTO quantidade_atual,id_prod FROM lotes WHERE codigo = codigo_id;
    SELECT nome INTO nome_prod FROM produtos WHERE id = id_prod;    

    -- Verifica se a quantidade de saída é menor ou igual à quantidade atual
    IF quantidade_saida <= quantidade_atual THEN
        -- Atualiza a quantidade na tabela produtos
        UPDATE lotes SET quantidade = quantidade_atual - quantidade_saida WHERE codigo = codigo_id;

        -- Insere o registro de saída no histórico
        INSERT INTO log_lotes (id_produto,nome_produto,id_lotes,tipo,quantidade,data_manipulacao)
        VALUES (id_prod,nome_prod,codigo_id,"Saida", quantidade_saida,now());
    ELSE
        -- Caso a quantidade de saída seja maior que a quantidade atual, emite uma mensagem de erro
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Quantidade de saída superior à quantidade disponível.';
    END IF;
END$

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`) VALUES
(1, 'Adm', 'adm@gmail.com', '0e023702b107d3520a33e6a03362fed5', 2), 
(2, 'Editor', 'editor@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1), 
(3, 'User', 'user@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0); 