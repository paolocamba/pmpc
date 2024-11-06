-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 10:48 PM
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
  `RequestID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `GeneratedPassword` varchar(255) NOT NULL,
  `RequestDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PasswordExpiration` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsPasswordUsed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_request`
--

INSERT INTO `account_request` (`RequestID`, `MemberID`, `Email`, `Username`, `GeneratedPassword`, `RequestDate`, `PasswordExpiration`, `IsPasswordUsed`) VALUES
(1, 15, 'cristinamanuson5@gmail.com', 'one', '$2y$10$qi3QbeYhHXlI3zXwP/zR6.jvs34MGdav1WzDrNUMag.FCPj1/h79S', '2024-10-30 13:31:44', '2024-10-30 07:31:44', 0),
(1, 15, 'cristinamanuson5@gmail.com', 'one', '$2y$10$qi3QbeYhHXlI3zXwP/zR6.jvs34MGdav1WzDrNUMag.FCPj1/h79S', '2024-10-30 13:31:44', '2024-10-30 07:31:44', 0),
(1, 15, 'cristinamanuson5@gmail.com', 'one', '$2y$10$qi3QbeYhHXlI3zXwP/zR6.jvs34MGdav1WzDrNUMag.FCPj1/h79S', '2024-10-30 13:31:44', '2024-10-30 07:31:44', 0);

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
(1, 'Bayanihan St.', 'San Nicolas', 'San Fernando', 'Pampanga'),
(2, 'Mabini St.', 'Wawang Pulo', 'San Jose del Monte', 'Bulacan'),
(3, 'Rizal Ave.', 'Bagong Silang', 'Caloocan City', 'Metro Manila'),
(4, 'Andres Bonifacio St.', 'Poblacion', 'Makati City', 'Metro Manila'),
(5, 'Malakas St.', 'San Antonio', 'Pasig City', 'Metro Manila'),
(6, 'Kalayaan St.', 'Pinyahan', 'Quezon City', 'Metro Manila'),
(7, 'Poblacion St.', 'Poblacion', 'Guagua', 'Pampanga'),
(8, 'Calle Real', 'Sto. Niño', 'Marikina City', 'Metro Manila'),
(9, 'Agoncillo St.', 'Bical', 'Tarlac City', 'Tarlac'),
(10, 'Calle de la Paz', 'San Isidro', 'Malabon City', 'Metro Manila'),
(11, 'Gen. Emilio Aguinaldo St.', 'Longos', 'Obando', 'Bulacan'),
(12, 'Don Quijote St.', 'San Vicente', 'Cavite City', 'Cavite'),
(13, 'Heneral Luna St.', 'Caniogan', 'Pasig City', 'Metro Manila'),
(14, 'Lapu-Lapu St.', 'Calapandayan', 'San Fernando', 'Pampanga'),
(15, 'San Jose St.', 'San Bartolome', 'Quezon City', 'Metro Manila'),
(16, 'Sampaguita St.', 'Saguin', 'San Fernando', 'Pampanga'),
(17, 'Pineapple St.', 'Balibago', 'Angeles City', 'Pampanga'),
(18, 'Rainbow St.', 'Ibayo', 'Marilao', 'Bulacan'),
(19, 'Mangga St.', 'San Pedro', 'Cabuyao', 'Laguna'),
(20, 'Corazon de Jesus St.', 'Batang 1st', 'San Mateo', 'Rizal'),
(21, 'Buhangin St.', 'Salangan', 'Angeles City', 'Pampanga'),
(22, 'Sampaloc St.', 'San Jose', 'Tarlac City', 'Tarlac'),
(23, 'Kalayaan Ave.', 'Longos', 'Caloocan City', 'Metro Manila'),
(24, 'Calle de los Reyes', 'Santo Domingo', 'Quezon City', 'Metro Manila'),
(25, 'Don Mariano Marcos Ave.', 'Sta. Ana', 'Tarlac City', 'Tarlac'),
(26, 'Villarica St.', 'Natividad', 'San Jose del Monte', 'Bulacan'),
(27, 'Quezon Ave.', 'Alabang', 'Muntinlupa City', 'Metro Manila'),
(28, 'Likhang Sining St.', 'Poblacion', 'Makati City', 'Metro Manila'),
(29, 'Waling-Waling St.', 'Balagtas', 'San Fernando', 'Pampanga'),
(30, 'Aplaya St.', 'Maybunga', 'Pasig City', 'Metro Manila'),
(31, 'Talamban St.', 'Cuayan', 'San Fernando', 'Pampanga'),
(32, 'Calle de la Independencia', 'San Jose', 'Malabon City', 'Metro Manila'),
(33, 'Gonzales St.', 'Bangkal', 'Makati City', 'Metro Manila'),
(34, 'Calle de Espana', 'San Juan', 'Tarlac City', 'Tarlac'),
(35, 'Bayani St.', 'Sto. Domingo', 'Angeles City', 'Pampanga'),
(36, 'Manggahan St.', 'Marulas', 'Valenzuela City', 'Metro Manila'),
(37, 'Calle de la Resistencia', 'Sanggalang', 'Bulacan', 'Bulacan'),
(38, 'Sambag St.', 'San Juan', 'San Fernando', 'Pampanga'),
(39, 'Bagumbayan St.', 'Poblacion', 'San Pedro', 'Laguna'),
(40, 'Dela Paz', 'Kapitolyo', 'Pasig City', 'Metro Manila'),
(41, 'Calle de Santa Maria', 'Manggahan', 'Pasig City', 'Metro Manila'),
(42, 'Libertad St.', 'Salitran', 'Dasmariñas', 'Cavite'),
(43, 'Calle de Belen', 'Camachile', 'San Fernando', 'Pampanga'),
(44, 'Kambal St.', 'San Juan', 'San Fernando', 'Pampanga'),
(45, 'Gaya-Gaya St.', 'San Felipe', 'Cabuyao', 'Laguna'),
(46, 'Bangkang Kahoy St.', 'Villa de San Jose', 'San Jose del Monte', 'Bulacan'),
(47, 'P. Tuazon St.', 'San Antonio', 'Quezon City', 'Metro Manila'),
(48, 'Sta. Rosa St.', 'Santo Domingo', 'San Fernando', 'Pampanga'),
(49, 'Camia St.', 'Sto. Niño', 'Angeles City', 'Pampanga'),
(50, 'Bulaklak St.', 'Maharlika', 'San Mateo', 'Rizal'),
(51, 'Balagtas St.', 'Bagumbayan', 'Quezon City', 'Metro Manila'),
(52, 'Manila St.', 'Sta. Lucia', 'Pasig City', 'Metro Manila'),
(53, 'Calle de San Jose', 'San Pedro', 'Makati City', 'Metro Manila');

-- --------------------------------------------------------

--
-- Table structure for table `admin_messages`
--

