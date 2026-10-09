-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 09 Eki 2026, 09:36:46
-- Sunucu sürümü: 5.7.44-cll-lve
-- PHP Sürümü: 8.1.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `site_ivesgo_panel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilceler`
--

CREATE TABLE `ilceler` (
  `ilce_id` int(11) NOT NULL,
  `ilce_il_id` int(11) DEFAULT NULL,
  `ilce_adi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ilceler`
--

INSERT INTO `ilceler` (`ilce_id`, `ilce_il_id`, `ilce_adi`) VALUES
(1, 1, 'SEYHAN'),
(2, 1, 'YÜREĞİR'),
(3, 1, 'SARIÇAM'),
(4, 1, 'ÇUKUROVA'),
(5, 1, 'ALADAĞ(KARSANTI)'),
(6, 1, 'CEYHAN'),
(7, 1, 'FEKE'),
(8, 1, 'İMAMOĞLU'),
(9, 1, 'KARAİSALI'),
(10, 1, 'KARATAŞ'),
(11, 1, 'KOZAN'),
(12, 1, 'POZANTI'),
(13, 1, 'SAİMBEYLİ'),
(14, 1, 'TUFANBEYLİ'),
(15, 1, 'YUMURTALIK'),
(16, 2, 'ADIYAMAN'),
(17, 2, 'BESNİ'),
(18, 2, 'ÇELİKHAN'),
(19, 2, 'GERGER'),
(20, 2, 'GÖLBAŞI'),
(21, 2, 'KAHTA'),
(22, 2, 'SAMSAT'),
(23, 2, 'SİNCİK'),
(24, 2, 'TUT'),
(25, 3, 'AFYONKARAHİSAR'),
(26, 3, 'BAŞMAKÇI'),
(27, 3, 'BAYAT'),
(28, 3, 'BOLVADİN'),
(29, 3, 'ÇAY'),
(30, 3, 'ÇOBANLAR'),
(31, 3, 'DAZKIRI'),
(32, 3, 'DİNAR'),
(33, 3, 'EMİRDAĞ'),
(34, 3, 'EVCİLER'),
(35, 3, 'HOCALAR'),
(36, 3, 'İHSANİYE'),
(37, 3, 'İSCEHİSAR'),
(38, 3, 'KIZILÖREN'),
(39, 3, 'SANDIKLI'),
(40, 3, 'SİNCANLI(SİNANPAŞA)'),
(41, 3, 'SULTANDAĞI'),
(42, 3, 'ŞUHUT'),
(43, 4, 'AĞRI'),
(44, 4, 'DİYADİN'),
(45, 4, 'DOĞUBEYAZIT'),
(46, 4, 'ELEŞKİRT'),
(47, 4, 'HAMUR'),
(48, 4, 'PATNOS'),
(49, 4, 'TAŞLIÇAY'),
(50, 4, 'TUTAK'),
(51, 5, 'AMASYA'),
(52, 5, 'GÖYNÜCEK'),
(53, 5, 'GÜMÜŞHACIKÖY'),
(54, 5, 'HAMAMÖZÜ'),
(55, 5, 'MERZİFON'),
(56, 5, 'SULUOVA'),
(57, 5, 'TAŞOVA'),
(58, 6, 'ALTINDAĞ'),
(59, 6, 'ÇANKAYA'),
(60, 6, 'ETİMESGUT'),
(61, 6, 'KEÇİÖREN'),
(62, 6, 'MAMAK'),
(63, 6, 'SİNCAN'),
(64, 6, 'YENİMAHALLE'),
(65, 6, 'GÖLBAŞI'),
(66, 6, 'PURSAKLAR'),
(67, 6, 'AKYURT'),
(68, 6, 'AYAŞ'),
(69, 6, 'BALA'),
(70, 6, 'BEYPAZARI'),
(71, 6, 'ÇAMLIDERE'),
(72, 6, 'ÇUBUK'),
(73, 6, 'ELMADAĞ'),
(74, 6, 'EVREN'),
(75, 6, 'GÜDÜL'),
(76, 6, 'HAYMANA'),
(77, 6, 'KALECİK'),
(78, 6, 'KAZAN'),
(79, 6, 'KIZILCAHAMAM'),
(80, 6, 'NALLIHAN'),
(81, 6, 'POLATLI'),
(82, 6, 'ŞEREFLİKOÇHİSAR'),
(83, 7, 'MURATPAŞA'),
(84, 7, 'KEPEZ'),
(85, 7, 'KONYAALTI'),
(86, 7, 'AKSU'),
(87, 7, 'DÖŞEMEALTI'),
(88, 7, 'AKSEKİ'),
(89, 7, 'ALANYA'),
(90, 7, 'ELMALI'),
(91, 7, 'FİNİKE'),
(92, 7, 'GAZİPAŞA'),
(93, 7, 'GÜNDOĞMUŞ'),
(94, 7, 'İBRADI(AYDINKENT)'),
(95, 7, 'KALE(DEMRE)'),
(96, 7, 'KAŞ'),
(97, 7, 'KEMER'),
(98, 7, 'KORKUTELİ'),
(99, 7, 'KUMLUCA'),
(100, 7, 'MANAVGAT'),
(101, 7, 'SERİK'),
(102, 8, 'ARTVİN'),
(103, 8, 'ARDANUÇ'),
(104, 8, 'ARHAVİ'),
(105, 8, 'BORÇKA'),
(106, 8, 'HOPA'),
(107, 8, 'MURGUL(GÖKTAŞ)'),
(108, 8, 'ŞAVŞAT'),
(109, 8, 'YUSUFELİ'),
(110, 9, 'AYDIN'),
(111, 9, 'BOZDOĞAN'),
(112, 9, 'BUHARKENT(ÇUBUKDAĞI)'),
(113, 9, 'ÇİNE'),
(114, 9, 'GERMENCİK'),
(115, 9, 'İNCİRLİOVA'),
(116, 9, 'KARACASU'),
(117, 9, 'KARPUZLU'),
(118, 9, 'KOÇARLI'),
(119, 9, 'KÖŞK'),
(120, 9, 'KUŞADASI'),
(121, 9, 'KUYUCAK'),
(122, 9, 'NAZİLLİ'),
(123, 9, 'SÖKE'),
(124, 9, 'SULTANHİSAR'),
(125, 9, 'DİDİM(YENİHİSAR)'),
(126, 9, 'YENİPAZAR'),
(127, 10, 'BALIKESİR'),
(128, 10, 'AYVALIK'),
(129, 10, 'BALYA'),
(130, 10, 'BANDIRMA'),
(131, 10, 'BİGADİÇ'),
(132, 10, 'BURHANİYE'),
(133, 10, 'DURSUNBEY'),
(134, 10, 'EDREMİT'),
(135, 10, 'ERDEK'),
(136, 10, 'GÖMEÇ'),
(137, 10, 'GÖNEN'),
(138, 10, 'HAVRAN'),
(139, 10, 'İVRİNDİ'),
(140, 10, 'KEPSUT'),
(141, 10, 'MANYAS'),
(142, 10, 'MARMARA'),
(143, 10, 'SAVAŞTEPE'),
(144, 10, 'SINDIRGI'),
(145, 10, 'SUSURLUK'),
(146, 11, 'BİLECİK'),
(147, 11, 'BOZÜYÜK'),
(148, 11, 'GÖLPAZARI'),
(149, 11, 'İNHİSAR'),
(150, 11, 'OSMANELİ'),
(151, 11, 'PAZARYERİ'),
(152, 11, 'SÖĞÜT'),
(153, 11, 'YENİPAZAR'),
(154, 12, 'BİNGÖL'),
(155, 12, 'ADAKLI'),
(156, 12, 'GENÇ'),
(157, 12, 'KARLIOVA'),
(158, 12, 'KIĞI'),
(159, 12, 'SOLHAN'),
(160, 12, 'YAYLADERE'),
(161, 12, 'YEDİSU'),
(162, 13, 'BİTLİS'),
(163, 13, 'ADİLCEVAZ'),
(164, 13, 'AHLAT'),
(165, 13, 'GÜROYMAK'),
(166, 13, 'HİZAN'),
(167, 13, 'MUTKİ'),
(168, 13, 'TATVAN'),
(169, 14, 'BOLU'),
(170, 14, 'DÖRTDİVAN'),
(171, 14, 'GEREDE'),
(172, 14, 'GÖYNÜK'),
(173, 14, 'KIBRISCIK'),
(174, 14, 'MENGEN'),
(175, 14, 'MUDURNU'),
(176, 14, 'SEBEN'),
(177, 14, 'YENİÇAĞA'),
(178, 15, 'BURDUR'),
(179, 15, 'AĞLASUN'),
(180, 15, 'ALTINYAYLA(DİRMİL)'),
(181, 15, 'BUCAK'),
(182, 15, 'ÇAVDIR'),
(183, 15, 'ÇELTİKÇİ'),
(184, 15, 'GÖLHİSAR'),
(185, 15, 'KARAMANLI'),
(186, 15, 'KEMER'),
(187, 15, 'TEFENNİ'),
(188, 15, 'YEŞİLOVA'),
(189, 16, 'NİLÜFER'),
(190, 16, 'OSMANGAZİ'),
(191, 16, 'YILDIRIM'),
(192, 16, 'BÜYÜKORHAN'),
(193, 16, 'GEMLİK'),
(194, 16, 'GÜRSU'),
(195, 16, 'HARMANCIK'),
(196, 16, 'İNEGÖL'),
(197, 16, 'İZNİK'),
(198, 16, 'KARACABEY'),
(199, 16, 'KELES'),
(200, 16, 'KESTEL'),
(201, 16, 'MUDANYA'),
(202, 16, 'MUSTAFAKEMALPAŞA'),
(203, 16, 'ORHANELİ'),
(204, 16, 'ORHANGAZİ'),
(205, 16, 'YENİŞEHİR'),
(206, 17, 'ÇANAKKALE'),
(207, 17, 'AYVACIK'),
(208, 17, 'BAYRAMİÇ'),
(209, 17, 'BİGA'),
(210, 17, 'BOZCAADA'),
(211, 17, 'ÇAN'),
(212, 17, 'ECEABAT'),
(213, 17, 'EZİNE'),
(214, 17, 'GELİBOLU'),
(215, 17, 'GÖKÇEADA(İMROZ)'),
(216, 17, 'LAPSEKİ'),
(217, 17, 'YENİCE'),
(218, 18, 'ÇANKIRI'),
(219, 18, 'ATKARACALAR'),
(220, 18, 'BAYRAMÖREN'),
(221, 18, 'ÇERKEŞ'),
(222, 18, 'ELDİVAN'),
(223, 18, 'ILGAZ'),
(224, 18, 'KIZILIRMAK'),
(225, 18, 'KORGUN'),
(226, 18, 'KURŞUNLU'),
(227, 18, 'ORTA'),
(228, 18, 'ŞABANÖZÜ'),
(229, 18, 'YAPRAKLI'),
(230, 19, 'ÇORUM'),
(231, 19, 'ALACA'),
(232, 19, 'BAYAT'),
(233, 19, 'BOĞAZKALE'),
(234, 19, 'DODURGA'),
(235, 19, 'İSKİLİP'),
(236, 19, 'KARGI'),
(237, 19, 'LAÇİN'),
(238, 19, 'MECİTÖZÜ'),
(239, 19, 'OĞUZLAR(KARAÖREN)'),
(240, 19, 'ORTAKÖY'),
(241, 19, 'OSMANCIK'),
(242, 19, 'SUNGURLU'),
(243, 19, 'UĞURLUDAĞ'),
(244, 20, 'DENİZLİ'),
(245, 20, 'ACIPAYAM'),
(246, 20, 'AKKÖY'),
(247, 20, 'BABADAĞ'),
(248, 20, 'BAKLAN'),
(249, 20, 'BEKİLLİ'),
(250, 20, 'BEYAĞAÇ'),
(251, 20, 'BOZKURT'),
(252, 20, 'BULDAN'),
(253, 20, 'ÇAL'),
(254, 20, 'ÇAMELİ'),
(255, 20, 'ÇARDAK'),
(256, 20, 'ÇİVRİL'),
(257, 20, 'GÜNEY'),
(258, 20, 'HONAZ'),
(259, 20, 'KALE'),
(260, 20, 'SARAYKÖY'),
(261, 20, 'SERİNHİSAR'),
(262, 20, 'TAVAS'),
(263, 21, 'SUR'),
(264, 21, 'BAĞLAR'),
(265, 21, 'YENİŞEHİR'),
(266, 21, 'KAYAPINAR'),
(267, 21, 'BİSMİL'),
(268, 21, 'ÇERMİK'),
(269, 21, 'ÇINAR'),
(270, 21, 'ÇÜNGÜŞ'),
(271, 21, 'DİCLE'),
(272, 21, 'EĞİL'),
(273, 21, 'ERGANİ'),
(274, 21, 'HANİ'),
(275, 21, 'HAZRO'),
(276, 21, 'KOCAKÖY'),
(277, 21, 'KULP'),
(278, 21, 'LİCE'),
(279, 21, 'SİLVAN'),
(280, 22, 'EDİRNE'),
(281, 22, 'ENEZ'),
(282, 22, 'HAVSA'),
(283, 22, 'İPSALA'),
(284, 22, 'KEŞAN'),
(285, 22, 'LALAPAŞA'),
(286, 22, 'MERİÇ'),
(287, 22, 'SÜLEOĞLU(SÜLOĞLU)'),
(288, 22, 'UZUNKÖPRÜ'),
(289, 23, 'ELAZIĞ'),
(290, 23, 'AĞIN'),
(291, 23, 'ALACAKAYA'),
(292, 23, 'ARICAK'),
(293, 23, 'BASKİL'),
(294, 23, 'KARAKOÇAN'),
(295, 23, 'KEBAN'),
(296, 23, 'KOVANCILAR'),
(297, 23, 'MADEN'),
(298, 23, 'PALU'),
(299, 23, 'SİVRİCE'),
(300, 24, 'ERZİNCAN'),
(301, 24, 'ÇAYIRLI'),
(302, 24, 'İLİÇ(ILIÇ)'),
(303, 24, 'KEMAH'),
(304, 24, 'KEMALİYE'),
(305, 24, 'OTLUKBELİ'),
(306, 24, 'REFAHİYE'),
(307, 24, 'TERCAN'),
(308, 24, 'ÜZÜMLÜ'),
(309, 25, 'PALANDÖKEN'),
(310, 25, 'YAKUTİYE'),
(311, 25, 'AZİZİYE(ILICA)'),
(312, 25, 'AŞKALE'),
(313, 25, 'ÇAT'),
(314, 25, 'HINIS'),
(315, 25, 'HORASAN'),
(316, 25, 'İSPİR'),
(317, 25, 'KARAÇOBAN'),
(318, 25, 'KARAYAZI'),
(319, 25, 'KÖPRÜKÖY'),
(320, 25, 'NARMAN'),
(321, 25, 'OLTU'),
(322, 25, 'OLUR'),
(323, 25, 'PASİNLER'),
(324, 25, 'PAZARYOLU'),
(325, 25, 'ŞENKAYA'),
(326, 25, 'TEKMAN'),
(327, 25, 'TORTUM'),
(328, 25, 'UZUNDERE'),
(329, 26, 'ODUNPAZARI'),
(330, 26, 'TEPEBAŞI'),
(331, 26, 'ALPU'),
(332, 26, 'BEYLİKOVA'),
(333, 26, 'ÇİFTELER'),
(334, 26, 'GÜNYÜZÜ'),
(335, 26, 'HAN'),
(336, 26, 'İNÖNÜ'),
(337, 26, 'MAHMUDİYE'),
(338, 26, 'MİHALGAZİ'),
(339, 26, 'MİHALIÇCIK'),
(340, 26, 'SARICAKAYA'),
(341, 26, 'SEYİTGAZİ'),
(342, 26, 'SİVRİHİSAR'),
(343, 27, 'ŞAHİNBEY'),
(344, 27, 'ŞEHİTKAMİL'),
(345, 27, 'OĞUZELİ'),
(346, 27, 'ARABAN'),
(347, 27, 'İSLAHİYE'),
(348, 27, 'KARKAMIŞ'),
(349, 27, 'NİZİP'),
(350, 27, 'NURDAĞI'),
(351, 27, 'YAVUZELİ'),
(352, 28, 'GİRESUN'),
(353, 28, 'ALUCRA'),
(354, 28, 'BULANCAK'),
(355, 28, 'ÇAMOLUK'),
(356, 28, 'ÇANAKÇI'),
(357, 28, 'DERELİ'),
(358, 28, 'DOĞANKENT'),
(359, 28, 'ESPİYE'),
(360, 28, 'EYNESİL'),
(361, 28, 'GÖRELE'),
(362, 28, 'GÜCE'),
(363, 28, 'KEŞAP'),
(364, 28, 'PİRAZİZ'),
(365, 28, 'ŞEBİNKARAHİSAR'),
(366, 28, 'TİREBOLU'),
(367, 28, 'YAĞLIDERE'),
(368, 29, 'GÜMÜŞHANE'),
(369, 29, 'KELKİT'),
(370, 29, 'KÖSE'),
(371, 29, 'KÜRTÜN'),
(372, 29, 'ŞİRAN'),
(373, 29, 'TORUL'),
(374, 30, 'HAKKARİ'),
(375, 30, 'ÇUKURCA'),
(376, 30, 'ŞEMDİNLİ'),
(377, 30, 'YÜKSEKOVA'),
(378, 31, 'ANTAKYA'),
(379, 31, 'ALTINÖZÜ'),
(380, 31, 'BELEN'),
(381, 31, 'DÖRTYOL'),
(382, 31, 'ERZİN'),
(383, 31, 'HASSA'),
(384, 31, 'İSKENDERUN'),
(385, 31, 'KIRIKHAN'),
(386, 31, 'KUMLU'),
(387, 31, 'REYHANLI'),
(388, 31, 'SAMANDAĞ'),
(389, 31, 'YAYLADAĞI'),
(390, 32, 'ISPARTA'),
(391, 32, 'AKSU'),
(392, 32, 'ATABEY'),
(393, 32, 'EĞRİDİR(EĞİRDİR)'),
(394, 32, 'GELENDOST'),
(395, 32, 'GÖNEN'),
(396, 32, 'KEÇİBORLU'),
(397, 32, 'SENİRKENT'),
(398, 32, 'SÜTÇÜLER'),
(399, 32, 'ŞARKİKARAAĞAÇ'),
(400, 32, 'ULUBORLU'),
(401, 32, 'YALVAÇ'),
(402, 32, 'YENİŞARBADEMLİ'),
(403, 33, 'AKDENİZ'),
(404, 33, 'YENİŞEHİR'),
(405, 33, 'TOROSLAR'),
(406, 33, 'MEZİTLİ'),
(407, 33, 'ANAMUR'),
(408, 33, 'AYDINCIK'),
(409, 33, 'BOZYAZI'),
(410, 33, 'ÇAMLIYAYLA'),
(411, 33, 'ERDEMLİ'),
(412, 33, 'GÜLNAR(GÜLPINAR)'),
(413, 33, 'MUT'),
(414, 33, 'SİLİFKE'),
(415, 33, 'TARSUS'),
(416, 34, 'BAKIRKÖY'),
(417, 34, 'BAYRAMPAŞA'),
(418, 34, 'BEŞİKTAŞ'),
(419, 34, 'BEYOĞLU'),
(420, 34, 'ARNAVUTKÖY'),
(421, 34, 'EYÜP'),
(422, 34, 'FATİH'),
(423, 34, 'GAZİOSMANPAŞA'),
(424, 34, 'KAĞITHANE'),
(425, 34, 'KÜÇÜKÇEKMECE'),
(426, 34, 'SARIYER'),
(427, 34, 'ŞİŞLİ'),
(428, 34, 'ZEYTİNBURNU'),
(429, 34, 'AVCILAR'),
(430, 34, 'GÜNGÖREN'),
(431, 34, 'BAHÇELİEVLER'),
(432, 34, 'BAĞCILAR'),
(433, 34, 'ESENLER'),
(434, 34, 'BAŞAKŞEHİR'),
(435, 34, 'BEYLİKDÜZÜ'),
(436, 34, 'ESENYURT'),
(437, 34, 'SULTANGAZİ'),
(438, 34, 'ADALAR'),
(439, 34, 'BEYKOZ'),
(440, 34, 'KADIKÖY'),
(441, 34, 'KARTAL'),
(442, 34, 'PENDİK'),
(443, 34, 'ÜMRANİYE'),
(444, 34, 'ÜSKÜDAR'),
(445, 34, 'TUZLA'),
(446, 34, 'MALTEPE'),
(447, 34, 'ATAŞEHİR'),
(448, 34, 'ÇEKMEKÖY'),
(449, 34, 'SANCAKTEPE'),
(450, 34, 'BÜYÜKÇEKMECE'),
(451, 34, 'ÇATALCA'),
(452, 34, 'SİLİVRİ'),
(453, 34, 'ŞİLE'),
(454, 34, 'SULTANBEYLİ'),
(455, 35, 'ALİAĞA'),
(456, 35, 'BALÇOVA'),
(457, 35, 'BAYINDIR'),
(458, 35, 'BORNOVA'),
(459, 35, 'BUCA'),
(460, 35, 'ÇİĞLİ'),
(461, 35, 'FOÇA'),
(462, 35, 'GAZİEMİR'),
(463, 35, 'GÜZELBAHÇE'),
(464, 35, 'KARŞIYAKA'),
(465, 35, 'KEMALPAŞA'),
(466, 35, 'KONAK'),
(467, 35, 'CUMAOVASI(MENDERES)'),
(468, 35, 'MENEMEN'),
(469, 35, 'NARLIDERE'),
(470, 35, 'SEFERİHİSAR'),
(471, 35, 'SELÇUK'),
(472, 35, 'TORBALI'),
(473, 35, 'URLA'),
(474, 35, 'BAYRAKLI'),
(475, 35, 'KARABAĞLAR'),
(476, 35, 'BERGAMA'),
(477, 35, 'BEYDAĞ'),
(478, 35, 'ÇEŞME'),
(479, 35, 'DİKİLİ'),
(480, 35, 'KARABURUN'),
(481, 35, 'KINIK'),
(482, 35, 'KİRAZ'),
(483, 35, 'ÖDEMİŞ'),
(484, 35, 'TİRE'),
(485, 36, 'KARS'),
(486, 36, 'AKYAKA'),
(487, 36, 'ARPAÇAY'),
(488, 36, 'DİGOR'),
(489, 36, 'KAĞIZMAN'),
(490, 36, 'SARIKAMIŞ'),
(491, 36, 'SELİM'),
(492, 36, 'SUSUZ'),
(493, 37, 'KASTAMONU'),
(494, 37, 'ABANA'),
(495, 37, 'AĞLI'),
(496, 37, 'ARAÇ'),
(497, 37, 'AZDAVAY'),
(498, 37, 'BOZKURT'),
(499, 37, 'CİDE'),
(500, 37, 'ÇATALZEYTİN'),
(501, 37, 'DADAY'),
(502, 37, 'DEVREKANİ'),
(503, 37, 'DOĞANYURT'),
(504, 37, 'HANÖNÜ(GÖKÇEAĞAÇ)'),
(505, 37, 'İHSANGAZİ'),
(506, 37, 'İNEBOLU'),
(507, 37, 'KÜRE'),
(508, 37, 'PINARBAŞI'),
(509, 37, 'SEYDİLER'),
(510, 37, 'ŞENPAZAR'),
(511, 37, 'TAŞKÖPRÜ'),
(512, 37, 'TOSYA'),
(513, 38, 'KOCASİNAN'),
(514, 38, 'MELİKGAZİ'),
(515, 38, 'TALAS'),
(516, 38, 'AKKIŞLA'),
(517, 38, 'BÜNYAN'),
(518, 38, 'DEVELİ'),
(519, 38, 'FELAHİYE'),
(520, 38, 'HACILAR'),
(521, 38, 'İNCESU'),
(522, 38, 'ÖZVATAN(ÇUKUR)'),
(523, 38, 'PINARBAŞI'),
(524, 38, 'SARIOĞLAN'),
(525, 38, 'SARIZ'),
(526, 38, 'TOMARZA'),
(527, 38, 'YAHYALI'),
(528, 38, 'YEŞİLHİSAR'),
(529, 39, 'KIRKLARELİ'),
(530, 39, 'BABAESKİ'),
(531, 39, 'DEMİRKÖY'),
(532, 39, 'KOFÇAZ'),
(533, 39, 'LÜLEBURGAZ'),
(534, 39, 'PEHLİVANKÖY'),
(535, 39, 'PINARHİSAR'),
(536, 39, 'VİZE'),
(537, 40, 'KIRŞEHİR'),
(538, 40, 'AKÇAKENT'),
(539, 40, 'AKPINAR'),
(540, 40, 'BOZTEPE'),
(541, 40, 'ÇİÇEKDAĞI'),
(542, 40, 'KAMAN'),
(543, 40, 'MUCUR'),
(544, 41, 'İZMİT'),
(545, 41, 'BAŞİSKELE'),
(546, 41, 'ÇAYIROVA'),
(547, 41, 'DARICA'),
(548, 41, 'DİLOVASI'),
(549, 41, 'KARTEPE'),
(550, 41, 'GEBZE'),
(551, 41, 'GÖLCÜK'),
(552, 41, 'KANDIRA'),
(553, 41, 'KARAMÜRSEL'),
(554, 41, 'TÜTÜNÇİFTLİK'),
(555, 41, 'DERİNCE'),
(556, 42, 'KARATAY'),
(557, 42, 'MERAM'),
(558, 42, 'SELÇUKLU'),
(559, 42, 'AHIRLI'),
(560, 42, 'AKÖREN'),
(561, 42, 'AKŞEHİR'),
(562, 42, 'ALTINEKİN'),
(563, 42, 'BEYŞEHİR'),
(564, 42, 'BOZKIR'),
(565, 42, 'CİHANBEYLİ'),
(566, 42, 'ÇELTİK'),
(567, 42, 'ÇUMRA'),
(568, 42, 'DERBENT'),
(569, 42, 'DEREBUCAK'),
(570, 42, 'DOĞANHİSAR'),
(571, 42, 'EMİRGAZİ'),
(572, 42, 'EREĞLİ'),
(573, 42, 'GÜNEYSINIR'),
(574, 42, 'HADİM'),
(575, 42, 'HALKAPINAR'),
(576, 42, 'HÜYÜK'),
(577, 42, 'ILGIN'),
(578, 42, 'KADINHANI'),
(579, 42, 'KARAPINAR'),
(580, 42, 'KULU'),
(581, 42, 'SARAYÖNÜ'),
(582, 42, 'SEYDİŞEHİR'),
(583, 42, 'TAŞKENT'),
(584, 42, 'TUZLUKÇU'),
(585, 42, 'YALIHÜYÜK'),
(586, 42, 'YUNAK'),
(587, 43, 'KÜTAHYA'),
(588, 43, 'ALTINTAŞ'),
(589, 43, 'ASLANAPA'),
(590, 43, 'ÇAVDARHİSAR'),
(591, 43, 'DOMANİÇ'),
(592, 43, 'DUMLUPINAR'),
(593, 43, 'EMET'),
(594, 43, 'GEDİZ'),
(595, 43, 'HİSARCIK'),
(596, 43, 'PAZARLAR'),
(597, 43, 'SİMAV'),
(598, 43, 'ŞAPHANE'),
(599, 43, 'TAVŞANLI'),
(600, 43, 'TUNÇBİLEK'),
(601, 44, 'MALATYA'),
(602, 44, 'AKÇADAĞ'),
(603, 44, 'ARAPKİR'),
(604, 44, 'ARGUVAN'),
(605, 44, 'BATTALGAZİ'),
(606, 44, 'DARENDE'),
(607, 44, 'DOĞANŞEHİR'),
(608, 44, 'DOĞANYOL'),
(609, 44, 'HEKİMHAN'),
(610, 44, 'KALE'),
(611, 44, 'KULUNCAK'),
(612, 44, 'PÖTÜRGE'),
(613, 44, 'YAZIHAN'),
(614, 44, 'YEŞİLYURT'),
(615, 45, 'MANİSA'),
(616, 45, 'AHMETLİ'),
(617, 45, 'AKHİSAR'),
(618, 45, 'ALAŞEHİR'),
(619, 45, 'DEMİRCİ'),
(620, 45, 'GÖLMARMARA'),
(621, 45, 'GÖRDES'),
(622, 45, 'KIRKAĞAÇ'),
(623, 45, 'KÖPRÜBAŞI'),
(624, 45, 'KULA'),
(625, 45, 'SALİHLİ'),
(626, 45, 'SARIGÖL'),
(627, 45, 'SARUHANLI'),
(628, 45, 'SELENDİ'),
(629, 45, 'SOMA'),
(630, 45, 'TURGUTLU'),
(631, 46, 'KAHRAMANMARAŞ'),
(632, 46, 'AFŞİN'),
(633, 46, 'ANDIRIN'),
(634, 46, 'ÇAĞLAYANCERİT'),
(635, 46, 'EKİNÖZÜ'),
(636, 46, 'ELBİSTAN'),
(637, 46, 'GÖKSUN'),
(638, 46, 'NURHAK'),
(639, 46, 'PAZARCIK'),
(640, 46, 'TÜRKOĞLU'),
(641, 47, 'MARDİN'),
(642, 47, 'DARGEÇİT'),
(643, 47, 'DERİK'),
(644, 47, 'KIZILTEPE'),
(645, 47, 'MAZIDAĞI'),
(646, 47, 'MİDYAT(ESTEL)'),
(647, 47, 'NUSAYBİN'),
(648, 47, 'ÖMERLİ'),
(649, 47, 'SAVUR'),
(650, 47, 'YEŞİLLİ'),
(651, 48, 'MUĞLA'),
(652, 48, 'BODRUM'),
(653, 48, 'DALAMAN'),
(654, 48, 'DATÇA'),
(655, 48, 'FETHİYE'),
(656, 48, 'KAVAKLIDERE'),
(657, 48, 'KÖYCEĞİZ'),
(658, 48, 'MARMARİS'),
(659, 48, 'MİLAS'),
(660, 48, 'ORTACA'),
(661, 48, 'ULA'),
(662, 48, 'YATAĞAN'),
(663, 49, 'MUŞ'),
(664, 49, 'BULANIK'),
(665, 49, 'HASKÖY'),
(666, 49, 'KORKUT'),
(667, 49, 'MALAZGİRT'),
(668, 49, 'VARTO'),
(669, 50, 'NEVŞEHİR'),
(670, 50, 'ACIGÖL'),
(671, 50, 'AVANOS'),
(672, 50, 'DERİNKUYU'),
(673, 50, 'GÜLŞEHİR'),
(674, 50, 'HACIBEKTAŞ'),
(675, 50, 'KOZAKLI'),
(676, 50, 'ÜRGÜP'),
(677, 51, 'NİĞDE'),
(678, 51, 'ALTUNHİSAR'),
(679, 51, 'BOR'),
(680, 51, 'ÇAMARDI'),
(681, 51, 'ÇİFTLİK(ÖZYURT)'),
(682, 51, 'ULUKIŞLA'),
(683, 52, 'ORDU'),
(684, 52, 'AKKUŞ'),
(685, 52, 'AYBASTI'),
(686, 52, 'ÇAMAŞ'),
(687, 52, 'ÇATALPINAR'),
(688, 52, 'ÇAYBAŞI'),
(689, 52, 'FATSA'),
(690, 52, 'GÖLKÖY'),
(691, 52, 'GÜLYALI'),
(692, 52, 'GÜRGENTEPE'),
(693, 52, 'İKİZCE'),
(694, 52, 'KARADÜZ(KABADÜZ)'),
(695, 52, 'KABATAŞ'),
(696, 52, 'KORGAN'),
(697, 52, 'KUMRU'),
(698, 52, 'MESUDİYE'),
(699, 52, 'PERŞEMBE'),
(700, 52, 'ULUBEY'),
(701, 52, 'ÜNYE'),
(702, 53, 'RİZE'),
(703, 53, 'ARDEŞEN'),
(704, 53, 'ÇAMLIHEMŞİN'),
(705, 53, 'ÇAYELİ'),
(706, 53, 'DEREPAZARI'),
(707, 53, 'FINDIKLI'),
(708, 53, 'GÜNEYSU'),
(709, 53, 'HEMŞİN'),
(710, 53, 'İKİZDERE'),
(711, 53, 'İYİDERE'),
(712, 53, 'KALKANDERE'),
(713, 53, 'PAZAR'),
(714, 54, 'ADAPAZARI'),
(715, 54, 'HENDEK'),
(716, 54, 'ARİFİYE'),
(717, 54, 'ERENLER'),
(718, 54, 'SERDİVAN'),
(719, 54, 'AKYAZI'),
(720, 54, 'FERİZLİ'),
(721, 54, 'GEYVE'),
(722, 54, 'KARAPÜRÇEK'),
(723, 54, 'KARASU'),
(724, 54, 'KAYNARCA'),
(725, 54, 'KOCAALİ'),
(726, 54, 'PAMUKOVA'),
(727, 54, 'SAPANCA'),
(728, 54, 'SÖĞÜTLÜ'),
(729, 54, 'TARAKLI'),
(730, 55, 'ATAKUM'),
(731, 55, 'İLKADIM'),
(732, 55, 'CANİK'),
(733, 55, 'TEKKEKÖY'),
(734, 55, 'ALAÇAM'),
(735, 55, 'ASARCIK'),
(736, 55, 'AYVACIK'),
(737, 55, 'BAFRA'),
(738, 55, 'ÇARŞAMBA'),
(739, 55, 'HAVZA'),
(740, 55, 'KAVAK'),
(741, 55, 'LADİK'),
(742, 55, '19MAYIS(BALLICA)'),
(743, 55, 'SALIPAZARI'),
(744, 55, 'TERME'),
(745, 55, 'VEZİRKÖPRÜ'),
(746, 55, 'YAKAKENT'),
(747, 56, 'SİİRT'),
(748, 56, 'BAYKAN'),
(749, 56, 'ERUH'),
(750, 56, 'KURTALAN'),
(751, 56, 'PERVARİ'),
(752, 56, 'AYDINLAR'),
(753, 56, 'ŞİRVAN'),
(754, 57, 'SİNOP'),
(755, 57, 'AYANCIK'),
(756, 57, 'BOYABAT'),
(757, 57, 'DİKMEN'),
(758, 57, 'DURAĞAN'),
(759, 57, 'ERFELEK'),
(760, 57, 'GERZE'),
(761, 57, 'SARAYDÜZÜ'),
(762, 57, 'TÜRKELİ'),
(763, 58, 'SİVAS'),
(764, 58, 'AKINCILAR'),
(765, 58, 'ALTINYAYLA'),
(766, 58, 'DİVRİĞİ'),
(767, 58, 'DOĞANŞAR'),
(768, 58, 'GEMEREK'),
(769, 58, 'GÖLOVA'),
(770, 58, 'GÜRÜN'),
(771, 58, 'HAFİK'),
(772, 58, 'İMRANLI'),
(773, 58, 'KANGAL'),
(774, 58, 'KOYULHİSAR'),
(775, 58, 'SUŞEHRİ'),
(776, 58, 'ŞARKIŞLA'),
(777, 58, 'ULAŞ'),
(778, 58, 'YILDIZELİ'),
(779, 58, 'ZARA'),
(780, 59, 'TEKİRDAĞ'),
(781, 59, 'ÇERKEZKÖY'),
(782, 59, 'ÇORLU'),
(783, 59, 'HAYRABOLU'),
(784, 59, 'MALKARA'),
(785, 59, 'MARMARAEREĞLİSİ'),
(786, 59, 'MURATLI'),
(787, 59, 'SARAY'),
(788, 59, 'ŞARKÖY'),
(789, 60, 'TOKAT'),
(790, 60, 'ALMUS'),
(791, 60, 'ARTOVA'),
(792, 60, 'BAŞÇİFTLİK'),
(793, 60, 'ERBAA'),
(794, 60, 'NİKSAR'),
(795, 60, 'PAZAR'),
(796, 60, 'REŞADİYE'),
(797, 60, 'SULUSARAY'),
(798, 60, 'TURHAL'),
(799, 60, 'YEŞİLYURT'),
(800, 60, 'ZİLE'),
(801, 61, 'TRABZON'),
(802, 61, 'AKÇAABAT'),
(803, 61, 'ARAKLI'),
(804, 61, 'ARSİN'),
(805, 61, 'BEŞİKDÜZÜ'),
(806, 61, 'ÇARŞIBAŞI'),
(807, 61, 'ÇAYKARA'),
(808, 61, 'DERNEKPAZARI'),
(809, 61, 'DÜZKÖY'),
(810, 61, 'HAYRAT'),
(811, 61, 'KÖPRÜBAŞI'),
(812, 61, 'MAÇKA'),
(813, 61, 'OF'),
(814, 61, 'SÜRMENE'),
(815, 61, 'ŞALPAZARI'),
(816, 61, 'TONYA'),
(817, 61, 'VAKFIKEBİR'),
(818, 61, 'YOMRA'),
(819, 62, 'TUNCELİ'),
(820, 62, 'ÇEMİŞGEZEK'),
(821, 62, 'HOZAT'),
(822, 62, 'MAZGİRT'),
(823, 62, 'NAZIMİYE'),
(824, 62, 'OVACIK'),
(825, 62, 'PERTEK'),
(826, 62, 'PÜLÜMÜR'),
(827, 63, 'ŞANLIURFA'),
(828, 63, 'AKÇAKALE'),
(829, 63, 'BİRECİK'),
(830, 63, 'BOZOVA'),
(831, 63, 'CEYLANPINAR'),
(832, 63, 'HALFETİ'),
(833, 63, 'HARRAN'),
(834, 63, 'HİLVAN'),
(835, 63, 'SİVEREK'),
(836, 63, 'SURUÇ'),
(837, 63, 'VİRANŞEHİR'),
(838, 64, 'UŞAK'),
(839, 64, 'BANAZ'),
(840, 64, 'EŞME'),
(841, 64, 'KARAHALLI'),
(842, 64, 'SİVASLI'),
(843, 64, 'ULUBEY'),
(844, 65, 'VAN'),
(845, 65, 'BAHÇESARAY'),
(846, 65, 'BAŞKALE'),
(847, 65, 'ÇALDIRAN'),
(848, 65, 'ÇATAK'),
(849, 65, 'EDREMİT(GÜMÜŞDERE)'),
(850, 65, 'ERCİŞ'),
(851, 65, 'GEVAŞ'),
(852, 65, 'GÜRPINAR'),
(853, 65, 'MURADİYE'),
(854, 65, 'ÖZALP'),
(855, 65, 'SARAY'),
(856, 66, 'YOZGAT'),
(857, 66, 'AKDAĞMADENİ'),
(858, 66, 'AYDINCIK'),
(859, 66, 'BOĞAZLIYAN'),
(860, 66, 'ÇANDIR'),
(861, 66, 'ÇAYIRALAN'),
(862, 66, 'ÇEKEREK'),
(863, 66, 'KADIŞEHRİ'),
(864, 66, 'SARAYKENT'),
(865, 66, 'SARIKAYA'),
(866, 66, 'SORGUN'),
(867, 66, 'ŞEFAATLİ'),
(868, 66, 'YENİFAKILI'),
(869, 66, 'YERKÖY'),
(870, 67, 'ZONGULDAK'),
(871, 67, 'ALAPLI'),
(872, 67, 'ÇAYCUMA'),
(873, 67, 'DEVREK'),
(874, 67, 'KARADENİZEREĞLİ'),
(875, 67, 'GÖKÇEBEY'),
(876, 68, 'AKSARAY'),
(877, 68, 'AĞAÇÖREN'),
(878, 68, 'ESKİL'),
(879, 68, 'GÜLAĞAÇ(AĞAÇLI)'),
(880, 68, 'GÜZELYURT'),
(881, 68, 'ORTAKÖY'),
(882, 68, 'SARIYAHŞİ'),
(883, 69, 'BAYBURT'),
(884, 69, 'AYDINTEPE'),
(885, 69, 'DEMİRÖZÜ'),
(886, 70, 'KARAMAN'),
(887, 70, 'AYRANCI'),
(888, 70, 'BAŞYAYLA'),
(889, 70, 'ERMENEK'),
(890, 70, 'KAZIMKARABEKİR'),
(891, 70, 'SARIVELİLER'),
(892, 71, 'KIRIKKALE'),
(893, 71, 'BAHŞİLİ'),
(894, 71, 'BALIŞEYH'),
(895, 71, 'ÇELEBİ'),
(896, 71, 'DELİCE'),
(897, 71, 'KARAKEÇİLİ'),
(898, 71, 'KESKİN'),
(899, 71, 'SULAKYURT'),
(900, 71, 'YAHŞİHAN'),
(901, 72, 'BATMAN'),
(902, 72, 'BEŞİRİ'),
(903, 72, 'GERCÜŞ'),
(904, 72, 'HASANKEYF'),
(905, 72, 'KOZLUK'),
(906, 72, 'SASON'),
(907, 73, 'ŞIRNAK'),
(908, 73, 'BEYTÜŞŞEBAP'),
(909, 73, 'CİZRE'),
(910, 73, 'GÜÇLÜKONAK'),
(911, 73, 'İDİL'),
(912, 73, 'SİLOPİ'),
(913, 73, 'ULUDERE'),
(914, 74, 'BARTIN'),
(915, 74, 'AMASRA'),
(916, 74, 'KURUCAŞİLE'),
(917, 74, 'ULUS'),
(918, 75, 'ARDAHAN'),
(919, 75, 'ÇILDIR'),
(920, 75, 'DAMAL'),
(921, 75, 'GÖLE'),
(922, 75, 'HANAK'),
(923, 75, 'POSOF'),
(924, 76, 'IĞDIR'),
(925, 76, 'ARALIK'),
(926, 76, 'KARAKOYUNLU'),
(927, 76, 'TUZLUCA'),
(928, 77, 'YALOVA'),
(929, 77, 'ALTINOVA'),
(930, 77, 'ARMUTLU'),
(931, 77, 'ÇİFTLİKKÖY'),
(932, 77, 'ÇINARCIK'),
(933, 77, 'TERMAL'),
(934, 78, 'KARABÜK'),
(935, 78, 'EFLANİ'),
(936, 78, 'ESKİPAZAR'),
(937, 78, 'OVACIK'),
(938, 78, 'SAFRANBOLU'),
(939, 78, 'YENİCE'),
(940, 79, 'KİLİS'),
(941, 79, 'ELBEYLİ'),
(942, 79, 'MUSABEYLİ'),
(943, 79, 'POLATELİ'),
(944, 80, 'OSMANİYE'),
(945, 80, 'BAHÇE'),
(946, 80, 'DÜZİÇİ'),
(947, 80, 'HASANBEYLİ'),
(948, 80, 'KADİRLİ'),
(949, 80, 'SUMBAS'),
(950, 80, 'TOPRAKKALE'),
(951, 81, 'DÜZCE'),
(952, 81, 'AKÇAKOCA'),
(953, 81, 'CUMAYERİ'),
(954, 81, 'ÇİLİMLİ'),
(955, 81, 'GÖLYAKA'),
(956, 81, 'GÜMÜŞOVA'),
(957, 81, 'KAYNAŞLI'),
(958, 81, 'YIĞILCA');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_ayar`
--

CREATE TABLE `i_ayar` (
  `id` int(11) NOT NULL,
  `site_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ana site linki',
  `bakim_modu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Yayında, 1: Bakım Modunda',
  `modul_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Admin modül aç/kapat yönetimi',
  `seo_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `site_iletisim` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sosyal_medya` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `mail_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sms_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `api_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pos_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `banka_bilgiler` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sepet_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `fatura_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `tema_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `dil_ayarlari` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `tarihce` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `koyu_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giris_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `popup_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_maps` text COLLATE utf8mb4_unicode_ci,
  `kullanim_kilavuzu` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_ayar`
--

INSERT INTO `i_ayar` (`id`, `site_url`, `bakim_modu`, `modul_ayarlari`, `seo_ayarlari`, `site_iletisim`, `sosyal_medya`, `mail_ayarlari`, `sms_ayarlari`, `api_ayarlari`, `pos_ayarlari`, `banka_bilgiler`, `sepet_ayarlari`, `fatura_ayarlari`, `tema_ayarlari`, `dil_ayarlari`, `tarihce`, `api_token`, `logo`, `koyu_logo`, `favicon`, `giris_resim`, `popup_resim`, `google_maps`, `kullanim_kilavuzu`) VALUES
(1, 'https://www.demositesi.net/ivesgo-panel/', 0, '{\"sms_bildirimleri\":\"1\",\"urunler\":\"1\",\"kategoriler\":\"1\",\"blog\":\"1\",\"sayfa\":\"1\",\"yorumlar\":\"1\",\"galeri\":\"1\",\"slider\":\"1\",\"sss\":\"1\",\"tarihce\":\"1\",\"iletisim\":\"1\",\"ekibimiz\":\"1\",\"menu\":\"1\",\"sabit-sayfa\":\"1\",\"sabit-resim\":\"1\",\"mail\":\"1\",\"bakim\":\"1\",\"raporlar\":\"1\"}', '{\"title\":\"İvesgo CRM | CRM Hizmetleri\",\"description\":\"İvesgo CRM Hizmetleri \"}', '[{\"tip\":\"1\",\"value\":\"0212 000 00 00\"},{\"tip\":\"2\",\"value\":\"destek@ivesgo.com\"},{\"tip\":\"3\",\"value\":\"adres\"},{\"tip\":\"4\",\"value\":\"0500 000 00 00\"},{\"tip\":\"5\",\"value\":\"90 500 000 00 00\"}]', '[{\"platform\":\"Instagram\",\"url\":\"#1\"},{\"platform\":\"Facebook\",\"url\":\"#2\"},{\"platform\":\"LinkedIn\",\"url\":\"#3\"}]', '{\"host\":\"mail.mobilapple.com\",\"port\":\"465\",\"user\":\"send@mobilapple.com\",\"pass\":\"Irm#F&5V{=*E\",\"alici\":\"destek@ivesgo.com\",\"isim\":\"destek@mobilapple.com\"}', '{\"firma\":\"0\",\"kullanici\":\"2129091303\",\"sifre\":\"15E3891\",\"baslik\":\"IVESGO\"}', '{}', '{\"aktif_pos\":\"0\",\"paytr\":{\"merchant_id\":\"id\",\"merchant_key\":\"key\",\"merchant_salt\":\"salt\"},\"iyzico\":{\"api_key\":\"\",\"secret_key\":\"\"},\"moka\":{\"moka_id\":\"1\",\"moka_username\":\"1\",\"moka_password\":\"1\"}}', '[{\"banka\":\"garanti\",\"para_birim\":\"TRY\",\"iban\":\"tr01001\"},{\"banka\":\"akbank\",\"para_birim\":\"EURO\",\"iban\":\"tr01002\"}]', '{\"min_sepet\":\"1500\",\"kargo_ucret\":\"200\",\"aktif_odemeler\":{\"kredi_karti\":\"1\",\"havale_eft\":\"1\"}}', NULL, '{\"tema_ayar\":{\"fonts_url\":\"Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap\",\"analytics\":\"AW-17353048700\",\"verification\":\"4423432432\",\"tag_manager\":\"G-F5C6DT795B\",\"facebook_pixel\":\"pixel\",\"linkedin_partner_id\":\"linkedin\",\"captcha\":\"recapthe\",\"captchaKey\":\"recapthe secret\",\"ga_property_id\":\"316930347\",\"tawk_id\":\"4324324fdsfds\",\"crisp_id\":\"432432fsfd\",\"whatsapp_tel\":\"9800084\",\"site_durum\":\"1\",\"bakim_bitis_tarihi\":\"2026-10-30T10:43\",\"topbar\":\"1\",\"slider\":\"1\",\"about\":\"1\",\"popup\":\"1\",\"cookie\":\"1\",\"lang\":\"1\",\"google_key_file\":\"google-key.json\"},\"renkler\":[{\"name\":\"--primary-color\",\"value\":\"#18304f\"},{\"name\":\"--accept\",\"value\":\"#ddd0\"}]}', '[{\"title\":\"firma_adi\",\"value\":\"İvesgo CRM\"},{\"title\":\"resim_on_ek\",\"value\":\"ivesgo-crm-\"},{\"title\":\"copyright\",\"value\":\"İvesgo CRM Sistemi\"},{\"title\":\"profil_blok_1\",\"value\":\"Özel kampanyalardan ve yeni koleksiyonlardan öncelikli olarak haberdar edilsin.\"}]', '[{\"yil\":\"2000\",\"baslik\":\"Kuruluş\",\"aciklama\":\"sdadsadasd ada dad \"}]', '9fc84b699979fe894297ddad2ddc2224cb5ef1a73310ec6256bb18ebe90c998f', 'ivesgo-crm-6ab28750f120f.png', 'ivesgo-crm-6ab52ccd39981.png', 'favicon_6ab288d2147b2_512.png', 'ivesgo-crm-6ab287fa3df8b.jpg', NULL, '', '[{\"baslik\":\"1. Genel Bakış, Yetkiler ve Güvenlik\",\"sorular\":[{\"soru\":\"Yönetim paneline giriş yaptıktan sonra ana sayfada neler görürüm?\",\"cevap\":\"Süper Admin (Rütbe 1), Yönetici (Rütbe 2) veya \'Raporlar\' görüntüleme yetkisi olan kullanıcılar ciro grafiklerini, toplam müşteri bakiyesini ve finansal özetleri görürler. Bu yetkilere sahip olmayan personeller ise hızlı işlem kısayolları ve kişisel durum paneli ile karşılaşırlar.\"},{\"soru\":\"Sistem üzerinde silme ve pasife alma işlemleri yetkilere göre nasıl yapılır?\",\"cevap\":\"Her modül için silme işlemi yalnızca ilgili modülde \'Sil\' yetkisi bulunan kullanıcılara açıktır. Yetkisi olmayan kullanıcıların arayüzünde silme butonları gizlenir ve doğrudan URL\\/AJAX ile erişim engellenerek loglanır. Pasife alma (durum değiştirme) işlemleri ise \'Düzenle\' yetkisi dahilinde switch anahtarları üzerinden gerçekleştirilir.\"},{\"soru\":\"Sistemde silinen veriler ve yedekleme politikası nasıl çalışır?\",\"cevap\":\"Sistemden silinen her türlü kritik veri ve kayıt güvenilirlik açısından otomatik olarak günlük rutin yedekleme mekanizmasına dahil edilir. Böylece olası veri kayıplarının önüne geçilir.\"},{\"soru\":\"Bir veri silindiğinde yüklenen resimlere ne olur?\",\"cevap\":\"Sistemde herhangi bir ürün, müşteri veya personel kaydı silindiğinde, o kayda ait sunucuda depolanan resim dosyaları da sunucu alanından tamamen silinir ve yer açılır.\"},{\"soru\":\"Sol menüdeki aktif sayfa yönlendirmeleri nasıl çalışır?\",\"cevap\":\"Sistem URL adresinizi otomatik algılar; alt menüsü olan ana başlıklar yalnızca ilgili alt sayfadaysanız otomatik olarak açılır ve aktif sınıfı alır.\"}]},{\"baslik\":\"2. Ayarlar Modülü\",\"sorular\":[{\"soru\":\"Ayarlar modülü ne işe yarar ve kimler erişebilir?\",\"cevap\":\"Ayarlar modülü; sistem genelindeki kurumsal bilgilerin, entegrasyon parametrelerinin, site başlıklarının ve kullanım kılavuzu içeriklerinin yönetildiği alandır. Yalnızca \'Ayarlar\' modülünde tam yetkisi olan yöneticiler bu alanı düzenleyebilir.\"},{\"soru\":\"Ayarlar sayfasında hangi yapılandırmalar yapılabilir?\",\"cevap\":\"Bu modül üzerinden CRM\'in temel çalışma parametreleri, API anahtarları, bildirim tercihleri ve sistem genelini etkileyen güncellemeler güvenli bir şekilde yönetilir.\"},{\"soru\":\"Ayarlarda yapılan değişiklikler ne zaman geçerli olur?\",\"cevap\":\"Kaydet butonuna basıldıktan sonra yapılan tüm sistem ayarları anlık olarak veritabanına işlenir ve tüm platformda hemen geçerli olur.\"},{\"soru\":\"Ayarlar modülünde yetki kısıtlaması nasıl uygulanır?\",\"cevap\":\"Yetkisi olmayan personeller ayarlar sayfasına girmeye çalıştığında sistem tarafından engellenir ve güvenlik loglarına kayıt atılır.\"},{\"soru\":\"Kullanım kılavuzu içeriği ayarlardan nasıl güncellenir?\",\"cevap\":\"Yöneticiler, kılavuz yönetim paneli üzerinden modül başlıkları ekleyebilir ve alt SSS satırlarını (add row \\/ clone mantığıyla) çoğaltarak güncel dokümantasyon oluşturabilir.\"}]},{\"baslik\":\"3. Müşteri & Cari Yönetimi (Müşteri İşlemleri)\",\"sorular\":[{\"soru\":\"Yeni bir müşteri sisteme nasıl eklenir?\",\"cevap\":\"1. \'Müşteriler\' modülüne gidin ve \'Yeni Müşteri Ekle\'ye tıklayın.\\r\\n2. **Müşteri Adı\\/Unvanı** ve **Telefon Numarası** zorunlu alanlardır; e-posta ve adres bilgilerini tamamlayın.\\r\\n3. Kaydet butonuna basın (\'Müşteriler - Ekle\' yetkisi gerekir).\"},{\"soru\":\"Müşteri silme veya pasife alma işlemi nasıl yapılır?\",\"cevap\":\"Müşteriler \'Müşteriler - Sil\' yetkisiyle tamamen silinebilir (bu durumda ilişkili resimler de silinir) ya da durum anahtarı kapatılarak pasif konuma getirilebilir.\"},{\"soru\":\"Müşteri cari bilgileri ve bakiyeleri nasıl güncellenir?\",\"cevap\":\"Müşteri listesindeki düzenle butonu kullanılarak cari bilgileri güncellenir. İşlem \'Müşteriler - Düzenle\' yetkisine bağlıdır.\"},{\"soru\":\"Müşteri listesinde arama ve filtreleme nasıl yapılır?\",\"cevap\":\"Müşteriler modülü içindeki arama çubuğu kullanılarak ad, telefon veya e-posta bilgisine göre saniyeler içinde filtreleme yapılabilir.\"},{\"soru\":\"Müşteri detaylarında neler görülebilir?\",\"cevap\":\"Müşterinin geçmiş siparişleri, cari bakiye durumu, ziyaret geçmişi ve iletişim bilgileri detay sayfasından takip edilebilir.\"}]},{\"baslik\":\"4. Sipariş ve Kargo Süreçleri\",\"sorular\":[{\"soru\":\"Yeni bir sipariş nasıl oluşturulur?\",\"cevap\":\"Siparişler menüsünden müşteri seçimi yapılarak, ürün\\/hizmet ve ödeme yöntemi (Kredi Kartı\\/Sanal POS, Havale, Kapıda Ödeme) belirlenip sipariş tamamlanır (\'Siparişler - Ekle\' yetkisi gerekir).\"},{\"soru\":\"Kargo bilgisi siparişe nasıl eklenir ve güncellenir?\",\"cevap\":\"1. \'Siparişler\' modülünden ilgili siparişin detay sayfasına gidin.\\r\\n2. Kargo firması ve takip numarasını ilgili JSON\\/veri alanlarına girin.\\r\\n3. Güncelle butonuna basın (\'Siparişler - Düzenle\' yetkisi gerekir).\"},{\"soru\":\"Sipariş güncellendiğinde müşteriye bildirim gitmesi nasıl çalışır?\",\"cevap\":\"Sipariş durumu veya kargo bilgisi güncellendiğinde, sistem otomatik olarak müşteriye bilgi amaçlı **SMS ve E-posta** iletilebilmesini sağlar.\"},{\"soru\":\"Sipariş iptali veya silinmesi durumunda stoklar ne olur?\",\"cevap\":\"İptal edilen veya silinen siparişlerde, sistem otomatik olarak stok miktarını günceller ve ilgili log kayıtlarını oluşturur.\"},{\"soru\":\"Sipariş ödeme durumları nasıl takip edilir?\",\"cevap\":\"Ödendi, Bekliyor veya İptal\\/İade şeklinde renkli rozetlerle siparişlerin finansal durumu liste üzerinden kolayca izlenebilir.\"}]},{\"baslik\":\"5. Ürün ve Stok Yönetimi\",\"sorular\":[{\"soru\":\"Yeni ürün ve hizmet ekleme adımları nelerdir?\",\"cevap\":\"Ürünler modülünden **Ürün Adı**, **Kategori**, **Fiyat** ve **Stok Miktarı** zorunlu alanları doldurularak yeni ürün eklenir (\'Ürünler - Ekle\' yetkisi gerekir).\"},{\"soru\":\"Kritik stok uyarısı nasıl takip edilir?\",\"cevap\":\"Stok miktarı 20 adedin altına düşen ürünler, yetkili kullanıcıların anasayfasındaki \'Stoğu Azalan Ürünler\' tablosunda otomatik listelenir.\"},{\"soru\":\"Ürün silindiğinde görsellerine ne olur?\",\"cevap\":\"Ürün silme yetkisiyle ürün sistemden kaldırıldığında, ürüne ait yüklenen tüm resim dosyaları sunucudan kalıcı olarak silinir.\"},{\"soru\":\"Kategoriler ve markalar nasıl yönetilir?\",\"cevap\":\"Ürünlerin alt kırılımları \'Kategoriler\' ve \'Markalar\' modülleri üzerinden eklenir, düzenlenir veya pasife alınır.\"},{\"soru\":\"Ürün fiyatı veya stok adedi nasıl güncellenir?\",\"cevap\":\"Ürün düzenle sayfasından ilgili alanlar değiştirilerek anında güncellenir (\'Ürünler - Düzenle\' yetkisi gerektirir).\"}]},{\"baslik\":\"6. Canlı Takip, Yüz Tanıma ve Kamera Sistemleri\",\"sorular\":[{\"soru\":\"Canlı takip modülü kamera verilerini nasıl işler?\",\"cevap\":\"Sisteme entegre kameralar veya `face-api.js` destekli yüz tanıma modülleri aracılığıyla mağazaya gelen ziyaretçiler anlık olarak taranır ve loglanır.\"},{\"soru\":\"Canlı tespitlerden doğrudan müşteri kaydı yapılabilir mi?\",\"cevap\":\"Evet! Canlı takip ekranında sistemin yakaladığı ve veritabanında kayıtlı olmayan bir kişi, tek tıkla doğrudan **yeni müşteri olarak eklenebilir**.\"},{\"soru\":\"Kamera net görmezse canlı tespitlerde veri hatası olur mu?\",\"cevap\":\"Kamera kişiyi net olarak algılayamadığı veya ışık\\/açı yetersiz kaldığı durumlarda yüz tanıma verisi yanıltıcı olabilir; bu tür **net olmayan tespitlerde veri hatalı veya eksik sonuç verebilir**, bu yüzden manuel doğrulama önerilir.\"},{\"soru\":\"Ziyaretler modülü ile canlı kamera takibi nasıl ilişkilendirilir?\",\"cevap\":\"Kameranın yakaladığı yüz ve giriş hareketleri \'Ziyaretler\' modülüne otomatik veya manuel olarak aktarılarak mağaza\\/kamera giriş istatistikleri oluşturulur.\"},{\"soru\":\"Canlı takip kayıtları silinebilir mi?\",\"cevap\":\"Kamera logları ve ziyaret geçmişleri yetki matrisine bağlı olarak silinebilir; ancak silinen kayıtlara ait medya\\/resim verileri sunucudan tamamen temizlenir.\"}]},{\"baslik\":\"7. Personel ve Yetki Matrisi Yönetimi\",\"sorular\":[{\"soru\":\"Yeni bir personel sisteme nasıl eklenir?\",\"cevap\":\"\'Personeller\' modülünden personel adı, kullanıcı adı, e-posta ve şifre zorunlu alanları doldurularak yeni personel oluşturulur.\"},{\"soru\":\"Personele modül bazlı yetkiler nasıl atanır?\",\"cevap\":\"Personel düzenle sayfasının altındaki **Modül Yetkilendirme Matrisi** tablosundan Müşteriler, Siparişler, Ürünler vb. modüller için Görüntüle, Ekle, Düzenle ve Sil yetkileri seçilerek kaydedilir.\"},{\"soru\":\"Personel hesabı nasıl silinir veya pasife alınır?\",\"cevap\":\"Personel \'Personeller - Sil\' yetkisiyle tamamen silinebilir ya da durumu pasife alınarak panele girişleri engellenebilir.\"},{\"soru\":\"Personel şifre güvenlik mekanizması nasıl çalışır?\",\"cevap\":\"Personel şifreleri `eski_sifreler` mekanizması ve güçlü hash algoritmasıyla korunur; güvenlik politikalarına uygun şekilde güncellenir.\"},{\"soru\":\"Personelin son giriş bilgileri nereden takip edilir?\",\"cevap\":\"Sistem logları üzerinden personelin en son ne zaman ve hangi IP adresinden sisteme giriş yaptığı (`LOGIN` türü) detaylıca izlenebilir.\"}]},{\"baslik\":\"8. Sistem Logları ve Güvenlik\",\"sorular\":[{\"soru\":\"Sistem logları hangi işlemleri kayıt altına alır?\",\"cevap\":\"INSERT, UPDATE, DELETE, LOGIN ve WARNING (Yetkisiz erişim denemesi) türündeki tüm hareketler `system_logs` tablosunda saniye saniye saklanır.\"},{\"soru\":\"Yetkisiz sayfa veya işlem denemelerinde ne olur?\",\"cevap\":\"Yetkisi olmayan bir sayfaya veya AJAX isteğine erişilmeye çalışıldığında sistem işlemi engeller, \'WARNING\' seviyesinde log atar ve kullanıcıyı güvenli alana yönlendirir.\"},{\"soru\":\"Log kayıtları silinebilir mi?\",\"cevap\":\"Log kayıtları güvenlik ve denetim izlenebilirliği açısından kritik olduğundan yalnızca süper admin yetkisiyle denetimli olarak yönetilebilir.\"},{\"soru\":\"IP tabanlı güvenlik kontrolleri nasıl işler?\",\"cevap\":\"Giriş ve kritik isteklerde IP adresleri loglanarak şüpheli veya yetkisiz dış erişim denemeleri anında tespit edilir.\"},{\"soru\":\"Güvenlik logları nereden incelenir?\",\"cevap\":\"Yönetim panelindeki \'Tüm Loglar\' modülü üzerinden tüm sistem hareketleri detaylı filtrelerle incelenebilir.\"},{\"soru\":\"Otomatik Giriş ve Uzun süre işlemsiz bekleme\",\"cevap\":\"Sistemde beni hatırla butonu ile sisteme giriş yaptığınızda sistem size ait bir kayıt tutarak otomatik girişi sağlamaktadır. Giriş sonrası 15 dk işlem yapmamanız halinde otomatik olarak kilit ekrana yönlendirerek şifrenizi girmenizi isteyecektir.\"}]},{\"baslik\":\"9. Ödeme ve Finansal Entegrasyonlar (POS Sistemleri)\",\"sorular\":[{\"soru\":\"PayTR, İyzico ve Moka POS entegrasyonları sisteme nasıl dahil edilir?\",\"cevap\":\"Sanal POS entegrasyonları (PayTR, İyzico ve Moka POS) modül bazlı lisanslamaya tabiidir. Bu entegrasyonlar ana sistem paketine dahil olarak gelmemektedir; ilgili ödeme modülü lisansı satın alındıktan sonra Ayarlar veya Entegrasyonlar paneli üzerinden API anahtarları girilerek aktif hale getirilir.\"},{\"soru\":\"Sanal POS API bilgileri girildikten sonra ödemeler nasıl takip edilir?\",\"cevap\":\"API entegrasyonu tamamlandıktan sonra sipariş ekranlarında seçilen ödeme yöntemine göre 3D Secure veya direkt çekimler otomatik olarak işlenir, sonuçları anlık olarak sipariş ve ödeme durumlarına yansıtılır.\"},{\"soru\":\"Ödeme entegrasyonlarında hata alınması durumunda ne yapılmalıdır?\",\"cevap\":\" API kullanıcı adı, şifre, merchant ID veya secret key bilgilerinin doğru girildiğinden emin olunmalıdır. Ayrıca test\\/canlı mod (sandbox\\/live) ayarlarının doğruluğu sistem loglarından denetlenebilir.\"},{\"soru\":\"POS modülüne herkes erişebilir mi?\",\"cevap\":\"Ödeme ve finansal entegrasyonların yönetimi ve API ayarlarının yapılması yalnızca \'Ayarlar\' ve ilgili finans yetkilerine sahip yöneticiler tarafından gerçekleştirilebilir.\"},{\"soru\":\"POS entegrasyonları silindiğinde geçmiş işlem logları ne olur?\",\"cevap\":\"Sanal POS ayarları güncellense veya değiştirilse dahi, daha önce yapılan tahsilatların ve ödeme loglarının geçmiş kayıtları güvenlik ve denetim amacıyla `system_logs` tablosunda saklanmaya devam eder.\"},{\"soru\":\"Pos Modülü Aktif Gelir Mi ?\",\"cevap\":\"Mevcut satın almış olduğunuz modülde sanal pos anlaşması dahil ise anlaşmalı olduğunuz poslara göre veya sisteme dahil pos firmaları ile api bağlantıları sağlanmaktadır.\"}]},{\"baslik\":\"10. E-Fatura ve Muhasebe Entegrasyonları (Paraşüt, Bizim Hesap, Logo İşbaşı, Akınsoft)\",\"sorular\":[{\"soru\":\"Paraşüt, Bizim Hesap, Logo İşbaşı ve Akınsoft e-fatura modülleri pakete dahil midir?\",\"cevap\":\"Hayır, bu e-fatura ve ön muhasebe entegrasyonları standart sistem kurulumuna dahil gelmemektedir. İşletmeniz ilgili modülü ayrıca satın alıp lisansladığı takdirde sisteme entegre edilebilir ve aktif hale getirilir.\"},{\"soru\":\"Muhasebe ve e-fatura API\'leri nasıl yapılandırılır?\",\"cevap\":\"Modül lisansı temin edildikten sonra, ilgili servis sağlayıcınızdan (Paraşüt, Bizim Hesap vb.) alacağınız API token ve yetkilendirme bilgileri, CRM aygıt paneline girilerek bağlantı sağlanır.\"},{\"soru\":\"CRM üzerinden e-fatura kesme işlemi nasıl denetlenir?\",\"cevap\":\"Siparişler tamamlandığında, yetkili kullanıcılar e-fatura entegrasyonu aracılığıyla tek tıkla fatura oluşturabilirler. Bu işlemlerin yetkisi rol matrisi üzerinden sınırlandırılabilir.\"},{\"soru\":\"Muhasebe API bağlantısında kopma olursa veriler kaybolur mu?\",\"cevap\":\"API bağlantılarında geçici kesintiler yaşansa bile sipariş ve cari verileriniz CRM veritabanında güvenle saklanır; bağlantı sağlandığında senkronizasyon tekrar gerçekleştirilebilir.\"},{\"soru\":\"E-fatura entegrasyon yetkisi hangi kullanıcılara verilebilir?\",\"cevap\":\"Finansal veri akışı ve resmi evrak süreçleri barındırdığı için bu modülün yönetimi ve yetkilendirmesi yalnızca yöneticiler veya yetkilendirilmiş muhasebe personelleri ile sınırlandırılmalıdır.\"}]},{\"baslik\":\"11. İletişim ve Bildirim Entegrasyonları (WhatsApp Cloud API)\",\"sorular\":[{\"soru\":\"WhatsApp Cloud API entegrasyonu sisteme nasıl dahil olur?\",\"cevap\":\"WhatsApp Cloud API modülü isteğe bağlı bir iletişim aracıdır; standart paket içeriğinde yer almaz. İlgili modülün lisanslanması durumunda sistem altyapısına dahil edilerek aktifleşir.\"},{\"soru\":\"WhatsApp Cloud API ile müşterilere hangi mesajlar iletilebilir?\",\"cevap\":\"Modül aktif olduktan sonra sipariş durum değişiklikleri, kargo takip bilgileri veya bilgilendirme mesajları otomatik ya da manuel olarak müşterilerin WhatsApp hatlarına gönderilebilir.\"},{\"soru\":\"WhatsApp mesaj gönderim yetkisi kimlerde bulunur?\",\"cevap\":\"Müşteri iletişim ve mesajlaşma modülü için gerekli yetkilere sahip olan personeller, müşteri detayları veya sipariş ekranları üzerinden WhatsApp entegrasyonunu kullanabilirler.\"},{\"soru\":\"WhatsApp entegrasyonunda hata alınırsa ne yapılmalıdır?\",\"cevap\":\"Meta (Facebook) Developer konsolu üzerinden alınan WhatsApp Cloud API token süresi, telefon numarası ID\'si ve webhook yapılandırmaları kontrol edilmelidir.\"},{\"soru\":\"Gönderilen mesajların geçmişi loglanır mı?\",\"cevap\":\"Müşterilerle yapılan WhatsApp bildirim ve iletişim hareketleri, sistemin denetlenebilirliği ve takibi açısından log mekanizmasıyla kayıt altında tutulur.\"}]}]');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_bildirimler`
--

CREATE TABLE `i_bildirimler` (
  `id` int(11) NOT NULL,
  `personel_id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `mesaj` text NOT NULL,
  `tip` varchar(50) DEFAULT 'siparis',
  `link` varchar(255) NOT NULL,
  `okundu` tinyint(1) DEFAULT '0',
  `tarih` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `i_bildirimler`
--

INSERT INTO `i_bildirimler` (`id`, `personel_id`, `baslik`, `mesaj`, `tip`, `link`, `okundu`, `tarih`) VALUES
(1, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 1, '2026-10-05 10:13:17'),
(2, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 1, '2026-10-05 14:56:50'),
(3, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-05 15:20:55'),
(4, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-06 09:46:52'),
(5, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-06 15:02:44'),
(6, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-07 09:32:57'),
(7, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-07 09:46:57'),
(8, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-07 10:54:28'),
(9, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-08 17:02:06'),
(10, 1, 'Sisteme Giriş Yapıldı', 'İvesgo Admin adlı kullanıcı sisteme başarıyla giriş yaptı.', 'success', 'index', 0, '2026-10-09 09:35:33');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_bloglar`
--

CREATE TABLE `i_bloglar` (
  `blog_id` int(11) NOT NULL,
  `blog_baslik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Blog Yazı Başlığı',
  `blog_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SEO Uyumlu URL (Slug)',
  `blog_kisa` text COLLATE utf8mb4_unicode_ci COMMENT 'Listeleme ve kartlar için kısa özet',
  `blog_icerik` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Zengin metin blog içeriği',
  `blog_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kapak görseli',
  `blog_etiketler` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Virgülle ayrılmış etiketler (seo, yazilim, vb.)',
  `blog_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SEO Tarayıcı Başlığı',
  `blog_description` text COLLATE utf8mb4_unicode_ci COMMENT 'SEO Arama Açıklaması',
  `sira` int(11) DEFAULT '0' COMMENT 'Özel sıralama indeksi',
  `blog_durum` tinyint(1) DEFAULT '1' COMMENT '1: Aktif Yayınla, 0: Taslak/Pasif',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_bloglar`
--

INSERT INTO `i_bloglar` (`blog_id`, `blog_baslik`, `blog_url`, `blog_kisa`, `blog_icerik`, `blog_resim`, `blog_etiketler`, `blog_title`, `blog_description`, `sira`, `blog_durum`, `olusturma_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'blog başlığı', 'blog-basligi', 'kısa', 'açıklama', 'ivesgo-crm-6ac3ac5e66300.jpg', 'etiket, burada', 'title', 'desc', 0, 1, '2026-10-05 16:55:43', '2026-10-05 16:55:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_ekibimiz`
--

CREATE TABLE `i_ekibimiz` (
  `ekip_id` int(11) NOT NULL,
  `ekip_ad_soyad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Personel Ad Soyad',
  `ekip_unvan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Görevi / Pozisyonu (Örn: Proje Yöneticisi)',
  `ekip_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SEO Uyumlu URL (Slug)',
  `ekip_telefon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'İletişim Telefon Numarası',
  `ekip_eposta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'İletişim E-Posta Adresi',
  `ekip_kisa` text COLLATE utf8mb4_unicode_ci COMMENT 'Listeleme ve kartlar için kısa açıklama',
  `ekip_icerik` longtext COLLATE utf8mb4_unicode_ci COMMENT 'Detay sayfaları için zengin metin açıklama',
  `ekip_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Profil / Portre Fotoğrafı',
  `sira` int(11) DEFAULT '0' COMMENT 'Gösterim sıralaması',
  `ekip_durum` tinyint(1) DEFAULT '1' COMMENT '1: Aktif Yayınla, 0: Taslak/Pasif',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_ekibimiz`
--

INSERT INTO `i_ekibimiz` (`ekip_id`, `ekip_ad_soyad`, `ekip_unvan`, `ekip_url`, `ekip_telefon`, `ekip_eposta`, `ekip_kisa`, `ekip_icerik`, `ekip_resim`, `sira`, `ekip_durum`, `olusturma_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'ad', 'mv.', 'ad', '05555', 'destek@dsadsa.com', 'kısa açıklama', 'açıklama', NULL, 0, 1, '2026-10-05 17:12:33', '2026-10-05 17:12:55');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_fotograflar`
--

CREATE TABLE `i_fotograflar` (
  `fotograf_id` int(11) NOT NULL,
  `fotograf_baslik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Slider Büyük Başlık (Ana Slogan)',
  `fotograf_aciklama` text COLLATE utf8mb4_unicode_ci COMMENT 'Slider Alt Açıklama / Spot Metin',
  `fotograf_resim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slider Arka Plan / Manşet Görseli',
  `buton_yazi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Buton üzerindeki yazı (Örn: İncele, Detaylı Bilgi)',
  `buton_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Butonun yönlendirileceği bağlantı (Link / Slug)',
  `buton_hedef` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '_self' COMMENT '_self: Aynı sekme, _blank: Yeni sekme',
  `sira` int(11) DEFAULT '0' COMMENT 'Slider gösterim sıralaması',
  `fotograf_durum` tinyint(1) DEFAULT '1' COMMENT '1: Aktif / Yayında, 0: Pasif / Gizli',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_fotograflar`
--

INSERT INTO `i_fotograflar` (`fotograf_id`, `fotograf_baslik`, `fotograf_aciklama`, `fotograf_resim`, `buton_yazi`, `buton_url`, `buton_hedef`, `sira`, `fotograf_durum`, `olusturma_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'başlık', 'açıklama', 'ivesgo-crm-6ac3a51a6cd83.jpg', 'bı-uton', 'url', '_blank', 0, 1, '2026-10-05 16:24:43', '2026-10-05 16:25:59');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_galeri`
--

CREATE TABLE `i_galeri` (
  `galeri_id` int(11) NOT NULL,
  `galeri_baslik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Galeri / Öğe Başlığı',
  `galeri_tip` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Fotoğraf, 2: Video, 3: Referans Logo, 4: Sertifika',
  `galeri_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Görsel veya Logo dosyası',
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Tip video ise YouTube / Embed video bağlantısı',
  `galeri_aciklama` text COLLATE utf8mb4_unicode_ci COMMENT 'Kısa açıklama veya detay',
  `sira` int(11) DEFAULT '0' COMMENT 'Gösterim sıralaması',
  `galeri_durum` tinyint(1) DEFAULT '1' COMMENT '1: Aktif Yayınla, 0: Taslak/Pasif',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_galeri`
--

INSERT INTO `i_galeri` (`galeri_id`, `galeri_baslik`, `galeri_tip`, `galeri_resim`, `video_url`, `galeri_aciklama`, `sira`, `galeri_durum`, `olusturma_tarihi`, `guncelleme_tarihi`) VALUES
(2, 'referans', 3, 'ivesgo-crm-6ac3aaf8efc63.jpg', NULL, 'ss', 0, 1, '2026-10-05 16:49:45', '2026-10-05 16:49:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_kampanyalar`
--

CREATE TABLE `i_kampanyalar` (
  `id` int(11) NOT NULL,
  `kampanya_adi` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kampanya başlığı',
  `kampanya_kodu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Varsa kupon kodu örn: YAZ2026',
  `kampanya_turu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'yuzde_indirim, tutar_indirim, ucretsiz_kargo',
  `indirim_orani` decimal(10,2) DEFAULT '0.00' COMMENT 'Yüzde veya Tutar değeri',
  `min_sepet_tutar` decimal(10,2) DEFAULT '0.00' COMMENT 'Kampanyanın geçerli olacağı min sepet tutarı',
  `baslangic_tarihi` datetime DEFAULT NULL,
  `bitis_tarihi` datetime DEFAULT NULL,
  `sira` int(11) NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Aktif, 0: Pasif',
  `eklenme_tarihi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_kampanyalar`
--

INSERT INTO `i_kampanyalar` (`id`, `kampanya_adi`, `kampanya_kodu`, `kampanya_turu`, `indirim_orani`, `min_sepet_tutar`, `baslangic_tarihi`, `bitis_tarihi`, `sira`, `durum`, `eklenme_tarihi`) VALUES
(1, 'Yaz İndirimi', 'YAZ2026', 'yuzde', 10.00, 1000.00, '2026-06-01 00:00:00', '2026-09-30 00:00:00', 3, 1, '2026-09-18 11:02:39'),
(2, 'Büyük Alışveriş Kuponu', 'BHY250', 'tutar', 250.00, 5000.00, '2026-09-01 00:00:00', '2026-12-31 00:00:00', 2, 1, '2026-09-18 11:02:39'),
(3, 'Ücretsiz Kargo', 'KARGO', 'kargo', 0.00, 750.00, '2026-01-01 00:00:00', '2026-12-31 00:00:00', 1, 1, '2026-09-18 11:02:39');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_kategoriler`
--

CREATE TABLE `i_kategoriler` (
  `id` int(11) NOT NULL,
  `ust_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Üst kategori ID (0 ise Ana Kategoridir)',
  `kategori_adi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SEO uyumlu URL (Benzersiz)',
  `kategori_aciklama` text COLLATE utf8mb4_unicode_ci COMMENT 'Kategori sayfası üst/alt açıklaması',
  `kategori_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kategori listeleme veya banner resmi',
  `kategori_icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Menülerde göstermek için FontAwesome vb. icon class',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sira` int(11) NOT NULL DEFAULT '0' COMMENT 'Sürükle-Bırak Sıralaması',
  `durum` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Aktif, 0: Pasif',
  `eklenme_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_kategoriler`
--

INSERT INTO `i_kategoriler` (`id`, `ust_id`, `kategori_adi`, `kategori_url`, `kategori_aciklama`, `kategori_resim`, `kategori_icon`, `seo_title`, `seo_description`, `sira`, `durum`, `eklenme_tarihi`, `guncelleme_tarihi`) VALUES
(1, 0, 'kategori 1', 'kategori-1', '<p>a&ccedil;ıklaması</p>\r\n', 'varcanlar-6aabcb4a8e24d.jpg', 'icon', 'title', 'desc', 0, 1, '2026-09-16 17:44:34', '2026-09-23 10:10:06'),
(2, 1, 'Test Kategori', 'test-kategori', '<p>Test Kategori</p>\r\n', NULL, 'Test Kategori', 'Test Kategori', 'Test Kategori', 0, 1, '2026-09-23 12:07:31', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_markalar`
--

CREATE TABLE `i_markalar` (
  `id` int(11) NOT NULL,
  `marka_adi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SEO uyumlu URL (Benzersiz)',
  `marka_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Marka Logosu',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sira` int(11) NOT NULL DEFAULT '0' COMMENT 'Sıralama',
  `durum` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Aktif, 0: Pasif',
  `eklenme_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_markalar`
--

INSERT INTO `i_markalar` (`id`, `marka_adi`, `marka_url`, `marka_logo`, `seo_title`, `seo_description`, `sira`, `durum`, `eklenme_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'marka', 'marka', 'varcanlar-6aabcee12ba74.jpg', 'title', 'desc', 0, 1, '2026-09-17 14:26:06', '2026-09-17 14:28:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_menuler`
--

CREATE TABLE `i_menuler` (
  `menu_id` int(11) NOT NULL,
  `ust_id` int(11) DEFAULT '0' COMMENT 'Bağlı olduğu üst menü ID (0 ise ana menü)',
  `menu_tip` int(11) DEFAULT '0' COMMENT '0: Header, 1: Footer, 2: Mega Menü, 3: Top Menü',
  `menu_baslik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Menü Görünen Adı',
  `menu_etiket` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Küçük badge / etiket yazısı',
  `menu_url` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Yönlendirme Linki (URL veya Slug)',
  `menu_icon` text COLLATE utf8mb4_unicode_ci COMMENT 'Menü İkonu (Tek/Çift tırnak destekli)',
  `menu_hedef` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '_self' COMMENT '_self: Aynı sekme, _blank: Yeni sekme',
  `sira` int(11) DEFAULT '0' COMMENT 'Gösterim sıralaması',
  `menu_durum` tinyint(1) DEFAULT '1' COMMENT '1: Aktif Yayınla, 0: Taslak/Pasif',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_menuler`
--

INSERT INTO `i_menuler` (`menu_id`, `ust_id`, `menu_tip`, `menu_baslik`, `menu_etiket`, `menu_url`, `menu_icon`, `menu_hedef`, `sira`, `menu_durum`, `olusturma_tarihi`, `guncelleme_tarihi`) VALUES
(1, 0, 0, 'Anasayfa', 'etiket', '/', 'fa-light fa-cash-register', '_blank', 0, 1, '2026-10-05 17:37:15', '2026-10-06 09:52:11'),
(2, 0, 0, 'İletişim', NULL, 'iletisim/', NULL, '_self', 0, 1, '2026-10-06 09:52:34', '2026-10-06 09:52:34'),
(3, 0, 0, 'Çözümler', NULL, 'cozumler/', NULL, '_self', 0, 1, '2026-10-06 09:52:41', '2026-10-06 09:52:41'),
(4, 0, 0, 'Galeri', NULL, 'galeri/', NULL, '_self', 0, 1, '2026-10-06 09:52:47', '2026-10-06 09:52:47'),
(5, 0, 0, 'Referanslar', NULL, 'referanslar/', NULL, '_self', 0, 1, '2026-10-06 09:53:34', '2026-10-06 09:53:34'),
(6, 3, 0, 'Kurumsal', NULL, 'hakkimizda/', NULL, '_self', 0, 0, '2026-10-06 09:53:47', '2026-10-06 09:54:31'),
(8, 0, 0, 'Hakkımızda', NULL, 'hakkimizda/', NULL, '_self', 0, 1, '2026-10-06 09:54:17', '2026-10-06 09:54:45');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_musteriler`
--

CREATE TABLE `i_musteriler` (
  `id` int(11) NOT NULL,
  `musteri_tipi` enum('bireysel','kurumsal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bireysel' COMMENT 'Müşteri Tipi',
  `musteri_adi` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Bireyselde Ad/Soyad, Kurumsalda Firma Kısa Adı',
  `unvan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kurumsal Resmi Ticari Ünvan',
  `yetkili_kisi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Firma ile görüşülecek yetkili kişi',
  `eposta` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Sabit Hat',
  `gsm` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Cep Telefonu',
  `il_id` int(11) DEFAULT NULL COMMENT 'ilceler tablosu ile ilişkili',
  `ilce_id` int(11) DEFAULT NULL COMMENT 'ilceler tablosu ile ilişkili',
  `fatura_adresi` text COLLATE utf8mb4_unicode_ci,
  `sevk_adresi` text COLLATE utf8mb4_unicode_ci COMMENT 'Fiziksel teslimat adresi (Faturadan farklı olabilir)',
  `vergi_dairesi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vergi_no` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bireyselde 11 Hane TC, Kurumsalda 10 Hane VKN',
  `bakiye` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Müşteri cari bakiyesi',
  `para_birimi` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TRY',
  `notlar` json NOT NULL,
  `musteri_mesaj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vip_durum` int(3) NOT NULL,
  `face_descriptor` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `musteri_resim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Aktif, 0: Pasif',
  `sira` int(9) NOT NULL,
  `kayit_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_musteriler`
--

INSERT INTO `i_musteriler` (`id`, `musteri_tipi`, `musteri_adi`, `unvan`, `yetkili_kisi`, `eposta`, `telefon`, `gsm`, `il_id`, `ilce_id`, `fatura_adresi`, `sevk_adresi`, `vergi_dairesi`, `vergi_no`, `bakiye`, `para_birimi`, `notlar`, `musteri_mesaj`, `vip_durum`, `face_descriptor`, `musteri_resim`, `durum`, `sira`, `kayit_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'kurumsal', 'Ahmet Yılmaz', 'Yılmazlar İnşaat Ltd. Şti.', '', 'destek@ivesgo.com', '05536406710', '', NULL, NULL, 'adres', 'adres tes.', 'vs', '1111', 0.00, 'TRY', 'null', '', 0, '', '', 1, 1, '2026-09-18 14:02:39', '2026-10-05 15:13:54'),
(2, 'kurumsal', 'Mehmet Demir', 'Demir Mimarlık', NULL, 'mehmet@demirimarlik.com', '05324445566', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'TRY', 'null', '', 0, '', '', 1, 7, '2026-09-18 14:02:39', '2026-10-05 15:13:54'),
(3, 'bireysel', 'Ayşe Kaya', 'Bireysel Müşteri', '', 'ayse@gmail.com', '05423332211', '', 0, 0, '', '', '', '', 0.00, '', 'null', '', 0, '', '', 1, 2, '2026-09-18 14:02:39', '2026-10-05 15:13:54'),
(16, 'bireysel', 'Fatih Altaylı', '', '', 'f@dd.com', '', '432432', 0, 0, '', '', '', '', 0.00, 'TL', '[{\"id\": \"6ab51189aa987\", \"metin\": \"Test Not fatih.\", \"tarih\": \"2026-09-24 15:03:21\", \"ekleyen\": \"İvesgo Admin\"}, {\"id\": \"6ab51189aa97f\", \"metin\": \"null\", \"tarih\": \"-\", \"ekleyen\": \"Sistem / Eski Not\"}]', '', 0, '[-0.0758158415555954,0.08218196034431458,0.0280077017378062,-0.04056841693818569,-0.05942061264067888,-0.014267954044044018,-0.010369906900450587,-0.10162658616900444,0.16044480353593826,-0.08698595687747002,0.19166988134384155,0.04296797583810985,-0.23839876055717468,-0.04948913585394621,-0.024067722260951996,0.11635076999664307,-0.1487475112080574,-0.09802108630537987,-0.1799839287996292,-0.15206921845674515,-0.021256908774375916,0.03324986528605223,0.02931353449821472,-0.023570850491523743,-0.153528593480587,-0.21558628976345062,-0.1000588983297348,-0.05574299581348896,0.05610235035419464,-0.08551277220249176,0.062359198927879333,0.002874242141842842,-0.18155158311128616,-0.05857512168586254,0.05347096174955368,0.07112154923379421,-0.0634977500885725,-0.07176362723112106,0.2030821293592453,0.017451101914048195,-0.07822025381028652,0.04147200472652912,0.01952877314761281,0.2213406190276146,0.20796261727809906,0.00566929392516613,0.005053306929767132,-0.08223507553339005,0.09373786300420761,-0.25452178716659546,0.024047533981502056,0.1623331382870674,0.060397570952773094,0.11113625392317772,0.056680397130548954,-0.10839365795254707,0.04890642873942852,0.18898508697748184,-0.18427658826112747,0.058575520757585764,0.03123356867581606,-0.15957743674516678,-0.07368620671331882,0.020496061071753502,0.10753272846341133,0.10840459913015366,-0.08818048797547817,-0.17789830267429352,0.1754593923687935,-0.1590418890118599,-0.02907728496938944,0.05797745659947395,-0.07349319010972977,-0.14798995852470398,-0.24857283383607864,0.06724400632083416,0.43700799345970154,0.15064842998981476,-0.14888469874858856,0.014327269047498703,-0.09661784768104553,-0.029211307875812054,0.027907317504286766,0.00160992331802845,-0.08774898573756218,-0.12803447619080544,-0.08501127734780312,0.036223342176526785,0.1871640458703041,-0.010144781321287155,-0.035136451944708824,0.18706706911325455,0.013219088781625032,-0.022262155718635768,0.03961476869881153,0.03286975808441639,-0.12847334519028664,-0.026551339775323868,-0.0622409712523222,-0.0470668775960803,0.057829572702758014,-0.1296081207692623,0.04323970712721348,0.09063183516263962,-0.13499263674020767,0.17729315906763077,-0.024699062923900783,-0.054030921310186386,0.016200075391680002,0.012324806302785873,-0.06895369151607156,-0.01954239676706493,0.1841462180018425,-0.23477625101804733,0.2443981170654297,0.21205101162195206,-0.03413079382153228,0.14484085142612457,0.06705137342214584,0.12508171424269676,-0.019033592892810702,0.03808819595724344,-0.08509563282132149,-0.13115056604146957,-0.057860201224684715,0.017697594594210386,0.04784732544794679,0.0130117058288306]', '', 1, 4, '2026-09-23 14:35:40', '2026-10-05 15:13:54'),
(17, 'bireysel', 'tibet erdoğru', '', '', '', '', '', 0, 0, '', '', '', '', 0.00, 'TL', 'null', '', 0, '[-0.07228579372167587,0.08781502395868301,0.05711261369287968,0.006152346730232239,-0.10850570723414421,-0.12889257073402405,0.02035651169717312,-0.20204775035381317,0.2204498052597046,-0.08939867466688156,0.19141365587711334,0.008671239949762821,-0.2412949949502945,-0.05138278007507324,-0.06752144545316696,0.0767330750823021,-0.16152004152536392,-0.16967105120420456,-0.09828651696443558,-0.08494948968291283,0.052261218428611755,0.015375467017292976,0.016185641288757324,0.05639869160950184,-0.1336102858185768,-0.30085065960884094,-0.09353385493159294,-0.06625651940703392,0.009939385112375021,-0.040556132793426514,-0.0010114279575645924,0.10474340990185738,-0.19767753779888153,-0.08849658071994781,0.02550813276320696,0.10193230956792831,-0.017771379556506872,-0.02066724095493555,0.16998234391212463,0.07256793975830078,-0.19707874208688736,0.06759190931916237,-0.016046741046011448,0.27844738960266113,0.2237161174416542,0.03848155867308378,0.03642684035003185,-0.13954634219408035,0.14243172109127045,-0.2296849638223648,0.06251778267323971,0.21863137185573578,0.12213394790887833,0.024627510458230972,0.12488909438252449,-0.13099774718284607,-0.03999889828264713,0.10237772390246391,-0.17980126291513443,0.08652268350124359,0.15653908997774124,-0.11406947672367096,0.01368771685520187,-0.09874841198325157,0.14235927909612656,0.09873855113983154,-0.11736125499010086,-0.03543338272720575,0.21803578734397888,-0.18173403292894363,-0.11335843801498413,0.03640330955386162,-0.07202400639653206,-0.16062167286872864,-0.2965736389160156,0.012501393212005496,0.4935041069984436,0.14940806478261948,-0.17595107853412628,-0.033643731847405434,-0.15959138423204422,0.02217553975060582,0.06925881654024124,0.01618412509560585,-0.06308908946812153,-0.05008901562541723,-0.14611272513866425,-0.0018190238624811172,0.22960984706878662,0.0478485943749547,-0.05277492664754391,0.22010581195354462,-0.006976438220590353,-0.0005074086802778766,0.037188777700066566,0.05552562326192856,-0.14017147570848465,-0.021603606641292572,-0.14993058890104294,-0.019581838510930538,-0.05498714558780193,-0.11832984164357185,-0.011049575172364712,0.05872099846601486,-0.14981023222208023,0.1301756389439106,0.010792051907628775,-0.02204697299748659,-0.06717496365308762,-0.011513099074363708,-0.12459484487771988,0.03672921098768711,0.13699262216687202,-0.2781675010919571,0.2784128487110138,0.11830437183380127,0.011801777873188257,0.16206017136573792,0.014030596241354942,0.05326942168176174,-0.06442619301378727,-0.12434402480721474,-0.0728965736925602,-0.17288000136613846,-0.007094252505339682,0.004575715167447925,0.09993600845336914,0.04481188114732504]', '', 1, 8, '2026-09-23 14:42:39', '2026-10-05 15:13:54'),
(18, 'bireysel', 'Acun ılıcalı', '', '', '', '', '', 0, 0, '', '', '', '', 0.00, 'TL', 'null', '', 0, '[-0.11672632023692131,0.049721917137503624,0.06199430301785469,-0.02078375779092312,-0.15304625034332275,-0.011831782292574644,-0.03492830600589514,-0.00935283221770078,0.09540699049830437,-0.08415747433900833,0.22389713674783707,-0.06670049950480461,-0.24458186328411102,-0.02880795020610094,-0.043665723875164986,0.11411609500646591,-0.1959150806069374,-0.11511975899338722,-0.14091239124536514,-0.09078428149223328,0.09117669984698296,0.09094562008976936,0.05244278162717819,-0.03836280666291714,-0.18081322312355042,-0.3868153542280197,-0.04596189968287945,-0.07660989090800285,0.0741034522652626,-0.04562785290181637,-0.004227989935316145,0.028924239799380302,-0.21752528101205826,-0.05398229509592056,0.05948021449148655,0.03301121573895216,0.008697984274476767,-0.04947247542440891,0.14736352860927582,0.06098474748432636,-0.21468745172023773,0.056575363501906395,-0.026097680442035198,0.3084800988435745,0.1511968970298767,0.10480780899524689,-0.003919550043065101,-0.09033243358135223,0.05097375065088272,-0.23959293216466904,0.11826096102595329,0.17519833892583847,0.058835674077272415,-0.024627896025776863,0.11433631554245949,-0.10558724403381348,0.025218097493052483,0.1234763152897358,-0.18508467823266983,0.02595246583223343,0.04856544919312,-0.004718351876363158,-0.004034673678688705,-0.10472824051976204,0.14126486331224442,0.056981226429343224,-0.08576904237270355,-0.11646832898259163,0.17120587825775146,-0.11716732755303383,-0.05046987161040306,0.05694201961159706,-0.10089723765850067,-0.16980798542499542,-0.3202417939901352,0.005470492993481457,0.47924336791038513,0.11598114669322968,-0.23687972128391266,-0.014209045097231865,-0.02257565315812826,0.006051542120985687,0.1629752516746521,0.08133850246667862,-0.10720697417855263,0.00541494318167679,-0.10136033594608307,0.042470552027225494,0.17210838198661804,-0.03115493804216385,-0.10885064676404,0.2327963188290596,0.04555290378630161,-0.0753193311393261,0.1163998581469059,0.03863558918237686,-0.0938357301056385,-0.05215844698250294,-0.14169489592313766,-0.04667594097554684,0.09139092266559601,-0.1041107065975666,-0.0761764720082283,0.12532299384474754,-0.17599038779735565,0.10610831156373024,-0.014999322593212128,-0.07656828686594963,-0.01987326517701149,-0.023640048690140247,-0.09357462450861931,-0.03566367831081152,0.11965532600879669,-0.2658499628305435,0.14154630154371262,0.23262746632099152,0.022569720167666674,0.18004369735717773,0.07086237147450447,0.00408556591719389,-0.012839438393712044,0.006463006415287964,-0.15934453159570694,-0.15517743676900864,0.033438594080507755,0.0009445254690945148,0.05368411913514137,0.02173691615462303]', '', 1, 3, '2026-09-23 14:43:46', '2026-10-05 15:13:54'),
(19, 'bireysel', 'gökhan', '', '', '', '', '', 0, 0, '', '', '', '', 0.00, 'TL', 'null', '', 0, '[-0.1422390267252922,0.08163599669933319,0.05742855090647936,-0.033695861930027604,-0.09966546297073364,0.019330165348947048,-0.04582521505653858,-0.05978015437722206,0.16414041072130203,-0.07496727630496025,0.10390999540686607,-0.015029868111014366,-0.18383747339248657,0.05910187587141991,-0.059913668781518936,0.08590477705001831,-0.1857352778315544,-0.07273577153682709,-0.11508788913488388,-0.11250855028629303,0.025894138030707836,0.11502246931195259,-0.033885331242345273,0.051957013085484505,-0.15317147225141525,-0.2855660617351532,-0.09941743314266205,-0.0703907422721386,0.07253648713231087,-0.12116441130638123,-0.018824882805347443,-0.01798963313922286,-0.15506993234157562,-0.040919408784247935,0.017362769605824724,0.08990603312849998,-0.07809967175126076,-0.035912588238716125,0.14042096585035324,0.06644009426236153,-0.13447344675660133,0.0828234413638711,0.009648950770497322,0.3686698228120804,0.21811846643686295,0.07798223197460175,-0.01736101135611534,-0.06733415275812149,0.17511074244976044,-0.2993834912776947,0.05853429064154625,0.14075985178351402,0.04781430400907993,0.06770442146807909,0.1339067593216896,-0.15655002743005753,0.00961241964250803,0.10545546934008598,-0.13827543705701828,0.13517078012228012,0.08100363984704018,-0.07350841164588928,0.02770853228867054,-0.03738073166459799,0.15576258301734924,0.06923608481884003,-0.10854047909379005,-0.11831308901309967,0.125493336468935,-0.17850670963525772,-0.005282514961436391,0.06865077093243599,-0.0524915736168623,-0.17175140231847763,-0.27816902101039886,0.07696275040507317,0.47173234820365906,0.14262742549180984,-0.15226849168539047,0.009525423403829336,-0.02519363071769476,-0.00412294409761671,0.13308004662394524,0.07745212689042091,-0.12434669211506844,-0.019462589756585658,-0.09513085708022118,0.07023699395358562,0.2104092538356781,0.016896305489353836,-0.015466984594240785,0.216765858232975,0.033277045004069805,-0.005897101014852524,0.06557042524218559,0.07616511359810829,-0.171240396797657,-0.030980478040874004,-0.10740287229418755,0.020701099187135696,0.06350652314722538,-0.10205874964594841,0.022057724185287952,0.1150871030986309,-0.14924156665802002,0.23712703585624695,-0.015482408693060279,-0.03528846241533756,-0.04873722977936268,-0.008151546120643616,-0.14632928743958473,0.04546605609357357,0.20062507688999176,-0.2687578797340393,0.16034307330846786,0.16784033179283142,-0.001242276281118393,0.15029314905405045,0.03913102671504021,0.040202879696153104,-0.03907423932105303,0.057845644652843475,-0.1192348524928093,-0.08485020697116852,0.0034470197279006243,-0.05039340630173683,0.02711538504809141,0.022785372100770473]', '', 1, 5, '2026-09-23 14:50:04', '2026-10-05 15:13:54'),
(20, 'bireysel', 'gökhan ivesgo', '', '', '', '', '', 0, 0, '', '', '', '', 0.00, 'TL', 'null', '', 0, '[-0.06316668167710304,0.09014138951897621,0.03890426177531481,-0.0663133542984724,-0.1011546403169632,-0.020729083567857742,0.0023765815421938896,-0.022561890073120594,0.20909734070301056,0.030057561583817005,0.21916603296995163,-0.03243834059685469,-0.2138156071305275,-0.03858986496925354,-0.08742902427911758,0.07112198323011398,-0.1538858562707901,-0.10166286304593086,-0.04889354854822159,-0.13391032069921494,0.11722459271550179,0.09868337586522102,-0.012388600036501884,0.03280778881162405,-0.14365556091070175,-0.2838955968618393,-0.011182841612026095,-0.13785795494914055,0.11631028726696968,-0.1606769561767578,-0.008955603232607245,0.03767520748078823,-0.17184162884950638,-0.09991497173905373,-0.006408841523807496,0.07987715676426888,-0.04770679399371147,-0.07205184549093246,0.11178353801369667,0.0763782225549221,-0.16852524876594543,0.10525817424058914,-0.005360843584639952,0.3463030755519867,0.18854206800460815,0.09155665710568428,-0.018418079242110252,-0.0923004113137722,0.10847939178347588,-0.30156005918979645,0.12706293910741806,0.16192422062158585,0.0853644497692585,0.010544612188823521,0.1497296467423439,-0.15348611772060394,-0.05902097374200821,0.06994844414293766,-0.1795676276087761,0.10792534425854683,0.08202921971678734,0.06557949632406235,0.01650790451094508,-0.17115844041109085,0.11696222424507141,0.0629508700221777,-0.09933745861053467,-0.050455497577786446,0.05107017420232296,-0.16515100747346878,-0.09677071496844292,0.11719488725066185,-0.0696696899831295,-0.17218774557113647,-0.2484392672777176,0.09992223232984543,0.41371943056583405,0.14919528365135193,-0.15818268060684204,0.0027950692747253925,-0.04224526509642601,0.023748675361275673,0.12960289418697357,-0.006894366582855582,-0.062154244631528854,-0.0039806748973205686,-0.10891000181436539,-0.00028028638917021453,0.1652456298470497,-0.03596518561244011,-0.05953344143927097,0.23619704693555832,-0.034041738137602806,0.016526633175089955,-0.004275556420907378,0.07356284186244011,-0.13047653436660767,0.049224236980080605,-0.09940532222390175,-0.05347195267677307,0.09412413090467453,-0.07897919043898582,-0.012441759463399649,0.07168138027191162,-0.18717295676469803,0.0959257110953331,0.010599266970530152,-0.01276115421205759,0.018576528411358595,-0.012207417050376534,-0.11218057572841644,0.01426582969725132,0.18786358833312988,-0.27137260138988495,0.2256062775850296,0.1863984316587448,0.03535967133939266,0.12106841430068016,0.0766502395272255,-0.01925812568515539,-0.0021516404231078923,-0.0516903605312109,-0.11324785649776459,-0.07346368208527565,0.022477150079794228,-0.02503551822155714,-0.0005976119064143859,0.013027612119913101]', '', 1, 6, '2026-09-24 17:22:01', '2026-10-05 15:13:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_sabit_resimler`
--

CREATE TABLE `i_sabit_resimler` (
  `id` int(11) NOT NULL,
  `resim_adi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kod içinde çağrılacak key/isim (örn: site_logo)',
  `resim_baslik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Admin panelinde görünen başlık',
  `resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Orjinal resim adı',
  `sira` int(11) DEFAULT '0',
  `durum` tinyint(1) DEFAULT '1',
  `eklenme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_sabit_resimler`
--

INSERT INTO `i_sabit_resimler` (`id`, `resim_adi`, `resim_baslik`, `resim`, `sira`, `durum`, `eklenme_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'circle', 'circle', 'ivesgo-crm-6ac49eb88df45.jpg', 0, 1, '2026-10-06 10:09:46', '2026-10-06 10:10:31'),
(2, 'foto-1', 'foto 1', 'ivesgo-crm-6ac49ec6cc743.png', 0, 1, '2026-10-06 10:10:00', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_sabit_sayfalar`
--

CREATE TABLE `i_sabit_sayfalar` (
  `id` int(11) NOT NULL,
  `sayfa_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Sayfa anahtarı (index, iletisim, hakkimizda vb.)',
  `baslik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sayfa_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'og:img veya arkaplan resmi',
  `sira` int(11) DEFAULT '0',
  `durum` tinyint(1) DEFAULT '1',
  `eklenme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_sabit_sayfalar`
--

INSERT INTO `i_sabit_sayfalar` (`id`, `sayfa_url`, `baslik`, `title`, `description`, `sayfa_resim`, `sira`, `durum`, `eklenme_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'index', 'Anasayfa', 'Title içerik', 'description içeriği', NULL, 0, 1, '2026-10-06 10:29:22', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_sayfalar`
--

CREATE TABLE `i_sayfalar` (
  `sayfa_id` int(11) NOT NULL,
  `sayfa_baslik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sayfa Başlığı (Örn: Hakkımızda, Profesyonel Çözümler)',
  `sayfa_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL adresi (hakkimizda, yazilim-cozumleri)',
  `sayfa_tip` tinyint(1) NOT NULL DEFAULT '1',
  `sayfa_kisa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sayfa_icerik` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sayfanın detaylı zengin metin (HTML) içeriği',
  `sayfa_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SEO Tarayıcı Başlığı',
  `sayfa_description` text COLLATE utf8mb4_unicode_ci COMMENT 'SEO Arama Açıklaması',
  `sayfa_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kapak veya illüstrasyon görseli',
  `sira` int(11) DEFAULT '0' COMMENT 'Özel sıralama indeksi',
  `sayfa_durum` tinyint(1) DEFAULT '1' COMMENT '1: Aktif Yayınla, 0: Taslak/Pasif',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sayfa_ozellikler` longtext COLLATE utf8mb4_unicode_ci COMMENT 'JSON formatında özellikler veya sorular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_sayfalar`
--

INSERT INTO `i_sayfalar` (`sayfa_id`, `sayfa_baslik`, `sayfa_url`, `sayfa_tip`, `sayfa_kisa`, `sayfa_icerik`, `sayfa_title`, `sayfa_description`, `sayfa_resim`, `sira`, `sayfa_durum`, `olusturma_tarihi`, `guncelleme_tarihi`, `sayfa_ozellikler`) VALUES
(1, 'Hakkımızda', 'hakkimizda', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor ', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', 'titl', 'desc', 'sayfa_multi_6ac4a4ef5efa8.jpg', 0, 1, '2026-10-05 15:52:59', '2026-10-06 10:52:53', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_sayfa_resimler`
--

CREATE TABLE `i_sayfa_resimler` (
  `id` int(11) NOT NULL,
  `sayfa_id` int(11) NOT NULL COMMENT 'Bağlı olduğu sayfanın ID değeri',
  `resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Resim dosya adı',
  `sira` int(11) DEFAULT '0',
  `eklenme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_sayfa_resimler`
--

INSERT INTO `i_sayfa_resimler` (`id`, `sayfa_id`, `resim`, `sira`, `eklenme_tarihi`) VALUES
(2, 1, 'sayfa_multi_6ac4a4ecc580e.jpg', 0, '2026-10-06 10:36:15'),
(4, 1, 'sayfa_6ac4a6291eb18.jpg', 0, '2026-10-06 10:52:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_siparisler`
--

CREATE TABLE `i_siparisler` (
  `id` int(11) NOT NULL,
  `siparis_kodu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Örn: SIP-20260917-ABC',
  `musteri_id` int(11) DEFAULT '0' COMMENT 'Kayıtlı müşteriyse i_musteriler tablosu ID, misafirse 0',
  `siparis_personel` int(5) NOT NULL,
  `musteri_bilgileri` json DEFAULT NULL COMMENT 'Müşteri ad, soyad, telefon, e-posta, tc/vkn',
  `urunler` json DEFAULT NULL COMMENT 'Satın alınan ürünler array (id, sku, ad, miktar, birim fiyat, kdv, toplam)',
  `fatura_adresi` json DEFAULT NULL COMMENT 'İl, ilçe, açık adres, vergi dairesi vb.',
  `teslimat_adresi` json DEFAULT NULL COMMENT 'İl, ilçe, açık adres, teslim alacak kişi',
  `ara_toplam` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'KDV ve Kargo hariç ürün toplamı',
  `kdv_toplam` decimal(10,2) NOT NULL DEFAULT '0.00',
  `indirim_toplam` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Kupon veya manuel indirimler',
  `kargo_ucreti` decimal(10,2) NOT NULL DEFAULT '0.00',
  `genel_toplam` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Müşterinin ödeyeceği nihai tutar',
  `para_birimi` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'TRY',
  `odeme_yontemi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kredi Kartı, Havale/EFT, Kapıda Ödeme, Cari',
  `odeme_durumu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Bekliyor, 1: Ödendi, 2: İade/İptal',
  `siparis_durumu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Yeni Sipariş' COMMENT 'Yeni, Hazırlanıyor, Kargoya Verildi, Teslim Edildi, İptal',
  `kargo_firmasi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Aras, Yurtiçi, Sürat vb.',
  `kargo_takip_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kargo_takip_url` text COLLATE utf8mb4_unicode_ci COMMENT 'Otomatik takip linki',
  `musteri_notu` text COLLATE utf8mb4_unicode_ci COMMENT 'Sipariş esnasında müşterinin düştüğü not',
  `admin_notu` text COLLATE utf8mb4_unicode_ci COMMENT 'Sadece panelde yöneticilerin gördüğü iç not',
  `api_fatura_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_adresi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Siparişi veren IP adresi (Güvenlik için)',
  `eklenme_tarihi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `silindi` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_siparisler`
--

INSERT INTO `i_siparisler` (`id`, `siparis_kodu`, `musteri_id`, `siparis_personel`, `musteri_bilgileri`, `urunler`, `fatura_adresi`, `teslimat_adresi`, `ara_toplam`, `kdv_toplam`, `indirim_toplam`, `kargo_ucreti`, `genel_toplam`, `para_birimi`, `odeme_yontemi`, `odeme_durumu`, `siparis_durumu`, `kargo_firmasi`, `kargo_takip_no`, `kargo_takip_url`, `musteri_notu`, `admin_notu`, `api_fatura_id`, `ip_adresi`, `eklenme_tarihi`, `guncelleme_tarihi`, `silindi`) VALUES
(1, 'SPK-2026-0101', 1, 0, '{\"eposta\": \"destek@ivesgo.com\", \"telefon\": \"05536406710\", \"ad_soyad\": \"Ahmet Yılmaz\", \"vergi_no\": \"1111\", \"firma_unvani\": \"Yılmazlar İnşaat Ltd. Şti.\", \"musteri_tipi\": \"kurumsal\", \"vergi_dairesi\": \"vs\"}', '[{\"id\": \"2\", \"adi\": \"Alüminyum Pergola Sistemi\", \"kdv\": 20, \"url\": \"urun/aluminyum-pergola-sistemi/\", \"adet\": 1, \"fiyat\": 11000, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-002\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 11000}, {\"id\": \"4\", \"adi\": \"Plastik Gıda Kabı 500ml\", \"kdv\": 20, \"url\": \"urun/plastik-gida-kabi-500ml/\", \"adet\": 10, \"fiyat\": 4.5, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-004\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 45}]', '{\"adres\": \"adres\"}', '{\"kisi\": \"\", \"adres\": \"adres tes.\"}', 9204.17, 1840.83, 0.00, 0.00, 11045.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '2', 'Yurtiçi Kargo', '1111', 'https://selfservis.yurticikargo.com/reports/SSWDocumentDetail.aspx?DocId=1111', NULL, '', '', NULL, '2026-04-09 07:15:00', '2026-09-25 13:09:54', 0),
(2, 'SPK-2026-0102', 0, 0, NULL, NULL, NULL, NULL, 7200.00, 1440.00, 200.00, 0.00, 8440.00, 'TRY', 'Havale / EFT', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-01-10 11:20:00', '2026-10-05 12:05:44', 1),
(3, 'SPK-2026-0103', 0, 0, NULL, NULL, NULL, NULL, 1500.00, 300.00, 0.00, 150.00, 1950.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-01-15 06:45:00', '2026-09-25 13:10:19', 0),
(4, 'SPK-2026-0104', 5, 0, NULL, NULL, NULL, NULL, 12500.00, 2500.00, 500.00, 0.00, 14500.00, 'TRY', 'Havale / EFT', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-01-22 13:10:00', '2026-09-22 11:49:36', 0),
(5, 'SPK-2026-0105', 5, 0, NULL, NULL, NULL, NULL, 4800.00, 960.00, 100.00, 150.00, 5810.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-01-28 08:30:00', '2026-09-25 13:10:19', 0),
(6, 'SPK-2026-0201', 0, 0, NULL, NULL, NULL, NULL, 2100.00, 420.00, 0.00, 150.00, 2670.00, 'TRY', 'Havale / EFT', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-02-04 09:00:00', '2026-09-22 11:49:36', 0),
(7, 'SPK-2026-0202', 0, 0, NULL, NULL, NULL, NULL, 9600.00, 1920.00, 300.00, 0.00, 11220.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-02-12 12:30:00', '2026-09-25 13:10:19', 0),
(8, 'SPK-2026-0203', 0, 0, NULL, NULL, NULL, NULL, 5400.00, 1080.00, 150.00, 150.00, 6480.00, 'TRY', 'Havale / EFT ', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-02-18 06:15:00', '2026-09-25 13:11:13', 0),
(9, 'SPK-2026-0204', 0, 0, NULL, NULL, NULL, NULL, 3200.00, 640.00, 0.00, 150.00, 3990.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-02-25 14:00:00', '2026-09-25 13:10:19', 0),
(10, 'SPK-2026-0301', 0, 0, NULL, NULL, NULL, NULL, 14500.00, 2900.00, 500.00, 0.00, 16900.00, 'TRY', 'Havale / EFT ', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-03-03 07:30:00', '2026-09-25 13:10:50', 0),
(11, 'SPK-2026-0302', 0, 0, NULL, NULL, NULL, NULL, 4100.00, 820.00, 100.00, 150.00, 4970.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-03-08 10:45:00', '2026-09-25 13:10:19', 0),
(12, 'SPK-2026-0303', 0, 0, NULL, NULL, NULL, NULL, 2700.00, 540.00, 0.00, 150.00, 3390.00, 'TRY', 'Havale / EFT', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-03-14 08:20:00', '2026-09-22 11:49:36', 0),
(13, 'SPK-2026-0304', 0, 0, NULL, NULL, NULL, NULL, 8300.00, 1660.00, 250.00, 0.00, 9710.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-03-19 12:10:00', '2026-09-25 13:10:19', 0),
(14, 'SPK-2026-0305', 0, 0, NULL, NULL, NULL, NULL, 6100.00, 1220.00, 150.00, 150.00, 7320.00, 'TRY', 'Havale / EFT ', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-03-24 06:00:00', '2026-09-25 13:11:13', 0),
(15, 'SPK-2026-0306', 5, 0, NULL, '[{\"id\": \"2\", \"adi\": \"Alüminyum Pergola Sistemi\", \"kdv\": 20, \"url\": \"urun/aluminyum-pergola-sistemi/\", \"adet\": 2, \"fiyat\": 11000, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"0\", \"stok_kodu\": \"PROD-002\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 22000}, {\"id\": \"3\", \"adi\": \"Cam Balkon Fitili\", \"kdv\": 20, \"url\": \"urun/cam-balkon-fitili/\", \"adet\": 20, \"fiyat\": 250, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"0\", \"stok_kodu\": \"PROD-003\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 5000}]', NULL, NULL, 22500.00, 4500.00, 0.00, 0.00, 27000.00, 'TRY', 'Havale / EFT ', 1, '1', '', '', '', NULL, '', '', NULL, '2026-03-29 13:40:00', '2026-09-25 13:11:13', 0),
(16, 'SPK-2026-0401', 3, 0, '{\"eposta\": \"ayse@gmail.com\", \"telefon\": \"05423332211\", \"ad_soyad\": \"Ayşe Kaya\", \"vergi_no\": \"\", \"firma_unvani\": \"Bireysel Müşteri\", \"musteri_tipi\": \"bireysel\", \"vergi_dairesi\": \"\"}', '[{\"id\": \"4\", \"adi\": \"Plastik Gıda Kabı 500ml\", \"kdv\": 20, \"url\": \"urun/plastik-gida-kabi-500ml/\", \"adet\": 10, \"fiyat\": 4.5, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-004\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 45}]', '{\"adres\": \"\"}', '{\"kisi\": \"\", \"adres\": \"\"}', 37.50, 7.50, 0.00, 200.00, 245.00, 'TRY', 'Havale / EFT ', 1, '1', '', '', '', NULL, 'a', '', NULL, '2026-04-06 11:15:00', '2026-09-25 14:39:20', 0),
(17, 'SPK-2026-0402', 0, 0, NULL, NULL, NULL, NULL, 5600.00, 1120.00, 200.00, 150.00, 6670.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-04-15 07:30:00', '2026-09-25 13:10:19', 0),
(19, 'SPK-2026-0501', 0, 0, NULL, NULL, NULL, NULL, 4500.00, 900.00, 100.00, 150.00, 5450.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-05-02 06:30:00', '2026-09-25 13:10:19', 0),
(21, 'SPK-2026-0503', 0, 0, NULL, NULL, NULL, NULL, 7800.00, 1560.00, 250.00, 0.00, 9110.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-05-12 09:10:00', '2026-09-25 13:10:19', 0),
(22, 'SPK-2026-0504', 0, 0, NULL, NULL, NULL, NULL, 3100.00, 620.00, 0.00, 150.00, 3870.00, 'TRY', 'Havale / EFT', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-05-17 07:00:00', '2026-09-22 11:49:36', 0),
(23, 'SPK-2026-0505', 0, 0, NULL, NULL, NULL, NULL, 9400.00, 1880.00, 300.00, 0.00, 10980.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-05-21 13:45:00', '2026-09-25 13:10:19', 0),
(24, 'SPK-2026-0506', 0, 0, NULL, NULL, NULL, NULL, 2200.00, 440.00, 0.00, 150.00, 2790.00, 'TRY', 'Kapıda Ödeme', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-05-26 11:15:00', '2026-09-22 11:49:36', 0),
(27, 'SPK-2026-0602', 0, 0, NULL, NULL, NULL, NULL, 3400.00, 680.00, 0.00, 150.00, 4230.00, 'TRY', 'Havale / EFT', 2, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-06-11 10:20:00', '2026-09-22 11:50:08', 0),
(30, 'SPK-2026-0605', 0, 0, NULL, NULL, NULL, NULL, 2800.00, 560.00, 0.00, 150.00, 3510.00, 'TRY', 'Kapıda Ödeme', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-06-28 13:30:00', '2026-09-22 11:49:36', 0),
(31, 'SPK-2026-0701', 0, 0, NULL, NULL, NULL, NULL, 6300.00, 1260.00, 200.00, 150.00, 7510.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-07-05 07:15:00', '2026-09-25 13:10:19', 0),
(32, 'SPK-2026-0702', 0, 0, NULL, NULL, NULL, NULL, 11400.00, 2280.00, 400.00, 0.00, 13280.00, 'TRY', 'Havale / EFT ', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-07-12 11:00:00', '2026-09-25 13:11:13', 0),
(33, 'SPK-2026-0703', 0, 0, NULL, NULL, NULL, NULL, 4200.00, 840.00, 100.00, 150.00, 5090.00, 'TRY', 'Havale / EFT', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-07-20 08:45:00', '2026-09-22 11:49:36', 0),
(34, 'SPK-2026-0704', 0, 0, NULL, NULL, NULL, NULL, 9800.00, 1960.00, 300.00, 0.00, 11460.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-07-27 13:20:00', '2026-09-25 13:10:19', 0),
(35, 'SPK-2026-0801', 0, 0, NULL, NULL, NULL, NULL, 3700.00, 740.00, 0.00, 150.00, 4590.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-08-03 06:20:00', '2026-09-25 13:10:19', 0),
(36, 'SPK-2026-0802', 0, 0, NULL, NULL, NULL, NULL, 14200.00, 2840.00, 500.00, 0.00, 16540.00, 'TRY', 'Havale / EFT ', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-08-09 10:10:00', '2026-09-25 13:11:13', 0),
(37, 'SPK-2026-0803', 0, 0, NULL, NULL, NULL, NULL, 5900.00, 1180.00, 150.00, 150.00, 7080.00, 'TRY', 'Havale / EFT', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-08-15 12:40:00', '2026-09-22 11:49:36', 0),
(38, 'SPK-2026-0804', 0, 0, NULL, NULL, NULL, NULL, 7500.00, 1500.00, 200.00, 0.00, 8800.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-08-20 07:00:00', '2026-09-25 13:10:19', 0),
(39, 'SPK-2026-0805', 0, 0, NULL, NULL, NULL, NULL, 2400.00, 480.00, 0.00, 150.00, 3030.00, 'TRY', 'Kapıda Ödeme', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-08-25 08:30:00', '2026-09-22 11:49:36', 0),
(40, 'SPK-2026-0806', 0, 0, NULL, NULL, NULL, NULL, 8100.00, 1620.00, 250.00, 0.00, 9470.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-08-30 13:00:00', '2026-09-25 13:10:19', 0),
(41, 'SPK-2026-0901', 6, 0, NULL, NULL, NULL, NULL, 12500.00, 2500.00, 500.00, 0.00, 14500.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-09-02 07:00:00', '2026-09-25 13:10:19', 0),
(42, 'SPK-2026-0902', 4, 0, NULL, NULL, NULL, NULL, 3000.00, 600.00, 0.00, 150.00, 3750.00, 'TRY', 'Havale / EFT', 3, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-09-06 11:30:00', '2026-09-22 11:50:58', 0),
(43, 'SPK-2026-0903', 3, 0, NULL, NULL, NULL, NULL, 4500.00, 900.00, 200.00, 0.00, 5200.00, 'TRY', 'Havale / EFT ', 2, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-09-10 06:15:00', '2026-09-25 13:11:13', 0),
(44, 'SPK-2026-0904', 1, 0, NULL, NULL, NULL, NULL, 9200.00, 1840.00, 300.00, 0.00, 10740.00, 'TRY', 'Kredi Kartı / Sanal POS', 4, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-09-14 08:40:00', '2026-09-25 13:10:19', 0),
(45, 'SPK-2026-0905', 2, 0, NULL, NULL, NULL, NULL, 6800.00, 1360.00, 200.00, 0.00, 7960.00, 'TRY', 'Kredi Kartı / Sanal POS', 0, '1', NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-09-17 12:20:00', '2026-09-25 13:10:19', 0),
(46, 'SIP-20260925-43CC8', 1, 0, '{\"eposta\": \"destek@ivesgo.com\", \"telefon\": \"05536406710\", \"ad_soyad\": \"Ahmet Yılmaz\", \"vergi_no\": \"1111\", \"firma_unvani\": \"Yılmazlar İnşaat Ltd. Şti.\", \"musteri_tipi\": \"kurumsal\", \"vergi_dairesi\": \"vs\"}', '[{\"id\": \"3\", \"adi\": \"Cam Balkon Fitili\", \"kdv\": 20, \"url\": \"urun/cam-balkon-fitili/\", \"adet\": 5, \"fiyat\": 250, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-003\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 1250}]', '{\"adres\": \"adres\"}', '{\"kisi\": \"\", \"adres\": \"adres tes.\"}', 1041.67, 208.33, 0.00, 200.00, 1450.00, 'TRY', 'Kredi Kartı / Sanal POS', 0, '8', NULL, NULL, NULL, NULL, 'test işlem', '', '176.88.73.60', '2026-09-25 06:40:01', NULL, 0),
(47, 'SIP-20260925-213B0', 1, 0, '{\"eposta\": \"destek@ivesgo.com\", \"telefon\": \"05536406710\", \"ad_soyad\": \"Ahmet Yılmaz\", \"vergi_no\": \"1111\", \"firma_unvani\": \"Yılmazlar İnşaat Ltd. Şti.\", \"musteri_tipi\": \"kurumsal\", \"vergi_dairesi\": \"vs\"}', '[{\"id\": \"3\", \"adi\": \"Cam Balkon Fitili\", \"kdv\": 20, \"url\": \"urun/cam-balkon-fitili/\", \"adet\": 5, \"fiyat\": 250, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-003\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 1250}]', '{\"adres\": \"adres\"}', '{\"kisi\": \"\", \"adres\": \"adres tes.\"}', 1041.67, 208.33, 0.00, 200.00, 1450.00, 'TRY', 'Kredi Kartı / Sanal POS', 0, '8', NULL, NULL, NULL, NULL, 'test işlem', '', '176.88.73.60', '2026-09-25 06:40:11', NULL, 0),
(48, 'SIP-20260925-DFFCA', 1, 0, '{\"eposta\": \"destek@ivesgo.com\", \"telefon\": \"05536406710\", \"ad_soyad\": \"Ahmet Yılmaz\", \"vergi_no\": \"1111\", \"firma_unvani\": \"Yılmazlar İnşaat Ltd. Şti.\", \"musteri_tipi\": \"kurumsal\", \"vergi_dairesi\": \"vs\"}', '[{\"id\": \"3\", \"adi\": \"Cam Balkon Fitili\", \"kdv\": 20, \"url\": \"urun/cam-balkon-fitili/\", \"adet\": 5, \"fiyat\": 250, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-003\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 1250}]', '{\"adres\": \"adres\"}', '{\"kisi\": \"\", \"adres\": \"adres tes.\"}', 1041.67, 208.33, 0.00, 200.00, 1450.00, 'TRY', 'Kredi Kartı / Sanal POS', 0, '8', NULL, NULL, NULL, NULL, 'test işlem', '', '176.88.73.60', '2026-09-25 06:41:33', NULL, 0),
(49, 'SIP-20260925-9236D', 1, 0, '{\"eposta\": \"destek@ivesgo.com\", \"telefon\": \"05536406710\", \"ad_soyad\": \"Ahmet Yılmaz\", \"vergi_no\": \"1111\", \"firma_unvani\": \"Yılmazlar İnşaat Ltd. Şti.\", \"musteri_tipi\": \"kurumsal\", \"vergi_dairesi\": \"vs\"}', '[{\"id\": \"3\", \"adi\": \"Cam Balkon Fitili\", \"kdv\": 20, \"url\": \"urun/cam-balkon-fitili/\", \"adet\": 5, \"fiyat\": 250, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-003\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 1250}]', '{\"adres\": \"adres\"}', '{\"kisi\": \"\", \"adres\": \"adres tes.\"}', 1041.67, 208.33, 0.00, 200.00, 1450.00, 'TRY', 'Kredi Kartı / Sanal POS', 0, '8', NULL, NULL, NULL, NULL, 'test işlem', '', '176.88.73.60', '2026-09-25 06:41:33', NULL, 0),
(50, 'SIP-20260925-A1137', 1, 0, '{\"eposta\": \"destek@ivesgo.com\", \"telefon\": \"05536406710\", \"ad_soyad\": \"Ahmet Yılmaz\", \"vergi_no\": \"1111\", \"firma_unvani\": \"Yılmazlar İnşaat Ltd. Şti.\", \"musteri_tipi\": \"kurumsal\", \"vergi_dairesi\": \"vs\"}', '[{\"id\": \"3\", \"adi\": \"Cam Balkon Fitili\", \"kdv\": 20, \"url\": \"urun/cam-balkon-fitili/\", \"adet\": 5, \"fiyat\": 250, \"resim\": \"assets/images/resim-yok.png\", \"kategori\": \"1\", \"stok_kodu\": \"PROD-003\", \"kdv_durumu\": \"Dahil\", \"satir_toplam\": 1250}]', '{\"adres\": \"adres\"}', '{\"kisi\": \"\", \"adres\": \"adres tes.\"}', 1041.67, 208.33, 0.00, 200.00, 1450.00, 'TRY', 'Kredi Kartı / Sanal POS', 1, '8', NULL, NULL, NULL, NULL, 'test işlem', '', '176.88.73.60', '2026-09-25 06:42:58', '2026-09-25 07:21:00', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_sss`
--

CREATE TABLE `i_sss` (
  `sss_id` int(11) NOT NULL,
  `sss_soru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sıkça Sorulan Soru',
  `sss_cevap` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sorunun detaylı yanıtı',
  `sira` int(11) DEFAULT '0' COMMENT 'Gösterim sıralaması',
  `sss_durum` tinyint(1) DEFAULT '1' COMMENT '1: Aktif Yayınla, 0: Taslak/Pasif',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_sss`
--

INSERT INTO `i_sss` (`sss_id`, `sss_soru`, `sss_cevap`, `sira`, `sss_durum`, `olusturma_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'sss', 'cevapsss', 0, 1, '2026-10-05 16:40:20', '2026-10-05 16:41:10');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_urunler`
--

CREATE TABLE `i_urunler` (
  `urun_id` int(11) NOT NULL,
  `stok_kodu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Benzersiz Stok/SKU Kodu',
  `urun_adi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urun_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urun_kategori` int(11) DEFAULT '0' COMMENT 'Kategoriler tablosundaki ID',
  `marka_id` int(11) DEFAULT '0' COMMENT 'Markalar tablosundaki ID (Varsa)',
  `alis_fiyati` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'CRM Kar/Zarar Raporları İçin (Müşteri Göremez)',
  `urun_fiyat` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Normal Satış Fiyatı (Üstü Çizili Fiyat)',
  `urun_indirim` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'İndirimli Son Satış Fiyatı (Sıfırsa normal fiyat geçerlidir)',
  `urun_kdv` int(2) NOT NULL DEFAULT '20' COMMENT 'KDV Oranı (Örn: 1, 10, 20)',
  `para_birimi` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TRY' COMMENT 'Fiyatın para birimi (TRY, USD, EUR)',
  `urun_stok` int(11) NOT NULL DEFAULT '0' COMMENT 'Mevcut Stok Miktarı',
  `stok_birimi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Adet' COMMENT 'Adet, Kg, Metre, Kutu vb.',
  `kapak_resmi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ürün Listeleme (Ana) Görseli',
  `kisa_aciklama` text COLLATE utf8mb4_unicode_ci COMMENT 'Ürün liste sayfalarındaki özet',
  `urun_aciklama` longtext COLLATE utf8mb4_unicode_ci COMMENT 'Detaylı HTML ürün açıklaması',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Özel Meta Başlığı (Boşsa urun_adi kullanılır)',
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Meta Açıklaması',
  `durum` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Aktif, 0: Pasif',
  `vitrin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: Anasayfada Vitrinde Çıksın',
  `yeni_urun` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: Yeni Etiketi Göster',
  `sira` int(5) NOT NULL,
  `eklenme_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_urunler`
--

INSERT INTO `i_urunler` (`urun_id`, `stok_kodu`, `urun_adi`, `urun_url`, `urun_kategori`, `marka_id`, `alis_fiyati`, `urun_fiyat`, `urun_indirim`, `urun_kdv`, `para_birimi`, `urun_stok`, `stok_birimi`, `kapak_resmi`, `kisa_aciklama`, `urun_aciklama`, `seo_title`, `seo_description`, `durum`, `vitrin`, `yeni_urun`, `sira`, `eklenme_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'PROD-001', 'Endüstriyel LED Armatür', 'endustriyel-led-armatur', 1, 0, 0.00, 1500.00, 1350.00, 20, 'TRY', 4, 'Adet', 'varcanlar-6aabd677545b7.jpg', NULL, NULL, NULL, NULL, 1, 0, 0, 1, '2026-09-18 14:02:39', '2026-09-23 12:06:48'),
(2, 'PROD-002', 'Alüminyum Pergola Sistemi', 'aluminyum-pergola-sistemi', 1, 0, 0.00, 12500.00, 11000.00, 20, 'TRY', 15, 'Adet', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 4, '2026-09-18 14:02:39', '2026-09-23 10:39:11'),
(3, 'PROD-003', 'Cam Balkon Fitili', 'cam-balkon-fitili', 1, 0, 0.00, 250.00, 0.00, 20, 'TRY', 50, 'Adet', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 3, '2026-09-18 14:02:39', '2026-09-23 10:39:11'),
(4, 'PROD-004', 'Plastik Gıda Kabı 500ml', 'plastik-gida-kabi-500ml', 1, 0, 0.00, 5.50, 4.50, 20, 'TRY', 2, 'Adet', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 2, '2026-09-18 14:02:39', '2026-09-23 10:39:11');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_urun_resimler`
--

CREATE TABLE `i_urun_resimler` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `resim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sira` int(11) DEFAULT '0' COMMENT 'Sürükle bırak sıralaması için'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_urun_resimler`
--

INSERT INTO `i_urun_resimler` (`id`, `urun_id`, `resim`, `sira`) VALUES
(6, 1, 'varcanlar-6aabdd1e10335.jpg', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_uyeler`
--

CREATE TABLE `i_uyeler` (
  `uye_id` int(11) NOT NULL,
  `uye_ad_soyad` varchar(150) NOT NULL,
  `uye_kullanici_adi` varchar(255) NOT NULL,
  `uye_sifre` varchar(200) NOT NULL,
  `eski_sifreler` text COMMENT 'Son kullanılan şifrelerin hash geçmişi (JSON)',
  `uye_eposta` varchar(200) NOT NULL,
  `uye_telefon` varchar(25) NOT NULL,
  `uye_resim` varchar(255) NOT NULL,
  `uye_tarih` datetime NOT NULL,
  `uye_rutbe` int(11) NOT NULL,
  `izinler` longtext,
  `face_descriptor` text,
  `uye_bildirim` int(3) NOT NULL,
  `uye_onay` int(11) NOT NULL,
  `activate_code` varchar(120) NOT NULL,
  `son_giris_ip` varchar(50) DEFAULT NULL,
  `son_giris_cihaz` text COMMENT 'Tarayıcı ve Cihaz Bilgisi',
  `giris_token` varchar(255) DEFAULT NULL COMMENT 'Farklı bilgisayar/oturum kontrolü için eşsiz token',
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `i_uyeler`
--

INSERT INTO `i_uyeler` (`uye_id`, `uye_ad_soyad`, `uye_kullanici_adi`, `uye_sifre`, `eski_sifreler`, `uye_eposta`, `uye_telefon`, `uye_resim`, `uye_tarih`, `uye_rutbe`, `izinler`, `face_descriptor`, `uye_bildirim`, `uye_onay`, `activate_code`, `son_giris_ip`, `son_giris_cihaz`, `giris_token`, `remember_token`) VALUES
(1, 'İvesgo Admin', 'ivesgo', '$2y$10$BIKJWKFm7k6.NJTBrX5Ur.AbfQDYekngg70lbWMZ/L6HaljDRNM.u', '$2y$10$7XuyLdSOryoiJINOFROzQ.GRWLzKU.rOV9FGyrBn57YzC0CxrGyhy', 'destek@ivesgo.com', '05536406710', 'ivesgo-crm-6ab51d4481946.jpg', '2016-09-27 00:00:00', 1, '{\"siparisler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"markalar\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"kampanyalar\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"raporlar\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"ziyaretler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"personeller\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"urunler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"kategoriler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"blog\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"sayfalar\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"menuler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"musteri-yorumlari\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"galeri\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"slider\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"sss\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"tarihce\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"iletisim\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"ekibimiz\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"bakim\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"seo-sayfa\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"sabit-resim\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"mail\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"logs\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"ayarlar\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"}}', '[-0.12340622395277023,0.10487033426761627,0.007651126943528652,-0.04994926601648331,0.013105648569762707,-0.012271536514163017,0.015804344788193703,-0.06702752411365509,0.1614486575126648,-0.04667259380221367,0.22927260398864746,0.07262428849935532,-0.2472028136253357,-0.05197611451148987,-0.02901579812169075,0.10564075410366058,-0.10525405406951904,-0.1545371562242508,-0.1535956859588623,-0.09216596931219101,0.004385787528008223,0.02750851772725582,0.08182945847511292,0.01226903684437275,-0.15286172926425934,-0.2721570134162903,-0.016407595947384834,-0.11046814173460007,0.13989493250846863,-0.10250673443078995,0.03676125779747963,-0.03201843053102493,-0.1866544485092163,-0.019622040912508965,-0.053821809589862823,0.052061259746551514,-0.06874274462461472,-0.12214208394289017,0.3248319625854492,0.04238226264715195,-0.1864062398672104,0.04264264553785324,-0.009949620813131332,0.2735452353954315,0.15915505588054657,-0.058410245925188065,0.1320909857749939,-0.11605960130691528,0.06005336716771126,-0.32320964336395264,0.1042889803647995,0.11894825845956802,0.05588332936167717,0.13370168209075928,0.008510727435350418,-0.2325342744588852,0.0013401855248957872,0.1754571497440338,-0.2151017040014267,0.11377448588609695,0.028091387823224068,0.03702496364712715,-0.013116668909788132,0.004304100759327412,0.26328009366989136,0.14172691106796265,-0.18717853724956512,-0.10351159423589706,0.13635556399822235,-0.14065417647361755,0.009912602603435516,0.134081169962883,-0.074012890458107,-0.20982162654399872,-0.26299208402633667,0.17859232425689697,0.32642295956611633,0.14201748371124268,-0.11159174144268036,0.02145969122648239,-0.12837739288806915,-0.012695282697677612,0.04503078758716583,0.07715968042612076,-0.1184951588511467,-0.030848756432533264,-0.053927984088659286,0.03318587318062782,0.20312751829624176,0.05446072295308113,-0.10342244058847427,0.2244376391172409,0.05344066768884659,0.02165050432085991,0.004126792773604393,0.18560448288917542,-0.11838885396718979,-0.014799593947827816,-0.06947534531354904,0.06422816216945648,0.05089866742491722,-0.06037260591983795,0.03769101947546005,0.11018810421228409,-0.11808353662490845,0.17939938604831696,-0.034928157925605774,-0.03399917110800743,0.019770266488194466,0.012414024211466312,-0.026125552132725716,-0.03809020668268204,0.10578037053346634,-0.27196621894836426,0.2677808701992035,0.20553168654441833,0.06889870017766953,0.16586695611476898,0.13939538598060608,0.03912678360939026,0.04629789665341377,0.03840186819434166,-0.1584903597831726,-0.014142278581857681,0.0332462340593338,-0.008946898393332958,0.05467061698436737,0.07623975723981857]', 1, 1, '', '176.88.75.161', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '1d78d660a3de9747eaa244e4b94bfe9d', NULL),
(2, 'Admin', 'admin', '$2y$10$xDQfDDEzxMEk8pf5wpiuAO4Q0OZpk0rfyMtS0NWFsSuYVrz5DAdcu', NULL, 'admin@ivesgo.com', '', 'ivesgo-TgATHwIuKp.jpg', '2016-09-27 00:00:00', 2, '{\"musteriler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"siparisler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"urunler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"kategoriler\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"markalar\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"kampanyalar\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"ziyaretler\":{\"goruntule\":\"1\",\"ekle\":\"1\"},\"personeller\":{\"goruntule\":\"1\",\"ekle\":\"1\",\"duzenle\":\"1\",\"durum\":\"1\",\"sil\":\"1\"},\"logs\":{\"goruntule\":\"1\"},\"ayarlar\":{\"goruntule\":\"1\"}}', NULL, 1, 1, '', '176.88.74.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '7b5041235289df06e2dd1386c9256ba8', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `i_yorumlar`
--

CREATE TABLE `i_yorumlar` (
  `yorum_id` int(11) NOT NULL,
  `yorum_ad_soyad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Yorumu Yapan Kişi / Kurum Adı',
  `yorum_unvan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kişinin Unvanı veya Şirketi (Örn: Genel Müdür, ABC Ltd.)',
  `yorum_metin` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Müşteri Yorumu / Görüşü',
  `yorum_puan` tinyint(1) DEFAULT '5' COMMENT 'Yıldız Puanı (1 ila 5 arası)',
  `yorum_resim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kişi Fotoğrafı veya Logo',
  `sira` int(11) DEFAULT '0' COMMENT 'Gösterim sıralaması',
  `yorum_durum` tinyint(1) DEFAULT '1' COMMENT '1: Onaylı/Yayında, 0: Beklemede/Pasif',
  `olusturma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP,
  `guncelleme_tarihi` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `i_yorumlar`
--

INSERT INTO `i_yorumlar` (`yorum_id`, `yorum_ad_soyad`, `yorum_unvan`, `yorum_metin`, `yorum_puan`, `yorum_resim`, `sira`, `yorum_durum`, `olusturma_tarihi`, `guncelleme_tarihi`) VALUES
(1, 'ad', 'ünvan', 'yorum içerik', 5, 'ivesgo-crm-6ac3b1614f4df.png', 0, 1, '2026-10-05 17:17:07', '2026-10-05 17:17:14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sehirler`
--

CREATE TABLE `sehirler` (
  `il_id` int(11) NOT NULL,
  `il_adi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `sehirler`
--

INSERT INTO `sehirler` (`il_id`, `il_adi`) VALUES
(1, 'ADANA'),
(2, 'ADIYAMAN'),
(3, 'AFYONKARAHİSAR'),
(4, 'AĞRI'),
(5, 'AMASYA'),
(6, 'ANKARA'),
(7, 'ANTALYA'),
(8, 'ARTVİN'),
(9, 'AYDIN'),
(10, 'BALIKESİR'),
(11, 'BİLECİK'),
(12, 'BİNGÖL'),
(13, 'BİTLİS'),
(14, 'BOLU'),
(15, 'BURDUR'),
(16, 'BURSA'),
(17, 'ÇANAKKALE'),
(18, 'ÇANKIRI'),
(19, 'ÇORUM'),
(20, 'DENİZLİ'),
(21, 'DİYARBAKIR'),
(22, 'EDİRNE'),
(23, 'ELAZIĞ'),
(24, 'ERZİNCAN'),
(25, 'ERZURUM'),
(26, 'ESKİŞEHİR'),
(27, 'GAZİANTEP'),
(28, 'GİRESUN'),
(29, 'GÜMÜŞHANE'),
(30, 'HAKKARİ'),
(31, 'HATAY'),
(32, 'ISPARTA'),
(33, 'MERSİN'),
(34, 'İSTANBUL'),
(35, 'İZMİR'),
(36, 'KARS'),
(37, 'KASTAMONU'),
(38, 'KAYSERİ'),
(39, 'KIRKLARELİ'),
(40, 'KIRŞEHİR'),
(41, 'KOCAELİ'),
(42, 'KONYA'),
(43, 'KÜTAHYA'),
(44, 'MALATYA'),
(45, 'MANİSA'),
(46, 'KAHRAMANMARAŞ'),
(47, 'MARDİN'),
(48, 'MUĞLA'),
(49, 'MUŞ'),
(50, 'NEVŞEHİR'),
(51, 'NİĞDE'),
(52, 'ORDU'),
(53, 'RİZE'),
(54, 'SAKARYA'),
(55, 'SAMSUN'),
(56, 'SİİRT'),
(57, 'SİNOP'),
(58, 'SİVAS'),
(59, 'TEKİRDAĞ'),
(60, 'TOKAT'),
(61, 'TRABZON'),
(62, 'TUNCELİ'),
(63, 'ŞANLIURFA'),
(64, 'UŞAK'),
(65, 'VAN'),
(66, 'YOZGAT'),
(67, 'ZONGULDAK'),
(68, 'AKSARAY'),
(69, 'BAYBURT'),
(70, 'KARAMAN'),
(71, 'KIRIKKALE'),
(72, 'BATMAN'),
(73, 'ŞIRNAK'),
(74, 'BARTIN'),
(75, 'ARDAHAN'),
(76, 'IĞDIR'),
(77, 'YALOVA'),
(78, 'KARABÜK'),
(79, 'KİLİS'),
(80, 'OSMANİYE'),
(81, 'DÜZCE');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `personel_id` int(11) DEFAULT NULL,
  `islem_turu` varchar(50) NOT NULL,
  `modul` varchar(100) DEFAULT NULL,
  `aciklama` text NOT NULL,
  `ip_adresi` varchar(45) NOT NULL,
  `tarih` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `system_logs`
--

INSERT INTO `system_logs` (`id`, `personel_id`, `islem_turu`, `modul`, `aciklama`, `ip_adresi`, `tarih`) VALUES
(1, 1, 'DELETE', 'Siparişler', 'Sipariş Kodu: SPK-2026-0604 olan sipariş silindi.', '176.88.73.60', '2026-09-25 17:36:19'),
(2, 1, 'UPDATE', 'Siparişler', 'Sipariş Kodu: SPK-2026-0401 için sipariş güncellendi.', '176.88.73.60', '2026-09-25 17:39:41'),
(3, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:18:15'),
(4, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:19:05'),
(5, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:22:32'),
(6, 2, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 2 - Admin, IP Adresi 176.88.73.11, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.73.11', '2026-09-29 16:31:11'),
(7, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:31:38'),
(8, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:33:11'),
(9, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:40:28'),
(10, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:41:48'),
(11, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:41:58'),
(12, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:42:08'),
(13, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:42:18'),
(14, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:44:00'),
(15, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:44:18'),
(16, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:44:25'),
(17, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:44:34'),
(18, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:44:48'),
(19, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:45:20'),
(20, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:45:25'),
(21, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:45:33'),
(22, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:45:39'),
(23, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:47:10'),
(24, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:55:35'),
(25, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 16:55:40'),
(26, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:00:58'),
(27, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:01:04'),
(28, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:13:18'),
(29, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:13:28'),
(30, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:15:06'),
(31, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:15:11'),
(32, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:15:51'),
(33, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.73.11', '2026-09-29 17:20:09'),
(34, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.72.25', '2026-09-30 09:46:25'),
(35, 1, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 1 - İvesgo Admin, IP Adresi 176.88.74.90, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.74.90', '2026-10-01 15:07:19'),
(36, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : Admin, ID 2', '176.88.74.90', '2026-10-01 15:24:35'),
(37, 2, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 2 - Admin, IP Adresi 176.88.74.90, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.74.90', '2026-10-01 15:24:46'),
(38, 1, 'UPDATE', 'KILAVUZ', 'Kullanım kılavuzu ve SSS içerikleri güncellendi.', '176.88.74.90', '2026-10-01 16:13:23'),
(39, 1, 'UPDATE', 'KILAVUZ', 'Kullanım kılavuzu ve SSS içerikleri güncellendi.', '176.88.74.90', '2026-10-01 16:26:53'),
(40, 1, 'UPDATE', 'KILAVUZ', 'Kullanım kılavuzu ve SSS içerikleri güncellendi.', '176.88.74.90', '2026-10-01 16:39:50'),
(41, 1, 'UPDATE', 'KILAVUZ', 'Kullanım kılavuzu ve SSS içerikleri güncellendi.', '176.88.74.90', '2026-10-01 16:41:39'),
(42, 1, 'UPDATE', 'KILAVUZ', 'Kullanım kılavuzu ve SSS içerikleri güncellendi.', '176.88.74.90', '2026-10-01 16:44:08'),
(43, 1, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 1 - İvesgo Admin, IP Adresi 176.88.74.254, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.74.254', '2026-10-02 16:10:31'),
(44, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.74.254', '2026-10-02 16:36:02'),
(45, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.74.254', '2026-10-02 16:48:41'),
(46, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.74.254', '2026-10-02 16:50:13'),
(47, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.74.254', '2026-10-02 16:58:25'),
(48, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.74.254', '2026-10-02 17:13:34'),
(49, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.74.254', '2026-10-02 17:13:57'),
(50, 1, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 1 - İvesgo Admin, IP Adresi 176.88.75.232, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.75.232', '2026-10-05 09:50:09'),
(51, 1, 'DELETE', 'Siparişler', 'Sipariş Kodu: SPK-2026-0102 olan sipariş silindi.', '176.88.75.232', '2026-10-05 15:05:44'),
(52, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.232', '2026-10-05 15:25:54'),
(53, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.232', '2026-10-05 15:25:59'),
(54, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.232', '2026-10-05 15:26:28'),
(55, 1, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 1 - İvesgo Admin, IP Adresi 176.88.74.225, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.74.225', '2026-10-06 09:46:52'),
(56, 1, 'UPDATE', 'Ayarlar', 'API ayarları güncellenmiştir.', '176.88.74.225', '2026-10-06 10:56:11'),
(57, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.74.225', '2026-10-06 10:57:45'),
(58, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.74.225', '2026-10-06 10:57:53'),
(59, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.74.225', '2026-10-06 11:18:57'),
(60, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.74.225', '2026-10-06 11:22:34'),
(61, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.74.225', '2026-10-06 11:30:28'),
(62, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : İvesgo Admin, ID 1', '176.88.74.225', '2026-10-06 11:31:08'),
(63, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : İvesgo Admin, ID 1', '176.88.74.225', '2026-10-06 11:40:59'),
(64, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.74.225', '2026-10-06 11:55:35'),
(65, 1, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 1 - İvesgo Admin, IP Adresi 176.88.75.192, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.75.192', '2026-10-07 09:32:57'),
(66, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.192', '2026-10-07 10:02:42'),
(67, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.192', '2026-10-07 10:02:47'),
(68, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.192', '2026-10-07 10:03:53'),
(69, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.192', '2026-10-07 10:03:59'),
(70, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:07:46'),
(71, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:14:37'),
(72, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:15:18'),
(73, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:47:26'),
(74, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:53:16'),
(75, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:55:54'),
(76, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:56:37'),
(77, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:57:12'),
(78, 1, 'UPDATE', 'Ayarlar', 'Sistem Ayarları Güncellenmiştir.', '176.88.75.192', '2026-10-07 10:58:49'),
(79, 1, 'UPDATE', 'PERSONEL', 'Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : İvesgo Admin, ID 1', '176.88.75.192', '2026-10-07 13:20:31'),
(80, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.192', '2026-10-07 13:21:31'),
(81, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.192', '2026-10-07 13:30:11'),
(82, 1, 'UPDATE', 'Ayarlar', 'Modül ayarları güncellenmiştir.', '176.88.75.192', '2026-10-07 13:33:09'),
(83, 1, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 1 - İvesgo Admin, IP Adresi 176.88.74.44, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.74.44', '2026-10-08 17:02:06'),
(84, 1, 'LOGIN', 'Giriş', 'Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı 1 - İvesgo Admin, IP Adresi 176.88.75.161, Cihaz Bilgisi Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '176.88.75.161', '2026-10-09 09:35:33');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ilceler`
--
ALTER TABLE `ilceler`
  ADD PRIMARY KEY (`ilce_id`),
  ADD KEY `ilce_il_id` (`ilce_il_id`);

--
-- Tablo için indeksler `i_ayar`
--
ALTER TABLE `i_ayar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_bildirimler`
--
ALTER TABLE `i_bildirimler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_bloglar`
--
ALTER TABLE `i_bloglar`
  ADD PRIMARY KEY (`blog_id`),
  ADD UNIQUE KEY `blog_url` (`blog_url`);

--
-- Tablo için indeksler `i_ekibimiz`
--
ALTER TABLE `i_ekibimiz`
  ADD PRIMARY KEY (`ekip_id`),
  ADD UNIQUE KEY `ekip_url` (`ekip_url`);

--
-- Tablo için indeksler `i_fotograflar`
--
ALTER TABLE `i_fotograflar`
  ADD PRIMARY KEY (`fotograf_id`);

--
-- Tablo için indeksler `i_galeri`
--
ALTER TABLE `i_galeri`
  ADD PRIMARY KEY (`galeri_id`);

--
-- Tablo için indeksler `i_kampanyalar`
--
ALTER TABLE `i_kampanyalar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kampanya_kodu` (`kampanya_kodu`);

--
-- Tablo için indeksler `i_kategoriler`
--
ALTER TABLE `i_kategoriler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_kategori_url` (`kategori_url`),
  ADD KEY `idx_ust_id` (`ust_id`),
  ADD KEY `idx_durum` (`durum`),
  ADD KEY `idx_sira` (`sira`);

--
-- Tablo için indeksler `i_markalar`
--
ALTER TABLE `i_markalar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_marka_url` (`marka_url`),
  ADD KEY `idx_durum` (`durum`),
  ADD KEY `idx_sira` (`sira`);

--
-- Tablo için indeksler `i_menuler`
--
ALTER TABLE `i_menuler`
  ADD PRIMARY KEY (`menu_id`);

--
-- Tablo için indeksler `i_musteriler`
--
ALTER TABLE `i_musteriler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_musteri_tipi` (`musteri_tipi`),
  ADD KEY `idx_durum` (`durum`),
  ADD KEY `idx_eposta` (`eposta`),
  ADD KEY `idx_vergi_no` (`vergi_no`);

--
-- Tablo için indeksler `i_sabit_resimler`
--
ALTER TABLE `i_sabit_resimler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_sabit_sayfalar`
--
ALTER TABLE `i_sabit_sayfalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_sayfalar`
--
ALTER TABLE `i_sayfalar`
  ADD PRIMARY KEY (`sayfa_id`),
  ADD UNIQUE KEY `sayfa_url` (`sayfa_url`);

--
-- Tablo için indeksler `i_sayfa_resimler`
--
ALTER TABLE `i_sayfa_resimler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `i_siparisler`
--
ALTER TABLE `i_siparisler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siparis_kodu` (`siparis_kodu`),
  ADD KEY `musteri_id` (`musteri_id`),
  ADD KEY `siparis_durumu` (`siparis_durumu`),
  ADD KEY `odeme_durumu` (`odeme_durumu`);

--
-- Tablo için indeksler `i_sss`
--
ALTER TABLE `i_sss`
  ADD PRIMARY KEY (`sss_id`);

--
-- Tablo için indeksler `i_urunler`
--
ALTER TABLE `i_urunler`
  ADD PRIMARY KEY (`urun_id`),
  ADD UNIQUE KEY `idx_stok_kodu` (`stok_kodu`),
  ADD UNIQUE KEY `idx_urun_url` (`urun_url`),
  ADD KEY `idx_urun_kategori` (`urun_kategori`),
  ADD KEY `idx_durum` (`durum`);

--
-- Tablo için indeksler `i_urun_resimler`
--
ALTER TABLE `i_urun_resimler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_urun_id` (`urun_id`);

--
-- Tablo için indeksler `i_uyeler`
--
ALTER TABLE `i_uyeler`
  ADD PRIMARY KEY (`uye_id`);

--
-- Tablo için indeksler `i_yorumlar`
--
ALTER TABLE `i_yorumlar`
  ADD PRIMARY KEY (`yorum_id`);

--
-- Tablo için indeksler `sehirler`
--
ALTER TABLE `sehirler`
  ADD PRIMARY KEY (`il_id`);

--
-- Tablo için indeksler `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ilceler`
--
ALTER TABLE `ilceler`
  MODIFY `ilce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=959;

--
-- Tablo için AUTO_INCREMENT değeri `i_ayar`
--
ALTER TABLE `i_ayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_bildirimler`
--
ALTER TABLE `i_bildirimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `i_bloglar`
--
ALTER TABLE `i_bloglar`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_ekibimiz`
--
ALTER TABLE `i_ekibimiz`
  MODIFY `ekip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_fotograflar`
--
ALTER TABLE `i_fotograflar`
  MODIFY `fotograf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_galeri`
--
ALTER TABLE `i_galeri`
  MODIFY `galeri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `i_kampanyalar`
--
ALTER TABLE `i_kampanyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `i_kategoriler`
--
ALTER TABLE `i_kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `i_markalar`
--
ALTER TABLE `i_markalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_menuler`
--
ALTER TABLE `i_menuler`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `i_musteriler`
--
ALTER TABLE `i_musteriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `i_sabit_resimler`
--
ALTER TABLE `i_sabit_resimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `i_sabit_sayfalar`
--
ALTER TABLE `i_sabit_sayfalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_sayfalar`
--
ALTER TABLE `i_sayfalar`
  MODIFY `sayfa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_sayfa_resimler`
--
ALTER TABLE `i_sayfa_resimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `i_siparisler`
--
ALTER TABLE `i_siparisler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Tablo için AUTO_INCREMENT değeri `i_sss`
--
ALTER TABLE `i_sss`
  MODIFY `sss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `i_urunler`
--
ALTER TABLE `i_urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `i_urun_resimler`
--
ALTER TABLE `i_urun_resimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `i_uyeler`
--
ALTER TABLE `i_uyeler`
  MODIFY `uye_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `i_yorumlar`
--
ALTER TABLE `i_yorumlar`
  MODIFY `yorum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
