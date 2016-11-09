CREATE TABLE users (
        id int(11) NOT NULL AUTO_INCREMENT,
        firstname varchar(128) NOT NULL,
        lastname varchar(128) NOT NULL,
  	phonenum varchar(128),
      	email varchar(128),
	notes text,
        PRIMARY KEY (id)
);