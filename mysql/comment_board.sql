create table comment_board
(
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11),
  activity_id int(11),
  date varchar(128) NOT NULL,
  time varchar(128) NOT NULL,
  comment text,
	foreign key (user_id) references users (id)
	on delete cascade,
  foreign key (activity_id) references activity (id)
  on delete cascade,
  PRIMARY KEY (id)
);