CREATE TABLE `admin_messages` (
  `MessageID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `Category` varchar(255) DEFAULT NULL,
  `MessageContent` mediumtext DEFAULT NULL,
  `DateSent` datetime DEFAULT NULL,
  `isReplied` tinyint(1) DEFAULT 0,
  `isViewed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_messages`
--

INSERT INTO `admin_messages` (`MessageID`, `MemberID`, `Category`, `MessageContent`, `DateSent`, `isReplied`, `isViewed`) VALUES
(95, 1, 'General Query', 'What are the operating hours of the cooperative?', '2024-10-24 04:02:25', 0, 1),
(96, 2, 'Membership', 'How can I become a member of the cooperative?', '2024-10-20 04:02:25', 0, 1),
(97, 3, 'Loan', 'What types of loans do you offer?', '2024-10-19 04:02:25', 0, 1),
(98, 4, 'Medical', 'What medical services are available for members?', '2024-11-01 04:02:25', 0, 1),
(99, 5, 'Services', 'What services do you provide apart from loans?', '2024-11-02 04:02:25', 0, 1),
(100, 6, 'General Query', 'Can I change my personal information?', '2024-11-04 04:02:25', 0, 1),
(101, 7, 'Membership', 'Is there a membership fee?', '2024-10-09 04:02:25', 0, 1),
(102, 8, 'Loan', 'How do I apply for a loan?', '2024-10-23 04:02:25', 0, 1),
(103, 9, 'Medical', 'Are there any medical consultations available?', '2024-10-21 04:02:25', 0, 1),
(104, 10, 'Services', 'What are the requirements for availing of services?', '2024-10-31 04:02:25', 0, 1),
(105, 11, 'General Query', 'How can I contact customer service?', '2024-10-25 04:02:25', 0, 1),
(106, 12, 'Membership', 'What documents do I need to submit for membership?', '2024-10-26 04:02:25', 0, 1),
(107, 13, 'Loan', 'What is the interest rate for personal loans?', '2024-10-16 04:02:25', 0, 1),
(108, 14, 'Medical', 'How do I schedule a medical appointment?', '2024-10-27 04:02:25', 0, 1),
(109, 15, 'Services', 'Do you provide financial advice?', '2024-10-19 04:02:25', 0, 1),
(110, 16, 'General Query', 'Where can I find the cooperative’s bylaws?', '2024-10-08 04:02:25', 0, 1),
(111, 17, 'Membership', 'How long does it take to process my membership application?', '2024-11-05 04:02:25', 0, 1),
(112, 18, 'Loan', 'Can I repay my loan early without penalties?', '2024-10-30 04:02:25', 0, 1),
(113, 19, 'Medical', 'What medical emergencies are covered?', '2024-11-05 04:02:25', 0, 1),
(114, 20, 'Services', 'Are there any promotional offers on services?', '2024-10-23 04:02:25', 0, 1),
(115, 21, 'General Query', 'How do I file a complaint?', '2024-10-30 04:02:25', 0, 1),
(116, 22, 'Membership', 'Can I transfer my membership?', '2024-10-16 04:02:25', 0, 1),
(117, 23, 'Loan', 'What is the maximum loan amount I can apply for?', '2024-10-11 04:02:25', 0, 1),
(118, 24, 'Medical', 'Are there any health cards for members?', '2024-10-31 04:02:25', 0, 1),
(119, 25, 'Services', 'How do I avail of your financial literacy programs?', '2024-10-27 04:02:25', 0, 1),
(120, 26, 'General Query', 'Is there an online portal for members?', '2024-11-03 04:02:25', 0, 1),
(121, 27, 'Membership', 'What benefits do members receive?', '2024-10-25 04:02:25', 0, 1),
(122, 28, 'Loan', 'How is the loan approval process?', '2024-10-13 04:02:25', 0, 1),
(123, 29, 'Medical', 'What health services are included in my membership?', '2024-10-16 04:02:25', 0, 1),
(124, 30, 'Services', 'Can I request a specific service?', '2024-11-04 04:02:25', 0, 1),
(125, 31, 'General Query', 'What are the qualifications for membership?', '2024-10-28 04:02:25', 0, 1),
(126, 32, 'Membership', 'Can I have multiple memberships?', '2024-10-30 04:02:25', 0, 1),
(127, 33, 'Loan', 'What happens if I miss a loan payment?', '2024-10-31 04:02:25', 0, 1),
(128, 34, 'Medical', 'How do I get reimbursed for medical expenses?', '2024-10-25 04:02:25', 0, 1),
(129, 35, 'Services', 'Are services available during holidays?', '2024-10-29 04:02:25', 0, 1),
(130, 36, 'General Query', 'How do I update my email address?', '2024-10-31 04:02:25', 0, 1),
(131, 37, 'Membership', 'What is the renewal process for membership?', '2024-11-01 04:02:25', 0, 1),
(132, 38, 'Loan', 'Are there any fees associated with loan applications?', '2024-10-30 04:02:25', 0, 1),
(133, 39, 'Medical', 'What do I do in case of a medical emergency?', '2024-10-18 04:02:25', 0, 1),
(134, 40, 'Services', 'How can I give feedback on services?', '2024-10-23 04:02:25', 0, 1),
(135, 41, 'General Query', 'What information do you need for account verification?', '2024-10-24 04:02:25', 0, 1),
(136, 42, 'Membership', 'Can I change my membership type?', '2024-10-15 04:02:25', 0, 1),
(137, 43, 'Loan', 'What is the turnaround time for loan approval?', '2024-10-28 04:02:25', 0, 1),
(138, 44, 'Medical', 'Are there any limitations on medical coverage?', '2024-10-28 04:02:25', 0, 1),
(139, 45, 'Services', 'Can I access services remotely?', '2024-10-18 04:02:25', 0, 1),
(140, 46, 'General Query', 'How do I reset my password?', '2024-10-31 04:02:25', 0, 1),
(141, 47, 'Membership', 'What happens if I don’t renew my membership?', '2024-11-05 04:02:25', 0, 1),
(142, 48, 'Loan', 'What documents do I need to apply for a loan?', '2024-10-19 04:02:25', 0, 1),
(143, 49, 'Medical', 'How often can I avail of medical check-ups?', '2024-10-12 04:02:25', 0, 1),
(144, 50, 'Services', 'How do I get in touch with the service department?', '2024-10-25 04:02:25', 0, 1),
(145, 1, 'General Query', 'Are you Open on Holidays?', '2024-11-05 04:02:52', 0, 1);

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
(18, 'Meeting Meetingan', '2024-10-10', NULL),
(19, 'MOCK DEFENSE', '2024-11-05', NULL);

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
(1, 'Reyes', 'Jeremy', '2024-11-27', 'Laboratory', 'jeremyreyes@example.com', 18, 5, 'Pending'),
(2, 'Moreno', 'Nicolas', '2024-11-06', 'Life insurance', 'nicolasmoreno@example.com', 19, 1, 'Approved'),
(3, 'Perez', 'Kevin', '2024-12-02', 'Medical consultation', 'kevinperez@example.com', 35, 4, 'Disapproved'),
(4, 'Camba', 'Rick Paolo', '2024-11-18', 'Health Card', 'rickpaolocamba@gmail.com', 1, 8, 'Disapproved'),
(5, 'Alvarez', 'Liana', '2024-11-06', 'Membership Application Payment', 'lianalvarez@example.com', 5, 11, 'Approved'),
(6, 'Jacob', 'Andrea', '2024-11-05', 'Space for rent', 'andreajacob@example.com', 43, 3, 'Approved'),
(7, 'Ong', 'Claire', '2024-11-24', 'Space for rent', 'claireong@example.com', 14, 3, 'Approved'),
(8, 'Perez', 'Kevin', '2024-11-23', 'Collateral Loan', 'kevinperez@example.com', 35, 10, 'Pending'),
(9, 'Cabrera', 'Katrina', '2024-11-25', 'Rice', 'katrinacabrera@example.com', 42, 2, 'Approved'),
(10, 'Kim', 'Theresa', '2024-12-01', 'Regular loan', 'theresakim@example.com', 15, 9, 'Approved'),
(11, 'Gutierrez', 'Brendan', '2024-11-23', 'Medical consultation', 'brendangutierrez@example.com', 44, 4, 'Pending'),
(12, 'Alvarez', 'Liana', '2024-11-24', 'Space for rent', 'lianalvarez@example.com', 5, 3, 'Approved'),
(13, 'Castillo', 'Pablo', '2024-11-13', 'Membership Application Payment', 'pablocastillo@example.com', 12, 11, 'Pending'),
(14, 'Kim', 'Theresa', '2024-11-20', 'Collateral Loan', 'theresakim@example.com', 15, 10, 'Approved'),
(15, 'Ortiz', 'Ysabella', '2024-11-21', 'Rice', 'ysabellaortiz@example.com', 34, 2, 'Approved'),
(16, 'Fernandez', 'Lindsay', '2024-11-18', 'Health Card', 'lindsayfernandez@example.com', 28, 8, 'Disapproved'),
(17, 'Cruz', 'Rafael', '2024-11-07', 'Laboratory', 'rafaelcruz@example.com', 4, 5, 'Disapproved'),
(18, 'Miranda', 'Carlito', '2024-11-20', 'Rice', 'carlitomiranda@example.com', 37, 2, 'Disapproved'),
(19, 'Villegas', 'Gerard', '2024-11-08', 'Regular loan', 'gerardvillegas@example.com', 40, 9, 'Disapproved'),
(20, 'Miranda', 'Carlito', '2024-11-30', 'Healom', 'carlitomiranda@example.com', 37, 7, 'Pending'),
(21, 'Hasan', 'Fatima', '2024-11-16', 'Medical consultation', 'fatimahasan@example.com', 24, 4, 'Approved'),
(22, 'Gutierrez', 'Brendan', '2024-11-06', 'Health Card', 'brendangutierrez@example.com', 44, 8, 'Approved'),
(23, 'Lima', 'Chloe', '2024-11-22', 'Membership Application Payment', 'chloelima@example.com', 26, 11, 'Approved'),
(24, 'Alvarez', 'Liana', '2024-11-20', 'Laboratory', 'lianalvarez@example.com', 5, 5, 'Disapproved'),
(25, 'Ramos', 'Isabela', '2024-12-04', 'Laboratory', 'isabelaramos@example.com', 8, 5, 'Pending'),
(26, 'Pascual', 'Vincent', '2024-11-12', 'Life insurance', 'vincentpascual@example.com', 31, 1, 'Disapproved'),
(27, 'Pacheco', 'Adrian', '2024-11-21', 'Laboratory', 'adrianpacheco@example.com', 50, 5, 'Approved'),
(28, 'Castillo', 'Andrew', '2024-11-28', 'Laboratory', 'andrewcastillo@example.com', 33, 5, 'Approved'),
(29, 'Lopez', 'Jennifer', '2024-11-27', 'X-ray', 'jenniferlopez@example.com', 36, 6, 'Pending'),
(30, 'Li', 'Ronald', '2024-11-21', 'Space for rent', 'ronaldli@example.com', 45, 3, 'Pending'),
(31, 'Fernandez', 'Lindsay', '2024-11-06', 'Health Card', 'lindsayfernandez@example.com', 28, 8, 'Disapproved'),
(32, 'Reyes', 'Jeremy', '2024-11-26', 'X-ray', 'jeremyreyes@example.com', 18, 6, 'Disapproved'),
(33, 'Rivera', 'Mario', '2024-11-11', 'Space for rent', 'mariorivera@example.com', 39, 3, 'Approved'),
(34, 'Villar', 'Julio', '2024-11-28', 'Medical consultation', 'juliovillar@example.com', 23, 4, 'Approved'),
(35, 'Camba', 'Rick Paolo', '2024-11-06', 'Healom', 'rickpaolocamba@gmail.com', 1, 7, 'Disapproved'),
(36, 'Quiroga', 'Fiona', '2024-11-15', 'Medical consultation', 'fionaquiroga@example.com', 30, 4, 'Approved'),
(37, 'Ang', 'Roberto', '2024-11-18', 'Life insurance', 'robertoang@example.com', 21, 1, 'Approved'),
(38, 'Jacob', 'Andrea', '2024-11-23', 'Membership Application Payment', 'andreajacob@example.com', 43, 11, 'Disapproved'),
(39, 'Castillo', 'Pablo', '2024-12-04', 'Medical consultation', 'pablocastillo@example.com', 12, 4, 'Disapproved'),
(40, 'Perez', 'Kevin', '2024-11-23', 'Collateral Loan', 'kevinperez@example.com', 35, 10, 'Disapproved');

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
-- Table structure for table `collateral_info`
--

CREATE TABLE `collateral_info` (
  `LoanID` int(11) NOT NULL,
  `square_meters` varchar(255) NOT NULL,
  `type_of_land` enum('Residential','Commercial','Agricultural') NOT NULL,
  `location` enum('Bagbugin','Bagong Barrio','Baka-bakahan','Bunsuran I','Bunsuran II','Bunsuran III','Cacarong Bata','Cacarong Matanda','Cupang','Malibong Bata','Malibong Matanda','Manatal','Mapulang Lupa','Masagana','Masuso','Pinagkuartelan','Poblacion','Real de Cacarong','Santo Niño','San Roque','Siling Bata','Siling Matanda') NOT NULL,
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
(1, '160', 'Residential', 'Pinagkuartelan', 'no', '', 'no', 'no', 'no', 'no', 'no', 'no');

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
(109, 1, 'Welcome to the cooperative!', '2024-10-08 03:54:35', 0, NULL),
(110, 1, 'Your membership has been successfully approved.', '2024-10-22 03:54:35', 0, NULL),
(111, 2, 'We appreciate your trust in us.', '2024-10-18 03:54:35', 0, NULL),
(112, 2, 'Your application is currently under review.', '2024-10-18 03:54:35', 0, NULL),
(113, 3, 'Thank you for your continued support.', '2024-10-30 03:54:35', 0, NULL),
(114, 3, 'Your member profile has been updated.', '2024-10-27 03:54:35', 0, NULL),
(115, 4, 'Your loan application status has been updated.', '2024-10-09 03:54:35', 0, NULL),
(116, 4, 'Please verify your contact information.', '2024-10-20 03:54:35', 0, NULL),
(117, 5, 'We\'re excited to have you with us!', '2024-11-04 03:54:35', 0, NULL),
(118, 5, 'Your savings account has been credited.', '2024-10-21 03:54:35', 0, NULL),
(119, 6, 'Let us know if you need assistance.', '2024-10-21 03:54:35', 0, NULL),
(120, 6, 'Thank you for being a valued member!', '2024-11-04 03:54:35', 0, NULL),
(121, 7, 'We\'re here to assist you with any queries.', '2024-10-18 03:54:35', 0, NULL),
(122, 7, 'Your appointment has been confirmed.', '2024-11-05 03:54:35', 0, NULL),
(123, 8, 'Check our latest updates on services available.', '2024-10-30 03:54:35', 0, NULL),
(124, 8, 'Thank you for your continued support.', '2024-10-07 03:54:35', 0, NULL),
(125, 9, 'Your application is currently under review.', '2024-10-28 03:54:35', 0, NULL),
(126, 9, 'Join us for our upcoming events.', '2024-10-24 03:54:35', 0, NULL),
(127, 10, 'Don\'t miss our special offers!', '2024-10-26 03:54:35', 0, NULL),
(128, 10, 'Your loan application status has been updated.', '2024-10-24 03:54:35', 0, NULL),
(129, 11, 'Your savings account has been credited.', '2024-11-04 03:54:35', 0, NULL),
(130, 11, 'We\'re excited to have you with us!', '2024-10-08 03:54:35', 0, NULL),
(131, 12, 'Thank you for being a valued member!', '2024-10-19 03:54:35', 0, NULL),
(132, 12, 'Stay tuned for more announcements.', '2024-11-04 03:54:35', 0, NULL),
(133, 13, 'Your member profile has been updated.', '2024-10-19 03:54:35', 0, NULL),
(134, 13, 'We appreciate your trust in us.', '2024-10-16 03:54:35', 0, NULL),
(135, 14, 'Your appointment has been confirmed.', '2024-10-15 03:54:35', 0, NULL),
(136, 14, 'Check our latest updates on services available.', '2024-10-22 03:54:35', 0, NULL),
(137, 15, 'We\'re here to assist you with any queries.', '2024-10-27 03:54:35', 0, NULL),
(138, 15, 'Your application is currently under review.', '2024-11-04 03:54:35', 0, NULL),
(139, 16, 'Join us for our upcoming events.', '2024-10-24 03:54:35', 0, NULL),
(140, 16, 'Thank you for your continued support.', '2024-10-12 03:54:35', 0, NULL),
(141, 17, 'Your loan application status has been updated.', '2024-10-09 03:54:35', 0, NULL),
(142, 17, 'Please verify your contact information.', '2024-11-01 03:54:35', 0, NULL),
(143, 18, 'We appreciate your trust in us.', '2024-10-09 03:54:35', 0, NULL),
(144, 18, 'Your member profile has been updated.', '2024-11-01 03:54:35', 0, NULL),
(145, 19, 'We\'re excited to have you with us!', '2024-11-03 03:54:35', 0, NULL),
(146, 19, 'Stay tuned for more announcements.', '2024-10-10 03:54:35', 0, NULL),
(147, 20, 'Your appointment has been confirmed.', '2024-10-30 03:54:35', 0, NULL),
(148, 20, 'Your savings account has been credited.', '2024-10-22 03:54:35', 0, NULL),
(149, 21, 'Let us know if you need assistance.', '2024-10-16 03:54:35', 0, NULL),
(150, 21, 'Thank you for being a valued member!', '2024-10-07 03:54:35', 0, NULL),
(151, 22, 'Check our latest updates on services available.', '2024-10-11 03:54:35', 0, NULL),
(152, 22, 'Your application is currently under review.', '2024-10-28 03:54:35', 0, NULL),
(153, 23, 'Join us for our upcoming events.', '2024-10-08 03:54:35', 0, NULL),
(154, 23, 'Don\'t miss our special offers!', '2024-10-12 03:54:35', 0, NULL),
(155, 24, 'Your loan application status has been updated.', '2024-10-29 03:54:35', 0, NULL),
(156, 24, 'Please verify your contact information.', '2024-10-14 03:54:35', 0, NULL),
(157, 25, 'We appreciate your trust in us.', '2024-11-05 03:54:35', 0, NULL),
(158, 25, 'Your member profile has been updated.', '2024-10-12 03:54:35', 0, NULL),
(159, 26, 'Thank you for your continued support.', '2024-11-04 03:54:35', 0, NULL),
(160, 26, 'Stay tuned for more announcements.', '2024-10-11 03:54:35', 0, NULL),
(161, 27, 'We\'re excited to have you with us!', '2024-11-02 03:54:35', 0, NULL),
(162, 27, 'Your appointment has been confirmed.', '2024-11-05 03:54:35', 0, NULL),
(163, 28, 'Your savings account has been credited.', '2024-10-17 03:54:35', 0, NULL),
(164, 28, 'We\'re here to assist you with any queries.', '2024-10-28 03:54:35', 0, NULL),
(165, 29, 'Let us know if you need assistance.', '2024-10-24 03:54:35', 0, NULL),
(166, 29, 'Thank you for being a valued member!', '2024-10-31 03:54:35', 0, NULL),
(167, 30, 'Check our latest updates on services available.', '2024-10-15 03:54:35', 0, NULL),
(168, 30, 'Join us for our upcoming events.', '2024-11-04 03:54:35', 0, NULL),
(169, 31, 'Your loan application status has been updated.', '2024-11-03 03:54:35', 0, NULL),
(170, 31, 'Please verify your contact information.', '2024-10-30 03:54:35', 0, NULL),
(171, 32, 'We appreciate your trust in us.', '2024-10-09 03:54:35', 0, NULL),
(172, 32, 'Your member profile has been updated.', '2024-10-09 03:54:35', 0, NULL),
(173, 33, 'Thank you for your continued support.', '2024-10-11 03:54:35', 0, NULL),
(174, 33, 'Stay tuned for more announcements.', '2024-10-22 03:54:35', 0, NULL),
(175, 34, 'We\'re excited to have you with us!', '2024-10-12 03:54:35', 0, NULL),
(176, 34, 'Your appointment has been confirmed.', '2024-10-17 03:54:35', 0, NULL),
(177, 35, 'Your savings account has been credited.', '2024-10-10 03:54:35', 0, NULL),
(178, 35, 'We\'re here to assist you with any queries.', '2024-10-25 03:54:35', 0, NULL),
(179, 36, 'Let us know if you need assistance.', '2024-10-26 03:54:35', 0, NULL),
(180, 36, 'Thank you for being a valued member!', '2024-10-19 03:54:35', 0, NULL),
(181, 37, 'Check our latest updates on services available.', '2024-10-12 03:54:35', 0, NULL),
(182, 37, 'Your application is currently under review.', '2024-10-26 03:54:35', 0, NULL),
(183, 38, 'Join us for our upcoming events.', '2024-10-29 03:54:35', 0, NULL),
(184, 38, 'Don\'t miss our special offers!', '2024-10-27 03:54:35', 0, NULL),
(185, 39, 'Your loan application status has been updated.', '2024-10-15 03:54:35', 0, NULL),
(186, 39, 'Please verify your contact information.', '2024-10-17 03:54:35', 0, NULL),
(187, 40, 'We appreciate your trust in us.', '2024-11-02 03:54:35', 0, NULL),
(188, 40, 'Your member profile has been updated.', '2024-10-19 03:54:35', 0, NULL),
(189, 41, 'Thank you for your continued support.', '2024-10-19 03:54:35', 0, NULL),
(190, 41, 'Stay tuned for more announcements.', '2024-10-31 03:54:35', 0, NULL),
(191, 42, 'We\'re excited to have you with us!', '2024-11-01 03:54:35', 0, NULL),
(192, 42, 'Your appointment has been confirmed.', '2024-10-30 03:54:35', 0, NULL),
(193, 43, 'Your savings account has been credited.', '2024-10-17 03:54:35', 0, NULL),
(194, 43, 'We\'re here to assist you with any queries.', '2024-10-20 03:54:35', 0, NULL),
(195, 44, 'Let us know if you need assistance.', '2024-10-12 03:54:35', 0, NULL),
(196, 44, 'Thank you for being a valued member!', '2024-10-24 03:54:35', 0, NULL),
(197, 45, 'Check our latest updates on services available.', '2024-10-17 03:54:35', 0, NULL),
(198, 45, 'Your application is currently under review.', '2024-11-04 03:54:35', 0, NULL),
(199, 46, 'Join us for our upcoming events.', '2024-10-30 03:54:35', 0, NULL),
(200, 46, 'Don\'t miss our special offers!', '2024-10-08 03:54:35', 0, NULL),
(201, 47, 'Your loan application status has been updated.', '2024-11-04 03:54:35', 0, NULL),
(202, 47, 'Please verify your contact information.', '2024-10-24 03:54:35', 0, NULL),
(203, 48, 'We appreciate your trust in us.', '2024-10-10 03:54:35', 0, NULL),
(204, 48, 'Your member profile has been updated.', '2024-10-28 03:54:35', 0, NULL),
(205, 49, 'Thank you for your continued support.', '2024-10-15 03:54:35', 0, NULL),
(206, 49, 'Stay tuned for more announcements.', '2024-10-15 03:54:35', 0, NULL),
(207, 50, 'We\'re excited to have you with us!', '2024-10-24 03:54:35', 0, NULL),
(208, 50, 'Your appointment has been confirmed.', '2024-10-08 03:54:35', 0, NULL),
(209, 51, 'Your savings account has been credited.', '2024-10-20 03:54:35', 0, NULL),
(210, 51, 'We\'re here to assist you with any queries.', '2024-10-09 03:54:35', 0, NULL),
(211, 52, 'Let us know if you need assistance.', '2024-10-09 03:54:35', 0, NULL),
(212, 52, 'Thank you for being a valued member!', '2024-10-13 03:54:35', 0, NULL),
(213, 53, 'Check our latest updates on services available.', '2024-10-30 03:54:35', 0, NULL),
(214, 53, 'Your application is currently under review.', '2024-10-17 03:54:35', 0, NULL),
(215, 54, 'Join us for our upcoming events.', '2024-10-16 03:54:35', 0, NULL),
(216, 54, 'Don\'t miss our special offers!', '2024-10-22 03:54:35', 0, NULL),
(217, 55, 'Your loan application status has been updated.', '2024-10-25 03:54:35', 0, NULL),
(218, 55, 'Please verify your contact information.', '2024-10-23 03:54:35', 0, NULL),
(219, 56, 'We appreciate your trust in us.', '2024-11-03 03:54:35', 0, NULL),
(220, 56, 'Your member profile has been updated.', '2024-11-04 03:54:35', 0, NULL),
(221, 57, 'Thank you for your continued support.', '2024-11-04 03:54:35', 0, NULL),
(222, 57, 'Stay tuned for more announcements.', '2024-11-05 03:54:35', 0, NULL),
(223, 58, 'We\'re excited to have you with us!', '2024-11-04 03:54:35', 0, NULL),
(224, 58, 'Your appointment has been confirmed.', '2024-11-02 03:54:35', 0, NULL),
(225, 59, 'Your savings account has been credited.', '2024-10-23 03:54:35', 0, NULL),
(226, 59, 'We\'re here to assist you with any queries.', '2024-10-10 03:54:35', 0, NULL),
(227, 60, 'Let us know if you need assistance.', '2024-11-02 03:54:35', 0, NULL),
(228, 60, 'Thank you for being a valued member!', '2024-10-11 03:54:35', 0, NULL),
(229, 61, 'Check our latest updates on services available.', '2024-10-09 03:54:35', 0, NULL),
(230, 61, 'Your application is currently under review.', '2024-11-03 03:54:35', 0, NULL),
(231, 62, 'Join us for our upcoming events.', '2024-10-15 03:54:35', 0, NULL),
(232, 62, 'Don\'t miss our special offers!', '2024-10-30 03:54:35', 0, NULL),
(233, 63, 'Your loan application status has been updated.', '2024-10-07 03:54:35', 0, NULL),
(234, 63, 'Please verify your contact information.', '2024-10-28 03:54:35', 0, NULL),
(235, 64, 'We appreciate your trust in us.', '2024-10-22 03:54:35', 0, NULL),
(236, 64, 'Your member profile has been updated.', '2024-10-22 03:54:35', 0, NULL),
(237, 65, 'Thank you for your continued support.', '2024-11-03 03:54:35', 0, NULL),
(238, 65, 'Stay tuned for more announcements.', '2024-10-11 03:54:35', 0, NULL),
(239, 66, 'We\'re excited to have you with us!', '2024-11-02 03:54:35', 0, NULL),
(240, 66, 'Your appointment has been confirmed.', '2024-10-09 03:54:35', 0, NULL),
(241, 67, 'Your savings account has been credited.', '2024-10-27 03:54:35', 0, NULL),
(242, 67, 'We\'re here to assist you with any queries.', '2024-10-10 03:54:35', 0, NULL),
(243, 68, 'Let us know if you need assistance.', '2024-10-25 03:54:35', 0, NULL),
(244, 68, 'Thank you for being a valued member!', '2024-10-27 03:54:35', 0, NULL),
(245, 1, 'Your feedback is important to us.', '2024-10-28 03:57:31', 0, NULL),
(246, 1, 'We have updated our privacy policy.', '2024-10-27 03:57:31', 0, NULL),
(247, 1, 'Your recent transaction was successful.', '2024-10-15 03:57:31', 0, NULL),
(248, 1, 'Check out our new features!', '2024-10-19 03:57:31', 0, NULL),
(249, 1, 'We are here to help you with any questions.', '2024-10-11 03:57:31', 0, NULL),
(250, 1, 'Your referral bonus has been added to your account.', '2024-10-22 03:57:31', 0, NULL);

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
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', NULL, 0.00, '', '', NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', '', '', '');

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
(1, 7, '2024-01-15', 7, 'In Progress', 1854.48),
(2, 22, '2024-02-20', 4, 'Completed', 1572.52),
(3, 2, '2024-03-05', 5, 'In Progress', 3730.95),
(4, 28, '2024-04-10', 6, 'Completed', 718.15),
(5, 42, '2024-05-25', 7, 'In Progress', 2216.63),
(6, 38, '2024-06-30', 6, 'Completed', 1339.99),
(7, 33, '2024-07-12', 6, 'In Progress', 3550.10),
(8, 46, '2024-08-08', 6, 'Completed', 1928.15),
(9, 27, '2024-09-16', 6, 'In Progress', 499.42),
(10, 35, '2024-10-21', 5, 'Completed', 493.78),
(11, 30, '2024-01-10', 7, 'In Progress', 1017.67),
(12, 22, '2024-02-15', 7, 'Completed', 781.82),
(13, 25, '2024-03-12', 4, 'In Progress', 668.24),
(14, 4, '2024-04-05', 4, 'Completed', 2649.99),
(15, 4, '2024-05-30', 8, 'In Progress', 4456.81),
(16, 50, '2024-06-20', 5, 'Completed', 1494.95),
(17, 29, '2024-07-04', 4, 'In Progress', 2462.24),
(18, 12, '2024-08-22', 7, 'Completed', 4715.56),
(19, 28, '2024-09-17', 8, 'In Progress', 3764.15),
(20, 4, '2024-10-18', 4, 'Completed', 3111.87),
(21, 26, '2024-01-08', 7, 'In Progress', 4817.51),
(22, 38, '2024-02-25', 7, 'Completed', 3780.51),
(23, 18, '2024-03-11', 6, 'In Progress', 1668.34),
(24, 4, '2024-04-09', 6, 'Completed', 1693.05),
(25, 50, '2024-05-22', 8, 'In Progress', 4299.25),
(26, 21, '2024-06-18', 6, 'Completed', 627.35),
(27, 51, '2024-07-13', 7, 'In Progress', 3108.31),
(28, 44, '2024-08-27', 6, 'Completed', 4626.26),
(29, 6, '2024-09-26', 7, 'In Progress', 2676.12),
(30, 12, '2024-10-15', 7, 'Completed', 3080.51),
(31, 50, '2024-01-12', 4, 'In Progress', 3485.30),
(32, 1, '2024-02-28', 4, 'Completed', 1450.40),
(33, 3, '2024-03-07', 6, 'In Progress', 1628.51),
(34, 50, '2024-04-22', 8, 'Completed', 320.19),
(35, 5, '2024-05-17', 5, 'In Progress', 3645.18),
(36, 20, '2024-06-16', 7, 'Completed', 4169.60),
(37, 38, '2024-07-25', 4, 'In Progress', 3348.45),
(38, 38, '2024-08-21', 7, 'Completed', 3396.71),
(39, 49, '2024-09-15', 8, 'In Progress', 1228.31),
(40, 28, '2024-10-14', 4, 'Completed', 354.09);

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
  `DateCreated` datetime DEFAULT current_timestamp(),
  `Savings` decimal(10,2) DEFAULT 0.00,
  `TypeOfMember` enum('Regular','Associate') DEFAULT 'Regular',
  `MembershipStatus` enum('Pending','Active') DEFAULT 'Pending',
  `ShareCapital` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Email`, `MemberID`, `LastName`, `FirstName`, `MiddleName`, `AddressID`, `Birthday`, `Sex`, `TINNumber`, `ContactNo`, `DateCreated`, `Savings`, `TypeOfMember`, `MembershipStatus`, `ShareCapital`) VALUES
