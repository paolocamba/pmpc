-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 08:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmpc`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_request`
--

CREATE TABLE `account_request` (
  `Id` int(11) NOT NULL,
  `MemberId` int(11) NOT NULL,
  `RequestDate` date NOT NULL,
  `RequestType` varchar(255) NOT NULL,
  `Status` enum('Pending','Approved','Rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `AddressID` int(11) NOT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `Barangay` varchar(50) DEFAULT NULL,
  `Municipality` varchar(50) DEFAULT NULL,
  `Province` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`AddressID`, `Street`, `Barangay`, `Municipality`, `Province`) VALUES
(1, 'Main St', 'Barangay 1', 'City A', 'Province A'),
(2, 'Second St', 'Barangay 2', 'City B', 'Province B'),
(3, 'Third St', 'Barangay 3', 'City C', 'Province C'),
(4, 'Fourth St', 'Barangay 4', 'City D', 'Province D'),
(5, 'Fifth St', 'Barangay 5', 'City E', 'Province E'),
(6, 'Sixth St', 'Barangay 6', 'City F', 'Province F'),
(7, 'Seventh St', 'Barangay 7', 'City G', 'Province G'),
(8, 'Eighth St', 'Barangay 8', 'City H', 'Province H'),
(9, 'Ninth St', 'Barangay 9', 'City I', 'Province I'),
(10, 'Tenth St', 'Barangay 10', 'City J', 'Province J'),
(11, 'Lonktok', 'Sto.Rosario', 'Iba', 'Zambales'),
(15, 'Lontok', 'Sto.Rosario', 'Iba', 'Zambales'),
(16, '173', 'Siling Bata', 'Pandi', 'Bulacan'),
(37, 'eqe', 'eqeq', 'qeq', 'qeq'),
(38, 'eqe', 'eqeq', 'qeq', 'qeq'),
(39, 'Lontok', 'Sto.Rosario', 'Iba', 'Zambales'),
(42, 'Lontok', 'Sto.Rosario', 'Iba', 'Zambales'),
(43, 'Lontok', 'Sto.Rosario', 'Iba', 'Zambales'),
(44, 'Saan', 'Siling Bata', 'Malolos', 'Bulacan'),
(45, 'All', 'Blue', 'One', 'Piece'),
(46, 'All', 'Blue', 'One', 'Piece'),
(47, 'w', 'w', 'w', 'w'),
(48, 'k', 'k', 'k', 'k'),
(49, 'g', 'g', 'g', 'g'),
(50, '173', '1', '1', '1'),
(51, '1', '1', '1', '1'),
(52, 'adada', 'dadad', 'dad', 'adad'),
(53, 'ada', 'adad', 'fsgs', 'sgsg'),
(54, 'gjhj', 'gjghj', 'gjhj', 'jgjh'),
(55, 'Lontok', 'dadad', 'dad', 'adad'),
(56, 'lklkl', 'klkkl', 'klkkl', 'klkl'),
(57, '123 Main St', 'Downtown', 'Cityville', 'State'),
(63, 'adsd', 'afafaf', 'afafaf', 'afafa'),
(66, 'adsd', 'afafaf', 'afafaf', 'afafa'),
(67, '14414', '4141', '51515', '1515'),
(68, 'N/A', 'Siling Bata', 'Pandi', 'Bulacan'),
(70, 'Malibu', 'Cacarong Matanda', 'Pandi', 'Bulacan'),
(71, 'balete', 'Sta Mesa', 'Manila', 'Manila'),
(72, 'Dapitan', 'Unli', 'Wings', 'Manila'),
(73, 'afaf', 'faf', 'fafa', 'faf'),
(74, 'hahaha', 'hahaha', 'hahaha', 'hehehe');

-- --------------------------------------------------------

--
-- Table structure for table `admin_messages`
--

CREATE TABLE `admin_messages` (
  `MessageID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `Category` varchar(255) DEFAULT NULL,
  `MessageContent` text DEFAULT NULL,
  `DateSent` datetime DEFAULT NULL,
  `isReplied` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_messages`
--

INSERT INTO `admin_messages` (`MessageID`, `MemberID`, `Category`, `MessageContent`, `DateSent`, `isReplied`) VALUES
(1, 12, 'General Query', 'Pano po mag withdraw?', '2024-10-27 08:35:57', 0),
(2, 12, 'Loan', 'How much for this?\n', '2024-10-27 10:05:41', 0),
(3, 12, 'Medical', 'Ano po blood type ko?', '2024-10-27 10:10:53', 1),
(12, NULL, 'Loan', 'hi', '2024-10-27 21:41:28', 0),
(13, NULL, 'Loan', 'hi', '2024-10-27 21:41:45', 0),
(17, 12, 'Medical', 'Magkano po ulo ng manok?', '2024-10-27 22:09:59', 1),
(21, 12, 'Membership', 'Bakit po ang tagal ng approval sa membership fee?', '2024-10-28 22:19:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `AnnouncementID` int(11) NOT NULL,
  `Ann_Name` varchar(255) DEFAULT NULL,
  `Ann_Date` date DEFAULT NULL,
  `Ann_Day` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`AnnouncementID`, `Ann_Name`, `Ann_Date`, `Ann_Day`) VALUES
(1, 'Health Seminar', '2024-10-20', 'Sunday'),
(2, 'Community Cleanup', '2024-11-05', 'Saturday'),
(3, 'Annual General Meeting', '2024-12-10', 'Tuesday'),
(4, 'Christmas Party', '2024-12-25', 'Monday'),
(5, 'New Year Celebration', '2025-01-01', 'Wednesday'),
(6, 'Valentine\'s Day Event', '2025-02-14', 'Friday'),
(13, 'Annual General Assembly', '2024-10-31', NULL),
(14, 'Subsidy', '2024-10-17', NULL),
(15, 'Subsidy', '2024-10-17', NULL),
(16, 'Subsidy', '2024-10-17', NULL),
(17, 'Meeting Meetingan', '2024-10-10', NULL),
(18, 'Meeting Meetingan', '2024-10-10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `Description` text DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `ServiceID` int(11) DEFAULT NULL,
  `Status` enum('Pending','Approved','Disapproved') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`AppointmentID`, `LastName`, `FirstName`, `AppointmentDate`, `Description`, `Email`, `MemberID`, `ServiceID`, `Status`) VALUES
(26, 'Camba', 'Rick Paolo', '2024-10-23', 'Life Insurance', 'rickpaolocamba@gmail.com', 12, 1, 'Disapproved'),
(27, 'Camba', 'Rick Paolo', '2024-10-25', 'X-RAY', 'rickpaolocamba@gmail.com', 12, 6, 'Approved'),
(28, 'Camba', 'Rick Paolo', '2024-10-25', 'X-RAY', 'rickpaolocamba@gmail.com', 12, 6, 'Pending'),
(29, 'Camba', 'Rick Paolo', '2024-10-31', 'Laboratory', 'rickpaolocamba@gmail.com', 12, 5, 'Approved'),
(31, 'Camba', 'Rick Paolo', '2024-10-29', 'Space for Rent', 'rickpaolocamba@gmail.com', 12, 3, 'Pending'),
(32, 'Camba', 'Rick Paolo', '2024-10-31', 'Hilot Healom', 'rickpaolocamba@gmail.com', 12, 7, 'Pending'),
(33, 'Camba', 'Rick Paolo', '2024-10-28', 'Hilot Healom', 'rickpaolocamba@gmail.com', 12, 7, 'Pending'),
(35, 'Santiago', 'Polikarpio', '2024-10-23', 'Membership Application Payment', 'Polikarpio@gmail.com', 76, 11, 'Approved'),
(36, 'Rizal', 'Jose', '2024-10-24', 'Membership Application Payment', 'Rizal@gmail.com', 77, 11, 'Pending'),
(37, 'fhafhfa', 'Jimber', '2024-10-19', 'Membership Application Payment', 'Jimbei@gmail.com', 78, 11, 'Pending'),
(38, 'hihihi', 'hahaha', '2024-10-25', 'Membership Application Payment', 'hahaha@gmail.com', 79, 11, 'Pending');

--
-- Triggers `appointments`
--
DELIMITER $$
CREATE TRIGGER `after_appointment_approval` AFTER UPDATE ON `appointments` FOR EACH ROW BEGIN
    -- Check if the appointment status was updated to "Approved"
    IF NEW.Status = 'Approved' AND OLD.Status <> 'Approved' THEN
        -- Check if the description matches one of the values for medical services
        IF NEW.Description IN ('Medical consultation', 'Laboratory', 'X-ray', 'Healom', 'Health Card') THEN
            -- Insert into the medical table with NULL for Amount
            INSERT INTO medical (MemberID, Date, ServiceID, Status, Amount)
            VALUES (NEW.MemberID, NEW.AppointmentDate, NEW.ServiceID, 'In Progress', NULL);
        ELSE
            -- Insert into the transaction table with NULL for Amount
            INSERT INTO transaction (MemberID, ServiceID, Date, Status, Amount)
            VALUES (NEW.MemberID, NEW.ServiceID, NOW(), 'In Progress', NULL);
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `collateral`
--

CREATE TABLE `collateral` (
  `CollateralID` int(11) NOT NULL,
  `LoanID` int(11) DEFAULT NULL,
  `SquareMeter` decimal(10,2) DEFAULT NULL,
  `LandType` varchar(50) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `RightOfWay` tinyint(1) DEFAULT NULL,
  `CommoditiesPresent` tinyint(1) DEFAULT NULL,
  `EMV` decimal(10,2) DEFAULT NULL,
  `TotalValue` decimal(15,2) DEFAULT NULL,
  `LoanableAmount` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collateral`
--

INSERT INTO `collateral` (`CollateralID`, `LoanID`, `SquareMeter`, `LandType`, `Location`, `RightOfWay`, `CommoditiesPresent`, `EMV`, `TotalValue`, `LoanableAmount`) VALUES
(1, 1, 100.00, 'Residential', 'Location A', 1, 1, 500000.00, 700000.00, 50000.00),
(2, 2, 150.00, 'Commercial', 'Location B', 0, 1, 800000.00, 1000000.00, 80000.00),
(3, 3, 200.00, 'Agricultural', 'Location C', 1, 0, 600000.00, 900000.00, 60000.00),
(4, 4, 120.00, 'Residential', 'Location D', 1, 1, 300000.00, 400000.00, 30000.00),
(5, 5, 250.00, 'Commercial', 'Location E', 0, 1, 900000.00, 1200000.00, 90000.00),
(6, 6, 90.00, 'Agricultural', 'Location F', 1, 0, 400000.00, 500000.00, 40000.00),
(7, 7, 110.00, 'Residential', 'Location G', 1, 1, 700000.00, 800000.00, 70000.00),
(8, 8, 80.00, 'Commercial', 'Location H', 0, 1, 200000.00, 300000.00, 20000.00),
(9, 9, 130.00, 'Agricultural', 'Location I', 1, 0, 500000.00, 600000.00, 50000.00),
(10, 10, 160.00, 'Residential', 'Location J', 1, 1, 400000.00, 700000.00, 60000.00);

-- --------------------------------------------------------

--
-- Table structure for table `collateral_info`
--

CREATE TABLE `collateral_info` (
  `LoanID` int(11) NOT NULL,
  `square_meters` varchar(255) NOT NULL,
  `type_of_land` enum('residential','commercial','agricultural') NOT NULL,
  `location` enum('bagbugin','bagong-barrio','baka-bakahan','bunsuran-i','bunsuran-ii','bunsuran-iii','cacarong-bata','cacarong-matanda','cupang','malibong-bata','malibong-matanda','manatal','mapulang-lupa','masagana','masuso','pinagkuartelan','poblacion','real-de-cacarong','santo-niño','san-roque','siling-bata','siling-matanda') NOT NULL,
  `right_of_way` enum('yes','no') NOT NULL,
  `land_title_path` varchar(255) NOT NULL,
  `hospital` enum('yes','no') DEFAULT 'no',
  `clinic` enum('yes','no') DEFAULT 'no',
  `school` enum('yes','no') DEFAULT 'no',
  `market` enum('yes','no') DEFAULT 'no',
  `church` enum('yes','no') DEFAULT 'no',
  `public_terminal` enum('yes','no') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collateral_info`
--

INSERT INTO `collateral_info` (`LoanID`, `square_meters`, `type_of_land`, `location`, `right_of_way`, `land_title_path`, `hospital`, `clinic`, `school`, `market`, `church`, `public_terminal`) VALUES
(15, '123', 'residential', 'poblacion', 'no', 'C:\\xampp\\htdocs\\pmpc\\html\\member/../../assets/uploads/collateral/12-671b25facd481.png', 'yes', 'no', 'no', 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `PostID` int(11) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Image` text DEFAULT NULL,
  `Event_Date` date DEFAULT NULL,
  `Event_Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`PostID`, `Title`, `Image`, `Event_Date`, `Event_Description`) VALUES
(22, 'Paschal Coop Year end get Together - Officers, Staff and Committees', 'Screenshot 2024-10-16 155951.png', '2023-12-28', 'celebrated the holiday season with a touch of Boho elegance.'),
(23, ' 12th Pfcco Central Luzon Get Together 2023 (Funday)', 'Screenshot 2024-10-16 160342.png', '2023-11-16', 'held at San Pablo, Malolos, Bulacan with the theme Unleash your inner K-Pop Star.'),
(24, '𝐂𝐞𝐥𝐞𝐛𝐫𝐚𝐭𝐢𝐧𝐠 𝟔 𝐲𝐞𝐚𝐫𝐬 𝐨𝐟 𝐦𝐚𝐤𝐢𝐧𝐠 𝐚 𝐝𝐢𝐟𝐟𝐞𝐫𝐞𝐧𝐜𝐞 𝐢𝐧 𝐡𝐞𝐚𝐥𝐭𝐡𝐜𝐚re', 'Screenshot 2024-10-16 160902.png', '2023-11-30', 'On our anniversary, we extend heartfelt gratitude to the incredible doctors who have been the backbone of our medical mission programs.'),
(25, 'T𝐡𝐚𝐧𝐤 𝐲𝐨𝐮 𝐟𝐨𝐫 𝐣𝐨𝐢𝐧𝐢𝐧𝐠 𝐮𝐬!  𝐓𝐡𝐚𝐧𝐤 𝐲𝐨𝐮 𝐟𝐨𝐫 𝐣𝐨𝐢𝐧𝐢𝐧𝐠 𝐮𝐬!', 'Screenshot 2024-10-16 162200.png', '2023-11-25', 'Paschal Coop Face-To-Face Pre-Membership Education Seminar (PMES) hosted by Mr. Julius David . Maki-isa sa ating Pre-Membership Education Seminar upang malaman ang kahalagahan ng kooperatiba at maging responsableng miyembro ng PASCHAL COOP.');

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `MessageID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Message` text NOT NULL,
  `Date` datetime DEFAULT current_timestamp(),
  `isRead` tinyint(1) DEFAULT 0,
  `related_message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`MessageID`, `MemberID`, `Message`, `Date`, `isRead`, `related_message_id`) VALUES
(5, 12, 'Join us as we celebrate the 8th Anniversary of Paschal\'s community outreach program.', '2024-08-21 16:45:00', 1, NULL),
(7, 12, 'Don\'t forget to complete your survey.', '2024-10-02 14:30:00', 1, NULL),
(8, 12, 'Your loan application has been processed.', '2024-10-03 09:15:00', 1, NULL),
(47, 5, '12', '2024-10-27 19:38:56', 0, NULL),
(48, 6, '12', '2024-10-27 19:38:56', 0, NULL),
(49, 7, '12', '2024-10-27 19:38:56', 0, NULL),
(50, 8, '12', '2024-10-27 19:38:56', 0, NULL),
(51, 9, '12', '2024-10-27 19:38:56', 0, NULL),
(52, 10, '12', '2024-10-27 19:38:56', 0, NULL),
(54, 64, '12', '2024-10-27 19:38:56', 0, NULL),
(55, 69, '12', '2024-10-27 19:38:56', 0, NULL),
(56, 71, '12', '2024-10-27 19:38:56', 0, NULL),
(57, 72, '12', '2024-10-27 19:38:56', 0, NULL),
(58, 73, '12', '2024-10-27 19:38:56', 0, NULL),
(86, 12, 'secret', '2024-10-28 00:34:04', 0, 17),
(87, 12, 'ayaw ko', '2024-10-28 22:26:24', 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication`
--

CREATE TABLE `loanapplication` (
  `LoanID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `DateOfLoan` date DEFAULT NULL,
  `AmountRequested` decimal(15,2) DEFAULT NULL,
  `LoanTerm` enum('3 Months','6 Months','9 Months','12 Months','15 Months','18 Months','21 Months','24 Months') DEFAULT NULL,
  `Purpose` text DEFAULT NULL,
  `LoanType` enum('Regular','Collateral') DEFAULT NULL,
  `ModeOfPayment` enum('Daily','Weekly','Bi-Monthly','Monthly','Quarterly','Semi-Anual') DEFAULT NULL,
  `years_stay_present_address` int(11) DEFAULT NULL,
  `own_house` tinyint(1) NOT NULL DEFAULT 0,
  `renting` tinyint(1) NOT NULL DEFAULT 0,
  `living_with_relative` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Single','Married','Separated','Widow/er','Live-in') NOT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `number_of_dependents` int(11) NOT NULL,
  `dependents_in_school` int(11) NOT NULL,
  `dependent1_name` varchar(255) DEFAULT NULL,
  `dependent1_age` int(11) DEFAULT NULL,
  `dependent1_grade_level` varchar(50) DEFAULT NULL,
  `dependent2_name` varchar(255) DEFAULT NULL,
  `dependent2_age` int(11) DEFAULT NULL,
  `dependent2_grade_level` varchar(50) DEFAULT NULL,
  `dependent3_name` varchar(255) DEFAULT NULL,
  `dependent3_age` int(11) DEFAULT NULL,
  `dependent3_grade_level` varchar(50) DEFAULT NULL,
  `dependent4_name` varchar(255) DEFAULT NULL,
  `dependent4_age` int(11) DEFAULT NULL,
  `dependent4_grade_level` varchar(50) DEFAULT NULL,
  `family_member_count` int(11) NOT NULL,
  `self_income` varchar(255) NOT NULL,
  `self_income_amount` decimal(10,2) NOT NULL,
  `other_income` varchar(255) DEFAULT NULL,
  `other_income_amount` decimal(10,2) DEFAULT NULL,
  `spouse_income` varchar(255) DEFAULT NULL,
  `spouse_income_amount` decimal(10,2) DEFAULT NULL,
  `spouse_other_income` varchar(255) DEFAULT NULL,
  `spouse_other_income_amount` decimal(10,2) DEFAULT NULL,
  `total_income` decimal(10,2) NOT NULL,
  `food_groceries_expense` decimal(10,2) NOT NULL,
  `gas_oil_transportation_expense` decimal(10,2) NOT NULL,
  `schooling_expense` decimal(10,2) NOT NULL,
  `utilities_expense` decimal(10,2) NOT NULL,
  `miscellaneous_expense` decimal(10,2) NOT NULL,
  `total_expenses` decimal(10,2) NOT NULL,
  `net_family_income` decimal(10,2) NOT NULL,
  `employer_name` varchar(255) NOT NULL,
  `employer_address` varchar(255) NOT NULL,
  `present_position` varchar(255) NOT NULL,
  `date_of_employment` date DEFAULT NULL,
  `monthly_income` decimal(10,2) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_telephone_no` varchar(20) NOT NULL,
  `self_employed_business_type` varchar(255) DEFAULT NULL,
  `business_start_date` date DEFAULT NULL,
  `savings_account` tinyint(1) NOT NULL DEFAULT 0,
  `savings_bank` varchar(255) DEFAULT NULL,
  `savings_branch` varchar(255) DEFAULT NULL,
  `current_account` tinyint(1) NOT NULL DEFAULT 0,
  `current_bank` varchar(255) DEFAULT NULL,
  `current_branch` varchar(255) DEFAULT NULL,
  `asset1` varchar(255) DEFAULT NULL,
  `asset2` varchar(255) DEFAULT NULL,
  `asset3` varchar(255) DEFAULT NULL,
  `asset4` varchar(255) DEFAULT NULL,
  `creditor1_name` varchar(255) DEFAULT NULL,
  `creditor1_address` varchar(255) DEFAULT NULL,
  `creditor1_original_amount` decimal(10,2) DEFAULT NULL,
  `creditor1_present_balance` decimal(10,2) DEFAULT NULL,
  `creditor2_name` varchar(255) DEFAULT NULL,
  `creditor2_address` varchar(255) DEFAULT NULL,
  `creditor2_original_amount` decimal(10,2) DEFAULT NULL,
  `creditor2_present_balance` decimal(10,2) DEFAULT NULL,
  `creditor3_name` varchar(255) DEFAULT NULL,
  `creditor3_address` varchar(255) DEFAULT NULL,
  `creditor3_original_amount` decimal(10,2) DEFAULT NULL,
  `creditor3_present_balance` decimal(10,2) DEFAULT NULL,
  `creditor4_name` varchar(255) DEFAULT NULL,
  `creditor4_address` varchar(255) DEFAULT NULL,
  `creditor4_original_amount` decimal(10,2) DEFAULT NULL,
  `creditor4_present_balance` decimal(10,2) DEFAULT NULL,
  `property_foreclosed_repossessed` tinyint(1) NOT NULL DEFAULT 0,
  `co_maker_cosigner_guarantor` tinyint(1) NOT NULL DEFAULT 0,
  `reference1_name` varchar(255) NOT NULL,
  `reference1_address` varchar(255) NOT NULL,
  `reference1_contact_no` varchar(20) NOT NULL,
  `reference2_name` varchar(255) NOT NULL,
  `reference2_address` varchar(255) NOT NULL,
  `reference2_contact_no` varchar(20) NOT NULL,
  `reference3_name` varchar(255) NOT NULL,
  `reference3_address` varchar(255) NOT NULL,
  `reference3_contact_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loanapplication`
--

INSERT INTO `loanapplication` (`LoanID`, `MemberID`, `DateOfLoan`, `AmountRequested`, `LoanTerm`, `Purpose`, `LoanType`, `ModeOfPayment`, `years_stay_present_address`, `own_house`, `renting`, `living_with_relative`, `status`, `spouse_name`, `number_of_dependents`, `dependents_in_school`, `dependent1_name`, `dependent1_age`, `dependent1_grade_level`, `dependent2_name`, `dependent2_age`, `dependent2_grade_level`, `dependent3_name`, `dependent3_age`, `dependent3_grade_level`, `dependent4_name`, `dependent4_age`, `dependent4_grade_level`, `family_member_count`, `self_income`, `self_income_amount`, `other_income`, `other_income_amount`, `spouse_income`, `spouse_income_amount`, `spouse_other_income`, `spouse_other_income_amount`, `total_income`, `food_groceries_expense`, `gas_oil_transportation_expense`, `schooling_expense`, `utilities_expense`, `miscellaneous_expense`, `total_expenses`, `net_family_income`, `employer_name`, `employer_address`, `present_position`, `date_of_employment`, `monthly_income`, `contact_person`, `contact_telephone_no`, `self_employed_business_type`, `business_start_date`, `savings_account`, `savings_bank`, `savings_branch`, `current_account`, `current_bank`, `current_branch`, `asset1`, `asset2`, `asset3`, `asset4`, `creditor1_name`, `creditor1_address`, `creditor1_original_amount`, `creditor1_present_balance`, `creditor2_name`, `creditor2_address`, `creditor2_original_amount`, `creditor2_present_balance`, `creditor3_name`, `creditor3_address`, `creditor3_original_amount`, `creditor3_present_balance`, `creditor4_name`, `creditor4_address`, `creditor4_original_amount`, `creditor4_present_balance`, `property_foreclosed_repossessed`, `co_maker_cosigner_guarantor`, `reference1_name`, `reference1_address`, `reference1_contact_no`, `reference2_name`, `reference2_address`, `reference2_contact_no`, `reference3_name`, `reference3_address`, `reference3_contact_no`) VALUES
(1, 1, '2024-01-15', 10000.00, '12 Months', 'Personal Expenses', 'Regular', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(2, 2, '2024-02-20', 15000.00, '24 Months', 'Home Renovation', 'Collateral', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(3, 3, '2024-03-10', 20000.00, '', 'Education', 'Regular', 'Weekly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(4, 4, '2024-04-05', 12000.00, '18 Months', 'Medical Expenses', 'Regular', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(5, 5, '2024-05-12', 25000.00, '', 'Business Expansion', 'Collateral', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(6, 6, '2024-06-15', 8000.00, '12 Months', 'Debt Consolidation', 'Regular', 'Weekly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(7, 7, '2024-07-20', 30000.00, '', 'Car Purchase', 'Collateral', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(8, 8, '2024-08-25', 10000.00, '6 Months', 'Travel Expenses', 'Regular', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(9, 9, '2024-09-30', 5000.00, '3 Months', 'Emergency Fund', 'Regular', 'Weekly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(10, 10, '2024-10-15', 15000.00, '', 'Home Improvement', 'Collateral', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(11, 12, '2024-10-25', 12000.00, '18 Months', 'Study', 'Regular', 'Monthly', NULL, 0, 0, 0, 'Single', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', ''),
(15, 12, '2024-10-18', 14000.00, '', 'afaf', 'Collateral', 'Weekly', 3, 1, 0, 0, 'Single', NULL, 0, 0, 'affaf', 13, '13', '', 0, '', '', 0, '', '', 0, '0', 0, '3113', 141414.00, '13131', 1414.00, '0', 1414.00, 'af', 1414.00, 0.00, 4141.00, 414.00, 1414.00, 1414.00, 414.00, 414.00, 1414.00, 'afaf', 'afaf', 'agagag', '2024-10-09', 4441.00, 'gagagag', '0', '', '0000-00-00', 0, '', '', 0, '', '', 'afaf', 'faf', 'afa', 'afaf', 'afaf', 'fafaf', 41414.00, 1414.00, 'agagag', 'agagag', 1414.00, 14141.00, '', '', 0.00, 0.00, '', '', 0.00, 0.00, 0, 1, 'afafaf', 'afafa', '4141', 'afafaf', 'afafaf', '1515', 'fafaf', 'afafa', '15151');

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication_status`
--

CREATE TABLE `loanapplication_status` (
  `LoanID` int(11) NOT NULL,
  `Eligibility` enum('Eligible','Not Eligible') NOT NULL,
  `Status` enum('Pending','Completed','Rejected') NOT NULL,
  `PredictedAmount` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loanapplication_status`
--

INSERT INTO `loanapplication_status` (`LoanID`, `Eligibility`, `Status`, `PredictedAmount`) VALUES
(1, '', 'Pending', NULL),
(2, 'Eligible', 'Pending', NULL),
(3, 'Eligible', 'Pending', NULL),
(4, 'Eligible', 'Pending', NULL),
(5, 'Eligible', 'Pending', NULL),
(6, 'Eligible', 'Pending', NULL),
(7, 'Eligible', 'Pending', NULL),
(8, 'Eligible', 'Pending', NULL),
(9, 'Eligible', 'Pending', NULL),
(10, 'Eligible', 'Pending', NULL),
(11, 'Eligible', 'Pending', NULL),
(15, 'Eligible', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_admin`
--

CREATE TABLE `loan_admin` (
  `LoanID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `AmountOfLoan` decimal(10,2) NOT NULL,
  `TypeOfLoan` enum('Regular','Collateral') NOT NULL,
  `Term` int(11) NOT NULL,
  `DateOfLoan` date NOT NULL,
  `MaturityDate` date NOT NULL,
  `CoMaker` varchar(100) DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  `LoanStatus` enum('In Progress','Completed') NOT NULL DEFAULT 'In Progress',
  `AmountPayable` decimal(11,0) DEFAULT NULL,
  `ModeOfPayment` enum('Daily','Bi-Weekly','Weekly','Bi-Monthly','Monthly') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE `medical` (
  `TransactID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `Status` enum('Completed','In Progress') NOT NULL DEFAULT 'In Progress',
  `Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical`
--

INSERT INTO `medical` (`TransactID`, `MemberID`, `Date`, `ServiceID`, `Status`, `Amount`) VALUES
(3, 6, '2024-10-25', 5, 'In Progress', 1200.00),
(4, 12, '2024-10-25', 6, 'In Progress', NULL),
(5, 12, '2024-10-31', 5, 'In Progress', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Email` char(255) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `AddressID` int(11) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Sex` varchar(10) DEFAULT NULL,
  `TINNumber` varchar(15) DEFAULT NULL,
  `ContactNo` varchar(15) DEFAULT NULL,
  `DateCreated` date DEFAULT NULL,
  `Savings` decimal(10,2) DEFAULT 0.00,
  `TypeOfMember` enum('Regular','Associate') DEFAULT 'Regular',
  `MembershipStatus` enum('Pending','Active') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Email`, `MemberID`, `LastName`, `FirstName`, `MiddleName`, `AddressID`, `Birthday`, `Sex`, `TINNumber`, `ContactNo`, `DateCreated`, `Savings`, `TypeOfMember`, `MembershipStatus`) VALUES
('11@gmail.com', 64, '0', 'Nami', 'Robin', 63, '2024-10-07', 'male', '3353535111', '73737111', NULL, 0.00, 'Regular', 'Active'),
('151515@egmail.com', 71, '0', 'Nami', 'Robin', 66, '2024-10-16', 'male', '3353111111', '9at1515', NULL, 0.00, 'Regular', 'Active'),
('bb@gmail.com', 72, 'Robin', 'Nami', 'Swan', 67, '2024-10-06', '0', '678678678', '7878', NULL, 0.00, 'Regular', 'Active'),
('benjaminjarombernardo0815@gmail.com', 75, 'Logan', 'Mark', 'V', 70, '2001-11-15', '0', '567-421-896-213', '09947307033', NULL, 0.00, 'Regular', 'Pending'),
('bernardobenjaminjarom@gmail.com', 73, 'Bernardo', 'Benjamin Jarom', 'Mañebo', 68, '2024-10-17', '0', '040513682', '09129130560', NULL, 0.00, 'Regular', 'Pending'),
('Brown@gmail.com', 5, 'Brown', 'David', 'E', 5, '1980-04-18', 'Male', '654789123', '09567890123', '2024-10-16', 0.00, 'Regular', 'Active'),
('Davis@gmail.com', 6, 'Davis', 'Olivia', 'F', 6, '1988-03-25', 'Female', '159753486', '09678901234', '2024-10-16', 0.00, 'Regular', 'Active'),
('Emilyjohnson@gmail.com', 2, 'Johnson', 'Emily', 'B', 2, '1990-08-20', 'Female', '987564321', '09234567890', '2024-10-16', 0.00, 'Regular', 'Active'),
('Garcia@gmail.com', 7, 'Garcia', 'Daniel', 'G', 7, '1984-11-15', 'Male', '357951486', '09789012345', '2024-10-16', 40000.00, 'Regular', 'Active'),
('hahaha@gmail.com', 79, 'hihihi', 'hahaha', 'hehehe', 74, '2024-10-17', '0', '6266226', '626161', NULL, 4000.00, 'Associate', 'Active'),
('Hernandez@gmail.com', 10, 'Hernandez', 'Mia', 'J', 10, '1995-07-15', 'Female', '753159852', '09012345678', '2024-10-16', 0.00, 'Regular', 'Active'),
('Jimbei@gmail.com', 78, 'fhafhfa', 'Jimber', 'hadhahd', 73, '2024-10-18', '0', '26627', '161616', NULL, 0.00, 'Regular', 'Active'),
('Johnsmith@gmail.com', 1, 'Smith', 'John', 'A', 1, '1985-06-15', 'Male', '123456789', '09123456789', '2024-10-16', 0.00, 'Regular', 'Active'),
('Jones@gmail.com', 4, 'Jones', 'Sophia', 'D', 4, '1995-12-05', 'Female', '321654987', '09456789012', '2024-10-16', 0.00, 'Regular', 'Active'),
('Martinez@gmail.com', 9, 'Martinez', 'Lucas', 'I', 9, '1975-09-05', 'Male', '951357258', '09901234567', '2024-10-16', 0.00, 'Regular', 'Active'),
('Polikarpio@gmail.com', 76, 'Santiago', 'Polikarpio', 'De Jesus', 71, '2024-10-16', '0', '8', '567', NULL, 40000.00, 'Regular', 'Active'),
('rickpaolocamba@gmail.com', 12, 'Camba', 'Rick Paolo', 'Pampuan', 15, '2003-03-09', 'male', '123123123', '09466446039', NULL, 0.00, 'Regular', 'Active'),
('Rizal@gmail.com', 77, 'Rizal', 'Jose', 'Protacio', 72, '2024-10-29', '0', '88', '63636', NULL, 0.00, 'Regular', 'Active'),
('Rodriguez@gmail.com', 8, 'Rodriguez', 'Ava', 'H', 8, '1992-01-30', 'Female', '852456123', '09890123456', '2024-10-16', 0.00, 'Regular', 'Active'),
('test@example.com', 69, 'usop', 'usop', 'middle', 1, '1990-01-01', 'male', '123444789', '09993456789', NULL, 0.00, 'Regular', 'Active'),
('Williams@gmail.com', 3, 'Williams', 'Michael', 'C', 3, '1982-02-10', 'Male', '456123789', '09345678901', '2024-10-16', 3000.00, 'Regular', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `membership_application`
--

CREATE TABLE `membership_application` (
  `MemberID` int(11) NOT NULL,
  `FillUpForm` tinyint(1) NOT NULL,
  `WatchedVideoSeminar` tinyint(1) NOT NULL,
  `PaidRegistrationFee` tinyint(1) NOT NULL,
  `Status` enum('Failed','In progress','Completed') NOT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `MembershipFeePaidAmount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_application`
--

INSERT INTO `membership_application` (`MemberID`, `FillUpForm`, `WatchedVideoSeminar`, `PaidRegistrationFee`, `Status`, `AppointmentDate`, `MembershipFeePaidAmount`) VALUES
(73, 1, 1, 1, 'Completed', '2024-10-25', 2000),
(76, 1, 1, 1, 'Completed', '2024-10-23', 40000),
(77, 1, 1, 1, 'Completed', '2024-10-24', 6000),
(78, 1, 1, 1, 'Completed', '2024-10-19', 6000),
(79, 1, 1, 1, 'Completed', '2024-10-25', 4000);

--
-- Triggers `membership_application`
--
DELIMITER $$
CREATE TRIGGER `after_membership_application_update` AFTER UPDATE ON `membership_application` FOR EACH ROW BEGIN
    -- Check if the status is updated to 'Completed' and all requirements are met
    IF NEW.Status = 'Completed' AND NEW.FillUpForm = 1 AND NEW.WatchedVideoSeminar = 1 AND NEW.PaidRegistrationFee = 1 THEN
        -- Update the MembershipStatus in the member table to 'Active'
        UPDATE member 
        SET MembershipStatus = 'Active' 
        WHERE MemberID = NEW.MemberID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_member_status` AFTER INSERT ON `membership_application` FOR EACH ROW BEGIN
    DECLARE membership_fee_paid_amount DECIMAL(10, 2);
    DECLARE member_type VARCHAR(20);

    -- Fetch the MembershipFeePaidAmount for the new application
    SET membership_fee_paid_amount = NEW.MembershipFeePaidAmount;

    -- Determine the TypeOfMember based on the MembershipFeePaidAmount
    IF membership_fee_paid_amount < 5000 THEN
        SET member_type = 'Associate';
    ELSE
        SET member_type = 'Regular';
    END IF;

    -- Update the corresponding member's record
    UPDATE member
    SET MembershipStatus = 'Active',
        Savings = membership_fee_paid_amount,
        TypeOfMember = member_type
    WHERE MemberID = NEW.MemberID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `member_credentials`
--

CREATE TABLE `member_credentials` (
  `MemberID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_credentials`
--

INSERT INTO `member_credentials` (`MemberID`, `Username`, `Email`, `Password`) VALUES
(1, 'Johnsmith', 'Johnsmith@gmail.com', '$2y$10$My5X6g2sTF5l.xn6ujt2nOGSiAfF6lMbQnFEvZkV.S6OkL7rDUPjW'),
(2, 'Emilyjohnson', 'Emilyjohnson@gmail.com', '$2y$10$2vXf6Uz17L6UufTxEpNQbeR0D5kjuNTiqXg7p2Magoum.eF.dP4AO'),
(3, 'Williams', 'Williams@gmail.com', '$2y$10$gsxPbw2Dbwzrqam33VfYc.LzlNcOc/pDND1A/o6cMhixRVeL71bZe'),
(4, 'Jones', 'Jones@gmail.com', '$2y$10$lVNeNiS7UJsIesjsOQxpsOrI0X68pxFQwKwnPIo9Bs/f46AiGNlf2'),
(5, 'Brown', 'Brown@gmail.com', '$2y$10$0NM6p.61NuT6U5QhbgWWgOcd6UzRpQQ1MIzPYnYx/i6E9heYfdN0u'),
(6, 'Davis', 'Davis@gmail.com', '$2y$10$E2UD5z3qy9LyjtF8AWoCpOodoW47Ms9F9jc8zNHNyvy4PNcmUAFQ2'),
(7, 'Garcia', 'Garcia@gmail.com', '$2y$10$AAYK8pNq42QOFwjzo7LCV.vS7yzjK0lGjQmIs5GLRr5pubU1Wjy2e'),
(8, 'Rodriguez', 'Rodriguez@gmail.com', '$2y$10$yQpxNSLy5Vn6Z/SE/7kXle/A48Gkv6oZ8ereFpzthwpnn4eAbL7oG'),
(9, 'Martinez', 'Martinez@gmail.com', '$2y$10$jahor7DsvCjsPhe31GZ03ew/ZQs3rh351ltTq4RQhxpafB9wrQAS.'),
(10, 'Hernandez', 'Hernandez@gmail.com', '$2y$10$MKW11.s7k49Q4qqYBqIxB.8ec7ANOKMetP4uWRsdMr/8jxrsOKeDS'),
(12, 'rickpaolo', 'rickpaolocamba@gmail.com', '$2y$10$xRHNaF/wywe.UwB6M.bCNe3LRtt57hrCHbGh0H4Z3T7NWAhpuW5u2'),
(64, 'admaaadafin@gmail.com', '11@gmail.com', '$2y$10$KYs84.XHRikFNRHcK3Dfieqhf7gZkRRZypGQaNyDowkqcEC5lpoM.'),
(71, '1415t', '151515@egmail.com', '$2y$10$FhT0rzyn9EogJ47.fp0/IeDZDfJ7CTBs9tiVySQMVX1eZmnpYGE6m'),
(72, 'qwerty', 'bb@gmail.com', '$2y$10$fTecUaHhJ.u.Myde7G.AQuieqW.NgS0f0nw7Yirn6PJp8k7Xpt.7u'),
(73, 'benj', 'bernardobenjaminjarom@gmail.com', '$2y$10$.Kg1bXo7/B1dfZaMyu9qbeW2SLQsKYr7VBPFkL9.2gyeSFMPhK/Cy'),
(75, 'sauge21', 'benjaminjarombernardo0815@gmail.com', '$2y$10$GK9IrqCaJDuc3bjqlnKdOOH.zjhGGZifYn/C/YUKpSyWb1mt2/J2K'),
(76, 'Polikarpio', 'Polikarpio@gmail.com', '$2y$10$7q0jReGDWRzZ5tzSlB6IVOWIceWykH4evGarQUx5i.BxiEuA7ONqC'),
(77, 'Rizal1234', 'Rizal@gmail.com', '$2y$10$NgKk01DEmx.w2hOe28zZ9e1pGZwEuJjT5aVYBNv8sylUolXtLAPY.'),
(78, 'jimbei', 'Jimbei@gmail.com', '$2y$10$5YpPBnFV9KjfB8te0WbGuOS7bIPfm5FJtWZv4O3tL.6v/FIpHUVci'),
(79, 'hahaha', 'hahaha@gmail.com', '$2y$10$ki3yR.yaq1p5gV9i6qXwE.cRMEh3PW0oo3SVmiWIUL8/810h8uwNe');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `ServiceID` int(11) NOT NULL,
  `ServiceName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`ServiceID`, `ServiceName`) VALUES
(1, 'Life insurance'),
(2, 'Rice'),
(3, 'Space for rent'),
(4, 'Medical consultation'),
(5, 'Laboratory'),
(6, 'X-ray'),
(7, 'Healom'),
(8, 'Health Card'),
(9, 'Regular loan'),
(10, 'Collateral Loan'),
(11, 'Membership Application Payment');

-- --------------------------------------------------------

--
-- Table structure for table `signupform`
--

CREATE TABLE `signupform` (
  `MemberID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `Sex` enum('Male','Female','Other') NOT NULL,
  `AddressID` int(11) DEFAULT NULL,
  `TINNumber` varchar(15) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `ContactNo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signupform`
--

INSERT INTO `signupform` (`MemberID`, `FirstName`, `LastName`, `MiddleName`, `Sex`, `AddressID`, `TINNumber`, `Birthday`, `ContactNo`) VALUES
(73, 'Benjamin Jarom', 'Bernardo', 'Mañebo', 'Male', 68, '040513682', '2024-10-17', '09129130560'),
(76, 'Polikarpio', 'Santiago', 'De Jesus', 'Male', 71, '8', '2024-10-16', '567'),
(77, 'Jose', 'Rizal', 'Protacio', 'Male', 72, '88', '2024-10-29', '63636'),
(78, 'Jimber', 'fhafhfa', 'hadhahd', 'Male', 73, '26627', '2024-10-18', '161616'),
(79, 'hahaha', 'hihihi', 'hehehe', 'Male', 74, '6266226', '2024-10-17', '626161');

-- --------------------------------------------------------

--
-- Table structure for table `staff_credentials`
--

CREATE TABLE `staff_credentials` (
  `StaffID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('Admin','Medical Officer','Loan Officer','Liaison Officer','Membership Officer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_credentials`
--

INSERT INTO `staff_credentials` (`StaffID`, `Username`, `Email`, `Password`, `Role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$cFijTqxBtupDdU7HZGO6feDn9ejRPiEBElziaY/CXtoIiIsWAgmBu', 'Admin'),
(2, 'member', 'member@gmail.com', '$2y$10$njfyKaf.aWajwYoOlLu1peYgRg7uNWU3EENhtA0dquB3AZ1s62iLG', 'Membership Officer'),
(3, 'loan', 'loan@gmail.com', '$2y$10$ZB0O7doTz.4X5h6GWIt8turtljzP7DqT.cOH..jt7KgtPHgpFedTK', 'Loan Officer'),
(4, 'liaison', 'liaison@gmail.com', '$2y$10$JGnLwmnq2WiCBue3R5tPJ..q3flnT4lqqy4D.PUORsf84UrolbTb.', 'Liaison Officer'),
(5, 'medical', 'medical@gmail.com', '$2y$10$wpgEy1f1B7Qw1nINm34IDepd2/gX1nMmm8u1OCMH44hoRsswqQO9u', 'Medical Officer');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Status` enum('In Progress','Completed') NOT NULL DEFAULT 'In Progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TransactID`, `MemberID`, `ServiceID`, `Date`, `Amount`, `Status`) VALUES
(2, 12, 3, '2024-10-20 09:05:45', 4500.00, 'In Progress'),
(4, 76, 11, '2024-10-29 01:30:04', NULL, 'In Progress');

--
-- Triggers `transaction`
--
DELIMITER $$
CREATE TRIGGER `after_transaction_insert` AFTER INSERT ON `transaction` FOR EACH ROW BEGIN
    IF NEW.ServiceID IN (4, 5, 6, 7, 8) THEN
        INSERT INTO medical (TransactID, MemberID, ServiceID) 
        VALUES (NEW.TransactID, NEW.MemberID, NEW.ServiceID);
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_request`
--
ALTER TABLE `account_request`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `MemberId` (`MemberId`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressID`);

--
-- Indexes for table `admin_messages`
--
ALTER TABLE `admin_messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`AnnouncementID`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `FK_MemberID` (`MemberID`);

--
-- Indexes for table `collateral`
--
ALTER TABLE `collateral`
  ADD PRIMARY KEY (`CollateralID`),
  ADD KEY `LoanID` (`LoanID`);

--
-- Indexes for table `collateral_info`
--
ALTER TABLE `collateral_info`
  ADD PRIMARY KEY (`LoanID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `MemberID` (`MemberID`),
  ADD KEY `inbox_ibfk_2` (`related_message_id`);

--
-- Indexes for table `loanapplication`
--
ALTER TABLE `loanapplication`
  ADD PRIMARY KEY (`LoanID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `loanapplication_status`
--
ALTER TABLE `loanapplication_status`
  ADD PRIMARY KEY (`LoanID`);

--
-- Indexes for table `loan_admin`
--
ALTER TABLE `loan_admin`
  ADD PRIMARY KEY (`LoanID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `medical`
--
ALTER TABLE `medical`
  ADD PRIMARY KEY (`TransactID`),
  ADD KEY `medical_ibfk_1` (`ServiceID`),
  ADD KEY `medical_ibfk_2` (`MemberID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD UNIQUE KEY `unique_email` (`Email`),
  ADD UNIQUE KEY `MemberID` (`MemberID`) USING BTREE,
  ADD UNIQUE KEY `unique_number` (`ContactNo`),
  ADD UNIQUE KEY `unique_tin` (`TINNumber`),
  ADD KEY `AddressID` (`AddressID`);

--
-- Indexes for table `membership_application`
--
ALTER TABLE `membership_application`
  ADD UNIQUE KEY `MemberID` (`MemberID`) USING BTREE;

--
-- Indexes for table `member_credentials`
--
ALTER TABLE `member_credentials`
  ADD PRIMARY KEY (`MemberID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`) USING BTREE,
  ADD UNIQUE KEY `unique_email` (`Email`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`ServiceID`);

--
-- Indexes for table `signupform`
--
ALTER TABLE `signupform`
  ADD UNIQUE KEY `MemberID` (`MemberID`) USING BTREE,
  ADD KEY `AddressID` (`AddressID`);

--
-- Indexes for table `staff_credentials`
--
ALTER TABLE `staff_credentials`
  ADD PRIMARY KEY (`StaffID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TransactID`),
  ADD KEY `MemberID` (`MemberID`),
  ADD KEY `ServiceID` (`ServiceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_request`
--
ALTER TABLE `account_request`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `admin_messages`
--
ALTER TABLE `admin_messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `AnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `collateral`
--
ALTER TABLE `collateral`
  MODIFY `CollateralID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `collateral_info`
--
ALTER TABLE `collateral_info`
  MODIFY `LoanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `loanapplication`
--
ALTER TABLE `loanapplication`
  MODIFY `LoanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `loan_admin`
--
ALTER TABLE `loan_admin`
  MODIFY `LoanID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical`
--
ALTER TABLE `medical`
  MODIFY `TransactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `membership_application`
--
ALTER TABLE `membership_application`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `signupform`
--
ALTER TABLE `signupform`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `staff_credentials`
--
ALTER TABLE `staff_credentials`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_request`
--
ALTER TABLE `account_request`
  ADD CONSTRAINT `account_request_ibfk_1` FOREIGN KEY (`MemberId`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE;

--
-- Constraints for table `admin_messages`
--
ALTER TABLE `admin_messages`
  ADD CONSTRAINT `admin_messages_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);

--
-- Constraints for table `collateral`
--
ALTER TABLE `collateral`
  ADD CONSTRAINT `collateral_ibfk_1` FOREIGN KEY (`LoanID`) REFERENCES `loanapplication` (`LoanID`);

--
-- Constraints for table `collateral_info`
--
ALTER TABLE `collateral_info`
  ADD CONSTRAINT `collateral_info_ibfk_1` FOREIGN KEY (`LoanID`) REFERENCES `loanapplication` (`LoanID`);

--
-- Constraints for table `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE,
  ADD CONSTRAINT `inbox_ibfk_2` FOREIGN KEY (`related_message_id`) REFERENCES `admin_messages` (`MessageID`) ON DELETE CASCADE;

--
-- Constraints for table `loanapplication`
--
ALTER TABLE `loanapplication`
  ADD CONSTRAINT `loanapplication_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);

--
-- Constraints for table `loanapplication_status`
--
ALTER TABLE `loanapplication_status`
  ADD CONSTRAINT `loanapplication_status_ibfk_1` FOREIGN KEY (`LoanID`) REFERENCES `loanapplication` (`LoanID`) ON DELETE CASCADE;

--
-- Constraints for table `loan_admin`
--
ALTER TABLE `loan_admin`
  ADD CONSTRAINT `loan_admin_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);

--
-- Constraints for table `medical`
--
ALTER TABLE `medical`
  ADD CONSTRAINT `medical_ibfk_1` FOREIGN KEY (`ServiceID`) REFERENCES `service` (`ServiceID`),
  ADD CONSTRAINT `medical_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`);

--
-- Constraints for table `membership_application`
--
ALTER TABLE `membership_application`
  ADD CONSTRAINT `fk_member` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE;

--
-- Constraints for table `member_credentials`
--
ALTER TABLE `member_credentials`
  ADD CONSTRAINT `fk_credentials_member` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_credentials_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE;

--
-- Constraints for table `signupform`
--
ALTER TABLE `signupform`
  ADD CONSTRAINT `fk_application` FOREIGN KEY (`MemberID`) REFERENCES `membership_application` (`MemberID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_signupform_member` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE,
  ADD CONSTRAINT `signupform_ibfk_1` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`ServiceID`) REFERENCES `service` (`ServiceID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
