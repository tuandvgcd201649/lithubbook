CREATE TABLE cart_items (
  cart_id INT,
  book_id INT,
  quantity INT DEFAULT 1,
  PRIMARY KEY (cart_id, book_id),
  FOREIGN KEY (cart_id) REFERENCES carts(id),
  FOREIGN KEY (book_id) REFERENCES books(id)
);