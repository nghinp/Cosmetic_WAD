CREATE DATABASE setupsprint_ecommerce_website;
USE setupsprint_ecommerce_website;

CREATE TABLE admin (
  AdminID INT NOT NULL AUTO_INCREMENT,
  Username VARCHAR(50) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  PRIMARY KEY (AdminID),
  UNIQUE (Username)
);

-- Default admin
INSERT INTO admin (Username, Password) VALUES ('admin@example.com', 'admin');

CREATE TABLE clients (
  ClientID INT NOT NULL AUTO_INCREMENT,
  FirstName VARCHAR(255) NOT NULL,
  LastName VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  Address VARCHAR(255),
  PhoneNumber VARCHAR(20),
  PRIMARY KEY (ClientID),
  UNIQUE (Email)
);

CREATE TABLE orders (
  OrderID INT NOT NULL AUTO_INCREMENT,
  ClientID INT,
  OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  TotalAmount DECIMAL(10, 2),
  OrderStatus VARCHAR(20),
  PRIMARY KEY (OrderID),
  FOREIGN KEY (ClientID) REFERENCES clients(ClientID)
);

CREATE TABLE product (
  ProductID INT NOT NULL AUTO_INCREMENT,
  ProductName VARCHAR(255) NOT NULL,
  Description TEXT,
  Category TEXT,
  SupplierID VARCHAR(100),
  OldPrice DECIMAL(10, 2) NOT NULL,
  SpecialPrice DECIMAL(10, 2),
  QuantityInStock INT,
  DateAdded DATE,
  LastUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  Discount DECIMAL(5, 2),
  ImageURL VARCHAR(255),
  Rating DECIMAL(3, 2),
  Status VARCHAR(20),
  Brand VARCHAR(40),
  PRIMARY KEY (ProductID)
);

CREATE TABLE orderdetail (
  OrderDetailID INT NOT NULL AUTO_INCREMENT,
  OrderID INT,
  ProductID INT,
  Quantity INT,
  Subtotal DECIMAL(10, 2),
  PRIMARY KEY (OrderDetailID),
  FOREIGN KEY (OrderID) REFERENCES orders(OrderID),
  FOREIGN KEY (ProductID) REFERENCES product(ProductID)
);
