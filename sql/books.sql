CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

INSERT INTO books (title, author, price) VALUES
('Book 1', 'Author 1', 9.99),
('Book 2', 'Author 2', 19.99),
('Book 3', 'Author 3', 29.99),
('Book 4', 'Author 4', 39.99),
('Book 5', 'Author 5', 49.99),
('Book 6', 'Author 6', 59.99),
('Book 7', 'Author 7', 69.99),
('Book 8', 'Author 8', 79.99),
('Book 9', 'Author 9', 89.99),
('Book 10', 'Author 10', 99.99);