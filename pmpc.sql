-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 02:28 PM
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
(12, 'Lonktok', 'Sto.Rosario', 'Iba', 'Zambales'),
(13, 'Lonktok', 'Sto.Rosario', 'Iba', 'Zambales'),
(14, 'Lonktok', 'Sto.Rosario', 'Iba', 'Zambales'),
(15, 'Lonktok', 'Sto.Rosario', 'Iba', 'Zambales'),
(16, '173', 'Siling Bata', 'Pandi', 'Bulacan'),
(17, 'fafafaf', 'afagga', 'agagag', 'agaga'),
(18, 'fafafaf', 'afagga', 'agagag', 'agaga'),
(22, 'fafafaf', 'gbaa', 'babab', 'agaga'),
(35, 'fafafaf', 'gbaa', 'babab', 'agaga'),
(36, 'eqe', 'eqeq', 'qeq', 'qeq'),
(37, 'eqe', 'eqeq', 'qeq', 'qeq'),
(38, 'eqe', 'eqeq', 'qeq', 'qeq'),
(39, 'Lontok', 'Sto.Rosario', 'Iba', 'Zambales'),
(42, 'Lontok', 'Sto.Rosario', 'Iba', 'Zambales'),
(43, 'Lontok', 'Sto.Rosario', 'Iba', 'Zambales');

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
(16, 'Subsidy', '2024-10-17', NULL);

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
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `BeneficiaryID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Relationship` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beneficiaries`
--

INSERT INTO `beneficiaries` (`BeneficiaryID`, `MemberID`, `Name`, `Birthday`, `Relationship`) VALUES
(1, 1, 'Sarah Doe', '2010-05-12', 'Daughter'),
(2, 1, 'Tom Doe', '2012-07-23', 'Son'),
(3, 2, 'Lucy Smith', '2011-09-15', 'Daughter'),
(4, 2, 'Mark Smith', '2013-11-30', 'Son'),
(5, 3, 'Anna Brown', '2009-02-22', 'Daughter'),
(6, 3, 'Ben Brown', '2014-04-05', 'Son'),
(7, 4, 'Rachel Jones', '2008-08-18', 'Daughter'),
(8, 4, 'Kyle Jones', '2015-10-10', 'Son'),
(9, 5, 'Emma Davis', '2007-01-29', 'Daughter'),
(10, 5, 'Ryan Davis', '2016-03-19', 'Son');

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
-- Table structure for table `emergencycontact`
--

CREATE TABLE `emergencycontact` (
  `EmergencyContactID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `ContactNo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergencycontact`
--

INSERT INTO `emergencycontact` (`EmergencyContactID`, `Name`, `ContactNo`) VALUES
(1, 'Alice Green', '09123456789'),
(2, 'Bob White', '09234567890'),
(3, 'Charlie Black', '09345678901'),
(4, 'Diana Yellow', '09456789012'),
(5, 'Eve Purple', '09567890123'),
(6, 'Frank Orange', '09678901234'),
(7, 'Grace Pink', '09789012345'),
(8, 'Hank Gray', '09890123456'),
(9, 'Ivy Red', '09901234567'),
(10, 'Jack Blue', '09012345678');

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
-- Table structure for table `expensedetails`
--

