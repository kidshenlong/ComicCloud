SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `comiccloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `comics`
--

CREATE TABLE IF NOT EXISTS `comics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seriesID` int(11) NOT NULL,
  `issue` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `coverimg` varchar(255) NOT NULL,
  `locationid` int(11) NOT NULL,
  `issueCVID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seriesID` (`seriesID`),
  KEY `locationid` (`locationid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `comicSeries`
--

CREATE TABLE IF NOT EXISTS `comicSeries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seriesName` varchar(255) NOT NULL,
  `seriesStartYear` int(11) NOT NULL,
  `seriesCover` varchar(255) NOT NULL,
  `seriesCVID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uploaderID` int(11) NOT NULL,
  `uploadname` varchar(255) NOT NULL,
  `uploadlocation` varchar(255) NOT NULL,
  `matched` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comics`
--
ALTER TABLE `comics`
  ADD CONSTRAINT `comics_ibfk_2` FOREIGN KEY (`locationid`) REFERENCES `uploads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comics_ibfk_3` FOREIGN KEY (`seriesID`) REFERENCES `comicSeries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
