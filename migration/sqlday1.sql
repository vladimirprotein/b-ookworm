CREATE TABLE user_type(
    id integer primary key,
    name varchar(10),
    created_at date,
    updated_at date,
    deleted_at date
    );


CREATE TABLE `user`(
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    unique_id varchar(20) unique not null,
    name varchar(80) NOT null,
    email varchar(300) not null UNIQUE,
    phone int unsigned not null,
    pass varchar(15) not null,
    user_type_id int(1) not null,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fkuser_type foreign key (user_type_id) references user_type(id)
    );
​
CREATE TABLE city(
    id int unsigned primary key AUTO_INCREMENT,
    name varchar(30) not null UNIQUE,
    created_at date,
    updated_at date,
    deleted_at date
    );
    
CREATE TABLE state(
    id int unsigned primary key AUTO_INCREMENT,
    name varchar(30) NOT null UNIQUE,
    created_at date,
    updated_at date,
    deleted_at date
    );
    
CREATE TABLE country(
    id int unsigned primary key AUTO_INCREMENT,
    country_code int unsigned unique not null,
    name varchar(30) NOT null UNIQUE,
    created_at date,
    updated_at date,
    deleted_at date
    );    
​
CREATE TABLE address(
    id int unsigned primary key AUTO_INCREMENT,
    addr varchar(50) NOT null,
    city_id int unsigned,
    state_id int unsigned ,
    country_id int unsigned ,
    pin int unsigned not null,
    user_id int unsigned,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fkcity foreign key (city_id) REFERENCES city(id),
    constraint fkstate foreign key (state_id) REFERENCES state(id),
    constraint fkcountry foreign key (country_id) REFERENCES country(id),
    constraint fkuser foreign key (user_id) REFERENCES `user`(id)
    );

CREATE TABLE payment_mode(
    id int primary key,
    name varchar(20),
    created_at date,
    updated_at date,
    deleted_at date
    );

CREATE TABLE transaction(
    id int unsigned primary key AUTO_INCREMENT,
    transaction_number varchar(20) not null unique,
    user_id int unsigned,
    payment_mode_id int,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fkuser1 foreign key (user_id) REFERENCES `user`(id),
    constraint fkpayment_mode foreign key (payment_mode_id) references payment_mode(id)
    );

CREATE TABLE orders(
    id int unsigned primary key AUTO_INCREMENT,
    order_number varchar(20) not null unique,
    transaction_id int unsigned,
    constraint fktransaction foreign key (transaction_id) references transaction(id)
    );



CREATE TABLE book(
    id int unsigned primary key AUTO_INCREMENT,
    book_isbn varchar(20) unique not null,
    title varchar(30) not null,
    created_at date,
    updated_at date,
    deleted_at date
    );

CREATE TABLE author(
    id int unsigned primary key AUTO_INCREMENT,
    author_reg varchar(10) unique,
    name varchar(30),
    created_at date,
    updated_at date,
    deleted_at date
    );

CREATE TABLE genre(
    id int unsigned primary key AUTO_INCREMENT,
    name varchar(30),
    created_at date,
    updated_at date,
    deleted_at date
    );

CREATE TABLE tag(
    id int unsigned primary key AUTO_INCREMENT,
    name varchar(30),
    created_at date,
    updated_at date,
    deleted_at date
    );



CREATE TABLE book_tag(
    id int unsigned primary key AUTO_INCREMENT,
    tag_id int unsigned,
    book_id int unsigned,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fktag foreign key (tag_id) references tag(id),
    constraint fkbook2 foreign key (book_id) references book(id),
    unique (tag_id,book_id)
    );

CREATE TABLE book_author(
    id int unsigned primary key AUTO_INCREMENT,
    author_id int unsigned,
    book_id int unsigned,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fkauthor foreign key (author_id) references author(id),
    constraint fkbook3 foreign key (book_id) references book(id),
    unique (author_id,book_id)
    );

CREATE TABLE book_genre(
    id int unsigned primary key AUTO_INCREMENT,
    genre_id int unsigned,
    book_id int unsigned,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fkgenre foreign key (genre_id) references genre(id),
    constraint fkbook4 foreign key (book_id) references book(id),
    unique (genre_id,book_id)
    );

CREATE TABLE book_seller(
    id int unsigned primary key AUTO_INCREMENT,
    user_id int unsigned,
    book_id int unsigned,
    quantity int unsigned,
    price int unsigned,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fkuser4 foreign key (user_id) references `user`(id),
    constraint fkbook5 foreign key (book_id) references book(id),
    unique (user_id,book_id,price)
    );

CREATE TABLE cart(
    id int unsigned primary key AUTO_INCREMENT,
    user_id int unsigned not null, 
    book_seller_id int unsigned not null,
    quantity int default 1,
    created_at date,
    updated_at date,
    deleted_at date,
    constraint fkuser2 foreign key (user_id) references `user`(id),
    constraint fkbookseller foreign key (book_seller_id) references book_seller(id),
    unique (user_id,book_seller_id)
    );
