-- Create Users Table
CREATE TABLE users (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) UNIQUE NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiration` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

-- Create Tasks Table
CREATE TABLE tasks (
  `id` int NOT NULL AUTO_INCREMENT  PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `description` text,
  `user_id` int DEFAULT NULL,
  `completed` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `due_date` timestamp NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO tasks (title, description, due_date, user_id, completed) 
        VALUES ('Drake', 'Dake should say something', '2023-10-18 00:00:00', 1, 1 );

SHOW GRANTS FOR 'admin'@'localhost' ON ekomi.*;