('adrianpacheco@example.com', 50, 'Pacheco', 'Adrian', 'Morales', 49, '1992-01-20', 'Male', '120456701', '09123456770', '2024-11-05 02:49:01', 46259.29, 'Regular', 'Active', 13903.44),
('alex.castro@example.com', 97, 'Castro', 'Alex', 'Morales', 29, '1990-02-05', 'Male', '901134567', '09967890123', '2024-11-05 04:29:54', 7200.00, 'Regular', 'Active', 1400.00),
('althea.santiago@example.com', 80, 'Santiago', 'Althea', 'Martinez', 42, '1995-05-16', 'Female', '230567890', '09456789712', '2024-11-05 04:29:54', 1800.00, 'Regular', 'Active', 800.00),
('ana.jimenez@example.com', 62, 'Jimenez', 'Ana', 'Tyler', 19, '2005-11-04', 'Male', '779615414', '09604725331', '2024-11-05 03:38:15', NULL, 'Regular', 'Pending', 0.00),
('ana.reyes@example.com', 63, 'Reyes', 'Ana', 'Ella', 34, '1993-11-04', 'Male', '758058562', '09163195990', '2024-11-05 03:38:15', NULL, 'Regular', 'Pending', 0.00),
('anabellabor@example.com', 22, 'Labor', 'Ana', 'Velasco', 21, '1995-09-30', 'Female', '341678923', '09567890102', '2024-11-05 02:49:01', 21739.33, 'Regular', 'Active', 16986.35),
('andreajacob@example.com', 43, 'Jacob', 'Andrea', 'Smith', 42, '1987-06-15', 'Female', '456789034', '09234567803', '2024-11-05 02:49:01', 16713.75, 'Regular', 'Active', 29609.68),
('andreaparedes@example.com', 11, 'Paredes', 'Andrea', 'Lopez', 10, '1996-10-10', 'Female', '987123654', '09234567801', '2024-11-05 02:49:01', 47907.19, 'Regular', 'Active', 6706.88),
('andrewcastillo@example.com', 33, 'Castillo', 'Andrew', 'Santos', 32, '1994-08-24', 'Male', '456089034', '09890123413', '2024-11-05 02:49:01', 27812.83, 'Regular', 'Active', 21943.52),
('angela.bautista@example.com', 94, 'Bautista', 'Angela', 'Santos', 48, '1987-07-14', 'Female', '677901234', '09845678912', '2024-11-05 04:29:54', 3700.00, 'Regular', 'Active', 900.00),
('anna.morales@example.com', 74, 'Morales', 'Anna', 'Bautista', 50, '1989-12-01', 'Female', '678931234', '09678900234', '2024-11-05 04:29:54', 2500.00, 'Regular', 'Active', 900.00),
('antonioaguilar@example.com', 7, 'Aguilar', 'Antonio', 'Aguilar', 6, '1989-06-06', 'Male', '678001234', '09678901234', '2024-11-05 02:49:01', 23279.10, 'Regular', 'Active', 47564.96),
('ashley.bautista@example.com', 100, 'Bautista', 'Ashley', 'Navarro', 28, '1996-07-28', 'Female', '234467890', '09890103456', '2024-11-05 04:29:54', 5400.00, 'Regular', 'Active', 1500.00),
('ava.lópez@example.com', 65, 'López', 'Ava', 'Parker', 35, '1969-11-04', 'Male', '152847770', '09912231355', '2024-11-05 03:42:08', NULL, 'Regular', 'Pending', 0.00),
('ava.martinez@example.com', 60, 'Martinez', 'Ava', 'Olivia', 17, '1989-11-04', 'Male', '879049890', '09487736311', '2024-11-05 03:38:14', NULL, 'Regular', 'Pending', 0.00),
('bobby.garcia@example.com', 115, 'Garcia', 'Bobby', 'Hernandez', 46, '1990-02-24', 'Male', '678101234', '09789010345', '2024-11-05 04:29:54', 4600.00, 'Regular', 'Active', 1200.00),
('brendangutierrez@example.com', 44, 'Gutierrez', 'Brendan', 'Martinez', 43, '1989-07-20', 'Male', '567890145', '09345678914', '2024-11-05 02:49:01', 23987.50, 'Regular', 'Active', 21242.62),
('carl.garcia@example.com', 103, 'Garcia', 'Carl', 'Rivera', 3, '1993-08-17', 'Male', '566890123', '09745678901', '2024-11-05 04:29:54', 6200.00, 'Regular', 'Active', 1300.00),
('carlitomiranda@example.com', 37, 'Miranda', 'Carlito', 'Castaneda', 36, '1993-12-14', 'Male', '800123478', '09456789057', '2024-11-05 02:49:01', 31250.60, 'Regular', 'Active', 42525.15),
('chloelima@example.com', 26, 'Lima', 'Chloe', 'Morales', 25, '1992-01-20', 'Female', '789112367', '09123456746', '2024-11-05 02:49:01', 21873.93, 'Regular', 'Active', 25794.22),
('chris.jimenez@example.com', 91, 'Jimenez', 'Chris', 'Morales', 50, '1985-11-30', 'Male', '045678901', '09781012345', '2024-11-05 04:29:54', 4900.00, 'Regular', 'Active', 1500.00),
('claireong@example.com', 14, 'Ong', 'Claire', 'Lim', 13, '1991-01-15', 'Female', '234678901', '09567890134', '2024-11-05 02:49:01', 13349.31, 'Regular', 'Active', 33363.88),
('claudia.bautista@example.com', 82, 'Bautista', 'Claudia', 'Rivera', 33, '1993-07-12', 'Female', '4567888012', '09678904234', '2024-11-05 04:29:54', 5200.00, 'Regular', 'Active', 1250.00),
('cynthiadela@example.com', 32, 'Dela Cruz', 'Cynthia', 'Zamora', 31, '1992-07-19', 'Female', '345078923', '09789012302', '2024-11-05 02:49:01', 29771.48, 'Regular', 'Active', 45765.77),
('danny.castillo@example.com', 81, 'Castillo', 'Danny', 'Fernandez', 42, '1986-03-21', 'Male', '345778901', '09567090123', '2024-11-05 04:29:54', 3200.00, 'Regular', 'Active', 1350.00),
('davidmarquez@example.com', 25, 'Marquez', 'David', 'Flores', 24, '1988-12-15', 'Male', '678601256', '09890123435', '2024-11-05 02:49:01', 42514.41, 'Regular', 'Active', 25274.73),
('elijah.martinez@example.com', 64, 'Martinez', 'Elijah', 'Hannah', 39, '1975-11-04', 'Male', '784503563', '09345506557', '2024-11-05 03:42:08', NULL, 'Regular', 'Pending', 0.00),
('emilysantos@example.com', 6, 'Santos', 'Emily', 'Pérez', 5, '1991-05-05', 'Female', '234567890', '09567890123', '2024-11-05 02:49:01', 42830.44, 'Regular', 'Active', 41328.01),
('ernest.dela_cruz@example.com', 89, 'Dela Cruz', 'Ernest', 'Castro', 25, '1992-03-27', 'Male', '923466789', '09560890123', '2024-11-05 04:29:54', 6000.00, 'Regular', 'Active', 1300.00),
('fatimahasan@example.com', 24, 'Hasan', 'Fatima', 'Zain', 23, '1993-11-10', 'Female', '567090145', '09789012324', '2024-11-05 02:49:01', 28148.73, 'Regular', 'Active', 13759.62),
('fernando.leyva@example.com', 71, 'Leyva', 'Fernando', 'López', 39, '1985-11-30', 'Male', '345648901', '09305678901', '2024-11-05 04:29:54', 8000.00, 'Regular', 'Active', 2000.00),
('fiona.leyva@example.com', 96, 'Leyva', 'Fiona', 'Garcia', 14, '1989-03-13', 'Female', '899123456', '09412345678', '2024-11-05 04:29:54', 6000.00, 'Regular', 'Active', 1350.00),
('fionaquiroga@example.com', 30, 'Quiroga', 'Fiona', 'Gonzalez', 29, '1996-05-09', 'Female', '123446701', '09567890180', '2024-11-05 02:49:01', 28351.91, 'Regular', 'Active', 3480.67),
('gerardvillegas@example.com', 40, 'Villegas', 'Gerard', 'Luna', 39, '1988-03-30', 'Male', '123456701', '09789012380', '2024-11-05 02:49:01', 23347.64, 'Regular', 'Active', 9296.19),
('gloria.perez@example.com', 78, 'Perez', 'Gloria', 'Castillo', 43, '1996-04-29', 'Female', '112345678', '09237567890', '2024-11-05 04:29:54', 2000.00, 'Regular', 'Active', 700.00),
('grace.torres@example.com', 92, 'Torres', 'Grace', 'Navarro', 5, '1993-06-22', 'Female', '456799012', '09456780987', '2024-11-05 04:29:54', 3100.00, 'Regular', 'Active', 1450.00),
('gracepo@example.com', 46, 'Po', 'Grace', 'Lim', 45, '1992-09-30', 'Female', '789012367', '09567890136', '2024-11-05 02:49:01', 20438.03, 'Regular', 'Active', 24301.58),
('henry.jimenez@example.com', 79, 'Jimenez', 'Henry', 'Gonzalez', 3, '1990-01-08', 'Male', '103456789', '09545678901', '2024-11-05 04:29:54', 3000.00, 'Regular', 'Active', 1500.00),
('isabelaramos@example.com', 8, 'Ramos', 'Isabela', 'Ramos', 7, '1994-07-07', 'Female', '789011345', '09789012345', '2024-11-05 02:49:01', 10193.81, 'Regular', 'Active', 22064.30),
('jasmine.jimenez@example.com', 59, 'Jimenez', 'Jasmine', 'Olivia', 32, '1967-11-04', 'Male', '154271878', '09792527157', '2024-11-05 03:38:14', NULL, 'Regular', 'Pending', 0.00),
('jasmine.ponce@example.com', 68, 'Ponce', 'Jasmine', 'Tyler', 35, '1992-11-04', 'Male', '534170158', '09509248043', '2024-11-05 03:42:09', NULL, 'Regular', 'Pending', 0.00),
('jasmine.torres@example.com', 72, 'Torres', 'Jasmine', 'Navarro', 34, '1990-03-10', 'Female', '456787012', '09450789912', '2024-11-05 04:29:54', 4000.00, 'Regular', 'Active', 1200.00),
('jenniferlopez@example.com', 36, 'Lopez', 'Jennifer', 'Luna', 35, '1990-11-09', 'Female', '780012367', '09345678946', '2024-11-05 02:49:01', 29740.06, 'Regular', 'Active', 32507.43),
('jenny.castillo@example.com', 102, 'Castillo', 'Jenny', 'Jimenez', 24, '1986-05-04', 'Female', '456711012', '092\r\n 4567890', '2024-11-05 04:29:54', 2800.00, 'Regular', 'Active', 700.00),
('jennytan@example.com', 41, 'Tan', 'Jenny', 'Liu', 40, '1993-04-05', 'Female', '234567812', '09890123491', '2024-11-05 02:49:01', 23316.95, 'Regular', 'Active', 16062.45),
('jeremyreyes@example.com', 18, 'Reyes', 'Jeremy', 'Cruz', 17, '1993-05-10', 'Male', '789012345', '09123456768', '2024-11-05 02:49:01', 7361.43, 'Regular', 'Active', 32619.80),
('jerry.navarro@example.com', 83, 'Navarro', 'Jerry', 'Dela Cruz', 36, '1987-08-19', 'Male', '567870123', '09789002345', '2024-11-05 04:29:54', 6500.00, 'Regular', 'Active', 1450.00),
('jessegarcia@example.com', 13, 'Garcia', 'Jesse', 'Martinez', 12, '1985-12-12', 'Male', '321789654', '09456789023', '2024-11-05 02:49:01', 44014.69, 'Regular', 'Active', 25214.08),
('johndoe@example.com', 2, 'Doe', 'John', 'Smith', 1, '1990-01-01', 'Male', '123456789', '09123456789', '2024-11-05 02:49:01', 38026.31, 'Regular', 'Active', 17489.33),
('johnsmith@example.com', 16, 'Smith', 'John', 'Doe', 15, '1994-03-25', 'Male', '567890123', '09789012356', '2024-11-05 02:49:01', 17367.73, 'Regular', 'Active', 31370.63),
('jose.ponce@example.com', 67, 'Ponce', 'Jose', 'Tyler', 16, '1964-11-04', 'Male', '098384181', '09205482895', '2024-11-05 03:42:09', NULL, 'Regular', 'Pending', 0.00),
('joseph.reyes@example.com', 77, 'Reyes', 'Joseph', 'Jimenez', 53, '1983-02-17', 'Male', '900234567', '09123456790', '2024-11-05 04:29:54', 4500.00, 'Regular', 'Active', 1400.00),
('joshuali@example.com', 47, 'Li', 'Joshua', 'Lee', 46, '1988-10-05', 'Male', '890123478', '09678901247', '2024-11-05 02:49:01', 750.00, 'Regular', 'Active', 35638.08),
('joyce.santos@example.com', 86, 'Santos', 'Joyce', 'Ponce', 50, '1997-12-30', 'Female', '890121456', '09234560890', '2024-11-05 04:29:54', 5900.00, 'Regular', 'Active', 1150.00),
('juan.gonzalez@example.com', 55, 'Gonzalez', 'Juan', 'Mia', 9, '1983-11-04', 'Male', '454109579', '09420021127', '2024-11-05 03:38:14', NULL, 'Regular', 'Pending', 0.00),
('juan.ramos@example.com', 52, 'Ramos', 'Juan', 'Aiden', 31, '1987-11-04', 'Male', '585438606', '09110957584', '2024-11-05 03:38:13', NULL, 'Regular', 'Pending', 0.00),
('julia.santos@example.com', 98, 'Santos', 'Julia', 'Fernandez', 50, '1992-09-17', 'Female', '712345678', '09578901234', '2024-11-05 04:29:54', 4800.00, 'Regular', 'Active', 900.00),
('juliovillar@example.com', 23, 'Villar', 'Julio', 'Cruz', 22, '1994-10-05', 'Male', '456709034', '09678901213', '2024-11-05 02:49:01', 10940.40, 'Regular', 'Active', 38787.76),
('karen.garcia@example.com', 76, 'Garcia', 'Karen', 'Ramos', 4, '1994-09-05', 'Female', '891123456', '09810123456', '2024-11-05 04:29:54', 5500.00, 'Regular', 'Active', 1100.00),
('katrinacabrera@example.com', 42, 'Cabrera', 'Katrina', 'Tan', 41, '1990-05-10', 'Female', '345678923', '09123456792', '2024-11-05 02:49:01', 17117.61, 'Regular', 'Active', 13224.77),
('kevinperez@example.com', 35, 'Perez', 'Kevin', 'Reyes', 34, '1989-10-04', 'Male', '678901056', '0923567835', '2024-11-05 02:49:01', 11771.04, 'Regular', 'Active', 16180.87),
('kyle.torres@example.com', 101, 'Torres', 'Kyle', 'Santiago', 22, '1991-11-10', 'Male', '345688901', '09023456789', '2024-11-05 04:29:54', 6000.00, 'Regular', 'Active', 1600.00),
('liam.ponce@example.com', 56, 'Ponce', 'Liam', 'Noah', 35, '1970-11-04', 'Male', '365394179', '09328241122', '2024-11-05 03:38:14', NULL, 'Regular', 'Pending', 0.00),
('lianalvarez@example.com', 5, 'Alvarez', 'Liana', 'Bautista', 4, '1995-04-04', 'Female', '321654987', '09456789012', '2024-11-05 02:49:01', 42591.22, 'Regular', 'Active', 20413.52),
('lindarobles@example.com', 48, 'Robles', 'Linda', 'Garcia', 47, '1990-11-10', 'Female', '901234589', '09789012358', '2024-11-05 02:49:01', 18293.92, 'Regular', 'Active', 27229.05),
('lindsayfernandez@example.com', 28, 'Fernandez', 'Lindsay', 'Torres', 27, '1995-03-30', 'Female', '001234589', '09345678968', '2024-11-05 02:49:01', 31263.50, 'Regular', 'Active', 24630.36),
('liza.santos@example.com', 70, 'Santos', 'Liza', 'Santiago', 35, '1992-08-22', 'Female', '204567890', '09934567890', '2024-11-05 04:29:54', 3000.00, 'Regular', 'Active', 1500.00),
('manuelsilva@example.com', 9, 'Silva', 'Manuel', 'Silva', 8, '1988-08-08', 'Male', '890123156', '09890123456', '2024-11-05 02:49:01', 26361.28, 'Regular', 'Active', 7915.34),
('maria.ramos@example.com', 61, 'Ramos', 'Maria', 'Mia', 35, '1984-11-04', 'Male', '920147164', '09961847030', '2024-11-05 03:38:15', NULL, 'Regular', 'Pending', 0.00),
('mariabautista@example.com', 20, 'Bautista', 'Maria', 'Ocampo', 19, '1992-07-20', 'Female', '123456780', '09345678980', '2024-11-05 02:49:01', 4492.87, 'Regular', 'Active', 42718.34),
('mariananavarro@example.com', 49, 'Navarro', 'Mariana', 'Pereira', 48, '1993-12-15', 'Female', '012345690', '09890123469', '2024-11-05 02:49:01', 9113.07, 'Regular', 'Active', 8410.35),
('mario.rivera@example.com', 69, 'Rivera', 'Mario', 'Dela Cruz', 28, '1980-05-15', 'Male', '923456719', '09923486789', '2024-11-05 04:29:54', 5000.00, 'Regular', 'Active', 1000.00),
('mariorivera@example.com', 39, 'Rivera', 'Mario', 'Salazar', 38, '1992-02-24', 'Male', '012340690', '09678901279', '2024-11-05 02:49:01', 11712.53, 'Regular', 'Active', 30331.60),
('mark.cruz@example.com', 57, 'Cruz', 'Mark', 'Tyler', 19, '1973-11-04', 'Male', '566308506', '09297609825', '2024-11-05 03:38:14', NULL, 'Regular', 'Pending', 0.00),
('marvelousbautista@example.com', 38, 'Bautista', 'Marvelous', 'Ocampo', 37, '1995-01-19', 'Female', '901204589', '09567890168', '2024-11-05 02:49:01', 19520.42, 'Regular', 'Active', 3607.28),
('maryjane@example.com', 3, 'Jane', 'Mary', 'Johnson', 2, '1992-02-02', 'Female', '987654321', '09234567890', '2024-11-05 02:49:01', 3475.16, 'Regular', 'Active', 3553.96),
('melanieflores@example.com', 17, 'Flores', 'Melanie', 'Garcia', 16, '1995-04-30', 'Female', '678901234', '09890123467', '2024-11-05 02:49:01', 4344.33, 'Regular', 'Active', 8059.75),
('mia.jimenez@example.com', 58, 'Jimenez', 'Mia', 'Olivia', 25, '1991-11-04', 'Male', '556244148', '09216285950', '2024-11-05 03:38:14', NULL, 'Regular', 'Pending', 0.00),
('michellestorm@example.com', 51, 'Storm', 'Michelle', 'Wong', 50, '1994-02-25', 'Female', '204567812', '09234567881', '2024-11-05 02:49:01', 24265.75, 'Regular', 'Active', 47149.54),
('nick.morales@example.com', 95, 'Morales', 'Nick', 'Rivera', 32, '1995-08-29', 'Male', '789012045', '09756789012', '2024-11-05 04:29:54', 3300.00, 'Regular', 'Active', 1100.00),
('nicolasmoreno@example.com', 19, 'Moreno', 'Nicolas', 'Diaz', 18, '1990-06-15', 'Male', '890123456', '09234567879', '2024-11-05 02:49:01', 18950.42, 'Regular', 'Active', 44303.49),
('olivia.gonzalez@example.com', 66, 'Gonzalez', 'Olivia', 'Mia', 37, '1974-11-04', 'Male', '397365026', '09293313988', '2024-11-05 03:42:08', NULL, 'Regular', 'Pending', 0.00),
('olivia.lópez@example.com', 53, 'López', 'Olivia', 'Chloe', 43, '1966-11-04', 'Male', '991165910', '09194920994', '2024-11-05 03:38:13', NULL, 'Regular', 'Pending', 0.00),
('oscar.morales@example.com', 85, 'Morales', 'Oscar', 'Jimenez', 38, '1984-04-18', 'Male', '789017345', '09133456789', '2024-11-05 04:29:54', 4200.00, 'Regular', 'Active', 1650.00),
('oscaralvarado@example.com', 27, 'Alvarado', 'Oscar', 'Romero', 26, '1989-02-25', 'Male', '890123078', '09234567857', '2024-11-05 02:49:01', 20666.18, 'Regular', 'Active', 14420.44),
('pablocastillo@example.com', 12, 'Castillo', 'Pablo', 'Gomez', 11, '1992-11-11', 'Male', '654321987', '09345678912', '2024-11-05 02:49:01', 7103.67, 'Regular', 'Active', 36257.02),
('pedro.castro@example.com', 73, 'Castro', 'Pedro', 'Morales', 51, '1978-07-14', 'Male', '567897123', '09507890123', '2024-11-05 04:29:54', 6000.00, 'Regular', 'Active', 1300.00),
('rafael.garcia@example.com', 87, 'Garcia', 'Rafael', 'Reyes', 28, '1980-02-14', 'Male', '905234567', '09340678901', '2024-11-05 04:29:54', 4500.00, 'Regular', 'Active', 1250.00),
('rafaelcruz@example.com', 4, 'Cruz', 'Rafael', 'Cruz', 3, '1993-03-03', 'Male', '456789123', '09345678901', '2024-11-05 02:49:01', 15974.07, 'Regular', 'Active', 15099.33),
('rickpaolocamba@gmail.com', 1, 'Camba', 'Rick Paolo', 'Pampuan', 15, '2003-03-09', 'male', '123123123', '09466446039', NULL, 24574.43, 'Regular', 'Active', 27574.15),
('robertoang@example.com', 21, 'Ang', 'Roberto', 'Cruz', 20, '1991-08-25', 'Male', '234507812', '09456789091', '2024-11-05 02:49:01', 14147.46, 'Regular', 'Active', 32014.86),
('ronald.dela_cruz@example.com', 75, 'Dela Cruz', 'Ronald', 'Gonzalez', 41, '1981-06-23', 'Male', '789072345', '09789082345', '2024-11-05 04:29:54', 7000.00, 'Regular', 'Active', 1600.00),
('ronaldli@example.com', 45, 'Li', 'Ronald', 'Zhang', 44, '1995-08-25', 'Male', '678901256', '09456789025', '2024-11-05 02:49:01', 20631.92, 'Regular', 'Active', 4115.03),
('rose.torres@example.com', 84, 'Torres', 'Rose', 'Santos', 30, '1991-11-22', 'Female', '677771234', '09890023456', '2024-11-05 04:29:54', 3700.00, 'Regular', 'Active', 1700.00),
('sarahlee@example.com', 10, 'Lee', 'Sarah', 'Tan', 9, '1990-09-09', 'Female', '012345678', '09123456780', '2024-11-05 02:49:01', 49679.40, 'Regular', 'Active', 45051.89),
('sophia.ramos@example.com', 54, 'Ramos', 'Sophia', 'Ella', 36, '1991-11-04', 'Male', '357927901', '09956965279', '2024-11-05 03:38:14', NULL, 'Regular', 'Pending', 0.00),
('sophia.reyes@example.com', 90, 'Reyes', 'Sophia', 'Gonzalez', 46, '1988-09-12', 'Female', '234560890', '09178901234', '2024-11-05 04:29:54', 7200.00, 'Regular', 'Active', 1600.00),
('stephanie.leyva@example.com', 88, 'Leyva', 'Stephanie', 'Santiago', 43, '1994-10-09', 'Female', '912345678', '09456780012', '2024-11-05 04:29:54', 2500.00, 'Regular', 'Active', 500.00),
('theresakim@example.com', 15, 'Kim', 'Theresa', 'Park', 14, '1990-02-20', 'Female', '456012789', '09678901245', '2024-11-05 02:49:01', 26221.27, 'Regular', 'Active', 39950.69),
('tommysalcedo@example.com', 29, 'Salcedo', 'Tommy', 'Vera', 28, '1994-04-04', 'Male', '012345090', '09456789079', '2024-11-05 02:49:01', 24089.63, 'Regular', 'Active', 44596.08),
('vincent.castillo@example.com', 93, 'Castillo', 'Vincent', 'Ponce', 34, '1991-01-19', 'Male', '567790123', '09389012345', '2024-11-05 04:29:54', 2200.00, 'Regular', 'Active', 1200.00),
('vincentpascual@example.com', 31, 'Pascual', 'Vincent', 'Tan', 30, '1993-06-14', 'Male', '234567012', '09678901291', '2024-11-05 02:49:01', 6711.49, 'Regular', 'Active', 37769.24),
('william.gonzalez@example.com', 99, 'Gonzalez', 'William', 'Torres', 4, '1984-12-20', 'Male', '623456789', '09789011345', '2024-11-05 04:29:54', 3000.00, 'Regular', 'Active', 1300.00),
('ysabellaortiz@example.com', 34, 'Ortiz', 'Ysabella', 'Mendoza', 33, '1991-09-29', 'Female', '567890045', '09123456724', '2024-11-05 02:49:01', 24711.71, 'Regular', 'Active', 7250.85);

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
(52, 1, 1, 0, 'In progress', '2024-11-26', NULL),
(53, 1, 1, 0, 'In progress', '2024-11-28', NULL),
(54, 1, 1, 0, 'In progress', '2024-11-13', NULL),
(55, 1, 1, 0, 'In progress', '2024-11-06', NULL),
(56, 1, 1, 0, 'In progress', '2024-11-09', NULL),
(57, 1, 1, 0, 'In progress', '2024-11-11', NULL),
(58, 1, 1, 0, 'In progress', '2024-11-30', NULL),
(59, 1, 1, 0, 'In progress', '2024-11-28', NULL),
(60, 1, 1, 0, 'In progress', '2024-11-25', NULL),
(61, 1, 1, 0, 'In progress', '2024-11-26', NULL),
(62, 1, 1, 0, 'In progress', '2024-11-23', NULL),
(63, 1, 1, 0, 'In progress', '2024-11-12', NULL),
(64, 1, 1, 0, 'In progress', '2024-11-12', NULL),
(65, 1, 1, 0, 'In progress', '2024-11-13', NULL),
(66, 1, 1, 0, 'In progress', '2024-11-21', NULL),
(67, 1, 1, 0, 'In progress', '2024-11-22', NULL),
(68, 1, 1, 0, 'In progress', '2024-11-27', NULL);

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
DELIMITER $$
CREATE TRIGGER `update_membership_status` AFTER INSERT ON `membership_application` FOR EACH ROW BEGIN
    -- Default to 'Pending' initially
    DECLARE newStatus VARCHAR(20);  -- Declare a local variable
    SET newStatus = 'Pending';

    -- Check if all conditions for 'Active' are met
    IF NEW.Status = 'Completed' AND NEW.FillUpForm = 1 AND NEW.WatchedVideoSeminar = 1 AND NEW.PaidRegistrationFee = 1 THEN
        SET newStatus = 'Active';
    END IF;

    -- Update the MembershipStatus in the member table based on the determined status
    UPDATE member 
    SET MembershipStatus = newStatus 
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
  `Password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_credentials`
