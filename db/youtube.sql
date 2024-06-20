-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 17, 2024 at 03:57 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youtube`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `commentID` int NOT NULL AUTO_INCREMENT,
  `videoID` int NOT NULL,
  `userID` int NOT NULL,
  `comment` text NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentID`),
  KEY `videoID` (`videoID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `videoID`, `userID`, `comment`, `time`) VALUES
(17, 68, 4, 'testing comment', '2024-05-05 22:56:55'),
(18, 70, 4, 'comment 2', '2024-05-05 22:56:55'),
(19, 63, 4, 'Making a comment', '2024-05-05 23:04:21'),
(20, 77, 4, 'Ayaz having fun', '2024-05-05 23:19:48'),
(21, 77, 3, 'Fun!', '2024-05-07 02:35:43'),
(22, 140, 4, 'today is the conference day', '2024-05-07 11:45:39'),
(23, 137, 18, 'Very nice! ', '2024-05-07 12:02:40'),
(24, 66, 3, 'hi', '2024-05-14 12:08:28'),
(25, 66, 3, 'sukuna 🐐', '2024-05-25 07:51:01'),
(26, 141, 3, 'boooo this sucks', '2024-05-25 07:51:24'),
(27, 138, 4, 'Luigi Dance!', '2024-05-26 00:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `dislikes`
--

DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE IF NOT EXISTS `dislikes` (
  `videoID` int NOT NULL,
  `userID` int NOT NULL,
  KEY `videoID` (`videoID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dislikes`
--

INSERT INTO `dislikes` (`videoID`, `userID`) VALUES
(141, 3);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `videoID` int NOT NULL,
  `userID` int NOT NULL,
  KEY `videoID` (`videoID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`videoID`, `userID`) VALUES
