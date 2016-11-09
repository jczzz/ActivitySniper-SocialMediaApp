create table user_activity
(
     	user_id int(11) not null,
     	activity_id int(11) not null,
     	primary key(user_id,activity_id),
	foreign key (user_id) references users (id)
	on delete cascade,
	foreign key (activity_id) references activity (id)
	on delete cascade
);