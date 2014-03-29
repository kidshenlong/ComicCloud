SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `comics` (
  `comic_id` int(11) NOT NULL AUTO_INCREMENT,
  `uploader_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `finishedProcess` tinyint(1) NOT NULL,
  PRIMARY KEY (`comic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `comicsInfo` (
  `comic_id` int(11) NOT NULL,
  `comic_series` varchar(255) NOT NULL,
  `comic_issue` int(11) DEFAULT NULL,
  `comic_start_year` varchar(255) DEFAULT NULL,
  `comic_cover_image` varchar(255) DEFAULT NULL,
  UNIQUE KEY `comic_id_2` (`comic_id`),
  KEY `comic_id` (`comic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `comicsInfo`
ADD CONSTRAINT `comicsInfo_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`comic_id`) ON DELETE CASCADE ON UPDATE CASCADE;
