CREATE TABLE `joint_property_value`
(
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_property_value`      INT UNSIGNED NOT NULL,
    `second_property_value`    INT UNSIGNED NOT NULL
) ENGINE=InnoDB CHARSET="utf8";