-- Insert sample data into the User table
INSERT INTO User (LastName, FirstName, Role, Phone, EmailAddress, Password)
VALUES
    ('Doe', 'John', 'client', '123-456-7890', 'john.doe@example.com', 'password123');

INSERT INTO User (LastName, FirstName, Role, Phone, EmailAddress, Password)
VALUES
    ('Smith', 'Alice', 'sitter', '987-654-3210', 'alice.smith@example.com', 'securepassword');

INSERT INTO User (LastName, FirstName, Role, Phone, EmailAddress, Password)
VALUES
    ('Johnson', 'Bob', 'handler', '555-555-5555', 'bob.johnson@example.com', 'p@ssw0rd');

-- Insert sample data into the Orders table
INSERT INTO Orders (ServiceState, ClientID, HandlerID, SitterID, OrderDate, DueDate)
VALUES
    ('pending', 1, 3, 2, '2023-12-13 08:00:00', '2023-12-15 18:00:00');

INSERT INTO Orders (ServiceState, ClientID, HandlerID, SitterID, OrderDate, DueDate)
VALUES
    ('assigned', 1, 3, 2, '2023-12-14 10:00:00', '2023-12-16 20:00:00');

INSERT INTO Orders (ServiceState, ClientID, HandlerID, SitterID, OrderDate, DueDate)
VALUES
    ('completed', 1, 3, 2, '2023-12-15 12:00:00', '2023-12-17 22:00:00');

-- Insert sample data into the Animal table
INSERT INTO Animal (OrderID, AnimalType, is_sit_at_home, is_walk, is_groom)
VALUES
    (1, 'dog', 1, 1, 0);

INSERT INTO Animal (OrderID, AnimalType, is_sit_at_home, is_walk, is_groom)
VALUES
    (2, 'cat', 0, 1, 0);

INSERT INTO Animal (OrderID, AnimalType, is_sit_at_home, is_walk, is_groom)
VALUES
    (3, 'dog', 1, 0, 1);

-- Insert sample data into the IP_Addresses table
INSERT INTO IP_Addresses (UserID, IPAddress)
VALUES
    (1, null);

INSERT INTO IP_Addresses (UserID, IPAddress)
VALUES
    (2, null);

INSERT INTO IP_Addresses (UserID, IPAddress)
VALUES
    (3, null);

-- Insert sample data into the Order_Comments table
INSERT INTO Order_Comments (OrderNumber, ResponderID, CommentText, CommentDate)
VALUES
    (1, 2, 'Handler assigned to the order.', '2023-12-13 09:00:00');

INSERT INTO Order_Comments (OrderNumber, ResponderID, CommentText, CommentDate)
VALUES
    (1, 3, 'Sitter accepted the order.', '2023-12-14 11:00:00');

INSERT INTO Order_Comments (OrderNumber, ResponderID, CommentText, CommentDate)
VALUES
    (1, 1, 'Service completed successfully.', '2023-12-16 21:00:00');
