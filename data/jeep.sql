-- Create the database
CREATE DATABASE IF NOT EXISTS mjeepl;
USE mjeepl;

-- Create the jeep table
CREATE TABLE `jeep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `weather` int(11) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `route` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `passengers` int(11) NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=19;
