CREATE TABLE `result`
(
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user`      VARCHAR(255) NOT NULL,
    `subject`   VARCHAR(255)  NOT NULL,
    `session`   VARCHAR(255)  NOT NULL,
    `term`      VARCHAR(255)  NOT NULL,
    `date`      VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB CHARSET="utf8";
