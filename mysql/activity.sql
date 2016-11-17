create table activity
(
  id int(11) NOT NULL AUTO_INCREMENT,
	create_user_id int(11),
  name varchar(128) NOT NULL,
  date varchar(128) NOT NULL,
	time varchar(128) NOT NULL,
	description text,
	address varchar(128) NOT NULL,
	catagory varchar(128) NOT NULL,
  picture varchar(128) DEFAULT 'default_act_pic.jpg',
	foreign key (create_user_id) references users (id)
	on delete cascade,
  PRIMARY KEY (id)
);
