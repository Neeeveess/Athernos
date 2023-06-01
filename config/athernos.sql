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
    id_lotes int,
    quantidade int,
    data_manipulacao datetime
);

Delimiter $

create trigger entrada_lotes
after insert on lotes
for each row 
begin 
    insert into log_lotes(id_lotes,tipo,quantidade,data_manipulacao) 
    values(new.codigo,"Entrada",new.quantidade,now());
end $

CREATE PROCEDURE registrar_saida(
    IN codigo_id INT,
    IN quantidade_saida INT
)
BEGIN
    DECLARE quantidade_atual INT;

    -- Obtém a quantidade atual do produto
    SELECT quantidade INTO quantidade_atual FROM lotes WHERE codigo = codigo_id;

    -- Verifica se a quantidade de saída é menor ou igual à quantidade atual
    IF quantidade_saida <= quantidade_atual THEN
        -- Atualiza a quantidade na tabela produtos
        UPDATE lotes SET quantidade = quantidade_atual - quantidade_saida WHERE codigo = codigo_id;

        -- Insere o registro de saída no histórico
        INSERT INTO log_lotes (id_lotes,tipo,quantidade,data_manipulacao)
        VALUES (codigo_id,"Saida", quantidade_saida,now());
    ELSE
        -- Caso a quantidade de saída seja maior que a quantidade atual, emite uma mensagem de erro
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Quantidade de saída superior à quantidade disponível.';
    END IF;
END$

Delimiter ;



insert into usuarios values(null,"Adm","adm@gmail.com","0e023702b107d3520a33e6a03362fed5","2");