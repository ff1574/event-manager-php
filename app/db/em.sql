--
-- Drop tables if they exist
--

DROP TABLE IF EXISTS `attendee_event`;
DROP TABLE IF EXISTS `attendee`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `event`;
DROP TABLE IF EXISTS `venue`;

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `role` WRITE;
INSERT INTO `role` VALUES (1,'admin'),(2,'attendee');
UNLOCK TABLES;

--
-- Table structure for table `attendee`
--

CREATE TABLE IF NOT EXISTS `attendee` (
  `attendee_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role_id` smallint unsigned NOT NULL,
  PRIMARY KEY (`attendee_id`),
  KEY `idx_fk_role_id` (`role_id`),
  CONSTRAINT `fk_attendee_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `attendee` WRITE;
INSERT INTO `attendee` VALUES 
(1, 'Kristina', 'Marasović', 'kxmzgr@rit.edu', 'kmu', '$2y$10$/TGAngySy2s117SvEBhQzuw5V2bVroaNbwuzgquvZ2MuhoWaD8HyS', 2),
(2, 'Franko', 'Fišter', 'ff1574@rit.edu', 'ff1574', '$2y$10$pdb9ubrwk26x8ldH06VP126XyAMm9D2F3O7XY8IkIsNW2g.DdsRs.', 1),
(3, 'John', 'Doe', 'john.doe@example.com', 'johndoe', '$2y$10$OgRa98PuV1AvwF9FZDBmhu0UOj0UqzMbWhO.wfsR.Z5gNWssg9Ty.', 2), 
(4, 'Jane', 'Doe', 'jane.doe@example.com', 'janedoe', '$2y$10$0T8yyjPpytgHQrAeh0eyA.MJ6uPm2XnUHQMZQy9kTLfZnHRGgXFu6', 2),
(5, 'Emily', 'Smith', 'emily.smith@example.com', 'emsmith', '$2y$10$FfueLuoO6VC2XlP10c0cu.JpsYJxsS/NH22gnCZXGy6M8QjvtydAy', 2),
(6, 'Michael', 'Johnson', 'michael.johnson@example.com', 'mjohnson', '$2y$10$GhTVlQ5t/sMJ4g9h38lZhOS/R5o9zqCZyb/NpOz38B11DoxuFyfWq', 2),
(7, 'Anna', 'Taylor', 'anna.taylor@example.com', 'annat', '$2y$10$VpXv3Fjso7B4Kov0jhMIW.VRNXPXsQosGeBb.lW8YZzqJ6fRQoxcW', 2),
(8, 'Robert', 'Brown', 'robert.brown@example.com', 'rbrown', '$2y$10$TpzOb6ogw5k6GgcbN6PL0uOVNHZWORUfsnItTOdLfT5hszOxDZTgG', 2),
(9, 'Linda', 'White', 'linda.white@example.com', 'lwhite', '$2y$10$LyfT/OZ5hljhG9vcjOw1Ru5jsVsSFFUcbjWemGDkVmvLx6fGO9y9.', 2);
UNLOCK TABLES;

--
-- Table structure for table `venue`
--

CREATE TABLE IF NOT EXISTS `venue` (
  `venue_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `capacity` int DEFAULT NULL,
  PRIMARY KEY (`venue_id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `venue` WRITE;
INSERT INTO `venue` (`venue_id`, `name`, `capacity`) VALUES 
(1, 'Modern Event Venue', 300),
(2, 'Cozy Wooden Venue', 100),
(3, 'Open Air Stadium', 5000),
(4, 'Downtown Conference Center', 500),
(5, 'Beachside Pavilion', 200),
(6, 'Mountain Retreat Lodge', 5);
UNLOCK TABLES;

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `event_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `allowed_number` int NOT NULL,
  `venue_id` smallint unsigned NOT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `idx_fk_venue_id` (`venue_id`),
  CONSTRAINT `fk_event_venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`venue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `event` WRITE;
INSERT INTO `event` (`event_id`, `name`, `start_date`, `end_date`, `allowed_number`, `venue_id`) VALUES 
(1, 'Corporate Gathering', '2024-10-10 09:00:00', '2024-10-10 17:00:00', 300, 1),
(2, 'Wedding Celebration', '2024-12-12 13:00:00', '2024-12-12 23:00:00', 100, 2),
(3, 'Music Festival', '2025-01-15 12:00:00', '2025-01-16 02:00:00', 5000, 3),
(4, 'Tech Conference', '2025-03-20 10:00:00', '2025-03-22 18:00:00', 500, 4),
(5, 'Beachside Yoga Retreat', '2025-04-10 08:00:00', '2025-04-15 18:00:00', 200, 5),
(6, 'Mountain Adventure Workshop', '2025-05-05 09:00:00', '2025-05-07 17:00:00', 150, 6);
UNLOCK TABLES;

--
-- Table structure for table `attendee_event`
--

CREATE TABLE IF NOT EXISTS `attendee_event` (
  `attendee_id` smallint unsigned NOT NULL,
  `event_id` smallint unsigned NOT NULL,
  `paid` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`attendee_id`,`event_id`),
  KEY `idx_fk_attendee_id` (`attendee_id`),
  KEY `idx_fk_event_id` (`event_id`),
  CONSTRAINT `fk_attendee_event_attendee` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`attendee_id`),
  CONSTRAINT `fk_attendee_event_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `attendee_event` WRITE;
INSERT INTO `attendee_event` (`attendee_id`, `event_id`, `paid`) VALUES 
(1, 1, 1),  -- Kristina Marasović attending Corporate Gathering
(2, 1, 1),  -- Franko Fišter attending Corporate Gathering
(3, 1, 0),  -- John Doe registered for Corporate Gathering, not paid
(4, 2, 1),  -- Jane Doe attending Wedding Celebration
(5, 3, 1),  -- Emily Smith attending Music Festival
(6, 3, 0),  -- Michael Johnson registered for Music Festival, not paid
(7, 4, 1),  -- Anna Taylor attending Tech Conference
(8, 4, 1),  -- Robert Brown attending Tech Conference
(9, 5, 1),  -- Linda White attending Beachside Yoga Retreat
(3, 6, 1),  -- John Doe attending Mountain Adventure Workshop
(4, 6, 1),  -- Jane Doe attending Mountain Adventure Workshop
(5, 5, 0);  -- Emily Smith registered for Beachside Yoga Retreat, not paid
UNLOCK TABLES;
