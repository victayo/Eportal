
CREATE TABLE `assessment` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `max_score` double(3,2) NOT NULL,
  `is_exam` tinyint(1) NOT NULL,
  `include_in_cumulative` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
