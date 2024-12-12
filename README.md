# Bookstore Management System

## Overview
This Bookstore Management System is a web-based e-commerce platform designed to manage a bookstore's operations. It provides a seamless shopping experience for customers while offering a comprehensive admin dashboard for managing books, customers, orders, and communication through a Contact Us form. The system is built using PHP with a MySQL database backend, ensuring a robust and scalable solution for both customers and administrators.

---

## Features

### Non Customers Side:
- **Browse Books**: Non Customers can view, search, and filter books by title, author, and price.
- **Register**: Non Customers can even login or Register if they don't have a account .
- **Send Messages**: Non Customers can send messages by there email and name to the admins without seeing the progress of the work.


### Customers Side:
- **Browse Books**: Customers can view, search, and filter books by title, author, genre, and price.
- **Place Orders**: Customers can add books to their cart and complete the purchase.
- **Order Management**: Customers can view order history, update personal details.
- **Send Messages**: Customers can send messages by there email and name to the admins and see the progress of the work.

### Admins Side:
- **Manage Books**: Admins can add, update, or delete books from the inventory.
- **Manage Customers**: Admins can view and manage customer details.
- **Manage Orders**: Admins can view all customer orders, search and filter orders, and update order statuses.
- **Manage Messages**: Admins can view and respond to customer messages submitted via the 'Contact Us' form.
- **Database Management**: Admins can oversee the database, including schema and relations.

---

## Technologies Used

- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL

---
## Database Schema

### Books Table
| Column        | Description                                          |
|---------------|-------------------------------------------------------|
| id            | Unique identifier for each book                       |
| title         | Title of the book                                    |
| author        | Author of the book                                   |
| description   | Brief description of the book                        |
| price         | Price of the book                                    |
| image         | Path to the book image                               |

### Admin Table
| Column        | Description                                          |
|---------------|-------------------------------------------------------|
| id            | Unique identifier for admin                          |
| name          | Name of the admin                                    |
| email         | Email of the admin                                   |
| password      | Encrypted password for admin                          |
| phone_number  | Admin's contact phone number                          |

### Customer Table
| Column        | Description                                          |
|---------------|-------------------------------------------------------|
| id            | Unique identifier for customer                       |
| name          | Name of the customer                                 |
| email         | Email of the customer                                |
| password      | Encrypted password for customer                      |
| phone_number  | Customer's contact phone number                      |

### Cart Table
| Column        | Description                                          |
|---------------|-------------------------------------------------------|
| id            | Unique identifier for cart                          |
| customer_id   | Foreign key linking to the customer table            |
| book_ids      | JSON encoded list of book IDs in the cart             |
| total_price   | Total price of items in the cart                     |

### Contact Us Table
| Column        | Description                                          |
|---------------|-------------------------------------------------------|
| id            | Unique identifier for message                        |
| name          | Name of the person submitting the message            |
| email         | Email of the person                                   |
| subject       | Subject of the message                                 |
| message       | Full message content                                  |
| read_it       | Boolean to mark if message is read (1 for Yes, 0 for No) |
| working_on    | Boolean to indicate if message is being worked on (1 for Yes, 0 for No) |
| done          | Boolean to mark if work on message is completed (1 for Yes, 0 for No) |

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/bookstore-management-system.git

2. Navigate to the project directory:
   ```bash
   cd bookstore-management-system

3. Setup the database:
   - Import the provided database schema in the Sql folder.

4. XAMP:
   - make sure to start the Apache ,and MYSQL Services
---

## License
This project is licensed under the MIT License. You are free to modify and use it according to your needs.

---

## Thank You ❤️
