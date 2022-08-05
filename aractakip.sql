-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 05 Ağu 2022, 15:31:55
-- Sunucu sürümü: 10.4.21-MariaDB
-- PHP Sürümü: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `aractakip`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aracmarkalari`
--

CREATE TABLE `aracmarkalari` (
  `id` int(11) NOT NULL,
  `markaadi` varchar(255) NOT NULL,
  `tarih` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `aracmarkalari`
--

INSERT INTO `aracmarkalari` (`id`, `markaadi`, `tarih`) VALUES
(1, 'Renault', '2022-08-04 15:27:19'),
(2, 'Seat', '2022-08-04 15:27:56'),
(3, 'Audi', '2022-08-16 15:27:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aracmodelleri`
--

CREATE TABLE `aracmodelleri` (
  `id` int(11) NOT NULL,
  `modeladi` varchar(255) NOT NULL,
  `aracmarkaid` int(11) NOT NULL,
  `aracsegmenti` varchar(20) NOT NULL,
  `tarih` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `aracmodelleri`
--

INSERT INTO `aracmodelleri` (`id`, `modeladi`, `aracmarkaid`, `aracsegmenti`, `tarih`) VALUES
(1, 'Clio', 1, 'B', '2022-08-04 15:28:12'),
(2, 'Toledo', 2, 'A', '2022-08-04 15:28:19'),
(3, 'Megane', 1, 'B', '2022-08-04 15:36:57');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteriler`
--

CREATE TABLE `musteriler` (
  `id` int(11) NOT NULL,
  `adsoyad` varchar(255) NOT NULL,
  `kullaniciadi` varchar(255) NOT NULL,
  `uyeliktarihi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `musteriler`
--

INSERT INTO `musteriler` (`id`, `adsoyad`, `kullaniciadi`, `uyeliktarihi`) VALUES
(5, 'murat baslamis', 'murat-baslamis', '2022-08-04 11:56:05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `servisbilgisi`
--

CREATE TABLE `servisbilgisi` (
  `id` int(11) NOT NULL,
  `musteriid` int(11) NOT NULL,
  `aracmarkaid` int(11) NOT NULL,
  `aracmodelid` int(11) NOT NULL,
  `tamirturid` int(11) NOT NULL,
  `tamiryerid` int(11) NOT NULL,
  `tamirtarihi` datetime NOT NULL,
  `tarih` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `servisbilgisi`
--

INSERT INTO `servisbilgisi` (`id`, `musteriid`, `aracmarkaid`, `aracmodelid`, `tamirturid`, `tamiryerid`, `tamirtarihi`, `tarih`) VALUES
(15, 5, 1, 1, 1, 1, '2022-08-05 14:00:00', '2022-08-05 10:00:00'),
(16, 5, 1, 1, 1, 2, '2022-08-05 14:00:00', '2022-08-05 12:00:00'),
(17, 5, 1, 1, 2, 1, '2022-08-05 15:00:00', '2022-08-05 10:00:00'),
(18, 5, 1, 1, 2, 2, '2022-08-05 15:00:00', '2022-08-05 14:00:00'),
(19, 5, 1, 1, 3, 3, '2022-08-05 15:00:00', '2022-08-05 13:30:00'),
(20, 5, 1, 1, 3, 3, '2022-08-05 14:00:00', '2022-08-05 03:27:13');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tamirturleri`
--

CREATE TABLE `tamirturleri` (
  `id` int(11) NOT NULL,
  `turadi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tamirturleri`
--

INSERT INTO `tamirturleri` (`id`, `turadi`) VALUES
(1, 'Lastik'),
(2, 'Yağ'),
(3, 'Motor Bakım');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tamirturveyerler`
--

CREATE TABLE `tamirturveyerler` (
  `id` int(11) NOT NULL,
  `tamirturid` int(11) NOT NULL,
  `tamiryerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tamirturveyerler`
--

INSERT INTO `tamirturveyerler` (`id`, `tamirturid`, `tamiryerid`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 2, 1),
(4, 2, 2),
(5, 3, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tamiryerleri`
--

CREATE TABLE `tamiryerleri` (
  `id` int(11) NOT NULL,
  `yeradi` varchar(255) NOT NULL,
  `aylikkapasite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tamiryerleri`
--

INSERT INTO `tamiryerleri` (`id`, `yeradi`, `aylikkapasite`) VALUES
(1, 'Tamirhane 1', 30),
(2, 'Tamirhane 2', 15),
(3, 'Tamirhane 3', 25);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `aracmarkalari`
--
ALTER TABLE `aracmarkalari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Tablo için indeksler `aracmodelleri`
--
ALTER TABLE `aracmodelleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `aracmarkaid` (`aracmarkaid`);

--
-- Tablo için indeksler `musteriler`
--
ALTER TABLE `musteriler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Tablo için indeksler `servisbilgisi`
--
ALTER TABLE `servisbilgisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Tablo için indeksler `tamirturleri`
--
ALTER TABLE `tamirturleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Tablo için indeksler `tamirturveyerler`
--
ALTER TABLE `tamirturveyerler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `tamirturid` (`tamirturid`),
  ADD KEY `tamiryerid` (`tamiryerid`);

--
-- Tablo için indeksler `tamiryerleri`
--
ALTER TABLE `tamiryerleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `aracmarkalari`
--
ALTER TABLE `aracmarkalari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `aracmodelleri`
--
ALTER TABLE `aracmodelleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `musteriler`
--
ALTER TABLE `musteriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `servisbilgisi`
--
ALTER TABLE `servisbilgisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `tamirturleri`
--
ALTER TABLE `tamirturleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `tamirturveyerler`
--
ALTER TABLE `tamirturveyerler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `tamiryerleri`
--
ALTER TABLE `tamiryerleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `musteriler`
--
ALTER TABLE `musteriler`
  ADD CONSTRAINT `musteriid` FOREIGN KEY (`id`) REFERENCES `servisbilgisi` (`musteriid`);

--
-- Tablo kısıtlamaları `servisbilgisi`
--
ALTER TABLE `servisbilgisi`
  ADD CONSTRAINT `servisbilgisi_ibfk_1` FOREIGN KEY (`tamirturid`) REFERENCES `tamirturleri` (`id`),
  ADD CONSTRAINT `servisbilgisi_ibfk_2` FOREIGN KEY (`tamiryerid`) REFERENCES `tamirturveyerler` (`tamiryerid`),
  ADD CONSTRAINT `servisbilgisi_ibfk_3` FOREIGN KEY (`aracmarkaid`) REFERENCES `aracmodelleri` (`aracmarkaid`),
  ADD CONSTRAINT `servisbilgisi_ibfk_4` FOREIGN KEY (`aracmodelid`) REFERENCES `aracmodelleri` (`id`);

--
-- Tablo kısıtlamaları `tamirturleri`
--
ALTER TABLE `tamirturleri`
  ADD CONSTRAINT `tamirturid` FOREIGN KEY (`id`) REFERENCES `tamirturveyerler` (`tamirturid`);

--
-- Tablo kısıtlamaları `tamiryerleri`
--
ALTER TABLE `tamiryerleri`
  ADD CONSTRAINT `tamiryerid` FOREIGN KEY (`id`) REFERENCES `tamirturveyerler` (`tamiryerid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
