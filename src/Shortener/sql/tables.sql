create table shortener
(
    id         int auto_increment,
    url       varchar(255) not null,
    short_code varchar(20)  not null,
    constraint shortener_pk
        primary key (id)
);