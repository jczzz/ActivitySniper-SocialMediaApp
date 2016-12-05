

create table message_board
(
  id int(11) NOT NULL AUTO_INCREMENT,

  user_id1 int(11),
  user_id2 int(11),
  foreign key (user_id1) references users (id) on delete cascade,
  foreign key (user_id2) references users (id) on delete cascade,

  date varchar(128) NOT NULL,
  time varchar(128) NOT NULL,
  comment text,

  PRIMARY KEY (id)
);