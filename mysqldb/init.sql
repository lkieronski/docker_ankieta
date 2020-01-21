SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE ankieta;
USE ankieta;

CREATE TABLE `Ankiety` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `pytanie` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `odpowiedz` tinyint(4) NOT NULL,
  `uwagi` text COLLATE utf8_polish_ci,
  `kod` varchar(16) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `Kody` (
  `id` int(11) NOT NULL,
  `kod` text CHARACTER SET latin1 NOT NULL,
  `poziom` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `Nazwy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `Pytania` (
  `id` int(11) NOT NULL,
  `pkod` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `pytanie` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `Tracking` (
  `id` int(11) NOT NULL,
  `kod` varchar(16) COLLATE utf8_polish_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

ALTER TABLE `Ankiety`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Kody`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Nazwy`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Pytania`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Tracking`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Ankiety`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2039;

ALTER TABLE `Kody`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

ALTER TABLE `Nazwy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `Pytania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

ALTER TABLE `Tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;