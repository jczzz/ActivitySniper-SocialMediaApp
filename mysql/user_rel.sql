CREATE TABLE user_rel (
       user_id1 int(11) NOT NULL,
       user_id2 int(11) NOT NULL,
       PRIMARY KEY (user_id1, user_id2),
       FOREIGN KEY (user_id1) REFERENCES users (id) ON DELETE CASCADE,
       FOREIGN KEY (user_id2) REFERENCES users (id) ON DELETE CASCADE
);      