--

INSERT INTO `member_credentials` (`MemberID`, `Username`, `Email`, `Password`, `reset_token`, `token_expiry`) VALUES
(1, 'user1', 'rickpaolocamba@gmail.com', '$2y$10$zeBeTakigMIc6gibxw4VK..K/mbjLUqABQ/fExXd7xAm6/ZywVfNy', NULL, NULL),
(2, 'user2', 'johndoe@example.com', '$2y$10$rJI4mBYM8Ct32UGdr0EfTO4MRRZsDhfHZRozLVknLJ4kBKdH19HK6', NULL, NULL),
(3, 'user3', 'maryjane@example.com', '$2y$10$VumQKjM9FLKPvBMAFBhGIOtPJ/wHFDC844z6nlmwuEs5mzV0iFql.', NULL, NULL),
(4, 'user4', 'rafaelcruz@example.com', '$2y$10$FWK2bk/hsZ1kVVjuvwpiv.YD7XZipHgrlMQ.F/yPo0RPXu8DyI/IS', NULL, NULL),
(5, 'user5', 'lianalvarez@example.com', '$2y$10$rV4eOFW3MhBWhdmyl0NJq.8tEMy4HBtHVpbXgvlWc.5A6UMm97QvC', NULL, NULL),
(6, 'user6', 'emilysantos@example.com', '$2y$10$Csmpf5wDCmZM04osWSY8ceGDlsWOZsbv8MloKPjequS8KL/on7qfq', NULL, NULL),
(7, 'user7', 'antonioaguilar@example.com', '$2y$10$00zU8NfqACiK4WAxwxZJbudbD7xLifFQjsw390rW2LHCY1aqMJy/e', NULL, NULL),
(8, 'user8', 'isabelaramos@example.com', '$2y$10$3PMG0kxzRJhYfO8j/oMHDOIoR7OQBM6lnciRqJ2h4miDw9NpsbPCS', NULL, NULL),
(9, 'user9', 'manuelsilva@example.com', '$2y$10$3jD1piXakTf.oNNQeK2qweyIjOlKLCgc9G4AApal/io5Ly9SAB38y', NULL, NULL),
(10, 'user10', 'sarahlee@example.com', '$2y$10$Ewd4johlvovQMkNvLO6yoOSswhAoXb6YYauNYvMQu.WVcnGHZUb3.', NULL, NULL),
(11, 'user11', 'andreaparedes@example.com', '$2y$10$b//unAGQvwiGJm1GooIWr.jP1Jagj/Xf6qGZ6CAdYhpeiabjdSi3.', NULL, NULL),
(12, 'user12', 'pablocastillo@example.com', '$2y$10$o0MDJQz3VkHBk4zebobYauHm5PaFTRloo75ZXIQf1l1cSgBUlaWxm', NULL, NULL),
(13, 'user13', 'jessegarcia@example.com', '$2y$10$73OwMVaS2qFdjHBZWjsgFexc/6L7BD7HYE2MFF4m35FPOGOb3RyC.', NULL, NULL),
(14, 'user14', 'claireong@example.com', '$2y$10$4MyKGrkaSLATeS/UYYILp.AOWINHcE2BZ5D5pvZzAkSqOYuOwRR8.', NULL, NULL),
(15, 'user15', 'theresakim@example.com', '$2y$10$2xJSKsSVztTt49VvYCQUJ.LWiLdSVaOITRZcNUC9wN0IzEycVC/5m', NULL, NULL),
(16, 'user16', 'johnsmith@example.com', '$2y$10$qdlKLg8JplNrh6eFRekJbexz6LdANXeLgOaDmFbc1Po0R97D.PwTm', NULL, NULL),
(17, 'user17', 'melanieflores@example.com', '$2y$10$SiUNod/MrDAmrL6kgjJT..Ylg0qJL0w5j44HsCCscqsJGa.OB.dHC', NULL, NULL),
(18, 'user18', 'jeremyreyes@example.com', '$2y$10$srOfGx4/MCPLZUekbg5AYONc3r3ChZtHDL8WQoMEIvICdORac3am2', NULL, NULL),
(19, 'user19', 'nicolasmoreno@example.com', '$2y$10$jBe6noweehnFrX3maC5ioudnAHIOu4SwjkkfLK/RzfdydG2fcs41W', NULL, NULL),
(20, 'user20', 'mariabautista@example.com', '$2y$10$c5ohs009zslNfTH16n3bA.2oNxnvNs2Eh2ovqBFfQCaXnEyL9bQRi', NULL, NULL),
(21, 'user21', 'robertoang@example.com', '$2y$10$jX14d/3k7zifBwLlRMdyxuGapeuDBSIWrYAxbjbSfutjz1c4pIe/q', NULL, NULL),
(22, 'user22', 'anabellabor@example.com', '$2y$10$PxfuyRRoWpHDQuVhoSm0i.gLn8AHX.9S3Seo8O6hOQY7zHMuBeA2e', NULL, NULL),
(23, 'user23', 'juliovillar@example.com', '$2y$10$y64ShxQcboQA/LQntwfGROm/cNbj/zF.0R8SFMVexNd1eweo4T0mS', NULL, NULL),
(24, 'user24', 'fatimahasan@example.com', '$2y$10$aeKu3bJGWhjQ/GJmvf7vPuT1IwtvcnhQcwfxuuIiyWSH14gL7RAeu', NULL, NULL),
(25, 'user25', 'davidmarquez@example.com', '$2y$10$oZh/MKbei0SfjaJcuMGDZe.uClZCycb/TBK8SayKm2MM1tASDEyk6', NULL, NULL),
(26, 'user26', 'chloelima@example.com', '$2y$10$n693D4lQaR4jEulyI35x4OKFcfGCVRzsPGqhD2nxKoBD9B9cYYYuC', NULL, NULL),
(27, 'user27', 'oscaralvarado@example.com', '$2y$10$CSUZZhinDv/pVrLE86bokO4mKL4SuhzQcBwOcoDxt4i/dwKe51O0S', NULL, NULL),
(28, 'user28', 'lindsayfernandez@example.com', '$2y$10$ToQ/oNgtV4j5kwAd/AKtI.hbNDOgsDpar42CqA3P2dikjG7ebdml6', NULL, NULL),
(29, 'user29', 'tommysalcedo@example.com', '$2y$10$wqv/poKy4eBN3U15Kh1jMOy64pQ56vMohzdsEMyUS2Qb6holk5pvi', NULL, NULL),
(30, 'user30', 'fionaquiroga@example.com', '$2y$10$Kex1I9RfR4lF.r8zm38N2eYNe9rPZrg3k/QityhioRFVd2unSUDVS', NULL, NULL),
(31, 'user31', 'vincentpascual@example.com', '$2y$10$0MxaizD1RKUTC4Jg8/UATOqNQpKBwjokLWy9k9v.J9Y/y1QHefn1O', NULL, NULL),
(32, 'user32', 'cynthiadela@example.com', '$2y$10$2sLApOS6XdeDfR9BqCHpaOrkgnj0xjlLk4MGxwisaEdsOz7Wy/cea', NULL, NULL),
(33, 'user33', 'andrewcastillo@example.com', '$2y$10$NEqirCKENzw/dGwBIbtmfOgU0zD9Ei8Pk87vzZcGx6sR3OVm7Lwqm', NULL, NULL),
(34, 'user34', 'ysabellaortiz@example.com', '$2y$10$duuhxNHZMeVk3RfuhYc09uya2nlRwxiFb5M385QW5eyJGTQwUEPOm', NULL, NULL),
(35, 'user35', 'kevinperez@example.com', '$2y$10$izdhcA9X6JPlJPR7mpM6auzJjrWbek6tlZ5nwomVQCEOH/OPaHQbu', NULL, NULL),
(36, 'user36', 'jenniferlopez@example.com', '$2y$10$i3sMAPKEs6KI/xiYAM8zFeN/jG0.2JNK0WMdLF.Xe82bMFpoyNE/q', NULL, NULL),
(37, 'user37', 'carlitomiranda@example.com', '$2y$10$.sRqmBwi5oB7O2EMPsqIfeLdi.QARo/rZps6.nbZgp9IgZpFXeVd6', NULL, NULL),
(38, 'user38', 'marvelousbautista@example.com', '$2y$10$0XMBiITR1tLMOg4mdoiwp.0pJu9gmtEzgH5JOsLyfFECuOE5TREca', NULL, NULL),
(39, 'user39', 'mariorivera@example.com', '$2y$10$3RwRHLICJEmhdr/sc55b4uezjGfO4lQkprNGFKFJhTOeV2K5Ikewi', NULL, NULL),
(40, 'user40', 'gerardvillegas@example.com', '$2y$10$yymf3BlEJ81jP/Yug7FV7Om3tMhwRALP5hjwaP6dtzoKyos/H4vTy', NULL, NULL),
(41, 'user41', 'jennytan@example.com', '$2y$10$72tgXithmKBLKAmFwMyi7utV.8zkhtqdvsTwnimu2X3cuvMzk6ony', NULL, NULL),
(42, 'user42', 'katrinacabrera@example.com', '$2y$10$nkd7d.BAbIna3w9lBJ0F3uaz5mUHpdHz9WL0hHOoi6ZpyDq2DBiqG', NULL, NULL),
(43, 'user43', 'andreajacob@example.com', '$2y$10$L0KQTBNYucahNVFeeoLt9.4WD5kf8UJvpSrCEZzhr93h1HNu.tinO', NULL, NULL),
(44, 'user44', 'brendangutierrez@example.com', '$2y$10$IjVuY12Mni2m5l/6cJojueAdnp0ceU/jWAkvm14QWxVJqdxDiYE52', NULL, NULL),
(45, 'user45', 'ronaldli@example.com', '$2y$10$Xy4OMX9WaZW02PCdAMw8Se5/AMBpKd2ahrw.Hk1nnqRmYEBvCsk4y', NULL, NULL),
(46, 'user46', 'gracepo@example.com', '$2y$10$X06eFPn5IfgtDsztAEw1HOBAXNRaUmxA9HhXbUh.bY/pib54Zbv1O', NULL, NULL),
(47, 'user47', 'joshuali@example.com', '$2y$10$r71.av8OFSMkQHrcn3J6D.tuLD/nNmF1YWoNrSEBFYoa6eZnozT92', NULL, NULL),
(48, 'user48', 'lindarobles@example.com', '$2y$10$Y1bUCjmGPhL1mmcouXAcie1efSNqEzzorY21K4Hf7ptxZSpaukYwW', NULL, NULL),
(49, 'user49', 'mariananavarro@example.com', '$2y$10$L3EtMl4fasfHnTsgqFSof.FRMf5/pEE2s0/PfzMTmmlSgZNkj638W', NULL, NULL),
(50, 'user50', 'adrianpacheco@example.com', '$2y$10$EkFupTWR7ltzfzUGAv2XvOCZv4tpedNy3JQ/akXsQyBkp0lAx7ZFW', NULL, NULL),
(51, 'user51', 'michellestorm@example.com', '$2y$10$iaZZZoNDlmyU3HPgTQ4pVuofM6tDIm0KtIvBRB8VJtkIW2/si.1qy', NULL, NULL),
(52, 'jramos', 'juan.ramos@example.com', '$2y$10$AvJ0Gn38CQWx5qN3Kkfsx.7ELy.xzXBxkDUam5aTO6sfv49XZnDwO', NULL, NULL),
(53, 'olópez', 'olivia.lópez@example.com', '$2y$10$LxPN2IXPE14EqUzum6n5..kc7yWrLhQvfcNWkux1q7BJs0qBevJIG', NULL, NULL),
(54, 'sramos', 'sophia.ramos@example.com', '$2y$10$pWjrIFOFMdyw1452X4d/V.G.2dcvqTcDJma3.fR6n5/5FMkR.toRu', NULL, NULL),
(55, 'jgonzalez', 'juan.gonzalez@example.com', '$2y$10$/oVzJxOkBVDlaSHupCMtWeMDLFMuokXSLOIvWWdJZ9SWeWMk9rIGm', NULL, NULL),
(56, 'lponce', 'liam.ponce@example.com', '$2y$10$TJXLDNAwiCH8855VJvK5Kux7wAurQCoc3M7IXcpyM1w/cX1l0b53S', NULL, NULL),
(57, 'mcruz', 'mark.cruz@example.com', '$2y$10$FvePfLqnXfXGR0BTYttHaOQh1Z3ybSeoW.Jqo1XSsTm37epW/eGJ2', NULL, NULL),
(58, 'mjimenez', 'mia.jimenez@example.com', '$2y$10$gOqutNYrUv6UgA7t.Ms1hehm2wSwC4wYVlJ83HoE2lrYXsVrBv3Wq', NULL, NULL),
(59, 'jjimenez', 'jasmine.jimenez@example.com', '$2y$10$vJ1AF6/sZD6.wIDA4V575efcwKy3UFF/yORP5iVCEaEuEKkWIsXUu', NULL, NULL),
(60, 'amartinez', 'ava.martinez@example.com', '$2y$10$9WR6nIBYrw2Hy70oGfS6t.w9YiiZz6nF3JbjqJkJNrPkJXi6H.7JW', NULL, NULL),
(61, 'mramos', 'maria.ramos@example.com', '$2y$10$l.ANOh5b.tDfbvl0i9YdhewaZcVYiNPNEYYUOB0bktLjWuRyqPzWa', NULL, NULL),
(62, 'ajimenez', 'ana.jimenez@example.com', '$2y$10$vDfwXO8yzPj8JuyoNIfD4OHY3DjxVqccVQ13b0/ynOwHvphLEstAu', NULL, NULL),
(63, 'areyes', 'ana.reyes@example.com', '$2y$10$eothrzqYs4BkiPwLh49vSelrl4BxE3.HxmLOZ8yepSosYYUwgzrtS', NULL, NULL),
(64, 'emartinez', 'elijah.martinez@example.com', '$2y$10$bZx2xmRGDlHuoFCNopq/6uQvAkREn5xXzByAKqU76gW2R8lhocL1i', NULL, NULL),
(65, 'alópez', 'ava.lópez@example.com', '$2y$10$YrAdPEJIwibZAfwMBCWafeZ5Aoj5cS0OyBPWMt.5Qaze0UoNVtAT2', NULL, NULL),
(66, 'ogonzalez', 'olivia.gonzalez@example.com', '$2y$10$cfX2/SDubEW6.f7/q9ykGup2a8Hz.24wZm9K56L4EAs0WhYHZVlGC', NULL, NULL),
(67, 'jponce', 'jose.ponce@example.com', '$2y$10$6bneoUWnXwudrYJ1NXWPp./7sxNkpZUt1SJOBNydWdLYf3xz8CzYm', NULL, NULL),
(68, 'jasmine.ponce', 'jasmine.ponce@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(69, 'mario.rivera', 'mario.rivera@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(70, 'liza.santos', 'liza.santos@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(71, 'fernando.leyva', 'fernando.leyva@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(72, 'jasmine.torres', 'jasmine.torres@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(73, 'pedro.castro', 'pedro.castro@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(74, 'anna.morales', 'anna.morales@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(75, 'ronald.dela_cruz', 'ronald.dela_cruz@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(76, 'karen.garcia', 'karen.garcia@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(77, 'joseph.reyes', 'joseph.reyes@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(78, 'gloria.perez', 'gloria.perez@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(79, 'henry.jimenez', 'henry.jimenez@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(80, 'althea.santiago', 'althea.santiago@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(81, 'danny.castillo', 'danny.castillo@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(82, 'claudia.bautista', 'claudia.bautista@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(83, 'jerry.navarro', 'jerry.navarro@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(84, 'rose.torres', 'rose.torres@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(85, 'oscar.morales', 'oscar.morales@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(86, 'joyce.santos', 'joyce.santos@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(87, 'rafael.garcia', 'rafael.garcia@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(88, 'stephanie.leyva', 'stephanie.leyva@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(89, 'ernest.dela_cruz', 'ernest.dela_cruz@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(90, 'sophia.reyes', 'sophia.reyes@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(91, 'chris.jimenez', 'chris.jimenez@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(92, 'grace.torres', 'grace.torres@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(93, 'vincent.castillo', 'vincent.castillo@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(94, 'angela.bautista', 'angela.bautista@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(95, 'nick.morales', 'nick.morales@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(96, 'fiona.leyva', 'fiona.leyva@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(97, 'alex.castro', 'alex.castro@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(98, 'julia.santos', 'julia.santos@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(99, 'william.gonzalez', 'william.gonzalez@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(100, 'ashley.bautista', 'ashley.bautista@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(101, 'kyle.torres', 'kyle.torres@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(102, 'jenny.castillo', 'jenny.castillo@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(103, 'carl.garcia', 'carl.garcia@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL),
(115, 'bobby.garcia', 'bobby.garcia@example.com', '$2y$10$Fl1h6YcFyYZjjiDRr8bF8.6JZNW32n8pJTdykzZzT3uuS8jGpXt8m', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `old_members`
--

CREATE TABLE `old_members` (
  `MemberID` int(11) NOT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `AddressID` int(11) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Sex` enum('Female','Male') DEFAULT NULL,
  `TINNumber` varchar(15) DEFAULT NULL,
  `ContactNo` varchar(11) DEFAULT NULL,
  `Savings` decimal(10,2) DEFAULT NULL,
  `TypeofMember` enum('Regular','Associate') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(52, 'Juan', 'Ramos', 'Aiden', 'Male', 31, '585438606', '1987-11-04', '09110957584'),
(53, 'Olivia', 'López', 'Chloe', 'Male', 43, '991165910', '1966-11-04', '09194920994'),
(54, 'Sophia', 'Ramos', 'Ella', 'Male', 36, '357927901', '1991-11-04', '09956965279'),
(55, 'Juan', 'Gonzalez', 'Mia', 'Male', 9, '454109579', '1983-11-04', '09420021127'),
(56, 'Liam', 'Ponce', 'Noah', 'Male', 35, '365394179', '1970-11-04', '09328241122'),
(57, 'Mark', 'Cruz', 'Tyler', 'Male', 19, '566308506', '1973-11-04', '09297609825'),
(58, 'Mia', 'Jimenez', 'Olivia', 'Male', 25, '556244148', '1991-11-04', '09216285950'),
(59, 'Jasmine', 'Jimenez', 'Olivia', 'Male', 32, '154271878', '1967-11-04', '09792527157'),
(60, 'Ava', 'Martinez', 'Olivia', 'Male', 17, '879049890', '1989-11-04', '09487736311'),
(61, 'Maria', 'Ramos', 'Mia', 'Male', 35, '920147164', '1984-11-04', '09961847030'),
(62, 'Ana', 'Jimenez', 'Tyler', 'Male', 19, '779615414', '2005-11-04', '09604725331'),
(63, 'Ana', 'Reyes', 'Ella', 'Male', 34, '758058562', '1993-11-04', '09163195990'),
(64, 'Elijah', 'Martinez', 'Hannah', 'Male', 39, '784503563', '1975-11-04', '09345506557'),
(65, 'Ava', 'López', 'Parker', 'Male', 35, '152847770', '1969-11-04', '09912231355'),
(66, 'Olivia', 'Gonzalez', 'Mia', 'Male', 37, '397365026', '1974-11-04', '09293313988'),
(67, 'Jose', 'Ponce', 'Tyler', 'Male', 16, '098384181', '1964-11-04', '09205482895'),
(68, 'Jasmine', 'Ponce', 'Tyler', 'Male', 35, '534170158', '1992-11-04', '09509248043');

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
(1, 26, 2, '2024-01-15 10:00:00', 4605.20, 'In Progress'),
(2, 38, 4, '2024-02-20 12:30:00', 3122.78, 'Completed'),
(3, 6, 4, '2024-03-05 14:45:00', 1782.48, 'In Progress'),
(4, 21, 2, '2024-04-10 09:15:00', 383.04, 'Completed'),
(5, 50, 4, '2024-05-25 11:00:00', 4516.68, 'In Progress'),
(6, 12, 3, '2024-06-30 15:30:00', 1691.85, 'Completed'),
(7, 17, 4, '2024-07-12 08:20:00', 2497.67, 'In Progress'),
(8, 15, 2, '2024-08-08 13:10:00', 2233.71, 'Completed'),
(9, 46, 2, '2024-09-16 16:00:00', 1659.79, 'In Progress'),
(10, 45, 3, '2024-10-21 17:40:00', 473.11, 'Completed'),
(11, 30, 4, '2024-01-10 11:00:00', 934.84, 'In Progress'),
(12, 19, 3, '2024-02-15 14:20:00', 4113.23, 'Completed'),
(13, 48, 2, '2024-03-12 09:00:00', 1517.45, 'In Progress'),
(14, 35, 3, '2024-04-05 10:45:00', 4138.60, 'Completed'),
(15, 20, 3, '2024-05-30 15:15:00', 1916.81, 'In Progress'),
(16, 11, 2, '2024-06-20 12:30:00', 2502.64, 'Completed'),
(17, 15, 2, '2024-07-04 09:10:00', 1257.55, 'In Progress'),
(18, 51, 2, '2024-08-22 16:00:00', 3332.97, 'Completed'),
(19, 14, 3, '2024-09-17 10:30:00', 883.31, 'In Progress'),
(20, 25, 4, '2024-10-18 14:50:00', 2675.09, 'Completed'),
(21, 30, 3, '2024-01-08 11:20:00', 657.37, 'In Progress'),
(22, 16, 2, '2024-02-25 16:45:00', 2362.18, 'Completed'),
(23, 21, 3, '2024-03-11 09:30:00', 525.34, 'In Progress'),
(24, 16, 3, '2024-04-09 10:05:00', 4948.25, 'Completed'),
(25, 41, 2, '2024-05-22 15:30:00', 4176.06, 'In Progress'),
(26, 51, 3, '2024-06-18 12:15:00', 1582.33, 'Completed'),
(27, 2, 2, '2024-07-13 09:50:00', 2933.06, 'In Progress'),
(28, 42, 3, '2024-08-27 14:35:00', 2421.84, 'Completed'),
(29, 7, 2, '2024-09-26 11:05:00', 4954.47, 'In Progress'),
(30, 7, 4, '2024-10-15 10:25:00', 467.80, 'Completed'),
(31, 7, 3, '2024-01-12 16:20:00', 853.37, 'In Progress'),
(32, 6, 2, '2024-02-28 09:40:00', 2439.27, 'Completed'),
(33, 42, 4, '2024-03-07 11:15:00', 1400.22, 'In Progress'),
(34, 49, 2, '2024-04-22 12:55:00', 2357.59, 'Completed'),
(35, 1, 4, '2024-05-17 08:10:00', 3601.01, 'In Progress'),
(36, 14, 2, '2024-06-16 10:05:00', 2025.62, 'Completed'),
(37, 7, 3, '2024-07-25 14:30:00', 2222.12, 'In Progress'),
(38, 19, 3, '2024-08-21 11:55:00', 4077.70, 'Completed'),
(39, 15, 2, '2024-09-15 10:30:00', 1519.01, 'In Progress'),
(40, 12, 3, '2024-10-14 12:00:00', 523.19, 'Completed');

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
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `admin_messages`
--
ALTER TABLE `admin_messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `AnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `collateral_info`
--
ALTER TABLE `collateral_info`
  MODIFY `LoanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

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
  MODIFY `TransactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=995;

--
-- AUTO_INCREMENT for table `membership_application`
--
ALTER TABLE `membership_application`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `signupform`
--
ALTER TABLE `signupform`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `staff_credentials`
--
ALTER TABLE `staff_credentials`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_messages`
--
ALTER TABLE `admin_messages`
  ADD CONSTRAINT `admin_messages_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);

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
