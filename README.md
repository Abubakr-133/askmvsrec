# ASK-MVSREC

ASK-MVSREC is a college-specific Question & Answer and Discussion platform for students of MVSR Engineering College. It allows users to ask questions, post discussions, and interact academically in a clean, responsive, and feature-rich interface.

---

## Features

### Authentication System
- Login using *Roll Number* only.
- Auto-generates college email as rollnumber@mvsrec.edu.in.
- *OTP-based login* – no password required.
- Email verification via OTP, handled through PHP Mail or SMTP.
- Session management using PHP sessions.

### Posts (Discussion Section)
- View and interact with public posts.
- Like/Dislike system:
  - A user can either like or dislike a post, not both at the same time.
  - Counts update dynamically.
- Responsive UI with Bootstrap (Mobile + Desktop friendly).
- Unicode-based like/dislike icons for consistent rendering.
- Posts retain original formatting (indentation, code blocks, spacing).
- "Show More/Hide" toggle appears only when text exceeds visible length.
- Displays username, timestamp, and post formatting properly.

### Questions & Answers
- Questions may include optional images (photos only).
- Answer system with editable textarea for original user.
- Answers may also contain optional images.
- Like/Dislike system shared across both questions and answers.
- Responsive layout for clean mobile and desktop viewing.
- Answer button dynamically opens a textarea preserving spaces.
- Username, date, and time are displayed for all posts and responses.

---

## Database Schema

### Users
| Column       | Type     | Description                    |
|--------------|----------|--------------------------------|
| roll_number  | VARCHAR  | Unique user identifier         |
| password     | VARCHAR  | OTP (temporary)                |
| verified     | BOOLEAN  | Whether user is verified       |

### Questions
| Column      | Type     | Description                    |
|-------------|----------|--------------------------------|
| id          | INT      | Primary key                    |
| roll_number | VARCHAR  | User who asked the question    |
| question    | TEXT     | Question content               |
| created_at  | DATETIME | Timestamp                      |

### Posts
| Column      | Type     | Description                    |
|-------------|----------|--------------------------------|
| id          | INT      | Primary key                    |
| roll_number | VARCHAR  | User who made the post         |
| content     | TEXT     | Content of the post            |
| image       | VARCHAR  | Optional image file name       |
| like        | INT      | Like count                     |
| dislike     | INT      | Dislike count                  |
| created_at  | DATETIME | Timestamp                      |

### OTP Verification
| Column      | Type     | Description                    |
|-------------|----------|--------------------------------|
| roll_number | VARCHAR  | Roll number of user            |
| otp         | VARCHAR  | One-time password              |
| expires_at  | DATETIME | Expiry time of OTP             |

### Answers
| Column       | Type     | Description                   |
|--------------|----------|-------------------------------|
| id           | INT      | Primary key                   |
| question_id  | INT      | Foreign key to Questions      |
| roll_number  | VARCHAR  | User who answered             |
| answer       | TEXT     | Answer content                |
| created_at   | DATETIME | Timestamp                     |

---

## Tech Stack

- *Frontend*: HTML, CSS, JavaScript, Bootstrap
- *Backend*: PHP
- *Database*: MySQL
- *Email Service*: PHP Mail or SMTP (for OTP delivery)

---

## Setup Instructions

1. Clone the repo:
   ```bash
   git clone https://github.com/Abubakr-133/askmvsrec
2.Create the askmvsrec database and its five tables as below:
  -- Create the database
CREATE DATABASE IF NOT EXISTS ask_mvsrec;
USE ask_mvsrec;

-- Users Table
CREATE TABLE IF NOT EXISTS Users (
    roll_number VARCHAR(20) PRIMARY KEY,
    password VARCHAR(100),
    verified BOOLEAN DEFAULT FALSE
);

-- Questions Table
CREATE TABLE IF NOT EXISTS Questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_number VARCHAR(20),
    question TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (roll_number) REFERENCES Users(roll_number)
);

-- Posts Table
CREATE TABLE IF NOT EXISTS Posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_number VARCHAR(20),
    content TEXT,
    image VARCHAR(255),
    like INT DEFAULT 0,
    dislike INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (roll_number) REFERENCES Users(roll_number)
);

-- OTP Verification Table
CREATE TABLE IF NOT EXISTS OTP Verification (
    roll_number VARCHAR(20) PRIMARY KEY,
    otp VARCHAR(10),
    expires_at DATETIME,
    FOREIGN KEY (roll_number) REFERENCES Users(roll_number)
);

-- Answers Table
CREATE TABLE IF NOT EXISTS Answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    roll_number VARCHAR(20),
    answer TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES Questions(id),
    FOREIGN KEY (roll_number) REFERENCES Users(roll_number)
);
3.Open Xampp,start the apache server and mysql database and search for the results on localhost
