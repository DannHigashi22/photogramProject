create database if not exists laravel_project;

create table users(
id              int(255) auto_increment not null,
rol             varchar(20),
name            varchar(100) not null,
surname         varchar(200) not null,
nick            varchar(100) not null,
email           varchar(255) not null,
pass            varchar(255) not null,
image           varchar(255),
created_at       datetime,
updated_at       datetime,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE(email)
)Engine=InnoDb;

insert into users values(null,'user','Dann','Higashi E','teniente_dann22','dann.higashi@inacapmil.cl','1234',null,curtime(),curtime(),null);
insert into users values(null,'user','Juan','Perez G','JuanitoPerez90','juan.Perez@hotmail.cl','1234',null,curtime(),curtime(),null);


create table if not exists images(
id          int(255) auto_increment not null,
user_id     int(255),
image_path  varchar(255) not null,
description text,
created_at   datetime,
updated_at   datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_user FOREIGN KEY(user_id) references users(id)
)Engine=InnoDB;

insert into images values(null,1,'test.jpg','prueba',curtime(),curtime());
insert into images values(null,2,'test2.jpg','prueba2',curtime(),curtime());


create table if not exists comments(
id          int(255) auto_increment not null,
user_id     int(255),
image_id    int(255),
content     text not null,
created_at   datetime,
updated_at   datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) references users(id),
CONSTRAINT fk_comments_images FOREIGN key(image_id) references images(id)
)Engine=InnoDb;

insert into comments values(null,1,2,'buena foto amigo',curtime(),curtime());
insert into comments values(null,2,1,'buena foto amigo 2',curtime(),curtime());

create table if not exists likes(
id          int(255) auto_increment not null,
user_id     int(255),
image_id    int(255),
created_at   datetime,
updated_at   datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) references users(id),
CONSTRAINT fk_likes_images FOREIGN key(image_id) references images(id)
)Engine=InnoDb;

insert into likes values(null,1,1,curtime(),curtime());
insert into likes values(null,1,2,curtime(),curtime());
