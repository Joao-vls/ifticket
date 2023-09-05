
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
    local_foto varchar(150) unique,
    possui_ti boolean default false,
    valor int default 0,
    data_cria date,
	nome varchar(100) not null,
    foreign key (curso_fk) references curso (codigo)
);
create table pagamento(
	data_recarga date not null,
    valor int not null,
    metodo enum('pix','cartao') not null,
	aluno_fk int not null,
    foreign key (aluno_fk) references aluno (matricula)
);
create table gasto(
    data_gasto date not null,
    valor int not null,
    aluno_fk int not null,
    foreign key (aluno_fk) references aluno (matricula)
);

insert into curso(nome_curso , nivel) values ('bsi','superior');
insert into curso(nome_curso , nivel) values ('adm','superior');
insert into curso(nome_curso , nivel) values ('ti','medio');
insert into curso(nome_curso , nivel) values ('ta','medio');


-- Usuario tem que estar pre cadastrado para pedir ticket
insert into aluno(curso_fk, senha ,  nome) values (1,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","Joaaa"), 
 (1,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","Q?"),
 (2,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","Quem"),
 (4,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","Teste aluno"),
 (3,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","Alono"),
 (3,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","js"),
 (3,"$2y$10$hlOUXSLqCYoawn/B5zT/iu0eMaiRUciT6NulM9gg.gzsAdVv21obm","silva");

-- usuario solicita ticket :update
update aluno set possui_ti=true ,data_cria=curdate() where matricula= 6;
update aluno set possui_ti=1 ,data_cria=curdate() where matricula= 1;
update aluno set possui_ti=1 ,data_cria=curdate() where matricula= 2;
update aluno set possui_ti=1 ,data_cria="2023-09-01" where matricula= 4;
update aluno set possui_ti=1 ,data_cria="2023-08-05" where matricula= 5;

-- usuario recarrega
insert into pagamento(aluno_fk , valor , metodo , data_recarga) values (1,10,'pix',CURDATE()),
 (1,15,'pix',CURDATE()),
 (1,3,'pix',"2023-09-05"),
 (5,10,'cartao',CURDATE()),
 (5,35,'pix',"2023-09-07"),
 (2,15,'pix',"2023-09-05"),
 (4,15,'cartao',"2023-09-05");

-- update valor
update aluno set valor=(select sum(valor) from pagamento where aluno_fk=aluno.matricula) where matricula=1;
update aluno set valor=(select sum(valor) from pagamento where aluno_fk=aluno.matricula) where matricula=2;
update aluno set valor=(select sum(valor) from pagamento where aluno_fk=aluno.matricula) where matricula=4;
update aluno set valor=(select sum(valor) from pagamento where aluno_fk=aluno.matricula) where matricula=5;

-- usuario gasta
insert into gasto(aluno_fk,valor,data_gasto) values (1,3,CURDATE()),
(1,3,"2023-09-08"),
(2,5,"2023-09-09"),
(4,3,"2023-09-10"),
(5,5,"2023-09-05");

-- update valor
update aluno set valor=(select sum(valor) from pagamento where aluno_fk=aluno.matricula) - (select sum(valor) from gasto where aluno_fk=aluno.matricula) where matricula=1;
update aluno set valor=valor-(select sum(valor) from gasto where aluno_fk=aluno.matricula) where matricula=1;
update aluno set valor=valor-(select sum(valor) from gasto where aluno_fk=aluno.matricula) where matricula=2;
update aluno set valor=valor-(select sum(valor) from gasto where aluno_fk=aluno.matricula) where matricula=4;
update aluno set valor=valor-(select sum(valor) from gasto where aluno_fk=aluno.matricula) where matricula=5;

-- info 1 : quantidade de aluno que possuem ticket
-- pode ser necessario para aumentar ou diminuir a demanda
select count(matricula) from aluno where possui_ti=1;

-- info 2 : Saldo da conta aluno 
select valor,nome from aluno where possui_ti is true;

-- info 3 : lucro com pagamentos
-- pode ser necessario para saber o quanto gastar com os serviços
select sum(valor) as lucro from pagamento;

-- info 4 : dias da semana que mais tem alunos consumindo
-- pode ser necessario para aumentar a demanda dos serviços nos dias que mais tem alunos
select dayname(data_gasto) as dia,count(data_gasto) as quantidade_alunos from  gasto group by dayname(data_gasto) order by  count(data_gasto) desc;


-- info 5 : cursos que mais tem alunos com ticket
-- pode ser necessario para saber qual nivel de curso tem mais demanda de tickets
select curso.nome_curso, count(*), curso.nivel from curso 
inner join aluno on aluno.curso_fk = curso.codigo and aluno.possui_ti is true group by curso.nome_curso,curso.nivel;









-- select  nome, pagamento.valor, gasto.valor  from aluno inner join gasto on gasto.aluno_fk = aluno.matricula and aluno.matricula=5 inner join pagamento on pagamento.aluno_fk = aluno.matricula;

select * from aluno;