CREATE TABLE `expensedetails` (
  `ExpenseDetailsID` int(11) NOT NULL,
  `Food` decimal(15,2) DEFAULT NULL,
  `Gas` decimal(15,2) DEFAULT NULL,
  `Schooling` decimal(15,2) DEFAULT NULL,
  `Lights` decimal(15,2) DEFAULT NULL,
  `Miscellaneous` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expensedetails`
--

INSERT INTO `expensedetails` (`ExpenseDetailsID`, `Food`, `Gas`, `Schooling`, `Lights`, `Miscellaneous`) VALUES
(1, 8000.00, 2000.00, 3000.00, 1500.00, 500.00),
(2, 9000.00, 2500.00, 2000.00, 1200.00, 600.00),
(3, 10000.00, 3000.00, 2500.00, 1300.00, 700.00),
(4, 7500.00, 1800.00, 2600.00, 1100.00, 550.00),
(5, 8500.00, 2200.00, 2400.00, 1250.00, 650.00),
(6, 9500.00, 2900.00, 2800.00, 1400.00, 800.00),
(7, 7200.00, 2300.00, 2700.00, 1350.00, 450.00),
(8, 8800.00, 2600.00, 2300.00, 1220.00, 570.00),
(9, 9200.00, 2800.00, 3100.00, 1450.00, 750.00),
(10, 7800.00, 2100.00, 2000.00, 1150.00, 430.00);

-- --------------------------------------------------------

--
-- Table structure for table `incomedetails`
--

CREATE TABLE `incomedetails` (
  `IncomeDetailsID` int(11) NOT NULL,
  `SelfIncome` decimal(15,2) DEFAULT NULL,
  `OtherIncome` decimal(15,2) DEFAULT NULL,
  `SpouseIncome` decimal(15,2) DEFAULT NULL,
  `AdditionalIncome` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incomedetails`
--

INSERT INTO `incomedetails` (`IncomeDetailsID`, `SelfIncome`, `OtherIncome`, `SpouseIncome`, `AdditionalIncome`) VALUES
(1, 20000.00, 5000.00, 15000.00, 2000.00),
(2, 25000.00, 3000.00, 12000.00, 1000.00),
(3, 30000.00, 4000.00, 18000.00, 2500.00),
(4, 35000.00, 2500.00, 14000.00, 3000.00),
(5, 40000.00, 6000.00, 16000.00, 500.00),
(6, 22000.00, 7000.00, 13000.00, 1500.00),
(7, 27000.00, 8000.00, 11000.00, 2000.00),
(8, 32000.00, 2000.00, 17000.00, 1800.00),
(9, 28000.00, 3000.00, 19000.00, 1600.00),
(10, 21000.00, 5000.00, 15000.00, 2400.00);

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication`
--

CREATE TABLE `loanapplication` (
  `LoanID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `DateOfLoan` date DEFAULT NULL,
  `AmountRequested` decimal(15,2) DEFAULT NULL,
  `LoanTerm` varchar(20) DEFAULT NULL,
  `Purpose` text DEFAULT NULL,
  `LoanType` enum('Regular','Collateral') DEFAULT NULL,
  `PaymentFrequency` enum('Monthly','Weekly') DEFAULT NULL,
  `ResidenceDetailsID` int(11) DEFAULT NULL,
  `IncomeDetailsID` int(11) DEFAULT NULL,
  `ExpenseDetailsID` int(11) DEFAULT NULL,
  `EmploymentID` int(11) DEFAULT NULL,
  `SavingsID` int(11) DEFAULT NULL,
  `AssetsID` int(11) DEFAULT NULL,
  `DebtsID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loanapplication`
--

INSERT INTO `loanapplication` (`LoanID`, `MemberID`, `DateOfLoan`, `AmountRequested`, `LoanTerm`, `Purpose`, `LoanType`, `PaymentFrequency`, `ResidenceDetailsID`, `IncomeDetailsID`, `ExpenseDetailsID`, `EmploymentID`, `SavingsID`, `AssetsID`, `DebtsID`) VALUES
(1, 1, '2024-01-15', 10000.00, '12 months', 'Personal Expenses', 'Regular', 'Monthly', 1, 1, 1, NULL, NULL, NULL, NULL),
(2, 2, '2024-02-20', 15000.00, '24 months', 'Home Renovation', 'Collateral', 'Monthly', 2, 2, 2, NULL, NULL, NULL, NULL),
(3, 3, '2024-03-10', 20000.00, '36 months', 'Education', 'Regular', 'Weekly', 3, 3, 3, NULL, NULL, NULL, NULL),
(4, 4, '2024-04-05', 12000.00, '18 months', 'Medical Expenses', 'Regular', 'Monthly', 4, 4, 4, NULL, NULL, NULL, NULL),
(5, 5, '2024-05-12', 25000.00, '60 months', 'Business Expansion', 'Collateral', 'Monthly', 5, 5, 5, NULL, NULL, NULL, NULL),
(6, 6, '2024-06-15', 8000.00, '12 months', 'Debt Consolidation', 'Regular', 'Weekly', 6, 6, 6, NULL, NULL, NULL, NULL),
(7, 7, '2024-07-20', 30000.00, '48 months', 'Car Purchase', 'Collateral', 'Monthly', 7, 7, 7, NULL, NULL, NULL, NULL),
(8, 8, '2024-08-25', 10000.00, '6 months', 'Travel Expenses', 'Regular', 'Monthly', 8, 8, 8, NULL, NULL, NULL, NULL),
(9, 9, '2024-09-30', 5000.00, '3 months', 'Emergency Fund', 'Regular', 'Weekly', 9, 9, 9, NULL, NULL, NULL, NULL),
(10, 10, '2024-10-15', 15000.00, '36 months', 'Home Improvement', 'Collateral', 'Monthly', 10, 10, 10, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_admin`
--

CREATE TABLE `loan_admin` (
  `LoanID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `AmountOfLoan` decimal(10,2) NOT NULL,
  `TypeOfLoan` enum('Regular','Collateral') NOT NULL,
  `Term` int(11) NOT NULL,
  `DateOfLoan` date NOT NULL,
  `MaturityDate` date NOT NULL,
  `CoMaker` varchar(100) DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  `LoanStatus` enum('In Progress','Completed') NOT NULL DEFAULT 'In Progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE `medical` (
  `Id` int(11) NOT NULL,
  `MemberId` int(11) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `ServiceID` varchar(255) NOT NULL,
  `Status` enum('Completed','In Progress') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Age` int(11) DEFAULT NULL,
  `Sex` varchar(10) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `BirthPlace` varchar(100) DEFAULT NULL,
  `Occupation` varchar(100) DEFAULT NULL,
  `TINNumber` varchar(15) DEFAULT NULL,
  `ContactNo` varchar(15) DEFAULT NULL,
  `SpouseID` int(11) DEFAULT NULL,
  `EmergencyContactID` int(11) DEFAULT NULL,
  `DateCreated` date DEFAULT NULL,
  `Savings` decimal(10,2) DEFAULT 0.00,
  `TypeOfMember` enum('Regular','Associate') DEFAULT 'Regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Email`, `MemberID`, `LastName`, `FirstName`, `MiddleName`, `AddressID`, `Birthday`, `Age`, `Sex`, `Status`, `BirthPlace`, `Occupation`, `TINNumber`, `ContactNo`, `SpouseID`, `EmergencyContactID`, `DateCreated`, `Savings`, `TypeOfMember`) VALUES
('413@gmail.com', 35, '0', 'qeqe', 'qeqe', NULL, '2024-10-20', NULL, 'male', NULL, NULL, NULL, '123498766', '0909765234', NULL, NULL, NULL, 0.00, 'Regular'),
('Brown@gmail.com', 5, 'Brown', 'David', 'E', 5, '1980-04-18', 44, 'Male', 'Divorced', 'City E', 'Architect', '654789123', '09567890123', 5, 5, '2024-10-16', 0.00, 'Regular'),
('Davis@gmail.com', 6, 'Davis', 'Olivia', 'F', 6, '1988-03-25', 36, 'Female', 'Single', 'City F', 'Designer', '159753486', '09678901234', 6, 6, '2024-10-16', 0.00, 'Regular'),
('Emilyjohnson@gmail.com', 2, 'Johnson', 'Emily', 'B', 2, '1990-08-20', 34, 'Female', 'Married', 'City B', 'Teacher', '987564321', '09234567890', 2, 2, '2024-10-16', 0.00, 'Regular'),
('Garcia@gmail.com', 7, 'Garcia', 'Daniel', 'G', 7, '1984-11-15', 39, 'Male', 'Married', 'City G', 'Chef', '357951486', '09789012345', 7, 7, '2024-10-16', 40000.00, 'Regular'),
('Hernandez@gmail.com', 10, 'Hernandez', 'Mia', 'J', 10, '1995-07-15', 29, 'Female', 'Single', 'City J', 'Accountant', '753159852', '09012345678', 10, 10, '2024-10-16', 0.00, 'Regular'),
('Johnsmith@gmail.com', 1, 'Smith', 'John', 'A', 1, '1985-06-15', 39, 'Male', 'Single', 'City A', 'Engineer', '123456789', '09123456789', 1, 1, '2024-10-16', 0.00, 'Regular'),
('Jones@gmail.com', 4, 'Jones', 'Sophia', 'D', 4, '1995-12-05', 28, 'Female', 'Single', 'City D', 'Nurse', '321654987', '09456789012', 4, 4, '2024-10-16', 0.00, 'Regular'),
('Martinez@gmail.com', 9, 'Martinez', 'Lucas', 'I', 9, '1975-09-05', 49, 'Male', 'Married', 'City I', 'Manager', '951357258', '09901234567', 9, 9, '2024-10-16', 0.00, 'Regular'),
('ricardo1@gmail.com', 40, '0', 'Ricardo', 'Janda', NULL, '2003-03-09', NULL, 'male', NULL, NULL, NULL, '987651233', '09127599973', NULL, NULL, NULL, 0.00, 'Regular'),
('rickpaolocamba@gmail.com', 12, 'Camba', 'Rick Paolo', 'Pampuan', 15, '2003-03-09', NULL, 'male', NULL, NULL, NULL, '121212123', '09466446039', NULL, NULL, NULL, 0.00, 'Regular'),
('Rodriguez@gmail.com', 8, 'Rodriguez', 'Ava', 'H', 8, '1992-01-30', 32, 'Female', 'Single', 'City H', 'Scientist', '852456123', '09890123456', 8, 8, '2024-10-16', 0.00, 'Regular'),
('Williams@gmail.com', 3, 'Williams', 'Michael', 'C', 3, '1982-02-10', 42, 'Male', 'Married', 'City C', 'Doctor', '456123789', '09345678901', 3, 3, '2024-10-16', 3000.00, 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `membership_application`
--

CREATE TABLE `membership_application` (
  `MemberID` int(11) NOT NULL,
  `FillUpForm` tinyint(1) NOT NULL,
  `WatchedVideoSeminar` tinyint(1) NOT NULL,
  `PaidRegistrationFee` tinyint(1) NOT NULL,
  `Status` enum('Failed','In progress','Completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_application`
--

INSERT INTO `membership_application` (`MemberID`, `FillUpForm`, `WatchedVideoSeminar`, `PaidRegistrationFee`, `Status`) VALUES
(35, 0, 1, 100, ''),
(40, 0, 1, 100, '');

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
(1, 'Johnsmith', 'Johnsmith@gmail.com', '$2y$10$YhOdll4vQAF61IaVnc9Rm.RCUDdNqg39i0Z3Ke1SIBVe1Kq8YUeVG'),
(2, 'Emilyjohnson', 'Emilyjohnson@gmail.com', '$2y$10$Gw0cK/GQRm9SQ81ECASScuXWGUdn0sbYJpRcbB5ApYwTiH/zmJax2'),
(3, 'Williams', 'Williams@gmail.com', '$2y$10$VHNmnE7igow0PKE.NGDuDen3utrqV6iKNPSGF3w4R4SBLOhbPHGue'),
(4, 'Jones', 'Jones@gmail.com', '$2y$10$QoTu/uA.5.ex261BYqt2AuyGwMJ0N2NTxqmhzkxkEiAOYEadNtTC.'),
(5, 'Brown', 'Brown@gmail.com', '$2y$10$c2VbDJGm9PeckLMDPeaEIuLOtwoZWYShxxELZlupk5TzabrhYW.x.'),
(6, 'Davis', 'Davis@gmail.com', '$2y$10$yS6ro6EZtkTUrrBOxq/7n.K8TSQgxKESwZpTB6YDWgb/g/jbQvHey'),
(7, 'Garcia', 'Garcia@gmail.com', '$2y$10$vyTVwTgXQ9APkrSWjU4ttOZgwXNrJbNyICDav6tw7GKDwiNOWfb56'),
(8, 'Rodriguez', 'Rodriguez@gmail.com', '$2y$10$hkxFzryxhf1eTSqtMHucMOfSvUlfFbMguEHscqmAxsh96gikNR5HG'),
(9, 'Martinez', 'Martinez@gmail.com', '$2y$10$wbCGzoPw24jDBaBmWJTHlO1pZLHdx5DOzfUum6SprVojT7A8MMHuK'),
(10, 'Hernandez', 'Hernandez@gmail.com', '$2y$10$WAOb0jWV4XWLQWetQ42KK.ue9ac0sXDuZAzEkFH/x85hPpzt1sI0e'),
(12, 'rickpaolo', 'rickpaolocamba@gmail.com', '$2y$10$u7V4IdeWlX35kSSAWdFMVuDdqwfPNnVCtHkCWyUwwKlNtN0I6VGza'),
(35, 'huehuedd', '413@gmail.com', '$2y$10$nuy2Jk6A1iZs/w0eI26lOe/RzA/C47M7bBzeIDSA4KrptLSgOSWwS'),
(40, 'ricardoo', 'ricardo1@gmail.com', '$2y$10$2hWOywa.a7cHzW0iUn3wk.e8IKN3peaU8onE6sfTBMS3FEn5uNSKO');

-- --------------------------------------------------------

--
-- Table structure for table `residencedetails`
--

CREATE TABLE `residencedetails` (
  `ResidenceDetailsID` int(11) NOT NULL,
  `YearsOfStay` int(11) DEFAULT NULL,
  `Renting` tinyint(1) DEFAULT NULL,
  `OwnHouse` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residencedetails`
--

INSERT INTO `residencedetails` (`ResidenceDetailsID`, `YearsOfStay`, `Renting`, `OwnHouse`) VALUES
(1, 5, 1, 0),
(2, 2, 0, 1),
(3, 10, 1, 0),
(4, 3, 1, 1),
(5, 1, 0, 1),
(6, 7, 1, 0),
(7, 4, 0, 1),
(8, 6, 1, 1),
(9, 8, 0, 0),
(10, 9, 1, 1);

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
(10, 'Collateral Loan');

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
(35, 'qeqe', 'qeqe', 'qeqe', 'Male', 38, '123498766', '2024-10-20', '0909765234'),
(40, 'Ricardo', 'Camba', 'Janda', 'Male', 43, '987651233', '2003-03-09', '09127599973');

-- --------------------------------------------------------

--
-- Table structure for table `spouse`
--

CREATE TABLE `spouse` (
  `SpouseID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Occupation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spouse`
--

INSERT INTO `spouse` (`SpouseID`, `Name`, `Age`, `Occupation`) VALUES
(1, 'John Doe', 30, 'Engineer'),
(2, 'Jane Smith', 28, 'Teacher'),
(3, 'Michael Brown', 35, 'Doctor'),
(4, 'Emily Davis', 32, 'Nurse'),
(5, 'Daniel Wilson', 40, 'Architect'),
(6, 'Sophia Johnson', 29, 'Designer'),
(7, 'Lucas Lee', 37, 'Chef'),
(8, 'Mia Garcia', 26, 'Scientist'),
(9, 'James Martinez', 45, 'Manager'),
(10, 'Olivia Rodriguez', 34, 'Accountant');

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
(1, 'admin', 'admin@gmail.com', '$2y$10$E7s7TJzGFW3ocX4CKIWp6.Rb6IzA903FUQmwk5kqiQWd5Gg/1/oIK', 'Admin'),
(2, 'loan', 'loan@gmail.com', '$2y$10$Ljxdf8EN16VBwkaKyrET/u7jFmcApW7A8tmlbVlhnjiu21bFz7p/6', 'Loan Officer'),
(3, 'liaison', 'liaison@gmail.com', '$2y$10$22Gm7UYKltfpAP1TTmolpu3B8GCQdZdhvo5HKUkr9HwBE1RfK.ADC', 'Liaison Officer'),
(4, 'member', 'member@gmail.com', '$2y$10$BtEAMNtktThlbKnLfVSPzutb1EDuAGKiltSKUKl9NeQ.m7uyCs2DO', 'Membership Officer'),
(5, 'medical', 'medical@gmail.com', '$2y$10$DupV1wMY7SVYjsr101CmBORO9Naupgn6GkvUeQ1NkN9TKWVEwj1Ra', 'Medical Officer');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Status` enum('In Progress','Completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TransactID`, `MemberID`, `ServiceID`, `Date`, `Amount`, `Status`) VALUES
(1, 7, 7, '2024-10-14 16:28:07', 200.00, 'In Progress'),
(2, 12, 3, '2024-10-20 09:05:45', 4500.00, 'Completed');

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
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`AnnouncementID`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`BeneficiaryID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `collateral`
--
ALTER TABLE `collateral`
  ADD PRIMARY KEY (`CollateralID`),
  ADD KEY `LoanID` (`LoanID`);

--
-- Indexes for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  ADD PRIMARY KEY (`EmergencyContactID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `expensedetails`
--
ALTER TABLE `expensedetails`
  ADD PRIMARY KEY (`ExpenseDetailsID`);

--
-- Indexes for table `incomedetails`
--
ALTER TABLE `incomedetails`
  ADD PRIMARY KEY (`IncomeDetailsID`);

--
-- Indexes for table `loanapplication`
--
ALTER TABLE `loanapplication`
  ADD PRIMARY KEY (`LoanID`),
  ADD KEY `MemberID` (`MemberID`),
  ADD KEY `ResidenceDetailsID` (`ResidenceDetailsID`),
  ADD KEY `IncomeDetailsID` (`IncomeDetailsID`),
  ADD KEY `ExpenseDetailsID` (`ExpenseDetailsID`);

--
-- Indexes for table `loan_admin`
--
ALTER TABLE `loan_admin`
  ADD PRIMARY KEY (`LoanID`);

--
-- Indexes for table `medical`
--
ALTER TABLE `medical`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `MemberId` (`MemberId`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD UNIQUE KEY `unique_email` (`Email`),
  ADD UNIQUE KEY `MemberID` (`MemberID`) USING BTREE,
  ADD UNIQUE KEY `unique_number` (`ContactNo`),
  ADD UNIQUE KEY `unique_tin` (`TINNumber`),
  ADD KEY `AddressID` (`AddressID`),
  ADD KEY `SpouseID` (`SpouseID`),
  ADD KEY `EmergencyContactID` (`EmergencyContactID`);

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
-- Indexes for table `residencedetails`
--
ALTER TABLE `residencedetails`
  ADD PRIMARY KEY (`ResidenceDetailsID`);

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
-- Indexes for table `spouse`
--
ALTER TABLE `spouse`
  ADD PRIMARY KEY (`SpouseID`);

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
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `AnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `BeneficiaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `collateral`
--
ALTER TABLE `collateral`
  MODIFY `CollateralID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  MODIFY `EmergencyContactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `expensedetails`
--
ALTER TABLE `expensedetails`
  MODIFY `ExpenseDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `incomedetails`
--
ALTER TABLE `incomedetails`
  MODIFY `IncomeDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `loanapplication`
--
ALTER TABLE `loanapplication`
  MODIFY `LoanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `loan_admin`
--
ALTER TABLE `loan_admin`
  MODIFY `LoanID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical`
--
ALTER TABLE `medical`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `membership_application`
--
ALTER TABLE `membership_application`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `residencedetails`
--
ALTER TABLE `residencedetails`
  MODIFY `ResidenceDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `signupform`
--
ALTER TABLE `signupform`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `spouse`
--
ALTER TABLE `spouse`
  MODIFY `SpouseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff_credentials`
--
ALTER TABLE `staff_credentials`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_request`
--
ALTER TABLE `account_request`
  ADD CONSTRAINT `account_request_ibfk_1` FOREIGN KEY (`MemberId`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE;

--
-- Constraints for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD CONSTRAINT `beneficiaries_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);

--
-- Constraints for table `collateral`
--
ALTER TABLE `collateral`
  ADD CONSTRAINT `collateral_ibfk_1` FOREIGN KEY (`LoanID`) REFERENCES `loanapplication` (`LoanID`);

--
-- Constraints for table `loanapplication`
--
ALTER TABLE `loanapplication`
  ADD CONSTRAINT `loanapplication_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`),
  ADD CONSTRAINT `loanapplication_ibfk_2` FOREIGN KEY (`ResidenceDetailsID`) REFERENCES `residencedetails` (`ResidenceDetailsID`),
  ADD CONSTRAINT `loanapplication_ibfk_3` FOREIGN KEY (`IncomeDetailsID`) REFERENCES `incomedetails` (`IncomeDetailsID`),
  ADD CONSTRAINT `loanapplication_ibfk_4` FOREIGN KEY (`ExpenseDetailsID`) REFERENCES `expensedetails` (`ExpenseDetailsID`);

--
-- Constraints for table `medical`
--
ALTER TABLE `medical`
  ADD CONSTRAINT `medical_ibfk_1` FOREIGN KEY (`MemberId`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`),
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`SpouseID`) REFERENCES `spouse` (`SpouseID`),
  ADD CONSTRAINT `member_ibfk_3` FOREIGN KEY (`EmergencyContactID`) REFERENCES `emergencycontact` (`EmergencyContactID`);

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
