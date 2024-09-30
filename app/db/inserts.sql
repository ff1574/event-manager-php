-- Mock data for 'role' table
LOCK TABLES `role` WRITE;
INSERT INTO `role` (`role_id`, `name`) VALUES 
(1, 'admin'),
(2, 'attendee');
UNLOCK TABLES;

-- Mock data for 'attendee' table
LOCK TABLES `attendee` WRITE;
INSERT INTO `attendee` (`attendee_id`, `first_name`, `last_name`, `email`, `username`, `password`, `role_id`) VALUES 
(1, 'Franko', 'Fišter', 'ff1574@rit.edu', 'ff1574', '$2y$10$pdb9ubrwk26x8ldH06VP126XyAMm9D2F3O7XY8IkIsNW2g.DdsRs.', 1),  -- Admin account
(3, 'John', 'Doe', 'john.doe@example.com', 'johndoe', '$2y$10$OgRa98PuV1AvwF9FZDBmhu0UOj0UqzMbWhO.wfsR.Z5gNWssg9Ty.', 2),  -- Attendee
(4, 'Jane', 'Doe', 'jane.doe@example.com', 'janedoe', '$2y$10$0T8yyjPpytgHQrAeh0eyA.MJ6uPm2XnUHQMZQy9kTLfZnHRGgXFu6', 2); -- Attendee
UNLOCK TABLES;

-- Mock data for 'venue' table
LOCK TABLES `venue` WRITE;
INSERT INTO `venue` (`venue_id`, `name`, `capacity`) VALUES 
(1, 'Modern Event Venue', 300),
(2, 'Cozy Wooden Venue', 100),
(3, 'Open Air Stadium', 5000);
UNLOCK TABLES;

-- Mock data for 'event' table
LOCK TABLES `event` WRITE;
INSERT INTO `event` (`event_id`, `name`, `start_date`, `end_date`, `allowed_number`, `venue_id`) VALUES 
(1, 'Corporate Gathering', '2024-10-10 09:00:00', '2024-10-10 17:00:00', 300, 1),
(2, 'Wedding Celebration', '2024-12-12 13:00:00', '2024-12-12 23:00:00', 100, 2),
(3, 'Music Festival', '2025-01-15 12:00:00', '2025-01-16 02:00:00', 5000, 3);
UNLOCK TABLES;

-- Mock data for 'attendee_event' table
LOCK TABLES `attendee_event` WRITE;
INSERT INTO `attendee_event` (`attendee_id`, `event_id`, `paid`) VALUES 
(1, 1, 1),  -- John Doe is attending the Corporate Gathering
(2, 1, 1),  -- Jane Doe is attending the Wedding Celebration
(3, 1, 0), 
(4, 1, 1),  -- John Doe is attending the Wedding Celebration
(4, 2, 1),  -- John Doe is attending the Music Festival
(4, 3, 1),
(3, 3, 1);

UNLOCK TABLES;
