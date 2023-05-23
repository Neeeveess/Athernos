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
GROUP BY produtos.nome;


DROP FUNCTION IF EXISTS inicial_maiuscula;
DELIMITER //
CREATE FUNCTION inicial_maiuscula(texto VARCHAR(100))
RETURNS VARCHAR(100)
BEGIN
    RETURN CONCAT(UPPER(LEFT(texto, 1)),LOWER(SUBSTRING(texto, 2)));
END //
DELIMITER ;


insert into usuarios values(null,"Adm","adm@gmail.com","0e023702b107d3520a33e6a03362fed5","2");