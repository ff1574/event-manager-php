SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `person` (
  `id` mediumint(10) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `nick_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `person` (`id`, `last_name`, `first_name`, `nick_name`) VALUES
(1, 'Marasovic', 'Kristina', 'KM'),
(2, 'Ivic', 'Ivo', 'II'),
(3, 'Doe', 'Jane', 'JD');

ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `person`
  MODIFY `id` mediumint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

