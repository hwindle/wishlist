CREATE TABLE current_items (
  current_id serial PRIMARY KEY,
  user_id INTEGER NOT NULL,
  item VARCHAR(150) NOT NULL,
  description VARCHAR(200),
  status VARCHAR(100) NOT NULL,
  place VARCHAR(150) NOT NULL
);