CREATE DATABASE event_management;
USE event_management;

CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(64) NOT NULL
);

INSERT INTO admin (username, password)
VALUES ('admin', SHA2('admin123', 256));

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  category VARCHAR(50),
  event_date DATE,
  venue VARCHAR(100),
  description TEXT
);

INSERT INTO events (title, category, event_date, venue, description)
VALUES
('Tech Symposium 2026', 'Technical', '2026-10-20', 'Seminar Hall',
 'Paper presentation, project expo and technical quiz.'),
('Cultural Fest - Utsav', 'Cultural', '2026-11-05', 'Open Auditorium',
 'Dance, music, drama and fine arts competitions.'),
('Inter-Department Sports Meet', 'Sports', '2026-11-15', 'College Ground',
 'Athletics, cricket, volleyball and kabaddi tournaments.');

CREATE TABLE registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  phone VARCHAR(15),
  department VARCHAR(50),
  year_of_study VARCHAR(10),
  registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

INSERT INTO registrations
(event_id, name, email, phone, department, year_of_study)
VALUES
(1, 'Arun Kumar', 'arun@gmail.com', '9876543210', 'CSE', 'III'),
(2, 'Priya S', 'priya@gmail.com', '9876543211', 'IT', 'II');