
-- Table: Orders
CREATE TABLE Orders (
    order_number INT PRIMARY KEY,
    type_of_order VARCHAR(50), -- Adjust size accordingly
    date_created DATE,
    service_state ENUM('pending', 'assigned', 'completed'),
    comments TEXT
);

-- Table: People
CREATE TABLE People (
    person_id INT PRIMARY KEY,
    last_name VARCHAR(50),
    first_name VARCHAR(50),
    role VARCHAR(50),
    phone VARCHAR(20),
    email VARCHAR(100) -- Adjust size accordingly
);

-- Table: IP_Addresses
CREATE TABLE IP_Addresses (
    ip_address_id INT PRIMARY KEY,
    ip_address VARCHAR(45) -- Adjust size accordingly
);

-- Table: Order_People (for many-to-many relationship between Orders and People)
CREATE TABLE Order_People (
    order_number INT,
    person_id INT,
    PRIMARY KEY (order_number, person_id),
    FOREIGN KEY (order_number) REFERENCES Orders(order_number),
    FOREIGN KEY (person_id) REFERENCES People(person_id)
);

-- Table: Order_IPs (for many-to-many relationship between Orders and IP Addresses)
CREATE TABLE Order_IPs (
    order_number INT,
    ip_address_id INT,
    PRIMARY KEY (order_number, ip_address_id),
    FOREIGN KEY (order_number) REFERENCES Orders(order_number),
    FOREIGN KEY (ip_address_id) REFERENCES IP_Addresses(ip_address_id)
);

-- Table: Comments
CREATE TABLE Comments (
    comment_id INT PRIMARY KEY,
    comment_text TEXT,
    commenter_name VARCHAR(100), -- Adjust size accordingly
    order_number INT,
    FOREIGN KEY (order_number) REFERENCES Orders(order_number),
    date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Include timestamp for ordering comments
);

-- Table: Responders
CREATE TABLE Responders (
    responder_id INT PRIMARY KEY,
    responder_type ENUM('client', 'sitter', 'handler') -- Adjust as needed
);

-- Table: Order_Responders (for mapping Orders to Responders)
CREATE TABLE Order_Responders (
    order_number INT,
    responder_id INT,
    PRIMARY KEY (order_number, responder_id),
    FOREIGN KEY (order_number) REFERENCES Orders(order_number),
    FOREIGN KEY (responder_id) REFERENCES Responders(responder_id)
);
