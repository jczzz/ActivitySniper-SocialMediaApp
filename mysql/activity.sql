create table activity
(
  id int(11) NOT NULL AUTO_INCREMENT,
	create_user_id int(11),
  name varchar(128) NOT NULL,
  date varchar(128) NOT NULL,
	time varchar(128) NOT NULL,
	description text,
	location_lng varchar(128) NOT NULL,
	location_lat varchar(128) NOT NULL,
	catagory varchar(128) NOT NULL,
	foreign key (create_user_id) references users (id)
	on delete cascade,
  PRIMARY KEY (id)
);
