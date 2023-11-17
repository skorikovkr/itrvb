DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS comments;

PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS users
(
    uuid TEXT NOT NULL CONSTRAINT uuid_pk PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT username_uq UNIQUE,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS posts
(
    uuid TEXT NOT NULL CONSTRAINT uuid_pk PRIMARY KEY,
    author_uuid TEXT NOT NULL,
    title TEXT NOT NULL,
    text TEXT NOT NULL,
    foreign key(author_uuid) references users(uuid)
);

CREATE TABLE IF NOT EXISTS comments
(
    uuid TEXT NOT NULL CONSTRAINT uuid_pk PRIMARY KEY,
    author_uuid TEXT NOT NULL,
    post_uuid TEXT NOT NULL,
    text TEXT NOT NULL,
    foreign key(author_uuid) references users(uuid),
    foreign key(post_uuid) references posts(uuid)
);

INSERT INTO users (uuid, username, first_name, last_name)
VALUES ('013782d3-5b7f-4518-b352-4a2aa6fbd86b', 'username1', 'User1-firstname', 'User1-lastname');

INSERT INTO users (uuid, username, first_name, last_name)
VALUES ('f09a2aac-ba50-4eb7-9036-6e27466ab17a', 'username2', 'User2-firstname', 'User2-lastname');

INSERT INTO posts (uuid, author_uuid, title, text)
VALUES (
    'c336bc52-e711-44bd-b0f5-ada649328281', 
    '013782d3-5b7f-4518-b352-4a2aa6fbd86b', 
    'Post1-title', 
    'Post1-text'
);

INSERT INTO comments (uuid, author_uuid, post_uuid, text)
VALUES (
    'f1f2fae6-8a72-4ced-84e3-7a66253f25ec', 
    'f09a2aac-ba50-4eb7-9036-6e27466ab17a', 
    'c336bc52-e711-44bd-b0f5-ada649328281', 
    'User2-comment-on-Post1'
);