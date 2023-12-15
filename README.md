
<h1 align="center"> Project PSIRT </h1>

## Case Study

<p align="left"> Pet Sitter Response Tracking System (PSIRT) is a system that keeps a record of services provided for dogs and cats. </p>

When a pet sitter service is requested, it is assigned a unique identifier and stored in a database. For each service, the system keeps track of the order number, the type of order (chosen from a list that may change dynamically), the date it was created, the service state (which can be 'pending,' 'assigned,' or ‘completed’), and a list of free-form comments. Each comment is associated with the name of the responders who wrote it.

In addition, each order could be any number of people (last name, first name, role, phone, email address) and IP addresses.

The pet sitter service responders can easily query the database by order number and get a detailed report of the entire history of a given service.

The PSIRT system has three types of responders: clients, sitters, and handlers. Clients create and manage requests, and they can also add comments to the service. Handlers recommend pet sitters to clients, who can either accept or deny service requests. Once a service is accepted, the order status is updated to "Assigned," and the sitter gains access to the client's contact information to add a service report. After the service is completed, the sitter updates the order status, and the client confirms it again. The order status then changes to "Completed," and the order is archived.

Free-form comments must be sorted from the most recent post on top to the oldest on the bottom.

All updates to a pet sitter service log are recorded as free-form comments on the order. And, it is important to note that all system use is subject to authentication via an external single sign-on system.

## Directory Structure

Below is the structure of our project repository:

```
PSIRT/
│
├── database/
│   ├── createDB.sql         # SQL script to create database tables
│   └── insertData.sql       # SQL script to populate sample data
│
├── frontend/
│   ├── mainPage.html              # Main page or dashboard
│   ├── contactForm.html
│   │
│   ├── assets/
│   │      ├── dogPaw.png
│   │      ├── nbackground.png
│   │      └── Picture2.png
│   │
│   ├── authentication/
│   │      ├── login.html
│   │      ├── login.php
│   │      │
│   │      ├── client/
│   │      │     ├── appointments.php
│   │      │     ├── client.html
│   │      │     └──client.php
│   │      │
│   │      ├── handler/
│   │      │     └──handler.php
│   │      │
│   │      └── sitter/
│   │            └──sitter.php
│   │
│   └── globalStyles/              # Folder for CSS stylesheets
│       └── styles.css             # CSS styling for the frontend
│
├── documentation/
│   ├── ERD_diagram.png           # Entity Relationship Diagram image
│   ├── structure.txt
│   ├── DBMS Final Presentation.pdf        # Comprehensive project report
│   ├── Normalization table
│   └── Website demo
│
└── README.md
```