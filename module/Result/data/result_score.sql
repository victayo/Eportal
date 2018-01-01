CREATE TABLE `result_score` (
  `result` int(11) NOT NULL,
  `assessment` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `result_score`
 ADD UNIQUE KEY `result` (`result`,`assessment`);
