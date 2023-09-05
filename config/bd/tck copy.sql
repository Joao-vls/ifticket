drop database ifticket;
create database ifticket;
use ifticket;

create table curso(
	codigo int primary key auto_increment,
    nome_curso varchar(20) not null,
    nivel enum('superior','medio') not null
);
create table aluno(
	matricula int primary key auto_increment,
    curso_fk int not null,
    senha varchar (150) not null,
	nome varchar(100) not null,
    foreign key (curso_fk) references curso (codigo)
);
create table arquivos(
	local_arq varchar(150) not null unique,
    tipo enum("pdf","imagem_perfil") not null,
    data_cria datetime not null,
 	aluno_fk int not null,
    foreign key (aluno_fk) references aluno (matricula)   
);
create table ticket(
	codigo_fk int primary key,
    valor int default 0,
    foreign key (codigo_fk) references aluno (matricula)
);
create table pagamento(
	data_recarga date not null,
    valor int not null,
    metodo enum('pix','cartao') not null,
	aluno_fk int not null,
    foreign key (aluno_fk) references aluno (matricula)
);
-- insert into curso(nome_curso,nivel) values ('bsi','superior');

-- insert into aluno(curso_fk,senha,nome) values (1,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","Q?");
-- insert into curso(nome_curso,nivel) values ('adm','superior');
-- insert into aluno(curso_fk,senha,nome) values (2,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","adm");
-- insert into aluno(curso_fk,senha,nome) values (2,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","admaluno");
-- insert into aluno(curso_fk,senha,nome) values (1,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","teste");
-- insert into ticket(codigo_fk) values ('2');
-- insert into ticket(codigo_fk) values ('1');
-- select * from aluno;
-- select * from ticket;

-- select * from aluno join curso on aluno.curso_fk = 2;
-- select * from aluno inner join curso on aluno.curso_fk = curso.codigo and aluno.curso_fk=1 
-- inner join ticket on aluno.matricula = ticket.codigo_fk ;

-- select * from aluno 
-- inner join ticket on aluno.matricula = ticket.codigo_fk and aluno.matricula=4;

-- SELECT * FROM aluno WHERE matricula =4  && nome="teste";

-- SELECT * FROM arquivos WHERE aluno_fk ='4' && tipo="imagem_perfil";

-- create table cartao(
-- 	numero_cartao int,
--     cod int,
--     aluno_fk int not null,
--     vali char(5) not null,
--     primary key(numero_cartao,cod),
--     foreign key (aluno_fk) references aluno (matricula)
-- );