(65, 4),
(66, 4),
(140, 3),
(138, 3),
(68, 3),
(140, 18),
(65, 3),
(142, 3),
(66, 3);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `channelID` int NOT NULL,
  `subscriberID` int NOT NULL,
  KEY `channelID` (`channelID`),
  KEY `subscriberID` (`subscriberID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`channelID`, `subscriberID`) VALUES
(11, 3),
(4, 3),
(11, 4),
(14, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pfp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'user.png',
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `email`, `pfp`, `creation_time`) VALUES
(3, 'Zack', '$2y$10$i49xpLQvMTyMcugj0mc7A.r0u81wuvf6ROUCwKMLwsPGN.pJhpZr.', 'test@gmail.com', '662fdf2938f761.70693689.jpeg', '2024-04-29 22:55:53'),
(4, 'Tester', '$2y$10$.tDNE8ocn3cF2jne4bsJRulsAqFH9egmBR1CJ3WqliyoGbQl4RU7y', 'test@mailing.com', '663118504d1195.94834593.jpeg', '2024-04-30 21:12:00'),
(5, 'Tester2', '$2y$10$b3wnNyKLsojc8Z4a4kImk.mpO4vhakCaD1s5s3ZRaQ41NNf5vJGxO', 'tester@test.com', 'user.png', '2024-04-30 21:14:09'),
(8, 'OnlineTester', '$2y$10$mITk8YK6jkoeV4dQZlEeJOvIr7CbCLwDezaJIDcF.bW21HyfYKiDe', 'onlinetest@gmail.com', 'user.png', '2024-05-01 12:12:22'),
(9, 'samajee', '$2y$10$wupLXC3spL3n.w7CqwBjRew/wuY1IdToqahLvvcWJU22v.lxdAnd.', 'samajee@gmail.com', '6631ed66a792f7.24966905.jpg', '2024-05-01 12:21:10'),
(10, 'User1', '$2y$10$BYnBM0ExRd1T/ogh/QUB1OF6oj.E.O.hK3OKTzkjvXr5zM79Lc.qm', 'user1@gmail.com', 'user.png', '2024-05-01 14:33:38'),
(11, 'meerawks', '$2y$10$FmOJhlTGA.SgRX8erDKuXORqSHUyDl.HnXo53G3gBTlZfSB.GRbJO', 'sameer.asif.mughals123@gmail.com', 'user.png', '2024-05-01 18:44:25'),
(12, 'Niggacore', '$2y$10$xKZSYXX4R1lyRRwyzc89eOZcPDnLGklQeITIVKprK4hAhGvW9hz6O', 'emonmurtaza@gmail.com', 'user.png', '2024-05-01 22:37:21'),
(13, 'Nigga', '$2y$10$y3CRRnJ5tgPzTxAK1tD01u8WqSXkI0WecGqSe44ieYHUDA.nLnLpK', 'emonmurtaza@gmail.com', '66327dfab41c60.89564154.jpg', '2024-05-01 22:38:02'),
(14, 'Nigga', '$2y$10$JRyAFV3YkFc4T9C5yzCrBuAIvdDrTpv3f97P.daQHVQxSuFf99era', 'emonmurtaza@gmail.com', '66327e388698b4.16142933.jpg', '2024-05-01 22:39:04'),
(15, 'memehackerx', '$2y$10$UVxjS4CVY7aiKwzZfPcSGOd4QMSq5DqwmTBb3bUIAHDxa1TK4z34u', '123@gmail.com', '663283daa07df5.03517927.png', '2024-05-01 23:03:06'),
(16, 'Nigger', '$2y$10$vqJ/q1T/F6au7irU7VtyC.lMyH5f8LQWVYc6hdZsi214giZAh.HoS', 'Nigger69@gmail.com', 'user.png', '2024-05-02 23:54:03'),
(17, 'Malikdrake', '$2y$10$7FVeuqf6tjEQ7VY6vva8E./cDfBfUKcbwOl7KHZ742CZzOHDYnHFa', 'mujtabajaved8@gmail.com', '6633e187783aa1.23673361.jpg', '2024-05-02 23:55:03'),
(18, 'DemoAccount', '$2y$10$qu3NHkx.zy2grGcMC08kGejitLKyjqLFH1BNozTCLqmtMyolpxkI2', 'demo@mail.com', '6639d1e50fb301.37157679.png', '2024-05-07 12:01:57'),
(20, '123', '$2y$10$JaUEXCPLBPCouwYYErECj.nwRsCB1LXzJVjTVwsvM6fFxQFa66ZQ.', '123@gmail.com', '664306be783532.75439567.jpg', '2024-05-14 11:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `video_ID` int NOT NULL AUTO_INCREMENT,
  `video_title` varchar(255) NOT NULL DEFAULT 'Title',
  `video_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `video_likes` int NOT NULL DEFAULT '0',
  `video_dislikes` int NOT NULL DEFAULT '0',
  `video_upload_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `video_views` int NOT NULL DEFAULT '0',
  `video_directory` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_thumbnail` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'thumbnails/wallpaper.webp',
  `uploaderID` int NOT NULL,
  PRIMARY KEY (`video_ID`),
  KEY `uploaderID` (`uploaderID`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_ID`, `video_title`, `video_description`, `video_likes`, `video_dislikes`, `video_upload_date`, `video_views`, `video_directory`, `video_thumbnail`, `uploaderID`) VALUES
(63, 'Comfy Rain :)', 'Test', 0, 0, '2024-04-29 06:22:08', 75, 'uploaded_videos/662ef640cf25b2.62763743.mp4', 'thumbnails/662ef640cf25b2.62763743.jpg', 3),
(64, 'meerawks', 'sameer test video', 0, 0, '2024-05-01 18:46:24', 36, 'uploaded_videos/663247b0347684.97697109.mp4', 'thumbnails/663247b0347684.97697109.jpg', 11),
(65, 'Car Animation', 'Testing uploader name addition', 2, 0, '2024-05-01 20:32:45', 115, 'uploaded_videos/6632609db5c7e3.20148748.mp4', 'thumbnails/6632609db5c7e3.20148748.jpg', 3),
(66, '⌕ ࣪˖ ִֶ࿐ ^᪲᪲᪲ ', 'pleas add me on discord its iirlshinji :3 \n\n⠀⠀⠀⠀⠀⠀⢀⡀⠀⠀⠀⠀⠀⠀⣾⡳⣼⣆⠀⠀⢹⡄⠹⣷⣄⢠⠇⠻⣷⣶⢀⣸⣿⡾⡏⠀⠰⣿⣰⠏⠀⣀⡀⠀⠀⠀⠀⠀⠀⠀\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⣀⡀⣀⣀⣀⡹⣟⡪⢟⣷⠦⠬⣿⣦⣌⡙⠿⡆⠻⡌⠿⣦⣿⣿⣿⣿⣦⣿⡿⠟⠚⠉⠀⠉⠳⣄⡀⠀⠀⠁⠀\n⠀⠀⠀⠀⠀⠀⠀⡀⢀⣼⣟⠛⠛⠙⠛⠉⠻⢶⣮⢿⣯⡙⢶⡌⠲⢤⡑⠀⠈⠛⠟⢿⣿⠛⣿⠋⠀⠀⠀⠀⠀⠀⠀⠀⠀⠙⣆⠀⠀⠀\n⠀⠀⠀⠀⠀⡸⠯⣙⠛⢉⣉⣙⣿⣿⡳⢶⣦⣝⢿⣆⠉⠻⣄⠈⢆⢵⡈⠀⠀⢰⡆⠀⣼⠓⠀⠀⠀          Nah   ', 2, 0, '2024-05-01 22:47:14', 28, 'uploaded_videos/66328022cba190.08401032.mp4', 'thumbnails/66328022cba190.08401032.jpg', 14),
(68, 'Nigga', '', 1, 0, '2024-05-01 22:51:14', 50, 'uploaded_videos/66328112f25608.21259064.mp4', 'thumbnails/66328112f25608.21259064.jpg', 14),
(70, 'Testing Video Title Display on Very Long Titles Such as This One', 'Test', 0, 0, '2024-05-02 09:35:19', 12, 'uploaded_videos/663318079737a0.51588784.mp4', 'thumbnails/663318079737a0.51588784.jpg', 3),
(72, 'Testing time', 'Testing time', 0, 0, '2024-05-02 22:01:19', 181, 'uploaded_videos/6633c6df4556b3.76627623.mp4', 'thumbnails/6633c6df4556b3.76627623.jpg', 3),
(73, 'Testing Time 2', 'Testing Time', 0, 0, '2024-05-02 22:17:18', 19, 'uploaded_videos/6633ca9ea4a355.08954057.mp4', 'thumbnails/6633ca9ea4a355.08954057.jpg', 3),
(76, 'CSS Grid Validation', '', 0, 0, '2024-05-03 00:08:35', 14, 'uploaded_videos/6633e4b2a8f944.25424237.mp4', 'thumbnails/6633e4b2a8f944.25424237.jpg', 3),
(77, 'Ayaz and Co.', 'test', 0, 0, '2024-05-03 10:16:06', 46, 'uploaded_videos/66347316bc0f44.04599271.mp4', 'thumbnails/66347316bc0f44.04599271.jpg', 3),
(78, 'test', 'test', 0, 0, '2024-05-03 12:19:49', 24, 'uploaded_videos/66349015f3c308.16724693.mp4', 'thumbnails/66349015f3c308.16724693.jpg', 3),
(136, 'Comfy Rain with Thumbnail', 'test', 0, 0, '2024-05-05 11:03:17', 7, 'uploaded_videos/66372125483d51.19672077.mp4', 'thumbnails/66372125483d51.19672077.jpg', 4),
(137, 'Comfy Rain Again!', 'thumbnail?', 0, 0, '2024-05-05 11:05:06', 47, 'uploaded_videos/663721923b9376.03441223.mp4', 'thumbnails/663721923b9376.03441223.jpg', 4),
(138, 'Luigi Dance', 'THUMBNAILS WORK NOW!!!!!', 1, 0, '2024-05-05 11:06:25', 127, 'uploaded_videos/663721e1628ab7.02519933.mp4', 'thumbnails/663721e1628ab7.02519933.jpg', 4),
(140, 'test', 'demo', 2, 0, '2024-05-07 11:44:42', 10, 'uploaded_videos/6639cdd654fd28.25903486.mp4', 'thumbnails/6639cdd654fd28.25903486.jpg', 4),
(141, 'Checking Upload after Error Handling', 'This video is uploaded as a overall test of upload module after making changes to unrelated modules', 0, 1, '2024-05-12 21:07:36', 9, 'uploaded_videos/6640e93b5c15a2.43895830.mp4', 'thumbnails/6640e93b5c15a2.43895830.jpg', 3),
(142, 'luigi dance ', 'tsting upload again', 1, 0, '2024-05-14 12:11:14', 3, 'uploaded_videos/66430e9193e3a6.97156305.mp4', 'thumbnails/66430e9193e3a6.97156305.jpg', 3),
(144, 'testing upload on new pc', 'test.. again', 0, 0, '2024-06-13 22:15:09', 0, 'uploaded_videos/666b291dc43090.89230646.mp4', 'thumbnails/666b291dc43090.89230646.jpg', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `video`
--
ALTER TABLE `video` ADD FULLTEXT KEY `video_title` (`video_title`,`video_description`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`videoID`) REFERENCES `video` (`video_ID`);

--
-- Constraints for table `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `dislikes_ibfk_1` FOREIGN KEY (`videoID`) REFERENCES `video` (`video_ID`),
  ADD CONSTRAINT `dislikes_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`videoID`) REFERENCES `video` (`video_ID`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`uploaderID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
