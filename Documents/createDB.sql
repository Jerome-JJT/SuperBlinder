CREATE DATABASE IF NOT EXISTS `tpi21blind_db`;
USE `tpi21blind_db`;


DROP TABLE IF EXISTS `scores`;
DROP TABLE IF EXISTS `games_tracks`;
DROP TABLE IF EXISTS `tracks`;
DROP TABLE IF EXISTS `games`;
DROP TABLE IF EXISTS `users`;



CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(320) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `creationDate` date NOT NULL,
  PRIMARY KEY (`ID`)
);



CREATE TABLE IF NOT EXISTS `games` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `seed` varchar(256) NOT NULL,
  PRIMARY KEY (`ID`)
);



CREATE TABLE IF NOT EXISTS `tracks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `fullPath` varchar(256) NOT NULL,
  `difficulty` enum('Easy','Normal','Hard') NOT NULL DEFAULT 'Normal',
  `type` enum('Movie','Serie','Other') NOT NULL DEFAULT 'Other',
  `creatorId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `track_creatorId` (`creatorId`),
  CONSTRAINT `track_creatorId` FOREIGN KEY (`creatorId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
);



CREATE TABLE IF NOT EXISTS `games_tracks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `gameId` int(11) NOT NULL,
  `trackId` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `game_trackId` (`trackId`),
  KEY `track_gameId` (`gameId`),
  CONSTRAINT `game_trackId` FOREIGN KEY (`trackId`) REFERENCES `tracks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `track_gameId` FOREIGN KEY (`gameId`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);



CREATE TABLE IF NOT EXISTS `scores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `gameId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `score_gameId` (`gameId`),
  KEY `score_userId` (`userId`),
  CONSTRAINT `score_gameId` FOREIGN KEY (`gameId`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `score_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);


