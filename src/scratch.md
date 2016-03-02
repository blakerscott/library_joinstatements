
Table	Create Table

authors
CREATE TABLE `authors` (
 `id` serial PRIMARY KEY,
 `author` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='authors of a book'


books
CREATE TABLE `books` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `title` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8


books_authors
CREATE TABLE `books_authors` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `book_id` bigint(20) DEFAULT NULL,
 `author_id` bigint(20) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='join table for books to authors'

checkout
CREATE TABLE `checkout` (
 `id` bigint(20) NOT NULL,
 `copy_id` bigint(20) DEFAULT NULL,
 `patron_id` bigint(20) DEFAULT NULL,
 `due_date` date DEFAULT NULL,
 `checkin_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 means the book has been returned',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

copies
CREATE TABLE `copies` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `book_id` int(20) DEFAULT NULL,
 `copies_out` int(20) DEFAULT NULL,
 `copies_total` bigint(20) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Number of copies of each book'

patrons
CREATE TABLE `patrons` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
