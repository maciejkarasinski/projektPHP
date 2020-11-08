-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Lis 2020, 20:34
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `mustat`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `emitraport`
--

CREATE TABLE `emitraport` (
  `emitRaport_id` int(11) NOT NULL,
  `raport_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `count` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `emitraport`
--

INSERT INTO `emitraport` (`emitRaport_id`, `raport_id`, `song_id`, `count`) VALUES
(1, 1, 1, 10),
(2, 1, 2, 50),
(3, 2, 1, 220),
(4, 2, 2, 270),
(6, 2, 23, 50),
(7, 13, 1, 1000),
(8, 13, 2, 2000),
(9, 13, 23, 3000),
(10, 14, 1, 1100),
(11, 14, 2, 2200),
(12, 14, 23, 3300),
(13, 14, 24, 4400);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `raports`
--

CREATE TABLE `raports` (
  `raport_id` int(11) NOT NULL,
  `year` int(10) NOT NULL,
  `month` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `raports`
--

INSERT INTO `raports` (`raport_id`, `year`, `month`, `name`) VALUES
(1, 2020, 'Styczeń', 'Raport_Emisji_za_styczeń_2020'),
(2, 2020, 'Luty', 'Raport_emisji_za_luty_2020'),
(13, 2020, 'Marzec', 'Raport_emisji_za_marzec_2020'),
(14, 2020, 'Kwiecień', 'Raport_emisji_za_kwiecień_2020');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `songs`
--

CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `file_name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `ISCR` varchar(50) NOT NULL,
  `composer` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `sauthor` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `songs`
--

INSERT INTO `songs` (`song_id`, `file_name`, `title`, `ISCR`, `composer`, `author`, `sauthor`, `duration`) VALUES
(1, 'dlaElizy.mp3', 'Dla Elizy', '123123123', 'Ludwig Van Beethoven', 'Ludwig Van Beethoven', 'Ludwig Van Beethoven', 300),
(2, 'czteryPoryRoku.mp3', 'Cztery pory roku', '12341234', 'Antonio Vivaldi', 'Antonio Vivaldi', 'Antonio Vivaldi', 460),
(23, 'etiudaRewolucyjna.mp3', 'Etiuda Rewolucyjna', '12351221541', 'Fryderyk Chopin', 'Fryderyk Chopin', 'Fryderyk Chopin', 520),
(24, 'donGiovanni.mp3', 'Don Giovanni', '1231231451241', 'Wolfgang Amadeusz Mozart', 'Wolfgang Amadeusz Mozart', 'Wolfgang Amadeusz Mozart', 660);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `user`, `password`, `email`) VALUES
(1, 'adam', '$2y$10$I.nSC7Rgo3sOw7NsL5P9AekV.gqPCKFLy9dsXZRqk2mvVC4vZhybW', 'adam@gmail.com'),
(2, 'kasia', '$2y$10$jwICFIsWFvl7c53AOEKNJ.22tygsWVZjFsbcpRzSPXU5gSb/DvGfW', 'kasia@gmail.com'),
(3, 'roman', '$2y$10$EGoDcsKlkCUrT74OSW.4V.s57o4UIkK082baL80hdzeSjRQixcSF2', 'roman@gmail.com');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `emitraport`
--
ALTER TABLE `emitraport`
  ADD PRIMARY KEY (`emitRaport_id`),
  ADD KEY `raport_id` (`raport_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indeksy dla tabeli `raports`
--
ALTER TABLE `raports`
  ADD PRIMARY KEY (`raport_id`);

--
-- Indeksy dla tabeli `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`),
  ADD UNIQUE KEY `iscr` (`ISCR`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `id` (`user_id`),
  ADD UNIQUE KEY `user` (`user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `emitraport`
--
ALTER TABLE `emitraport`
  MODIFY `emitRaport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `raports`
--
ALTER TABLE `raports`
  MODIFY `raport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `emitraport`
--
ALTER TABLE `emitraport`
  ADD CONSTRAINT `emitraport_ibfk_1` FOREIGN KEY (`raport_id`) REFERENCES `raports` (`raport_id`),
  ADD CONSTRAINT `emitraport_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
