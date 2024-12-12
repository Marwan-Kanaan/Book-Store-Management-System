-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 06:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `phone_number`) VALUES
(1, 'Mira Khodor', 'mirakhoder1@gmail.com', '$2y$10$n/6kchPLXA.mxmfjEmvIsum2kxD3JlQFhnUeTUYzjnOr8ii1xX7c2', '03 567 982'),
(2, 'Samer Samir', 'samer@gmail.com', '$2y$10$S.aCW1GpQgmwkt9dPXVxTeg6yiSqsC954glnd8SL5NVIwIX8.fDw.', '03 864 864');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `image`, `description`, `price`) VALUES
(14, 'Ice & Fire : A Game of Thrones', 'George R. R. Martin', 'ice and fire 1.jpg', 'A Game of Thrones is the first novel in A Song of Ice and Fire, a series of fantasy novels by American author George R. R. Martin. It was first published on August 1, 1996. The novel won the 1997 Locus Award and was nominated for both the 1997 Nebula Awar', 35.00),
(15, 'Ice & Fire : A Clash of Kings', 'George R. R. Martin', 'ice and fire 2.jpg', 'A Clash of Kings is the second of seven planned novels in A Song of Ice and Fire by American author George R. R. Martin, an epic fantasy series. It was first published in the United Kingdom on November 16, 1998; the first United States edition followed on', 40.00),
(16, 'Ice & Fire : A Storm of Swords', 'George R. R. Martin', 'ice and fire 3.jpg', 'A Storm of Swords is the third of seven planned novels in the fantasy series A Song of Ice and Fire by American author George R. R. Martin. It was first published in the United Kingdom on August 8, 2000, with a United States edition following in November ', 45.00),
(17, 'Ice & Fire : A Feast for Crows', 'George R. R. Martin', 'ice and fire 4.jpg', 'A Feast for Crows is the fourth of seven planned novels in the epic fantasy series A Song of Ice and Fire by American author George R. R. Martin. The novel was first published in the United Kingdom on October 17, 2005, with a United States edition followi', 45.00),
(18, 'Ice & Fire : A Dance with Dragons', 'George R. R. Martin', 'ice and fire 5.jpg', 'A Dance with Dragons is the fifth novel of seven planned in the epic fantasy series A Song of Ice and Fire by American author George R. R. Martin. In some areas, the paperback edition was published in two parts: Dreams and Dust and After the Feast.', 50.00),
(19, 'Ice & Fire : The Winds of Winter', 'George R. R. Martin', 'ice and fire 6.jpg', 'The Winds of Winter is the planned sixth novel in the epic fantasy series A Song of Ice and Fire by American writer George R. R. Martin. The manuscript is expected to be over 1,500 pages in length.', 25.00),
(20, 'Ice & Fire : A Dream of Spring', 'George R. R. Martin', 'ice and fire 7.jpg', 'A Dream of Spring is the planned title of the seventh volume of George R. R. Martin\'s A Song of Ice and Fire series. The book is to follow The Winds of Winter and is intended to be the final volume of the series.', 30.00),
(21, 'خوف I', 'Osamah M. Al Muslim', 'khof 1.jpg', 'There are those who describe me as liberated, and this is an admission from the describer that I was enslaved to something that he is still enslaved to, and there are those who see my ideas as a great danger to the rising generation, as if this generation', 20.00),
(22, 'خوف II', 'Osamah M. Al Muslim', 'khof 2.jpg', 'Today we live in a world saturated with materialism, which blinds us to another world... a parallel and darker world... a world that disappears behind blindness... a blindness that has afflicted most of us.', 23.00),
(23, 'خوف III', 'Osamah M. Al Muslim', 'khof 3.jpg', '\"I am biased towards myself and fanatical about my ideas. I do not have time to spend refuting a point of view that is backed by a spiteful, resentful person. Nor do I have an ounce of respect to offer to an arrogant, haughty person. I am satisfied with m', 25.00),
(24, 'سفاح الأزقة', 'Othman Abed', 'safa7.jpg', 'I opened my eyes wide after the news hit me like a thunderbolt! My heart was racing and my headache was increasing. My shock wasn’t that I was assigned to an investigation outside of Riyadh… but that I was assigned to that particular case… the case that s', 28.00),
(25, 'إنني أتعفن رعبا', 'Mariam Al Hisi', 'Ro3ban.jpg', 'I am rotting with terror by Maryam Al-Haisi... The novel talks about two main characters, the first of whom is \"Maria\", a young woman who suffers from a mental illness that leads her to see abnormal nightmares at a rate beyond the capacity of a normal per', 30.00),
(26, 'العوسج', 'Jawhara Al Ramal', '3osak.jpg', 'A new novel by the writer Jawhara Al-Ramal has been released, titled: “Al-Awsaj”, which is a striking and attractive title, referring to the Al-Awsaj tree, which legend has it is a tree under which a tribe of jinn live, and is called the devilish tree in ', 34.00),
(27, 'طائفة الشعيبة', 'Othman Abed', 'ta2fat.jpg', 'How are all these strange contradictory things connected to each other? An abandoned resort with a new theater inside! Is it one of those devil-worshipping sects, with their strange rituals? The goat\'s head dripping with blood invaded my imagination, I do', 22.00);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `book_ids` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `total_items` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `customer_id`, `book_ids`, `total_price`, `total_items`) VALUES
(1, 1, '[\"Ice & Fire : A Clash of Kings\",\"Ice & Fire : A Clash of Kings\"]', 80.00, 2),
(2, 1, '[\"Ice & Fire : The Winds of Winter\",\"\\u062e\\u0648\\u0641 I\",\"\\u062e\\u0648\\u0641 III\",\"\\u062e\\u0648\\u0641 II\"]', 93.00, 4),
(3, 1, '[\"\\u0627\\u0644\\u0639\\u0648\\u0633\\u062c\",\"\\u0637\\u0627\\u0626\\u0641\\u0629 \\u0627\\u0644\\u0634\\u0639\\u064a\\u0628\\u0629\"]', 56.00, 2),
(4, 2, '[\"Ice & Fire : A Storm of Swords\"]', 45.00, 1),
(10, 1, '[\"Ice & Fire : A Dream of Spring\"]', 30.00, 1),
(11, 1, '[\"Ice & Fire : The Winds of Winter\"]', 25.00, 1),
(12, 1, '[\"\\u062e\\u0648\\u0641 II\"]', 23.00, 1),
(13, 1, '[\"Ice & Fire : A Dream of Spring\"]', 30.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_it` tinyint(1) DEFAULT 0,
  `working_on` tinyint(1) DEFAULT 0,
  `done` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `read_it`, `working_on`, `done`) VALUES
(1, 'Omar Khaled', 'omarkhaled1@gmail.com', 'Add More Books', 'hello, Hope you have a nice day. \r\n\r\nPlease can you add the collection of Harry Potter Books ? \r\n\r\nBest Regards.\r\n\r\n', '2024-12-12 15:35:03', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `password`, `phone_number`) VALUES
(1, 'Omar Khaled', 'omarkhaled1@gmail.com', '$2y$10$n/6kchPLXA.mxmfjEmvIsum2kxD3JlQFhnUeTUYzjnOr8ii1xX7c2', '81 649 758'),
(2, 'Jad Abo Ali', 'aboali@gmail.com', '$2y$10$E92gXq7Y.myTlipKRg7jYOlNCetIvV/ea1D.eBuFrXU08BpPfOmIS', '07 954 164'),
(3, 'Omar Dob', 'dob@gmail.com', '$2y$10$Uz3bEqrlpMryY1jyGk/5Q.s7SKtEkyCCwwxX8hMwX1hETo67sa2oe', '02 975 487'),
(4, 'Samir Samkara', 'samkara@gmail.com', '$2y$10$DwPZ9wgOlCVSPPetYrGNAuvSyL4MxnEbZ9p6cTZ8NPMtj9ArAYqMW', '70 508 762');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
