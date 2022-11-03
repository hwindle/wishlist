CREATE TABLE users (
  user_id serial PRIMARY KEY,
  user_name VARCHAR(150),
  email VARCHAR(200),
  password VARCHAR(240) NOT NULL
);