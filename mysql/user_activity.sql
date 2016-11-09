create table user_activity
(
     	user_id varchar(128) not null,
     	activity_id varchar(128) not null,
     	primary key(user_id,activity_id),
	foreign key (user_id) references user
	on delete cascade,
	foreign key (activity_id) references activity
	on delete cascade
);