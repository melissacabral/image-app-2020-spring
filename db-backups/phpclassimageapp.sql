-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2020 at 10:39 AM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpclassimageapp`
--
CREATE DATABASE IF NOT EXISTS `phpclassimageapp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `phpclassimageapp`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` smallint(6) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Black and White'),
(2, 'Macro Photos');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` smallint(6) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `body` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  `post_id` smallint(6) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `body`, `date`, `post_id`, `is_approved`) VALUES
(1, 1, 'This is a comment from user 1', '2020-03-24 11:27:47', 1, 1),
(2, 2, 'This is a comment from user 2', '2020-03-24 11:27:47', 2, 1),
(3, 2, 'another comment', '2020-03-26 09:05:36', 2, 1),
(4, 1, 'another great comment on this post', '2020-03-26 09:05:36', 2, 1),
(5, 1, 'test comment on thursday ', '2020-03-26 10:55:31', 4, 1),
(6, 1, 'testinggggg', '2020-03-26 11:03:39', 4, 1),
(7, 1, ' click here ', '2020-03-26 11:06:24', 4, 1),
(8, 1, 'helloooo', '2020-03-26 11:07:56', 1, 1),
(9, 1, 'hi', '2020-03-26 11:52:06', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` smallint(6) NOT NULL,
  `title` varchar(75) NOT NULL,
  `image` varchar(100) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `body` varchar(400) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `image`, `user_id`, `date`, `body`, `category_id`, `allow_comments`, `is_published`) VALUES
(1, 'This is a post in category 2 - macro', 'https://picsum.photos/id/237/400/400', 1, '2020-03-23 10:54:48', 'this is the body', 2, 1, 1),
(2, 'practice insert statement', 'https://picsum.photos/id/1024/400/400', 2, '2020-03-24 08:38:00', 'this is the body', 1, 0, 1),
(4, 'Happy Tuesday', 'https://picsum.photos/id/0/400/400', 1, '2020-03-24 10:33:06', 'hello it worked', 1, 1, 1),
(5, '', '88cf807d7de1026828be6708d5801693bd76178c', 1, '2020-04-07 09:57:38', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` smallint(6) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(40) NOT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  `bio` varchar(1000) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `join_date` datetime NOT NULL,
  `secret_key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_pic`, `bio`, `is_admin`, `join_date`, `secret_key`) VALUES
(1, 'Melissa', 'mcabral@gmail.com', '19cd0892658faafd5bf80f969f7368c2607b9ad5', 'https://randomuser.me/api/portraits/lego/6.jpg', 'I like snacks', 1, '2020-03-23 09:59:34', 'fe2a4cee339997cb367613180919d9eea055a877'),
(2, 'Random User', 'somebody@mail.com', '19cd0892658faafd5bf80f969f7368c2607b9ad5', 'https://randomuser.me/api/portraits/lego/7.jpg', 'hi', 0, '2020-03-23 10:01:08', NULL),
(3, 'random test on friday', 'bricks@super-junk.com', '19cd0892658faafd5bf80f969f7368c2607b9ad5', '', '', 0, '2020-04-03 09:45:42', NULL),
(4, 'Bananas', 'bananas@mail.com', '19cd0892658faafd5bf80f969f7368c2607b9ad5', '', '', 0, '2020-04-03 10:03:45', '51c2fa623d098034051799a0fc8e3549231397f4'),
(5, 'someone new', 'newbie@mail.com', '19cd0892658faafd5bf80f969f7368c2607b9ad5', '', '', 0, '2020-04-03 10:44:18', NULL),
(6, 'random 12375143', 'dshgdrgyfgnhxhfnxhsfdgh@mail.com', '19cd0892658faafd5bf80f969f7368c2607b9ad5', '', '', 0, '2020-04-03 10:55:59', NULL),
(7, 'happymonday', 'monday@gmail.com', '19cd0892658faafd5bf80f969f7368c2607b9ad5', '', '', 0, '2020-04-06 09:37:46', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
