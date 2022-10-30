CREATE TABLE wishlist (
  wishlist_id serial PRIMARY KEY,
  user_id INTEGER NOT NULL,
  item VARCHAR(150) NOT NULL,
  category VARCHAR(60) NOT NULL,
  shop_name VARCHAR(100) NOT NULL,
  url VARCHAR(200),
  pic VARCHAR(200),
  quantity INTEGER NOT NULL,
  price NUMERIC(5, 2) NOT NULL,
  total_price NUMERIC(6, 2) GENERATED ALWAYS AS (price * quantity) STORED,
  room VARCHAR(100) NOT NULL,
  priority INTEGER NOT NULL
);