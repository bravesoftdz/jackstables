-- SQLITE DATABASE --
CREATE TABLE `product` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`name`	TEXT NOT NULL UNIQUE,
	`description`	TEXT NOT NULL,
	`category`	TEXT,
	`image`	TEXT
);


-- For the /admin section --
CREATE TABLE `administrator` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`username`	TEXT UNIQUE,
	`password`	TEXT
);
