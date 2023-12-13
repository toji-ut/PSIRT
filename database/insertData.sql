-- Insert sample data into Animal table
INSERT INTO Animal (AnimalType, is_sit_at_home, is_walk, is_groom) VALUES(
    'Dog', 1, 1, 1);

INSERT INTO Animal (AnimalType, is_sit_at_home, is_walk, is_groom) VALUES(
    'Cat', 0, 1, 0);

-- Insert sample data into User table
INSERT INTO User (LastName, FirstName, Role, Phone, EmailAddress, Password) VALUES (
    'Doe', 'John', 'client', '123-456-7890', 'john.doe@example.com', 'password123');

INSERT INTO User (LastName, FirstName, Role, Phone, EmailAddress, Password) VALUES (
    'Smith', 'Jane', 'sitter', '987-654-3210', 'jane.smith@example.com', 'letmein');

INSERT INTO User (LastName, FirstName, Role, Phone, EmailAddress, Password) VALUES (
    'Johnson', 'Bob', 'handler', '555-123-4567', 'bob.johnson@example.com', 'securepass');

-- Insert sample data into Orders table
INSERT INTO Orders (ServiceState, ClientID, HandlerID, SitterID, OrderDate, DueDate, OrderType) VALUES (
    'pending', 1, 3, 2, '2023-12-15 10:00:00', '2023-12-20 15:00:00', 'Dog');

INSERT INTO Orders (ServiceState, ClientID, HandlerID, SitterID, OrderDate, DueDate, OrderType) VALUES (
    'assigned', 2, 1, 3, '2023-12-14 12:00:00', '2023-12-18 18:00:00', 'Cat');

INSERT INTO Orders (ServiceState, ClientID, HandlerID, SitterID, OrderDate, DueDate, OrderType) VALUES (
    'completed', 3, 2, 1, '2023-12-10 08:00:00', '2023-12-12 16:00:00', 'Bird');

-- Insert sample data into IP_Addresses table
INSERT INTO IP_Addresses (UserID, IPAddress) VALUES (
    1, '192.168.1.1');

INSERT INTO IP_Addresses (UserID, IPAddress) VALUES (
    2, '10.0.0.2');

INSERT INTO IP_Addresses (UserID, IPAddress) VALUES (
    3, '172.16.0.3');

-- Insert sample data into Order_Comments table
INSERT INTO Order_Comments (OrderNumber, ResponderID, CommentText, CommentDate) VALUES (
    1, 2, 'Looking forward to it!', '2023-12-15 08:30:00');

INSERT INTO Order_Comments (OrderNumber, ResponderID, CommentText, CommentDate) VALUES (
    2, 3, 'Will be there on time.', '2023-12-14 13:45:00');

INSERT INTO Order_Comments (OrderNumber, ResponderID, CommentText, CommentDate) VALUES (
    3, 1, 'Task completed successfully.', '2023-12-12 17:30:00');
