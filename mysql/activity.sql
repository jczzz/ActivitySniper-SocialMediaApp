create table activity 
(
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(128) NOT NULL,
        date varchar(128) NOT NULL,
	time varchar(128) NOT NULL,
	description text,
	location_lng varchar(128) NOT NULL,
	location_lat varchar(128) NOT NULL,
	catagory varchar(128) NOT NULL,
        PRIMARY KEY (id)
);