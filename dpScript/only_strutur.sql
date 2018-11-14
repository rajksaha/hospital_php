-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 19, 2017 at 04:28 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `doctorplatform`
--

-- --------------------------------------------------------

--
-- Table structure for table `advice`
--

CREATE TABLE IF NOT EXISTS `advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `lang` tinyint(1) NOT NULL,
  `advice` text CHARACTER SET utf8 NOT NULL,
  `pdf` varchar(512) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=347 ;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `appointmentID` int(11) NOT NULL AUTO_INCREMENT,
  `doctorCode` varchar(15) NOT NULL,
  `patientCode` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` int(11) NOT NULL,
  `appointmentType` int(11) NOT NULL,
  `addedBy` varchar(15) NOT NULL,
  PRIMARY KEY (`appointmentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4728 ;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_type`
--

CREATE TABLE IF NOT EXISTS `appointment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `complain`
--

CREATE TABLE IF NOT EXISTS `complain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `symptomID` int(11) NOT NULL,
  `durationNum` double NOT NULL,
  `durationType` int(11) DEFAULT NULL,
  `detail` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7116 ;

-- --------------------------------------------------------

--
-- Table structure for table `contentdetail`
--

CREATE TABLE IF NOT EXISTS `contentdetail` (
  `contentDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `contentType` varchar(20) NOT NULL,
  `entityID` int(11) NOT NULL,
  `detail` text CHARACTER SET utf8 NOT NULL,
  `code` text NOT NULL,
  PRIMARY KEY (`contentDetailID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=463 ;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE IF NOT EXISTS `diagnosis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `diseaseID` int(11) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4200 ;

-- --------------------------------------------------------

--
-- Table structure for table `disease`
--

CREATE TABLE IF NOT EXISTS `disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3357 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `doctorID` int(11) NOT NULL AUTO_INCREMENT,
  `doctorCode` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sex` varchar(15) NOT NULL,
  `age` decimal(10,0) NOT NULL,
  `phone` varchar(15) NOT NULL,
  PRIMARY KEY (`doctorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctorcategory`
--

CREATE TABLE IF NOT EXISTS `doctorcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctorsettings`
--

CREATE TABLE IF NOT EXISTS `doctorsettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `patientType` int(11) NOT NULL,
  `patientState` int(11) NOT NULL,
  `prescriptionStyle` tinyint(1) NOT NULL,
  `hospitalID` int(11) NOT NULL,
  `photoSupport` tinyint(1) NOT NULL,
  `personCodeInitial` int(16) NOT NULL,
  `pdfPage` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctorId` (`doctorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_advice_settings`
--

CREATE TABLE IF NOT EXISTS `doctor_advice_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `adviceID` int(11) NOT NULL,
  `displayOrder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=259 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_drug`
--

CREATE TABLE IF NOT EXISTS `doctor_drug` (
  `doctorDrugID` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `drugID` int(11) NOT NULL,
  `drugTimeID` int(11) NOT NULL,
  `drugDoseUnit` varchar(255) NOT NULL,
  `drugWhenID` int(11) NOT NULL,
  `drugAdviceID` int(11) NOT NULL,
  PRIMARY KEY (`doctorDrugID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14359 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_drug_dose`
--

CREATE TABLE IF NOT EXISTS `doctor_drug_dose` (
  `doctorDrugDoseID` int(11) NOT NULL AUTO_INCREMENT,
  `doctorDrugID` int(11) NOT NULL,
  `dose` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `numOfDay` int(11) DEFAULT NULL,
  `durationType` int(11) NOT NULL,
  PRIMARY KEY (`doctorDrugDoseID`),
  UNIQUE KEY `doctorDrugDoseID` (`doctorDrugDoseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14479 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_followup_setteing`
--

CREATE TABLE IF NOT EXISTS `doctor_followup_setteing` (
  `followUpSerttingID` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `invID` int(11) NOT NULL,
  PRIMARY KEY (`followUpSerttingID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_history_settings`
--

CREATE TABLE IF NOT EXISTS `doctor_history_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `historyID` int(11) NOT NULL,
  `displayOrder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_inv_setteing`
--

CREATE TABLE IF NOT EXISTS `doctor_inv_setteing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `invID` int(11) NOT NULL,
  `displayOrder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=314 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_vital_settings`
--

CREATE TABLE IF NOT EXISTS `doctor_vital_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `vitalID` int(11) NOT NULL,
  `displayOrder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=147 ;

-- --------------------------------------------------------

--
-- Table structure for table `dose_period`
--

CREATE TABLE IF NOT EXISTS `dose_period` (
  `drugPrescribeID` int(11) NOT NULL,
  `dose` varchar(160) CHARACTER SET utf8 DEFAULT NULL,
  `numOfDay` double DEFAULT NULL,
  `durationType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `drug`
--

CREATE TABLE IF NOT EXISTS `drug` (
  `drugID` int(33) NOT NULL AUTO_INCREMENT,
  `typeID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `drugName` varchar(255) NOT NULL,
  `strength` varchar(255) NOT NULL,
  PRIMARY KEY (`drugID`),
  KEY `strength` (`strength`),
  KEY `drugID` (`drugID`,`drugName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8725 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugadvicetype`
--

CREATE TABLE IF NOT EXISTS `drugadvicetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorType` int(11) NOT NULL,
  `bangla` text CHARACTER SET utf8 NOT NULL,
  `english` text NOT NULL,
  `pdf` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugcompany`
--

CREATE TABLE IF NOT EXISTS `drugcompany` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `folder` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugdaytype`
--

CREATE TABLE IF NOT EXISTS `drugdaytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bangla` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pdf` varchar(255) CHARACTER SET utf8 NOT NULL,
  `english` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugtype`
--

CREATE TABLE IF NOT EXISTS `drugtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `initial` varchar(10) NOT NULL,
  `unit` varchar(25) CHARACTER SET utf8 NOT NULL,
  `unitInitial` varchar(45) NOT NULL,
  `optionalUnitInitial` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugwhentype`
--

CREATE TABLE IF NOT EXISTS `drugwhentype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bangla` varchar(255) CHARACTER SET utf8 NOT NULL,
  `english` varchar(255) NOT NULL,
  `pdf` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `drug_history`
--

CREATE TABLE IF NOT EXISTS `drug_history` (
  `drugHistoryID` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) NOT NULL,
  `drugName` varchar(100) NOT NULL,
  `currentStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`drugHistoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `drug_prescription`
--

CREATE TABLE IF NOT EXISTS `drug_prescription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `drugTypeID` int(11) NOT NULL,
  `drugID` int(11) NOT NULL,
  `drugTimeID` int(11) NOT NULL,
  `drugDoseUnit` varchar(45) NOT NULL,
  `drugWhenID` int(11) NOT NULL,
  `drugAdviceID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30916 ;

-- --------------------------------------------------------

--
-- Table structure for table `follow_up_result`
--

CREATE TABLE IF NOT EXISTS `follow_up_result` (
  `resultID` int(11) NOT NULL AUTO_INCREMENT,
  `followUpID` int(11) NOT NULL,
  `data` text NOT NULL,
  `entryDate` date NOT NULL,
  PRIMARY KEY (`resultID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeCode` varchar(45) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortName` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `history_option`
--

CREATE TABLE IF NOT EXISTS `history_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `historyID` int(11) NOT NULL,
  `optionName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `history_prescription`
--

CREATE TABLE IF NOT EXISTS `history_prescription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `patientHistoryID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=245 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv`
--

CREATE TABLE IF NOT EXISTS `inv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1127 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_category`
--

CREATE TABLE IF NOT EXISTS `inv_category` (
  `invCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`invCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_prescription`
--

CREATE TABLE IF NOT EXISTS `inv_prescription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `invID` int(11) NOT NULL,
  `note` text NOT NULL,
  `checked` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13093 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_report`
--

CREATE TABLE IF NOT EXISTS `inv_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invPrescribeID` int(11) NOT NULL,
  `result` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menuID` int(11) NOT NULL,
  `menuURL` varchar(255) NOT NULL,
  `defaultName` varchar(255) NOT NULL,
  `isPopUp` int(11) NOT NULL,
  `functionName` varchar(100) NOT NULL,
  `inPrescription` tinyint(1) NOT NULL,
  `displayOrder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `menusettings`
--

CREATE TABLE IF NOT EXISTS `menusettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `menuID` int(11) NOT NULL,
  `menuHeader` varchar(45) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `next_visit`
--

CREATE TABLE IF NOT EXISTS `next_visit` (
  `appointmentID` int(11) NOT NULL,
  `nextVisitType` int(11) NOT NULL,
  `date` date NOT NULL,
  `numOfDay` int(11) NOT NULL,
  `dayType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `patientID` int(11) NOT NULL AUTO_INCREMENT,
  `patientCode` varchar(15) NOT NULL,
  `name` varchar(45) NOT NULL,
  `age` decimal(10,0) NOT NULL,
  `sex` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `occupation` varchar(245) NOT NULL,
  `referredBy` varchar(245) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`patientID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1568 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_detail`
--

CREATE TABLE IF NOT EXISTS `patient_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `tri` int(11) NOT NULL,
  `triStatus` int(11) NOT NULL,
  `edb` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patientID` (`patientID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_family_history`
--

CREATE TABLE IF NOT EXISTS `patient_family_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) NOT NULL,
  `diseaseID` int(11) NOT NULL,
  `relation` int(11) NOT NULL,
  `present` varchar(45) NOT NULL,
  `type` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_follow_up`
--

CREATE TABLE IF NOT EXISTS `patient_follow_up` (
  `patientFollowUpID` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) NOT NULL,
  `doctorID` int(11) NOT NULL,
  `invID` int(11) NOT NULL,
  PRIMARY KEY (`patientFollowUpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_history`
--

CREATE TABLE IF NOT EXISTS `patient_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) NOT NULL,
  `historyID` int(11) NOT NULL,
  `historyResult` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=170 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_past_disease`
--

CREATE TABLE IF NOT EXISTS `patient_past_disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) NOT NULL,
  `diseaseID` int(11) NOT NULL,
  `isPresent` tinyint(1) NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_type`
--

CREATE TABLE IF NOT EXISTS `patient_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorType` int(11) NOT NULL,
  `typeName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_advice`
--

CREATE TABLE IF NOT EXISTS `prescription_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `adviceID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31046 ;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_family_disease`
--

CREATE TABLE IF NOT EXISTS `prescription_family_disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `familyDiseaseID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_past_disease`
--

CREATE TABLE IF NOT EXISTS `prescription_past_disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `pastDiseaseID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_reference`
--

CREATE TABLE IF NOT EXISTS `prescription_reference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `refferedDoctorID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

--
-- Table structure for table `reffered_doctor`
--

CREATE TABLE IF NOT EXISTS `reffered_doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorName` varchar(255) NOT NULL,
  `doctorAdress` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings_advice`
--

CREATE TABLE IF NOT EXISTS `settings_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `diseaseID` int(11) NOT NULL,
  `adviceID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=223 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings_dose_drug`
--

CREATE TABLE IF NOT EXISTS `settings_dose_drug` (
  `drugSettingID` int(11) NOT NULL,
  `dose` varchar(100) DEFAULT NULL,
  `numOfDay` int(11) DEFAULT NULL,
  `durationType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings_drug`
--

CREATE TABLE IF NOT EXISTS `settings_drug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `diseaseID` int(11) NOT NULL,
  `drugTypeID` int(11) NOT NULL,
  `drugID` int(11) NOT NULL,
  `drugTimeID` int(11) NOT NULL,
  `drugDoseUnit` varchar(255) NOT NULL,
  `drugWhenID` int(11) NOT NULL,
  `drugAdviceID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=390 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings_inv`
--

CREATE TABLE IF NOT EXISTS `settings_inv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctorID` int(11) NOT NULL,
  `diseaseID` int(11) NOT NULL,
  `invID` int(11) NOT NULL,
  `note` text NOT NULL,
  `checked` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

-- --------------------------------------------------------

--
-- Table structure for table `surgery`
--

CREATE TABLE IF NOT EXISTS `surgery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `symptom`
--

CREATE TABLE IF NOT EXISTS `symptom` (
  `symptomID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`symptomID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=910 ;

-- --------------------------------------------------------

--
-- Table structure for table `vital`
--

CREATE TABLE IF NOT EXISTS `vital` (
  `vitalId` int(11) NOT NULL AUTO_INCREMENT,
  `vitalName` varchar(255) NOT NULL,
  `shortName` varchar(255) NOT NULL,
  `vitalUnit` varchar(45) NOT NULL,
  PRIMARY KEY (`vitalId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

-- --------------------------------------------------------

--
-- Table structure for table `vital_option`
--

CREATE TABLE IF NOT EXISTS `vital_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vitalId` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

-- --------------------------------------------------------

--
-- Table structure for table `vital_prescription`
--

CREATE TABLE IF NOT EXISTS `vital_prescription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointMentID` int(11) NOT NULL,
  `vitalID` int(11) NOT NULL,
  `vitalResult` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18736 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
