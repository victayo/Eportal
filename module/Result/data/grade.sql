CREATE TABLE `grade` (
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `remark` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grade`
 ADD UNIQUE KEY `min` (`min`,`max`);
