###
#  Assumes MySQL 5.6.5+ for 2 CURRENT_TIMESTAMP fields
###

CREATE TABLE IF NOT EXISTS `products` (
	`id` 		int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` 		text,
	`created` 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`updated` 	TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
	`id` 		int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` 		text,
	`created` 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`updated` 	TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS `comments` (
	`id` 			int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user_id` 		int(10) NOT NULL,
	`product_id` 	int(10) NOT NULL,
	'comment' 		text,
	`read` 			tinyint(1) DEFAULT 0,
	`created` 		TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`updated` 		TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP
  	INDEX user_product (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;


# Add some sample data
INSERT INTO products SET name = "Product 1";
INSERT INTO products SET name = "Product 2";
INSERT INTO products SET name = "Product 3";
INSERT INTO products SET name = "Product 4";
INSERT INTO products SET name = "Product 5";

INSERT INTO users SET name = "User 1";
INSERT INTO users SET name = "User 2";
INSERT INTO users SET name = "User 3";
INSERT INTO users SET name = "User 4";
INSERT INTO users SET name = "User 5";

INSERT INTO comments SET user_id = 1, product_id = 1, comment = "Comment 1", read = 0;
INSERT INTO comments SET user_id = 1, product_id = 1, comment = "Comment 2", read = 0;
INSERT INTO comments SET user_id = 1, product_id = 1, comment = "Comment 3", read = 1;
INSERT INTO comments SET user_id = 1, product_id = 2, comment = "Comment 4", read = 1;
INSERT INTO comments SET user_id = 1, product_id = 3, comment = "Comment 5", read = 0;
INSERT INTO comments SET user_id = 2, product_id = 3, comment = "Comment 6", read = 0;
INSERT INTO comments SET user_id = 3, product_id = 4, comment = "Comment 7", read = 1;
INSERT INTO comments SET user_id = 4, product_id = 5, comment = "Comment 8", read = 0;
INSERT INTO comments SET user_id = 5, product_id = 1, comment = "Comment 8", read = 0;