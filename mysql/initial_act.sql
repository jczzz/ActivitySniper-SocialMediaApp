INSERT INTO users VALUES(NULL,'James','Zhang','604-111-1111','hza83@sfu.ca','827ccb0eea8a706c4c34a16891f84e7b','My name is James, I am one of the developers of Activity Sniper.','pikachu_hi_pokemon.jpg');
INSERT INTO users VALUES(NULL,'Aaron','Bao','604-222-2222','junbob@sfu.ca','827ccb0eea8a706c4c34a16891f84e7b','My name is Aaron, a 4th year SFU student.','images.jpg');
INSERT INTO users VALUES(NULL,'Jack','Geng','604-333-3333','zgeng@sfu.ca','827ccb0eea8a706c4c34a16891f84e7b','My name is Jack !','3021636-8076666672-CdPe6.jpg');

INSERT INTO activity VALUES(NULL,'2','play basketball','2016-12-05','01:39','Let\'s play basketball','928 Sperling Avenue, Burnaby, BC, Canada','sport','basketball.jpg');
INSERT INTO activity (id,create_user_id,name,date,time,description,address,catagory) VALUES(NULL,'2','go to library','2016-12-07','15:42','study at SFU library','8888 University Drive East, Burnaby, BC, Canada','study');
INSERT INTO activity VALUES(NULL,'2','football game','2016-12-09','13:46','Come to the exciting football game.','777 Pacific Boulevard, Vancouver, BC, Canada','sport','nike-football.jpg');

INSERT INTO activity VALUES(NULL,'3','Hotpot Dinner','2016-12-11','18:51','favourite Chinese hotpot','5300 Number 3 Road, Richmond, BC, Canada','food','61536_1.jpg');
INSERT INTO activity (id,create_user_id,name,date,time,description,address,catagory) VALUES(NULL,'3','play volleyball','2016-12-13','19:56','let\'s play volleyball.','6111 River Road, Richmond, BC, Canada','sport');
INSERT INTO activity (id,create_user_id,name,date,time,description,address,catagory) VALUES(NULL,'3','tennis','2016-12-15','01:59','Play tennis.','2088 Kensington Avenue, Burnaby, BC, Canada','sport');

INSERT INTO activity (id,create_user_id,name,date,time,description,address,catagory) VALUES(NULL,'4','House party','2016-12-17','02:01','welcome everyone.','7040 Malibu Drive, Burnaby, BC, Canada','food');
INSERT INTO activity VALUES(NULL,'4','Play Pokemon Go','2016-12-05','02:03','Play pokemon together','2901 E Hastings St, Vancouver, BC, Canada','game','pokemon-go.jpg');
INSERT INTO activity (id,create_user_id,name,date,time,description,address,catagory) VALUES(NULL,'4','Play PingPong Ball','2016-12-19','14:06','Let\'s play pingpong together','8048 Lougheed Highway, Burnaby, BC, Canada','sport');

insert into user_rel values('3','2');
insert into user_rel values('4','2');

insert into user_activity values('2','1');
insert into user_activity values('2','2');
insert into user_activity values('2','3');

insert into user_activity values('4','3');
insert into user_activity values('2','4');
insert into user_activity values('3','4');

insert into user_activity values('2','5');
insert into user_activity values('3','5');
insert into user_activity values('3','6');

insert into user_activity values('2','7');
insert into user_activity values('4','7');
insert into user_activity values('4','8');

insert into user_activity values('2','9');
insert into user_activity values('4','9');

insert into comment_board values(NULL,'2','3','2016-12-05','02:25:51','Is there any people want to go with me???');
insert into comment_board values(NULL,'4','3','2016-12-05','02:27:39','Me !!!!!!!!');
insert into comment_board values(NULL,'3','3','2016-12-05','02:28:20','Me Tooooooooooo...');
