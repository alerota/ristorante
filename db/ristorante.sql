-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 29, 2018 alle 10:27
-- Versione del server: 10.1.29-MariaDB
-- Versione PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ristorante`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `fasceorarie`
--

CREATE TABLE `fasceorarie` (
  `id_contatore_fasce` int(11) NOT NULL,
  `id_fascia` int(11) NOT NULL,
  `orario` varchar(15) NOT NULL,
  `fase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `fasceorarie`
--

INSERT INTO `fasceorarie` (`id_contatore_fasce`, `id_fascia`, `orario`, `fase`) VALUES
(1, 1, '12.00', 2),
(2, 1, '13.00', 2),
(5, 1, '19.00', 4),
(6, 1, '20.00', 4),
(7, 1, '19.30', 4),
(13, 2, '19.00', 4),
(14, 2, '20.00', 4),
(16, 3, '10.00', 0),
(17, 3, '10.30', 0),
(18, 3, '17.30', 3),
(19, 3, '18.00', 3),
(20, 3, '18.30', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `gestionefasceorarie`
--

CREATE TABLE `gestionefasceorarie` (
  `id_gestionefasceorarie` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `id_fascia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `gestionefasceorarie`
--

INSERT INTO `gestionefasceorarie` (`id_gestionefasceorarie`, `nome`, `id_fascia`) VALUES
(1, 'Pranzo e Cena', 1),
(2, 'Cena', 2),
(3, 'Chiusura', -1),
(5, 'Coso', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `id_prenotazione` int(11) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `num_partecipanti` int(11) NOT NULL,
  `giorno` varchar(10) NOT NULL,
  `orario` varchar(15) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `id_stagione` int(11) NOT NULL,
  `id_fase` int(11) NOT NULL,
  `note_prenotazione` text NOT NULL,
  `scadenza` int(11) NOT NULL,
  `arrivo` int(11) NOT NULL,
  `chiusura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prenotazioni`
--

INSERT INTO `prenotazioni` (`id_prenotazione`, `cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`, `scadenza`, `arrivo`, `chiusura`) VALUES
(1, 'A', '1', 47, '2018-05-18', '19.00', 3, 7, 4, '', 0, 0, 0),
(3, 'C', '3', 13, '2018-05-18', '19.00', 1, 7, 4, '', 0, 0, 0),
(4, 'D', '5', 4, '2018-05-18', '20.00', 1, 7, 4, '', 0, 0, 0),
(5, 'Rota', '1', 7, '2018-05-26', '19.00', 1, 7, 4, 'che bello', 0, 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazionidarevisionare`
--

CREATE TABLE `prenotazionidarevisionare` (
  `id_prenotazione` int(11) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `num_partecipanti` int(11) NOT NULL,
  `giorno` varchar(10) NOT NULL,
  `orario` varchar(15) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `id_stagione` int(11) NOT NULL,
  `id_fase` int(11) NOT NULL,
  `note_prenotazione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `sale`
--

CREATE TABLE `sale` (
  `id_sala` int(11) NOT NULL,
  `Nome_sala` varchar(20) NOT NULL,
  `Numero_posti_prenotabili` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sale`
--

INSERT INTO `sale` (`id_sala`, `Nome_sala`, `Numero_posti_prenotabili`) VALUES
(1, 'Sala 1', 20),
(2, 'Sala 2', 30),
(3, 'Sala 3', 50),
(5, 'Sala 5', 20),
(6, 'Terrazza esterna', 40),
(7, 'Giardino', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `stagioni`
--

CREATE TABLE `stagioni` (
  `id_stagione` int(11) NOT NULL,
  `nome_stagione` varchar(30) NOT NULL,
  `giorno_inizio` varchar(10) NOT NULL,
  `giorno_fine` varchar(10) NOT NULL,
  `priorita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `stagioni`
--

INSERT INTO `stagioni` (`id_stagione`, `nome_stagione`, `giorno_inizio`, `giorno_fine`, `priorita`) VALUES
(6, 'Pasqua', '2018-06-21', '2018-06-21', 11),
(7, 'Stagione autunnale', '2018-05-14', '2018-07-27', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `stagioni_orari`
--

CREATE TABLE `stagioni_orari` (
  `id_contatore_stagione_orari` int(11) NOT NULL,
  `id_stagione` int(11) NOT NULL,
  `giorno_settimana` int(11) NOT NULL,
  `id_fascia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `stagioni_orari`
--

INSERT INTO `stagioni_orari` (`id_contatore_stagione_orari`, `id_stagione`, `giorno_settimana`, `id_fascia`) VALUES
(1, 6, 0, 1),
(2, 6, 1, 1),
(3, 6, 2, 1),
(4, 6, 3, 1),
(5, 6, 4, 1),
(6, 6, 5, 1),
(7, 6, 6, 1),
(8, 7, 0, 1),
(9, 7, 1, -1),
(10, 7, 2, 1),
(11, 7, 3, 2),
(12, 7, 4, 2),
(13, 7, 5, 1),
(14, 7, 6, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `stagioni_sale`
--

CREATE TABLE `stagioni_sale` (
  `id_contatore_stagione_sale` int(11) NOT NULL,
  `id_stagione` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `stagioni_sale`
--

INSERT INTO `stagioni_sale` (`id_contatore_stagione_sale`, `id_stagione`, `id_sala`) VALUES
(5, 6, 1),
(6, 6, 2),
(7, 6, 5),
(8, 7, 1),
(9, 7, 2),
(10, 7, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `storico`
--

CREATE TABLE `storico` (
  `id_storico` int(11) NOT NULL,
  `nome_cliente` varchar(50) NOT NULL,
  `tel_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `storico`
--

INSERT INTO `storico` (`id_storico`, `nome_cliente`, `tel_cliente`) VALUES
(1, 'io', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(12, 'ale', '75e678b74030c0af1331bbfe3ef17783');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `fasceorarie`
--
ALTER TABLE `fasceorarie`
  ADD PRIMARY KEY (`id_contatore_fasce`);

--
-- Indici per le tabelle `gestionefasceorarie`
--
ALTER TABLE `gestionefasceorarie`
  ADD PRIMARY KEY (`id_gestionefasceorarie`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id_prenotazione`);

--
-- Indici per le tabelle `prenotazionidarevisionare`
--
ALTER TABLE `prenotazionidarevisionare`
  ADD PRIMARY KEY (`id_prenotazione`);

--
-- Indici per le tabelle `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id_sala`);

--
-- Indici per le tabelle `stagioni`
--
ALTER TABLE `stagioni`
  ADD PRIMARY KEY (`id_stagione`);

--
-- Indici per le tabelle `stagioni_orari`
--
ALTER TABLE `stagioni_orari`
  ADD PRIMARY KEY (`id_contatore_stagione_orari`);

--
-- Indici per le tabelle `stagioni_sale`
--
ALTER TABLE `stagioni_sale`
  ADD PRIMARY KEY (`id_contatore_stagione_sale`);

--
-- Indici per le tabelle `storico`
--
ALTER TABLE `storico`
  ADD PRIMARY KEY (`id_storico`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `fasceorarie`
--
ALTER TABLE `fasceorarie`
  MODIFY `id_contatore_fasce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `gestionefasceorarie`
--
ALTER TABLE `gestionefasceorarie`
  MODIFY `id_gestionefasceorarie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `id_prenotazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `prenotazionidarevisionare`
--
ALTER TABLE `prenotazionidarevisionare`
  MODIFY `id_prenotazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `sale`
--
ALTER TABLE `sale`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `stagioni`
--
ALTER TABLE `stagioni`
  MODIFY `id_stagione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `stagioni_orari`
--
ALTER TABLE `stagioni_orari`
  MODIFY `id_contatore_stagione_orari` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `stagioni_sale`
--
ALTER TABLE `stagioni_sale`
  MODIFY `id_contatore_stagione_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `storico`
--
ALTER TABLE `storico`
  MODIFY `id_storico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
