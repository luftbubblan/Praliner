-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Värd: localhost:8889
-- Tid vid skapande: 30 jun 2022 kl 09:49
-- Serverversion: 5.7.34
-- PHP-version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `praliner`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` int(11) NOT NULL,
  `guest` varchar(3) DEFAULT NULL,
  `billing_full_name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `billing_street` varchar(90) NOT NULL,
  `billing_postal_code` varchar(255) NOT NULL,
  `billing_city` varchar(90) NOT NULL,
  `billing_country` varchar(90) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `guest`, `billing_full_name`, `email`, `phone`, `billing_street`, `billing_postal_code`, `billing_city`, `billing_country`, `create_date`) VALUES
(4, 5, 304, NULL, 'Jag Jagsson', 'jag@gmail.com', '0701234567', 'Vägen 1', '12312', 'Orten', 'Sverige', '2022-06-29 15:23:13'),
(5, NULL, 150, 'yes', 'Anna Nilsson', 'annamalinoscar@gmail.com', '0701231231', 'Vägen 2', '12345', 'Gargnäs', 'Sverige', '2022-06-29 15:25:07');

-- --------------------------------------------------------

--
-- Tabellstruktur `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_title` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_title`, `quantity`, `unit_price`, `created_at`) VALUES
(4, 4, 19, 'Fläderpralin', 3, 18, '2022-06-29 15:23:13'),
(5, 4, 10, 'Jordgubbstårta', 1, 250, '2022-06-29 15:23:13'),
(6, 5, 6, 'Kaffe Baileys', 5, 30, '2022-06-29 15:25:07');

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(90) NOT NULL,
  `flavour` varchar(90) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `img_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`id`, `title`, `flavour`, `description`, `price`, `stock`, `img_url`) VALUES
(1, 'Mjölkchokladskräm', 'Ljus choklad, krispkex, Callebauts golden choklad', 'Ljus choklad fylld med mjölkchokladkräm med krispkex. Toppad med en ganache av Callebauts golden choklad med smak av len härlig kola.', 25, 20, 'img/Mjölkchokladskräm.jpeg'),
(2, 'Jordgubbspralin', 'Vit choklad, jordgubb, smör', 'En midsommardröm som tar dig rakt in i sommaren och ut på jordgubbslandet.', 20, 4, 'img/Jordgubbspraliner.jpeg'),
(6, 'Kaffe Baileys', 'Kaffe, baileys', 'Kaffe och baileys med ätbara blommor. Behöver ingen vidare beskrivning.', 30, 25, 'img/Kaffe och baileys .jpeg'),
(10, 'Jordgubbstårta', 'Jordgubb, grädde', 'En riktigt god jordgubbstårta.\r\nDekorerad med blommor från ros, blåklocka, penséer, smultronblad och torkad blåklint.', 250, 3, 'img/tårta.png'),
(13, 'Mörkröda', 'Mjölkchoklad, kex\r\n\r\n', 'Mörkröda med guldstänk och smak av mjölkchoklad och mjölkchokladskräm med kex. Skitgoda helt enkelt!\r\n\r\n', 18, 20, 'img/Mörkröda.jpeg'),
(14, 'Cappuccinopralin', 'Cappuccino, choklad', 'Eftermiddagsfikat i en och samma tugga. Toner av Callebauts capuccinochoklad. ', 20, 14, 'img/capuccino.png'),
(15, 'Prinsesspralin', 'Vit choklad, mandelmassa, grädde', 'Vill du njuta av en alldeles egen princesstårta där du får äta hela själv! Då är denna smarriga pralin för dig', 25, 12, 'img/Prinsesstårta i pralinkostym.jpg'),
(17, 'Citronpralin', 'Vit choklad, citron och fläder', 'En krämig fräsch sommarpralin med smaker av vit choklad, citron och fläder.\r\nDekorerad med blomster av hundkex.', 18, 25, 'img/citronfläder.png'),
(19, 'Fläderpralin', 'Fläder, Vit Choklad', 'Krämig fläderpralin med vit choklad, dekorerad med förgätmigej.', 18, 6, 'img/vit.jpeg');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(60) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `street` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `city` varchar(90) NOT NULL,
  `country` varchar(90) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `street`, `postal_code`, `city`, `country`, `create_date`) VALUES
(4, 'Namn', 'Namnsson', 'namn@gmail.com', '$2y$12$s1n5uFaVyJ8U8unK5g.48uor5U/fBaRSNILxRmjARa0UkOzka2QgC', '0701234567', 'Gatan 1', '12345', 'Orten', 'Sverige', '2022-06-29 15:17:10'),
(5, 'Jag', 'Jagsson', 'jag@gmail.com', '$2y$12$UsKn64.1fIApHPH/SY14SOGy8kAtml8Fi07kcdYbC8czsaU1x/dpa', '0701234567', 'Vägen 1', '12312', 'Orten', 'Sverige', '2022-06-29 15:18:35'),
(6, 'Anna', 'Nilsson', 'anna@gmail.com', '$2y$12$uOkYNcLqKC4UqvNT37IlWu.2LsxnfGUVa5EH7nsHJ/R3o6hu13sxm', '0701234567', 'Annasgata 1', '12345', 'Umeå', 'Sverige', '2022-06-29 15:19:17'),
(7, 'Malin', 'Volle', 'Malin@gmail.com', '$2y$12$2bYwMkXawAqmfzrOtThUBehczKCi18xvmCl9pz0QkkvjY3dVWpuOK', '0701234123', 'Skånegatan 1', '12333', 'Ägelholm', 'Danmark', '2022-06-29 15:20:15'),
(8, 'Oscar', 'Luftbubblan', 'Oscar@gmail.com', '$2y$12$eesOOXHOj2RQTAiZkIr6P.LoZMX/KTzAf882NbZiCtNvOODxU.4Ey', '0701231234', 'Oscargatan 1', '12345', 'Umeå', 'Sverige', '2022-06-29 15:21:03');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
