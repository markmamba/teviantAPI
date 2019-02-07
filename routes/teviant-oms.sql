-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 26, 2019 at 03:01 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `teviant_oms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `belongs_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `created_at`, `updated_at`, `parent_id`, `lft`, `rgt`, `depth`, `name`, `slug`, `belongs_to`) VALUES
(1, NULL, NULL, 1, 3, 12, 2, 'Categories', 'categories', NULL),
(2, NULL, NULL, NULL, 30, 43, 1, 'Groups', 'groups', NULL),
(3, NULL, NULL, 1, 3, 12, 2, 'Eyes', 'eyes', NULL),
(6, NULL, NULL, 2, 31, 32, 2, 'Artist\'s Pick', 'artist-s-pick', NULL),
(7, NULL, NULL, 2, 33, 34, 2, 'Best Featured', 'best-featured', NULL),
(8, NULL, NULL, 2, 35, 36, 2, 'Best Sellers', 'best-sellers', NULL),
(9, NULL, NULL, 2, 37, 38, 2, 'Featured', 'featured', NULL),
(10, NULL, NULL, 2, 39, 40, 2, 'New', 'new', NULL),
(11, NULL, NULL, 2, 41, 42, 2, 'Collections', 'collections', NULL),
(12, NULL, NULL, 1, 21, 28, 2, 'Accessories', 'accessories', NULL),
(13, NULL, NULL, 15, 16, 17, 3, 'Eyebrow Tint', 'eyebrow-tint', NULL),
(14, NULL, NULL, 15, 18, 19, 3, 'Eyebrow Gel', 'eyebrow-gel', NULL),
(15, NULL, NULL, 1, 13, 20, 2, 'Eyebrows', 'eyebrows', NULL),
(16, NULL, NULL, 3, 6, 7, 3, 'Pen Eyeliner', 'pen-eyeliner', NULL),
(17, NULL, NULL, 3, 10, 11, 3, 'Mascara', 'mascara', NULL),
(18, NULL, NULL, 15, 14, 15, 3, 'Eyebrow Duo', 'eyebrow-duo', NULL),
(19, NULL, NULL, 12, 22, 23, 3, 'Upper Lashes', 'upper-lashes', NULL),
(20, NULL, NULL, 12, 24, 25, 3, 'Lower Lashes', 'lower-lashes', NULL),
(21, NULL, NULL, 12, 26, 27, 3, 'Tools', 'tools', NULL),
(22, NULL, NULL, 3, 4, 5, 3, 'Eye Shadow Palette', 'eye-shadow-palette', NULL),
(23, NULL, NULL, 3, 8, 9, 3, 'Glitter Liner', 'glitter-liner', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `metric_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_assembly` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(13,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `parent_id`, `created_at`, `updated_at`, `deleted_at`, `category_id`, `user_id`, `metric_id`, `name`, `description`, `is_assembly`, `price`) VALUES
(1, NULL, NULL, '2018-12-24 11:38:18', NULL, NULL, NULL, 3, 'Amore Eyeshadow Palette', '<p><big>Teviant x Love Marie Collection</big></p>\r\n\r\n<p><big>Here&rsquo;s to new beginnings. Embracing innocence and naivit&eacute;, Amore is a soft breath of fresh air. She has a fresh take on life and is ready to experience it.</big></p>\r\n\r\n<p><big>Soft and earth-toned shades for a soft, everyday look. With various shades of nude that&rsquo;s suitable for all skin tones.</big></p>\r\n\r\n<p><big>Use matte colors on the whole eyelid, followed by shimmery shades in the middle for definition. Concentrate dark tones on the outside, intensifying according to time of day.</big></p>\r\n\r\n<p><big>Shades included:&nbsp;<br />\r\nStellato - Shimmery champagne<br />\r\nRosa - Holographic salmon with gold undertones<br />\r\nGrazie - Matte nude<br />\r\nGelato - Shimmery cinnamon brown<br />\r\nSole - Matte brown<br />\r\nVita - Shimmery copper<br />\r\nBella - Shimmery bronze<br />\r\nToscana - Shimmery rose gold<br />\r\nAllora - Shimmery light gold<br />\r\nDolce - Matte light mocha<br />\r\nCappucino - Frosted nude<br />\r\nMilano - Matte brick red</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '2450.00'),
(2, NULL, '2018-11-29 02:23:35', '2019-01-04 14:59:46', NULL, NULL, NULL, 3, 'Mademoiselle Eyeshadow Palette', '<p><big>Teviant x Love Marie Collection</big></p>\r\n\r\n<p><big>Fly free as a bird. A daydreamer and goal getter, Mademoiselle rides the waves yet loves a good experiment. She lives in the moment and is constantly on a mission to find herself.&nbsp;</big></p>\r\n\r\n<p><big>Jewel-toned pigments for rendezvous-ready eyes. A balanced mix of pigments and textures for that bold eye look in just one palette. A great transition palette from day to night. Use the more sober colors for day and build on it with jewel-toned hues for night.</big></p>\r\n\r\n<p><big>Shades included:&nbsp;</big></p>\r\n\r\n<p><big>La Mode - Frosted amethyst purple<br />\r\nOoh Lala - Matte cobalt blue&nbsp;<br />\r\nMonde - Shimmery cerulean blue<br />\r\nCest La Vie - Holographic off white with banana yellow glitter undertones<br />\r\nProvences - Holographic navy blue with lavander glitter undertones<br />\r\nLavande - Shimmery lavander with silver undertones<br />\r\nBonjour - Shimmery mica yellow<br />\r\nEiffel - Shimmery bronze&nbsp;<br />\r\nMerci - Holographic turquoise with gold glitter undertones<br />\r\nCafe - Matte coffee brown with pink glitter undertones<br />\r\nNuit - Holographic midnight blue&nbsp;<br />\r\nRendezvous - Shimmery gunmetal with silver glitter undertones</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '2450.00'),
(3, NULL, '2018-11-29 02:24:27', '2018-12-11 23:25:01', NULL, NULL, NULL, 3, 'Señorita Eyeshadow Palette', '<p><big>Teviant x Love Marie Collection</big></p>\r\n\r\n<p><big>Life is an endless party. Finding love and enjoying her youth, Se&ntilde;orita is the embodiment of rebellious passion. She is charming and mysterious&mdash;a soul that has been set on fire.&nbsp;<br />\r\nLadylike tones for a look that&rsquo;s forever young. A versatile palette that coasts from simple, to soft, to glamorous, to bold. Choose the pastel and neutral shades for a feminine look, or use the bold and dark colors for added edge.</big></p>\r\n\r\n<p><big>Shades included:&nbsp;</big></p>\r\n\r\n<p><big>Beso - Multidimensional holographic purple with blue glitter undertones<br />\r\nEnvy - Holographic forest green<br />\r\nMialma - Matte dark brown&nbsp;<br />\r\nDestiny - Metallic silver<br />\r\nFantasia - Metallic rust orange<br />\r\nLust - Matte blue violet<br />\r\nSangria - Metallic sangria purple<br />\r\nCarino - Holographic baby pink with purple glitter undertones<br />\r\nVivir - Matte brown with silver glitter<br />\r\nChica - Multidimensional holographic old rose shade with light blue glitter undertones<br />\r\nPapi - Matte umber brown with gold glitter undertones<br />\r\nAzar - Shimmery black with silver glitter</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '2450.00'),
(4, NULL, '2018-11-29 02:25:21', '2018-12-11 16:56:33', NULL, NULL, NULL, 3, 'Queen Eyeshadow Palette', '<p><big>Teviant x Love Marie Collection</big></p>\r\n\r\n<p><big>She&rsquo;s out to conquer the world&mdash;with her crown in place. Like true royalty, Queen is aware of herself and exudes power, elegance, and regality. At the end of the day, she always knows that her best bet is herself.</big></p>\r\n\r\n<p><big>Candy pop bright colors for a boost of makeup-induced confidence. Richly pigmented, colors stand out in a swipe. Go ahead, be bold and don&rsquo;t be afraid to combine!</big></p>\r\n\r\n<p><big>Shades included:&nbsp;<br />\r\nNeit - Matte red orange<br />\r\nNile - Matte Mandarin orange<br />\r\nPalace - Frosted royal gold<br />\r\nAswan - Shimmery walnut brown<br />\r\nCleo - Matte mustard&nbsp;<br />\r\nLuxor - Metallic orange<br />\r\nRegal - Matte lilac<br />\r\nOffering - Matte Jet black with subtle silver sparkles<br />\r\nWorship - Holographic lemon yellow gold&nbsp;<br />\r\nScarab - Metallic copper<br />\r\nRania - Shimmery silver<br />\r\nPharoah - Shimmery gunmetal</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '2450.00'),
(5, NULL, '2018-11-29 02:27:04', '2018-12-06 12:29:40', NULL, NULL, NULL, 3, 'Madam Eyebrow Gel', '<p><big>This special no-clump formulation allows for coverage while maintaining a natural look. With enough product on the wand, brush up to shape and to&nbsp;set eyebrows.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nMadam - Dark Brown<br />\r\nLady - Medium Brown<br />\r\nDame - Red Brown<br />\r\nMiss - Light Brown</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(6, NULL, '2018-11-29 02:28:09', '2018-12-05 00:26:36', NULL, NULL, NULL, 3, 'Lady Eyebrow Gel', '<p><big>This special no-clump formulation allows for coverage while maintaining a natural look. With enough product on the wand, brush up to shape and to&nbsp;set eyebrows.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nMadam - Dark Brown<br />\r\nLady - Medium Brown<br />\r\nDame - Red Brown<br />\r\nMiss - Light Brown</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '995.00'),
(7, NULL, '2018-11-29 02:28:50', '2018-12-05 00:26:26', NULL, NULL, NULL, 3, 'Dame Eyebrow Gel', '<p><big>This special no-clump formulation allows for coverage while maintaining a natural look. With enough product on the wand, brush up to shape and to&nbsp;set eyebrows.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nMadam - Dark Brown<br />\r\nLady - Medium Brown<br />\r\nDame - Red Brown<br />\r\nMiss - Light Brown</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '995.00'),
(8, NULL, '2018-11-29 02:29:52', '2018-12-05 00:26:57', NULL, NULL, NULL, 3, 'Miss Eyebrow Gel', '<p><big>This special no-clump formulation allows for coverage while maintaining a natural look. With enough product on the wand, brush up to shape and to&nbsp;set eyebrows.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nMadam - Dark Brown<br />\r\nLady - Medium Brown<br />\r\nDame - Red Brown<br />\r\nMiss - Light Brown</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(9, NULL, '2018-11-29 02:30:43', '2018-12-08 21:28:13', NULL, NULL, NULL, 3, 'Pearl Glitter Liner', '<p><big>Formulated in Italy, this long-wearing, quick drying eyeliner is composed of precise sizes of glitter particles and materials within safety standards. With the thin applicator brush, build on multiple swipes or apply on top of liquid eyeliner for a fun look.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nPearl - White<br />\r\nAmber - Rose Gold<br />\r\nOro - Gold<br />\r\nArgent - Silver</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '995.00'),
(10, NULL, '2018-11-29 02:31:42', '2019-01-04 17:26:40', NULL, NULL, NULL, 3, 'Amber Glitter Liner', '<p><big>Formulated in Italy, this long-wearing, quick drying eyeliner is composed of precise sizes of glitter particles and materials within safety standards. With the thin applicator brush, build on multiple swipes or apply on top of liquid eyeliner for a fun look.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nPearl - White<br />\r\nAmber - Rose Gold<br />\r\nOro - Gold<br />\r\nArgent - Silver</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(11, NULL, '2018-11-29 02:32:35', '2018-12-11 17:39:01', NULL, NULL, NULL, 3, 'Oro Glitter Liner', '<p><big>Formulated in Italy, this long-wearing, quick drying eyeliner is composed of precise sizes of glitter particles and materials within safety standards. With the thin applicator brush, build on multiple swipes or apply on top of liquid eyeliner for a fun look.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nPearl - White<br />\r\nAmber - Rose Gold<br />\r\nOro - Gold<br />\r\nArgent - Silver</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(12, NULL, '2018-11-29 02:34:11', '2019-01-04 17:26:40', NULL, NULL, NULL, 3, 'Argent Glitter Liner', '<p><big>Formulated in Italy, this long-wearing, quick drying eyeliner is composed of precise sizes of glitter particles and materials within safety standards. With the thin applicator brush, build on multiple swipes or apply on top of liquid eyeliner for a fun look.</big></p>\r\n\r\n<p><big>Available in four shades:<br />\r\nPearl - White<br />\r\nAmber - Rose Gold<br />\r\nOro - Gold<br />\r\nArgent - Silver</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(13, NULL, '2018-11-29 02:35:58', '2018-12-05 00:02:38', NULL, NULL, NULL, 3, 'Empress Eyebrow Duo Powder', '<p><big>Emphasize, fix, and redesign the eyebrows or simply give them a more pronounced color. Compacted powder with a velvety and covering touch, the formula is enriched with a texturizing amino-acid derivative that confers softness and spreadability. Ideal to fill an unclear eyebrow arch or draw colored strokes to increase the volume effect. Double-function, it is ideal to fill or draw at strokes.</big></p>\r\n\r\n<p><big>Create the perfect eyebrow gradient with this highly pigmented eyebrow duo. Each product comes in a dark and light powder. Apply the darker shade from the outside to the arch point, and the lighter shade from the inner brow until it blends with the darker color. Blend further until natural-looking.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nEmpress - Dark Brown<br />\r\nQueen - Medium Brown<br />\r\nHighness - Light Brown</big></p>\r\n\r\n<p><strong><big>Ship&nbsp;out December 15, 2018.</big></strong></p>', 0, '995.00'),
(14, NULL, '2018-11-29 02:36:52', '2018-12-05 22:11:25', NULL, NULL, NULL, 3, 'Queen Eyebrow Duo Powder', '<p><big>Emphasize, fix, and redesign the eyebrows or simply give them a more pronounced color. Compacted powder with a velvety and covering touch, the formula is enriched with a texturizing amino-acid derivative that confers softness and spreadability. Ideal to fill an unclear eyebrow arch or draw colored strokes to increase the volume effect. Double-function, it is ideal to fill or draw at strokes.</big></p>\r\n\r\n<p><big>Create the perfect eyebrow gradient with this highly pigmented eyebrow duo. Each product comes in a dark and light powder. Apply the darker shade from the outside to the arch point, and the lighter shade from the inner brow until it blends with the darker color. Blend further until natural-looking.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nEmpress - Dark Brown<br />\r\nQueen - Medium Brown<br />\r\nHighness - Light Brown</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(15, NULL, '2018-11-29 02:38:42', '2018-12-09 09:27:29', NULL, NULL, NULL, 3, 'Highness Eyebrow Duo Powder', '<p><big>Emphasize, fix, and redesign the eyebrows or simply give them a more pronounced color. Compacted powder with a velvety and covering touch, the formula is enriched with a texturizing amino-acid derivative that confers softness and spreadability. Ideal to fill an unclear eyebrow arch or draw colored strokes to increase the volume effect. Double-function, it is ideal to fill or draw at strokes.</big></p>\r\n\r\n<p><big>Create the perfect eyebrow gradient with this highly pigmented eyebrow duo. Each product comes in a dark and light powder. Apply the darker shade from the outside to the arch point, and the lighter shade from the inner brow until it blends with the darker color. Blend further until natural-looking.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nEmpress - Dark Brown<br />\r\nQueen - Medium Brown<br />\r\nHighness - Light Brown</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(16, NULL, '2018-11-29 02:45:44', '2018-12-05 00:04:34', NULL, NULL, NULL, 3, 'She Eyebrow Tint', '<p><big>Long-lasting, smudge proof, waterproof, and glamorous round the clock.</big></p>\r\n\r\n<p><big>Created with a special four-point brush on its tip, this unique product mimics hair strokes in the eyebrows to produce a 3-D microbladed look. Apply directly on fresh and dry brows to maintain the rich pigment.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nShe - Dark Brown<br />\r\nHer - Medium Brown<br />\r\nHerself - Light Brown</big></p>\r\n\r\n<p><big>&nbsp;</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '995.00'),
(17, NULL, '2018-11-29 02:48:26', '2018-12-13 14:29:39', NULL, NULL, NULL, 3, 'Her Eyebrow Tint', '<p><big>Long-lasting, smudge proof, waterproof, and glamorous round the clock.</big></p>\r\n\r\n<p><big>Created with a special four-point brush on its tip, this unique product mimics hair strokes in the eyebrows to produce a 3-D microbladed look. Apply directly on fresh and dry brows to maintain the rich pigment.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nShe - Dark Brown<br />\r\nHer - Medium Brown<br />\r\nHerself - Light Brown</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '995.00'),
(18, NULL, '2018-11-29 02:49:16', '2018-12-11 17:39:01', NULL, NULL, NULL, 3, 'Herself Eyebrow Tint', '<p><big>Long-lasting, smudge proof, waterproof, and glamorous round the clock.</big></p>\r\n\r\n<p><big>Created with a special four-point brush on its tip, this unique product mimics hair strokes in the eyebrows to produce a 3-D microbladed look. Apply directly on fresh and dry brows to maintain the rich pigment.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nShe - Dark Brown<br />\r\nHer - Medium Brown<br />\r\nHerself - Light Brown</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '995.00'),
(19, NULL, '2018-11-29 02:50:31', '2018-12-05 00:06:24', NULL, NULL, NULL, 3, 'Duenna Liquid Eyeliner Pen', '<p><big>Waterproof, quick-dry liquid eyeliner pen, long-lasting, ultra smooth. No smudge eyeliner for makeup to stay all day.</big></p>\r\n\r\n<p><big>Defined eyes for up to 18 hours&mdash;Albert perfected this formula to make sure it can withstand long hours&nbsp;in tropical weather. Comes with a sharp point and hard bristle for easy application. Keep a steady hand while swiping outward, keeping as close to the lashline as possible.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nDuenna - Blue<br />\r\nGreen - Colleen<br />\r\nVirago - Black</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '795.00'),
(20, NULL, '2018-11-29 02:51:40', '2019-01-04 17:14:11', NULL, NULL, NULL, 3, 'Colleen Liquid Eyeliner Pen', '<p><big>Waterproof, quick-dry liquid eyeliner pen, long-lasting, ultra smooth. No smudge eyeliner for makeup to stay all day.</big></p>\r\n\r\n<p><big>Defined eyes for up to 18 hours&mdash;Albert perfected this formula to make sure it can withstand long hours&nbsp;in tropical weather. Comes with a sharp point and hard bristle for easy application. Keep a steady hand while swiping outward, keeping as close to the lashline as possible.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nDuenna - Blue<br />\r\nGreen - Colleen<br />\r\nVirago - Black</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '795.00'),
(21, NULL, '2018-11-29 02:53:30', '2018-12-20 16:44:21', NULL, NULL, NULL, 3, 'Virago Liquid Eyeliner Pen', '<p><big>Waterproof, quick-dry liquid eyeliner pen, long-lasting, ultra smooth. No smudge eyeliner for makeup to stay all day.</big></p>\r\n\r\n<p><big>Defined eyes for up to 18 hours&mdash;Albert perfected this formula to make sure it can withstand long hours&nbsp;in tropical weather. Comes with a sharp point and hard bristle for easy application. Keep a steady hand while swiping outward, keeping as close to the lashline as possible.</big></p>\r\n\r\n<p><big>Available in three shades:<br />\r\nDuenna - Blue<br />\r\nGreen - Colleen<br />\r\nVirago - Black</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '795.00'),
(22, NULL, '2018-11-29 02:59:35', '2019-01-04 17:14:11', NULL, NULL, NULL, 3, 'Noir Mascara Duo', '<p><big>Not all mascaras are created equal, and this two-wand mascara is surely superior. Waterproof, smudge-proof and long wearing, the mascara makes lashes appear longer and fuller. Its double wands are composed of tiny fibers, with the large brush meant to be used for upper lashes and the small brush especially designed for lower lashes. Stroke outward from the base for a dramatic effect.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '795.00'),
(23, NULL, '2018-11-29 03:00:38', '2018-12-20 16:44:21', NULL, NULL, NULL, 3, 'Love False Eyelashes', '<p><big>Versatile lashes suited for everyday, suitable for almond to round-shaped eyes. Hand-made and designed to appear natural.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '295.00'),
(24, NULL, '2018-11-29 03:01:45', '2018-12-20 16:44:21', NULL, NULL, NULL, 3, 'Naomi False Eyelashes', '<p><big>Best for all eye shapes, and makes eyes look instantly awake. Hand-made and designed to appear natural.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '295.00'),
(25, NULL, '2018-11-29 03:02:48', '2018-12-20 16:44:21', NULL, NULL, NULL, 3, 'Nelly False Eyelashes', '<p><big>A daily lash option for naturally bright eyes. Hand-made and designed to appear natural.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '295.00'),
(26, NULL, '2018-11-29 03:03:44', '2018-12-12 18:41:09', NULL, NULL, NULL, 3, 'Tyra False Eyelashes', '<p><big>Don&rsquo;t be intimidated by its spiky cut&mdash;these are perfect for a soft, feminine look that can go from daily to glam. Hand-made and designed to appear natural.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '295.00'),
(27, NULL, '2018-11-29 03:08:15', '2018-12-20 16:44:21', NULL, NULL, NULL, 3, 'Taylor False Eyelashes', '<p><big>A no-makeup look staple that makes eyes look expressive. Hand-made and designed to appear natural.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '295.00'),
(28, NULL, '2018-11-29 03:09:04', '2018-12-12 18:41:09', NULL, NULL, NULL, 3, 'Grace False Eyelashes', '<p><big>A hard-to-find yet much needed makeup staple, these lower lashes are the perfect subtle finish to any makeup look&mdash;or even without makeup!</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '295.00'),
(29, NULL, '2018-11-29 03:09:47', '2018-12-07 19:58:45', NULL, NULL, NULL, 3, 'Linda False Eyelashes', '<p><big>A hard-to-find yet much needed makeup staple, these lower lashes are the perfect subtle finish to any makeup look&mdash;or even without makeup!</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '295.00'),
(30, NULL, '2018-11-29 03:11:06', '2018-12-06 14:19:52', NULL, NULL, NULL, 3, 'Eyelash Curler', '<p><big>Purposely designed for Asian eyes, this tool envelopes the lashes perfectly with its modified curve and length.&nbsp;</big></p>\r\n\r\n<p><big>Wipe eyelash curler with a dry cloth after each use.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '995.00'),
(31, NULL, '2018-11-29 03:12:11', '2018-12-08 00:10:45', NULL, NULL, NULL, 3, 'False Lashes Applicator', '<p><big>All-in-one false lashes applicator. Accurately applies the false lashes without any difficulties. Its unique design, crafted with sophisticated steel fits all eye shapes and lashes in order to guarantee the perfect application.</big></p>\r\n\r\n<p><big>Made only with medical-grade material used in surgery tools, this lash applicator is rust-resistant and safe to use.</big></p>\r\n\r\n<p><big><strong>Ships out December 15, 2018.</strong></big></p>', 0, '1150.00'),
(32, NULL, '2018-11-30 12:53:42', '2018-12-05 00:17:28', NULL, NULL, NULL, 3, 'Tweezer', '<p><big>A meticulously hand finished tweezer with a slanted tip. Features an accurate tip alignment, calibrated tension, and symmetry that grabs and removes hair without breaking it or hurting the skin.</big></p>\r\n\r\n<p><big>Made only with medical-grade material used in surgery tools, this plucker is designed to avoid rust, suitable for skin contact.</big></p>\r\n\r\n<p><big>Tweeze the hair from the direction of growth and remove one hair at a time. To ensure the tweezers keeps its firm fold, regularly wipe the tip with alcohol in order to remove any oily build up.</big></p>\r\n\r\n<p><strong><big>Ships out December 15, 2018.</big></strong></p>', 0, '1150.00');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assemblies`
--

CREATE TABLE `inventory_assemblies` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `inventory_id` int(10) UNSIGNED NOT NULL,
  `part_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_skus`
--

CREATE TABLE `inventory_skus` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `inventory_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_skus`
--

INSERT INTO `inventory_skus` (`id`, `created_at`, `updated_at`, `inventory_id`, `code`) VALUES
(1, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 1, '0710535605501'),
(2, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 2, '0710535605518'),
(3, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 3, '0710535605525'),
(4, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 4, '0710535605532'),
(5, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 5, '0710535605549'),
(6, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 6, '0710535605556'),
(7, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 7, '0710535605563'),
(8, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 8, '0710535605570'),
(9, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 9, '0710535605587'),
(10, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 10, '0710535605594'),
(11, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 11, '0710535605600'),
(12, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 12, '0710535605617'),
(13, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 13, '0710535605624'),
(14, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 14, '0710535605631'),
(15, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 15, '0710535605648'),
(16, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 16, '0710535605655'),
(17, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 17, '0710535605662'),
(18, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 18, '0710535605679'),
(19, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 19, '0710535605686'),
(20, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 20, '0710535605693'),
(21, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 21, '0710535605709'),
(22, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 22, '0710535605716'),
(23, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 23, '0710535605723'),
(24, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 24, '0710535605730'),
(25, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 25, '0710535605747'),
(26, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 26, '0710535605754'),
(27, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 27, '0710535605761'),
(28, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 28, '0710535605778'),
(29, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 29, '0710535605785'),
(30, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 30, '4897085970016'),
(31, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 31, '4897085970139'),
(32, '2019-01-24 06:45:32', '2019-01-24 06:45:32', 32, '4897085970122');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stocks`
--

CREATE TABLE `inventory_stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `inventory_id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `quantity` decimal(8,2) NOT NULL DEFAULT '0.00',
  `aisle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `row` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_stocks`
--

INSERT INTO `inventory_stocks` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `inventory_id`, `location_id`, `quantity`, `aisle`, `row`, `bin`) VALUES
(1, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 1, 1, '0.00', NULL, NULL, NULL),
(2, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 2, 1, '32.00', NULL, NULL, NULL),
(3, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 3, 1, '13.00', NULL, NULL, NULL),
(4, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 4, 1, '28.00', NULL, NULL, NULL),
(5, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 5, 1, '154.00', NULL, NULL, NULL),
(6, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 6, 1, '35.00', NULL, NULL, NULL),
(7, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 7, 1, '233.00', NULL, NULL, NULL),
(8, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 8, 1, '246.00', NULL, NULL, NULL),
(9, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 9, 1, '162.00', NULL, NULL, NULL),
(10, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 10, 1, '82.00', NULL, NULL, NULL),
(11, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 11, 1, '82.00', NULL, NULL, NULL),
(12, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 12, 1, '205.00', NULL, NULL, NULL),
(13, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 13, 1, '30.00', NULL, NULL, NULL),
(14, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 14, 1, '216.00', NULL, NULL, NULL),
(15, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 15, 1, '246.00', NULL, NULL, NULL),
(16, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 16, 1, '206.00', NULL, NULL, NULL),
(17, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 17, 1, '197.00', NULL, NULL, NULL),
(18, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 18, 1, '211.00', NULL, NULL, NULL),
(19, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 19, 1, '234.00', NULL, NULL, NULL),
(20, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 20, 1, '232.00', NULL, NULL, NULL),
(21, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 21, 1, '215.00', NULL, NULL, NULL),
(22, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 22, 1, '9.00', NULL, NULL, NULL),
(23, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 23, 1, '475.00', NULL, NULL, NULL),
(24, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 24, 1, '494.00', NULL, NULL, NULL),
(25, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 25, 1, '496.00', NULL, NULL, NULL),
(26, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 26, 1, '494.00', NULL, NULL, NULL),
(27, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 27, 1, '490.00', NULL, NULL, NULL),
(28, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 28, 1, '496.00', NULL, NULL, NULL),
(29, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 29, 1, '494.00', NULL, NULL, NULL),
(30, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 30, 1, '71.00', NULL, NULL, NULL),
(31, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 31, 1, '58.00', NULL, NULL, NULL),
(32, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, NULL, 32, 1, '96.00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock_movements`
--

CREATE TABLE `inventory_stock_movements` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `before` decimal(8,2) NOT NULL DEFAULT '0.00',
  `after` decimal(8,2) NOT NULL DEFAULT '0.00',
  `cost` decimal(8,2) DEFAULT '0.00',
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_order_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_stock_movements`
--

INSERT INTO `inventory_stock_movements` (`id`, `created_at`, `updated_at`, `deleted_at`, `stock_id`, `user_id`, `before`, `after`, `cost`, `reason`, `transfer_order_id`) VALUES
(1, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 1, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(2, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 2, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(3, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 2, NULL, '0.00', '32.00', '0.00', 'Stock Adjustment', NULL),
(4, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 3, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(5, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 3, NULL, '0.00', '13.00', '0.00', 'Stock Adjustment', NULL),
(6, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 4, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(7, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 4, NULL, '0.00', '28.00', '0.00', 'Stock Adjustment', NULL),
(8, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 5, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(9, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 5, NULL, '0.00', '154.00', '0.00', 'Stock Adjustment', NULL),
(10, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 6, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(11, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 6, NULL, '0.00', '35.00', '0.00', 'Stock Adjustment', NULL),
(12, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 7, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(13, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 7, NULL, '0.00', '233.00', '0.00', 'Stock Adjustment', NULL),
(14, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 8, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(15, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 8, NULL, '0.00', '246.00', '0.00', 'Stock Adjustment', NULL),
(16, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 9, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(17, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 9, NULL, '0.00', '162.00', '0.00', 'Stock Adjustment', NULL),
(18, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 10, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(19, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 10, NULL, '0.00', '82.00', '0.00', 'Stock Adjustment', NULL),
(20, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 11, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(21, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 11, NULL, '0.00', '82.00', '0.00', 'Stock Adjustment', NULL),
(22, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 12, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(23, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 12, NULL, '0.00', '205.00', '0.00', 'Stock Adjustment', NULL),
(24, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 13, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(25, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 13, NULL, '0.00', '30.00', '0.00', 'Stock Adjustment', NULL),
(26, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 14, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(27, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 14, NULL, '0.00', '216.00', '0.00', 'Stock Adjustment', NULL),
(28, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 15, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(29, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 15, NULL, '0.00', '246.00', '0.00', 'Stock Adjustment', NULL),
(30, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 16, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(31, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 16, NULL, '0.00', '206.00', '0.00', 'Stock Adjustment', NULL),
(32, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 17, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(33, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 17, NULL, '0.00', '197.00', '0.00', 'Stock Adjustment', NULL),
(34, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 18, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(35, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 18, NULL, '0.00', '211.00', '0.00', 'Stock Adjustment', NULL),
(36, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 19, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(37, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 19, NULL, '0.00', '234.00', '0.00', 'Stock Adjustment', NULL),
(38, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 20, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(39, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 20, NULL, '0.00', '232.00', '0.00', 'Stock Adjustment', NULL),
(40, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 21, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(41, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 21, NULL, '0.00', '215.00', '0.00', 'Stock Adjustment', NULL),
(42, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 22, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(43, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 22, NULL, '0.00', '9.00', '0.00', 'Stock Adjustment', NULL),
(44, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 23, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(45, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 23, NULL, '0.00', '475.00', '0.00', 'Stock Adjustment', NULL),
(46, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 24, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(47, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 24, NULL, '0.00', '494.00', '0.00', 'Stock Adjustment', NULL),
(48, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 25, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(49, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 25, NULL, '0.00', '496.00', '0.00', 'Stock Adjustment', NULL),
(50, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 26, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(51, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 26, NULL, '0.00', '494.00', '0.00', 'Stock Adjustment', NULL),
(52, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 27, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(53, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 27, NULL, '0.00', '490.00', '0.00', 'Stock Adjustment', NULL),
(54, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 28, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(55, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 28, NULL, '0.00', '496.00', '0.00', 'Stock Adjustment', NULL),
(56, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 29, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(57, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 29, NULL, '0.00', '494.00', '0.00', 'Stock Adjustment', NULL),
(58, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 30, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(59, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 30, NULL, '0.00', '71.00', '0.00', 'Stock Adjustment', NULL),
(60, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 31, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(61, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 31, NULL, '0.00', '58.00', '0.00', 'Stock Adjustment', NULL),
(62, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 32, NULL, '0.00', '0.00', '0.00', 'First Item Record; Stock Increase', NULL),
(63, '2019-01-24 06:45:32', '2019-01-24 06:45:32', NULL, 32, NULL, '0.00', '96.00', '0.00', 'Stock Adjustment', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_suppliers`
--

CREATE TABLE `inventory_suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `inventory_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(8,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transaction_histories`
--

CREATE TABLE `inventory_transaction_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `state_before` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_after` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_before` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_after` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `belongs_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `created_at`, `updated_at`, `parent_id`, `lft`, `rgt`, `depth`, `name`, `belongs_to`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 'Default', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `metrics`
--

CREATE TABLE `metrics` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metrics`
--

INSERT INTO `metrics` (`id`, `created_at`, `updated_at`, `user_id`, `name`, `symbol`) VALUES
(1, NULL, NULL, NULL, 'Kilogram', 'kg'),
(2, NULL, NULL, NULL, 'Liter', 'l'),
(3, NULL, NULL, NULL, 'Piece', 'pc');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2000_01_01_000000_create_users_table', 1),
(2, '2000_01_01_100000_create_password_resets_table', 1),
(3, '2014_07_31_123201_create_metrics_table', 1),
(4, '2014_07_31_123204_create_categories_table', 1),
(5, '2014_07_31_123204_create_locations_table', 1),
(6, '2014_07_31_123213_create_inventory_tables', 1),
(7, '2015_03_02_143457_create_inventory_sku_table', 1),
(8, '2015_03_06_135351_create_inventory_supplier_tables', 1),
(9, '2015_03_09_122729_create_inventory_transaction_tables', 1),
(10, '2015_05_05_100032_create_inventory_variants_table', 1),
(11, '2015_05_08_115310_modify_inventory_table_for_assemblies', 1),
(12, '2015_05_08_115523_create_inventory_assemblies_table', 1),
(13, '2015_08_04_131614_create_settings_table', 1),
(14, '2016_05_10_130540_create_permission_tables', 1),
(15, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(16, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(17, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(18, '2016_06_01_000004_create_oauth_clients_table', 1),
(19, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(20, '2018_02_21_004554_create_orders', 1),
(21, '2018_02_21_022137_create_order_users', 1),
(22, '2018_02_21_022243_create_order_shipping_addresses', 1),
(23, '2018_02_21_022505_create_order_billing_addresses', 1),
(24, '2018_02_21_022600_create_order_carriers', 1),
(25, '2018_02_21_022707_create_order_products', 1),
(26, '2018_02_21_054510_add_order_id_in_order_products', 1),
(27, '2018_03_08_125212_add_order_id_to_order_shipping_addresses', 1),
(28, '2018_03_08_125425_add_order_id_to_order_billing_addresses', 1),
(29, '2018_03_08_130353_add_order_id_to_order_users', 1),
(30, '2018_03_08_130428_add_order_id_to_order_carriers', 1),
(31, '2018_03_11_125954_add_price_to_order_products', 1),
(32, '2018_03_11_134852_create_order_statuses_table', 1),
(33, '2018_03_11_140357_add_status_to_orders', 1),
(34, '2018_03_15_003730_add_quantity_reserved_and_quantity_taken_in_order_products', 1),
(35, '2018_03_16_085211_create_order_product_reservations_table', 1),
(36, '2018_03_16_163650_add_default_to_quantity_taken_in_order_product_reservations', 1),
(37, '2018_03_16_165622_drop_quantity_reserved_and_quantity_taken_in_order_products', 1),
(38, '2018_03_17_091024_add_movement_id_in_order_product_reservations_table', 1),
(39, '2018_03_19_091156_add_picked_at_and_picked_by_in_order_product_reservations_table', 1),
(40, '2018_03_19_092336_create_order_shipments_table', 1),
(41, '2018_03_19_100152_add_columns_in_order_carriers_table', 1),
(42, '2018_03_21_100518_add_packer_and_packed_at_in_orders_table', 1),
(43, '2018_03_21_152105_rename_packer_to_packer_id_in_orders', 1),
(44, '2018_03_25_154658_add_columns_in_order_shipments_table', 1),
(45, '2018_03_26_145842_change_shipment_package_dimensions_to_null', 1),
(46, '2018_03_29_095237_create_order_product_pickings', 1),
(47, '2018_04_01_073204_remove_movement_id_in_order_product_reservations_table', 1),
(48, '2018_04_01_074902_add_movement_id_in_order_product_pickings_table', 1),
(49, '2018_04_04_103043_create_purchase_orders_table', 1),
(50, '2018_04_04_103553_create_purchase_order_products', 1),
(51, '2018_04_04_103659_create_purchase_order_product_receivings', 1),
(52, '2018_04_05_042923_add_inventory_id_in_purchase_order_products_table', 1),
(53, '2018_04_05_084512_add_price_to_inventories_table', 1),
(54, '2018_04_05_090215_add_price_and_quantity_to_purchase_order_products_table', 1),
(55, '2018_04_05_125511_add_purchase_order_id_in_purchase_order_products_table', 1),
(56, '2018_04_07_071602_remove_is_completed_and_add_date_received_in_purchase_orders_table', 1),
(57, '2018_04_07_094026_replace_purchase_order_id_with_order_purchase_order_product_id_in_purchase_product_receivings_table', 1),
(58, '2018_04_07_122629_restructure_purchase_order_product_receivings_table', 1),
(59, '2018_04_11_214855_create_purchase_order_receiving_products', 1),
(60, '2018_04_11_224542_remove_purchase_order_product_id_and_quantity_in_purchase_order_receivings_table', 1),
(61, '2018_04_19_060159_add_completed_at_in_purchase_orders_table', 1),
(62, '2018_05_16_112317_create_transfer_orders_table', 1),
(63, '2018_05_28_012738_rename_ailse_to_aisle_in_transfer_orders', 1),
(64, '2018_05_28_040924_add_transfer_order_id_in_movements', 1),
(65, '2018_06_01_164004_add_completed_at_in_purchase_order_products', 1),
(66, '2018_06_05_040128_replace_purchase_order_receiving_product_id_with_purchase_order_product_id_in_transfer_orders', 1),
(67, '2018_10_05_130043_change_address2_to_nullable_in_order_shipping_addresses', 1),
(68, '2018_10_05_135758_change_county_to_nullable_in_order_shipping_addresses', 1),
(69, '2018_10_05_140551_change_order_address_fields_to_not_nullable', 1),
(70, '2018_12_10_050016_add_slug_in_categories', 1),
(71, '2018_12_10_073043_drop_order_shipping_addresses', 1),
(72, '2018_12_10_093244_drop_order_billing_addresses', 1),
(73, '2018_12_10_095701_add_shipping_billing_address_in_orders', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `common_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `packer_id` int(10) UNSIGNED DEFAULT NULL,
  `packed_at` timestamp NULL DEFAULT NULL,
  `shipping_address` json DEFAULT NULL,
  `billing_address` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `common_id`, `status_id`, `packer_id`, `packed_at`, `shipping_address`, `billing_address`, `created_at`, `updated_at`) VALUES
(1, 11, 2, NULL, '2019-01-24 18:37:06', '{\"id\": 25, \"city\": \"Mandaluyong City\", \"name\": \"Martin Bautista\", \"town\": null, \"unit\": \"Unit 803\", \"email\": \"martinmbautista@gmail.com\", \"house\": null, \"phone\": \"+639175665662\", \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"Laurel St\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Pleasant Hills\", \"building\": \"Princeville condominium\", \"country_id\": 27, \"created_at\": \"2018-11-29 21:40:25\", \"updated_at\": \"2018-11-29 21:40:25\", \"postal_code\": \"1552\", \"country_cca2\": null, \"mobile_phone\": \"+639175665662\", \"state_postal\": null}', '{\"id\": 25, \"city\": \"Mandaluyong City\", \"name\": \"Martin Bautista\", \"town\": null, \"unit\": \"Unit 803\", \"email\": \"martinmbautista@gmail.com\", \"house\": null, \"phone\": \"+639175665662\", \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"Laurel St\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Pleasant Hills\", \"building\": \"Princeville condominium\", \"country_id\": 27, \"created_at\": \"2018-11-29 21:40:25\", \"updated_at\": \"2018-11-29 21:40:25\", \"postal_code\": \"1552\", \"country_cca2\": null, \"mobile_phone\": \"+639175665662\", \"state_postal\": null}', '2018-12-14 10:15:20', '2019-01-24 18:37:06'),
(2, 35, 1, NULL, NULL, '{\"id\": 75, \"city\": \"Taguig\", \"name\": \"Armida Bayot\", \"town\": null, \"unit\": \"11F\", \"email\": \"armi_b@sbcglobal.net\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"5th Ave. Crescent Park West\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"BGC\", \"building\": \"Net Park Building\", \"country_id\": 27, \"created_at\": \"2018-12-04 03:46:25\", \"updated_at\": \"2018-12-04 03:46:25\", \"postal_code\": \"1634\", \"country_cca2\": null, \"mobile_phone\": \"09178005496\", \"state_postal\": null}', '{\"id\": 75, \"city\": \"Taguig\", \"name\": \"Armida Bayot\", \"town\": null, \"unit\": \"11F\", \"email\": \"armi_b@sbcglobal.net\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"5th Ave. Crescent Park West\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"BGC\", \"building\": \"Net Park Building\", \"country_id\": 27, \"created_at\": \"2018-12-04 03:46:25\", \"updated_at\": \"2018-12-04 03:46:25\", \"postal_code\": \"1634\", \"country_cca2\": null, \"mobile_phone\": \"09178005496\", \"state_postal\": null}', '2018-12-14 10:21:26', '2019-01-24 06:45:33'),
(3, 36, 1, NULL, NULL, '{\"id\": 76, \"city\": \"las piñas city\", \"name\": \"Abby Mercado\", \"town\": null, \"unit\": \"4322\", \"email\": \"abbymercado20@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"bf resort village\", \"region\": \"ncr\", \"street\": \"constantine street italia 500\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 135, \"address1\": null, \"address2\": null, \"barangay\": \"talon dos\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-04 08:05:23\", \"updated_at\": \"2018-12-04 08:05:23\", \"postal_code\": \"1740\", \"country_cca2\": null, \"mobile_phone\": \"09178018842\", \"state_postal\": null}', '{\"id\": 76, \"city\": \"las piñas city\", \"name\": \"Abby Mercado\", \"town\": null, \"unit\": \"4322\", \"email\": \"abbymercado20@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"bf resort village\", \"region\": \"ncr\", \"street\": \"constantine street italia 500\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 135, \"address1\": null, \"address2\": null, \"barangay\": \"talon dos\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-04 08:05:23\", \"updated_at\": \"2018-12-04 08:05:23\", \"postal_code\": \"1740\", \"country_cca2\": null, \"mobile_phone\": \"09178018842\", \"state_postal\": null}', '2018-12-14 10:21:26', '2019-01-24 06:45:33'),
(4, 39, 1, NULL, NULL, '{\"id\": 83, \"city\": \"ANTIPOLO CITY\", \"name\": \"Katherine Munar\", \"town\": \"ANTIPOLO CITY\", \"unit\": \"6\", \"email\": \"katedcmakeup@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"RIZAL\", \"region\": \"ncr\", \"street\": \"MAXIMILLIAN STREET, KINGSVILLE EXECUTIVE VILLAGE\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 125, \"address1\": null, \"address2\": null, \"barangay\": \"MAYAMOT\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-05 15:25:58\", \"updated_at\": \"2018-12-08 02:40:02\", \"postal_code\": \"1870\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '{\"id\": 82, \"city\": \"ANTIPOLO CITY\", \"name\": null, \"town\": \"ANTIPOLO CITY\", \"unit\": \"6\", \"email\": null, \"house\": null, \"phone\": null, \"state\": null, \"county\": \"RIZAL\", \"region\": \"ncr\", \"street\": \"MAXIMILLIAN STREET, KINGSVILLE EXECUTIVE VILLAGE, BRGY. MAYAMOT\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 125, \"address1\": null, \"address2\": null, \"barangay\": \"MAYAMOT\", \"building\": \"KATE DC MAKEUP STUDIO\", \"country_id\": 27, \"created_at\": \"2018-12-05 15:25:58\", \"updated_at\": \"2018-12-05 15:25:58\", \"postal_code\": \"1870\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '2018-12-14 10:21:26', '2019-01-24 06:45:33'),
(5, 33, 1, NULL, NULL, '{\"id\": 66, \"city\": \"Quezon City\", \"name\": null, \"town\": \"Project 2\", \"unit\": \"71\", \"email\": null, \"house\": null, \"phone\": null, \"state\": null, \"county\": \"NCR\", \"region\": \"ncr\", \"street\": \"Chico Street\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 117, \"address1\": null, \"address2\": null, \"barangay\": \"Barangay Quirino 2A\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-01 21:28:48\", \"updated_at\": \"2018-12-01 21:28:48\", \"postal_code\": \"1102\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '{\"id\": 65, \"city\": \"Quezon city\", \"name\": null, \"town\": \"Project 2\", \"unit\": \"71\", \"email\": null, \"house\": null, \"phone\": null, \"state\": null, \"county\": \"NCR\", \"region\": \"ncr\", \"street\": \"Chico Street\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 117, \"address1\": null, \"address2\": null, \"barangay\": \"Barangay Quirino 2A\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-01 21:28:48\", \"updated_at\": \"2018-12-01 21:28:48\", \"postal_code\": \"1102\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(6, 6, 1, NULL, NULL, '{\"id\": 17, \"city\": \"PASAY CITY\", \"name\": \"CLAUDINE BACCAY\", \"town\": null, \"unit\": \"Blk 6A LOT 27 KALAYAAN VILLAGE\", \"email\": \"dindin.claudine@gmail.com\", \"house\": null, \"phone\": \"09273819878\", \"state\": null, \"county\": \"PASAY CITY\", \"region\": \"ncr\", \"street\": \"GATE 1 KALAYAAN VILLAGE\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"BRGY 201\", \"building\": \"BLK 6A LOT 27 KALAYAAN VILLAGE\", \"country_id\": 27, \"created_at\": \"2018-11-29 09:46:05\", \"updated_at\": \"2018-11-29 09:46:05\", \"postal_code\": \"1630\", \"country_cca2\": null, \"mobile_phone\": \"09273819878\", \"state_postal\": null}', '{\"id\": 17, \"city\": \"PASAY CITY\", \"name\": \"CLAUDINE BACCAY\", \"town\": null, \"unit\": \"Blk 6A LOT 27 KALAYAAN VILLAGE\", \"email\": \"dindin.claudine@gmail.com\", \"house\": null, \"phone\": \"09273819878\", \"state\": null, \"county\": \"PASAY CITY\", \"region\": \"ncr\", \"street\": \"GATE 1 KALAYAAN VILLAGE\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"BRGY 201\", \"building\": \"BLK 6A LOT 27 KALAYAAN VILLAGE\", \"country_id\": 27, \"created_at\": \"2018-11-29 09:46:05\", \"updated_at\": \"2018-11-29 09:46:05\", \"postal_code\": \"1630\", \"country_cca2\": null, \"mobile_phone\": \"09273819878\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(7, 29, 1, NULL, NULL, '{\"id\": 61, \"city\": \"San Juan\", \"name\": \"Maria Rica Aplasca\", \"town\": null, \"unit\": \"Unit A\", \"email\": \"cookieaplasca@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"307 M.A. Reyes\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Little Baguio\", \"building\": \"Brownstone Homes\", \"country_id\": 27, \"created_at\": \"2018-12-01 10:16:59\", \"updated_at\": \"2018-12-01 10:16:59\", \"postal_code\": \"1500\", \"country_cca2\": null, \"mobile_phone\": \"09178851987\", \"state_postal\": null}', '{\"id\": 62, \"city\": \"Marikina City\", \"name\": \"Maria Rica Aplasca\", \"town\": null, \"unit\": \"34\", \"email\": \"cookieaplasca@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Tanguile Street Monte Vista Subdivision\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Industrial Valley\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-01 10:16:59\", \"updated_at\": \"2018-12-01 10:16:59\", \"postal_code\": \"1801\", \"country_cca2\": null, \"mobile_phone\": \"09178851987\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(8, 27, 1, NULL, NULL, '{\"id\": 56, \"city\": \"Metro Manila\", \"name\": \"Tessa Gaerlan c/o Maria Nydia Danas\", \"town\": null, \"unit\": \"1920\", \"email\": \"tf_gaerlan@hotmail.com\", \"house\": null, \"phone\": \"639237712363\", \"state\": null, \"county\": \"Malate\", \"region\": \"ncr\", \"street\": \"Taft Avenue\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 33, \"address1\": null, \"address2\": null, \"barangay\": \"708\", \"building\": \"EGI Taft Tower\", \"country_id\": 27, \"created_at\": \"2018-12-01 05:53:06\", \"updated_at\": \"2018-12-01 05:53:06\", \"postal_code\": \"1004\", \"country_cca2\": null, \"mobile_phone\": \"61430131354\", \"state_postal\": null}', '{\"id\": 57, \"city\": \"Metro Manila\", \"name\": \"Tessa Gaerlan c/o Maria Nydia Danas\", \"town\": null, \"unit\": \"1920\", \"email\": \"tf_gaerlan@hotmail.com\", \"house\": null, \"phone\": \"639237712363\", \"state\": null, \"county\": \"Malate\", \"region\": \"ncr\", \"street\": \"Taft Avenue\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 33, \"address1\": null, \"address2\": null, \"barangay\": \"708\", \"building\": \"EGI Taft Tower\", \"country_id\": 27, \"created_at\": \"2018-12-01 05:53:06\", \"updated_at\": \"2018-12-01 05:53:06\", \"postal_code\": \"1004\", \"country_cca2\": null, \"mobile_phone\": \"61430131354\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(9, 26, 1, NULL, NULL, '{\"id\": 55, \"city\": \"Mandaluyong\", \"name\": \"Charlene Harn\", \"town\": null, \"unit\": \"7F\", \"email\": \"charlene_harn@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Ortigas Avenue\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Brgy. Wack-Wack\", \"building\": \"Columbia Tower\", \"country_id\": 27, \"created_at\": \"2018-12-01 02:22:25\", \"updated_at\": \"2018-12-01 02:22:25\", \"postal_code\": \"1550\", \"country_cca2\": null, \"mobile_phone\": \"09178177181\", \"state_postal\": null}', '{\"id\": 55, \"city\": \"Mandaluyong\", \"name\": \"Charlene Harn\", \"town\": null, \"unit\": \"7F\", \"email\": \"charlene_harn@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Ortigas Avenue\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Brgy. Wack-Wack\", \"building\": \"Columbia Tower\", \"country_id\": 27, \"created_at\": \"2018-12-01 02:22:25\", \"updated_at\": \"2018-12-01 02:22:25\", \"postal_code\": \"1550\", \"country_cca2\": null, \"mobile_phone\": \"09178177181\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(10, 31, 1, NULL, NULL, '{\"id\": 67, \"city\": \"Rizal\", \"name\": \"Ruth Damasco\", \"town\": null, \"unit\": \"18\", \"email\": \"ruth.damasco@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"CALABARZON (Region IV-A)\", \"region\": \"luzon\", \"street\": \"Gerona St. Vista Verde Exec Vill\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 119, \"address1\": null, \"address2\": null, \"barangay\": \"San Isidro\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-01 23:49:55\", \"updated_at\": \"2018-12-01 23:49:55\", \"postal_code\": \"1900\", \"country_cca2\": null, \"mobile_phone\": \"09178370426\", \"state_postal\": null}', '{\"id\": 67, \"city\": \"Rizal\", \"name\": \"Ruth Damasco\", \"town\": null, \"unit\": \"18\", \"email\": \"ruth.damasco@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"CALABARZON (Region IV-A)\", \"region\": \"luzon\", \"street\": \"Gerona St. Vista Verde Exec Vill\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 119, \"address1\": null, \"address2\": null, \"barangay\": \"San Isidro\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-01 23:49:55\", \"updated_at\": \"2018-12-01 23:49:55\", \"postal_code\": \"1900\", \"country_cca2\": null, \"mobile_phone\": \"09178370426\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(11, 24, 1, NULL, NULL, '{\"id\": 20, \"city\": \"quezon city\", \"name\": \"elizabeth ang\", \"town\": null, \"unit\": null, \"email\": \"lizamunoz_ang@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"metro manila\", \"region\": \"ncr\", \"street\": \"53 9th st new manila rolling hills\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 16, \"address1\": null, \"address2\": null, \"barangay\": \"damayang lagi\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-29 15:41:03\", \"updated_at\": \"2018-11-30 23:38:59\", \"postal_code\": \"1112\", \"country_cca2\": null, \"mobile_phone\": \"639228268331\", \"state_postal\": null}', '{\"id\": 19, \"city\": \"quezon city\", \"name\": \"elizabeth ang\", \"town\": null, \"unit\": null, \"email\": \"lizamunoz_ang@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"metro manila\", \"region\": \"ncr\", \"street\": \"53 9th st new manila rolling hills\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 16, \"address1\": null, \"address2\": null, \"barangay\": \"damayang lagi\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-29 15:41:03\", \"updated_at\": \"2018-11-30 23:38:59\", \"postal_code\": \"1112\", \"country_cca2\": null, \"mobile_phone\": \"639228268331\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(12, 21, 1, NULL, NULL, '{\"id\": 48, \"city\": \"Pasig city\", \"name\": \"Athina mae Cayaba\", \"town\": null, \"unit\": \"Unit 308\", \"email\": \"Yapnorielbon@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Pasig city\", \"region\": \"ncr\", \"street\": \"Kaimitoville\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Ugong\", \"building\": \"Bldg 1\", \"country_id\": 27, \"created_at\": \"2018-11-30 11:23:10\", \"updated_at\": \"2018-11-30 11:23:10\", \"postal_code\": \"1800\", \"country_cca2\": null, \"mobile_phone\": \"09289569655\", \"state_postal\": null}', '{\"id\": 48, \"city\": \"Pasig city\", \"name\": \"Athina mae Cayaba\", \"town\": null, \"unit\": \"Unit 308\", \"email\": \"Yapnorielbon@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Pasig city\", \"region\": \"ncr\", \"street\": \"Kaimitoville\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Ugong\", \"building\": \"Bldg 1\", \"country_id\": 27, \"created_at\": \"2018-11-30 11:23:10\", \"updated_at\": \"2018-11-30 11:23:10\", \"postal_code\": \"1800\", \"country_cca2\": null, \"mobile_phone\": \"09289569655\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(13, 57, 2, NULL, NULL, '{\"id\": 104, \"city\": \"Manila\", \"name\": \"Maria Carla Kho\", \"town\": null, \"unit\": \"2389 Tejeron St\", \"email\": \"mariacarlakho@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro manila\", \"region\": \"ncr\", \"street\": \"Tejeron St\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 171, \"address1\": null, \"address2\": null, \"barangay\": \"Barangay 780\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-13 17:57:39\", \"updated_at\": \"2018-12-13 17:57:39\", \"postal_code\": \"1017\", \"country_cca2\": null, \"mobile_phone\": \"09178130285\", \"state_postal\": null}', '{\"id\": 104, \"city\": \"Manila\", \"name\": \"Maria Carla Kho\", \"town\": null, \"unit\": \"2389 Tejeron St\", \"email\": \"mariacarlakho@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro manila\", \"region\": \"ncr\", \"street\": \"Tejeron St\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 171, \"address1\": null, \"address2\": null, \"barangay\": \"Barangay 780\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-13 17:57:39\", \"updated_at\": \"2018-12-13 17:57:39\", \"postal_code\": \"1017\", \"country_cca2\": null, \"mobile_phone\": \"09178130285\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:33'),
(14, 23, 1, NULL, NULL, '{\"id\": 52, \"city\": \"Quezon City\", \"name\": \"Dorothy Ong\", \"town\": null, \"unit\": \"95 unit 2\", \"email\": \"dcong57@gmail.com\", \"house\": null, \"phone\": \"025141288\", \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"95 Mother ignacia ave.\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"South Triangle\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-30 22:58:20\", \"updated_at\": \"2018-11-30 22:58:20\", \"postal_code\": \"1103\", \"country_cca2\": null, \"mobile_phone\": \"+639178357585\", \"state_postal\": null}', '{\"id\": 53, \"city\": \"QUEZON city\", \"name\": \"Dorothy Ong\", \"town\": null, \"unit\": \"Unit 2.\", \"email\": \"dcong57@gmail.com\", \"house\": null, \"phone\": \"025141288\", \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"95 Mother ignacia ave.\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"South Triangle\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-30 22:58:20\", \"updated_at\": \"2018-11-30 22:58:20\", \"postal_code\": \"1103\", \"country_cca2\": null, \"mobile_phone\": \"+639178357585\", \"state_postal\": null}', '2018-12-18 11:18:30', '2019-01-24 06:45:34'),
(15, 45, 1, NULL, NULL, '{\"id\": 90, \"city\": \"Cebu\", \"name\": \"Petrina Lim\", \"town\": null, \"unit\": \"None\", \"email\": \"petrina.lim@cie.edu.ph\", \"house\": null, \"phone\": \"3453993\", \"state\": null, \"county\": \"Cebu\", \"region\": \"visayas\", \"street\": \"Archbishop Reyes Avenue\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Luzo\", \"building\": \"BT Furniture\", \"country_id\": 27, \"created_at\": \"2018-12-07 07:53:30\", \"updated_at\": \"2018-12-07 07:53:30\", \"postal_code\": \"6000\", \"country_cca2\": null, \"mobile_phone\": \"9177028102\", \"state_postal\": null}', '{\"id\": 90, \"city\": \"Cebu\", \"name\": \"Petrina Lim\", \"town\": null, \"unit\": \"None\", \"email\": \"petrina.lim@cie.edu.ph\", \"house\": null, \"phone\": \"3453993\", \"state\": null, \"county\": \"Cebu\", \"region\": \"visayas\", \"street\": \"Archbishop Reyes Avenue\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Luzo\", \"building\": \"BT Furniture\", \"country_id\": 27, \"created_at\": \"2018-12-07 07:53:30\", \"updated_at\": \"2018-12-07 07:53:30\", \"postal_code\": \"6000\", \"country_cca2\": null, \"mobile_phone\": \"9177028102\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:34'),
(16, 46, 1, NULL, NULL, '{\"id\": 91, \"city\": \"Manila\", \"name\": \"Andrea Go\", \"town\": null, \"unit\": \"108\", \"email\": \"andr3a_go@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"Veronica Street Tytana Plaza Binondo\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"108\", \"building\": \"Metrobank Building\", \"country_id\": 27, \"created_at\": \"2018-12-07 21:31:36\", \"updated_at\": \"2018-12-07 21:31:36\", \"postal_code\": \"1006\", \"country_cca2\": null, \"mobile_phone\": \"09177091088\", \"state_postal\": null}', '{\"id\": 91, \"city\": \"Manila\", \"name\": \"Andrea Go\", \"town\": null, \"unit\": \"108\", \"email\": \"andr3a_go@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"Veronica Street Tytana Plaza Binondo\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"108\", \"building\": \"Metrobank Building\", \"country_id\": 27, \"created_at\": \"2018-12-07 21:31:36\", \"updated_at\": \"2018-12-07 21:31:36\", \"postal_code\": \"1006\", \"country_cca2\": null, \"mobile_phone\": \"09177091088\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:34'),
(17, 49, 1, NULL, NULL, '{\"id\": 5, \"city\": \"Pasig City\", \"name\": \"Mai-Mai Manlapaz\", \"town\": null, \"unit\": \"18\", \"email\": \"maimai.manlapaz@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Gen. Delgado c/o Manlapaz Store, San Antonio Village\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 10, \"address1\": null, \"address2\": null, \"barangay\": \"San Antonio\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-29 06:38:33\", \"updated_at\": \"2018-12-08 17:34:53\", \"postal_code\": \"1605\", \"country_cca2\": null, \"mobile_phone\": \"09994048899\", \"state_postal\": null}', '{\"id\": 4, \"city\": \"Pasig City\", \"name\": \"Mai-Mai Manlapaz\", \"town\": null, \"unit\": \"18\", \"email\": \"maimai.manlapaz@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Gen. Delgado c/o Manlapaz Store, San Antonio Village\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 10, \"address1\": null, \"address2\": null, \"barangay\": \"San Antonio\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-29 06:38:33\", \"updated_at\": \"2018-12-08 17:34:53\", \"postal_code\": \"1605\", \"country_cca2\": null, \"mobile_phone\": \"09994048899\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:34'),
(18, 50, 1, NULL, NULL, '{\"id\": 95, \"city\": \"Pasig City\", \"name\": null, \"town\": null, \"unit\": \"G/F\", \"email\": null, \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Saint Josemaria Escriva Drive\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 165, \"address1\": null, \"address2\": null, \"barangay\": \"San Antonio\", \"building\": \"8137 PLAZA\", \"country_id\": 27, \"created_at\": \"2018-12-09 17:05:04\", \"updated_at\": \"2018-12-09 17:05:04\", \"postal_code\": \"1605\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '{\"id\": 94, \"city\": \"Pasig City\", \"name\": null, \"town\": null, \"unit\": \"54\", \"email\": null, \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"San Pedro St\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 165, \"address1\": null, \"address2\": null, \"barangay\": \"Kapitolyo\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-09 17:05:04\", \"updated_at\": \"2018-12-09 17:05:04\", \"postal_code\": \"1603\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:34'),
(19, 38, 1, NULL, NULL, '{\"id\": 78, \"city\": \"Pasig\", \"name\": \"Kate Enriquez\", \"town\": null, \"unit\": \"507\", \"email\": \"snippetsofkate@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Emerald Avenue, Ortigas Center\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 138, \"address1\": null, \"address2\": null, \"barangay\": \"Ortigas Center\", \"building\": \"Taipan Place Building\", \"country_id\": 27, \"created_at\": \"2018-12-04 22:59:42\", \"updated_at\": \"2018-12-04 22:59:42\", \"postal_code\": \"1605\", \"country_cca2\": null, \"mobile_phone\": \"09178460990\", \"state_postal\": null}', '{\"id\": 79, \"city\": \"Parañaque\", \"name\": \"Kate Enriquez\", \"town\": null, \"unit\": \"1F\", \"email\": \"snippetsofkate@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"1F Rogationist, Multinational Village\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 138, \"address1\": null, \"address2\": null, \"barangay\": \"Moonwalk\", \"building\": \"Peter Townhomes\", \"country_id\": 27, \"created_at\": \"2018-12-04 22:59:42\", \"updated_at\": \"2018-12-04 22:59:42\", \"postal_code\": \"1708\", \"country_cca2\": null, \"mobile_phone\": \"09178460990\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:34'),
(20, 5, 1, NULL, NULL, '{\"id\": 16, \"city\": \"Quezon City\", \"name\": \"Pauline Lim\", \"town\": null, \"unit\": \"9 Bautista Street\", \"email\": \"pauline_mae_lim@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"luzon\", \"street\": \"Bautista Street\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 23, \"address1\": null, \"address2\": null, \"barangay\": \"Ugong Norte\", \"building\": \"Corinthian Gardens\", \"country_id\": 27, \"created_at\": \"2018-11-29 09:00:31\", \"updated_at\": \"2018-11-29 09:00:31\", \"postal_code\": \"1110\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '{\"id\": 16, \"city\": \"Quezon City\", \"name\": \"Pauline Lim\", \"town\": null, \"unit\": \"9 Bautista Street\", \"email\": \"pauline_mae_lim@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"luzon\", \"street\": \"Bautista Street\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 23, \"address1\": null, \"address2\": null, \"barangay\": \"Ugong Norte\", \"building\": \"Corinthian Gardens\", \"country_id\": 27, \"created_at\": \"2018-11-29 09:00:31\", \"updated_at\": \"2018-11-29 09:00:31\", \"postal_code\": \"1110\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(21, 34, 1, NULL, NULL, '{\"id\": 74, \"city\": \"Paranaque\", \"name\": \"Sasha Temones\", \"town\": null, \"unit\": \"77 L5B5\", \"email\": \"Sasha.temones@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Darwin st PH3\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"BF Homes\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-04 02:31:17\", \"updated_at\": \"2018-12-04 02:31:17\", \"postal_code\": \"1700\", \"country_cca2\": null, \"mobile_phone\": \"09088660198\", \"state_postal\": null}', '{\"id\": 74, \"city\": \"Paranaque\", \"name\": \"Sasha Temones\", \"town\": null, \"unit\": \"77 L5B5\", \"email\": \"Sasha.temones@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Darwin st PH3\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"BF Homes\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-12-04 02:31:17\", \"updated_at\": \"2018-12-04 02:31:17\", \"postal_code\": \"1700\", \"country_cca2\": null, \"mobile_phone\": \"09088660198\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(22, 32, 1, NULL, NULL, '{\"id\": 68, \"city\": \"Manila\", \"name\": \"Doris Dee\", \"town\": null, \"unit\": \"4A\", \"email\": \"doriscdee@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"431 Jaboneros Street, Binondo\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 120, \"address1\": null, \"address2\": null, \"barangay\": \"281\", \"building\": \"N/A\", \"country_id\": 27, \"created_at\": \"2018-12-02 00:44:19\", \"updated_at\": \"2018-12-02 00:44:19\", \"postal_code\": \"1006\", \"country_cca2\": null, \"mobile_phone\": \"09777024556\", \"state_postal\": null}', '{\"id\": 69, \"city\": \"Manila\", \"name\": \"Doris Dee\", \"town\": null, \"unit\": \"4A\", \"email\": \"doriscdee@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"431 Jaboneros Street, Binondo\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 120, \"address1\": null, \"address2\": null, \"barangay\": \"281\", \"building\": \"N/A\", \"country_id\": 27, \"created_at\": \"2018-12-02 00:44:19\", \"updated_at\": \"2018-12-02 00:44:19\", \"postal_code\": \"1006\", \"country_cca2\": null, \"mobile_phone\": \"09777024556\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(23, 17, 1, NULL, NULL, '{\"id\": 43, \"city\": \"Pasig\", \"name\": \"Frances Reyes\", \"town\": null, \"unit\": \"#43\", \"email\": \"mylittlechini@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"Baywood St. Greenwoods, Phase 6\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 61, \"address1\": null, \"address2\": null, \"barangay\": \"Pinagbuhatan\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-30 02:35:28\", \"updated_at\": \"2018-11-30 02:35:28\", \"postal_code\": \"1600\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '{\"id\": 43, \"city\": \"Pasig\", \"name\": \"Frances Reyes\", \"town\": null, \"unit\": \"#43\", \"email\": \"mylittlechini@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Manila\", \"region\": \"ncr\", \"street\": \"Baywood St. Greenwoods, Phase 6\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 61, \"address1\": null, \"address2\": null, \"barangay\": \"Pinagbuhatan\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-30 02:35:28\", \"updated_at\": \"2018-11-30 02:35:28\", \"postal_code\": \"1600\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(24, 16, 1, NULL, NULL, '{\"id\": 40, \"city\": \"Mandaluyong City\", \"name\": \"Jennifer Garcia\", \"town\": null, \"unit\": \"57-D South Tower\", \"email\": \"jennyvgarcia530@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Internal Road Shangri-La Place\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 29, \"address1\": null, \"address2\": null, \"barangay\": \"Brgy. Wack-Wack\", \"building\": \"One Shangri-La Place\", \"country_id\": 27, \"created_at\": \"2018-11-30 02:24:08\", \"updated_at\": \"2018-11-30 02:24:08\", \"postal_code\": \"1550\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '{\"id\": 40, \"city\": \"Mandaluyong City\", \"name\": \"Jennifer Garcia\", \"town\": null, \"unit\": \"57-D South Tower\", \"email\": \"jennyvgarcia530@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"Internal Road Shangri-La Place\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 29, \"address1\": null, \"address2\": null, \"barangay\": \"Brgy. Wack-Wack\", \"building\": \"One Shangri-La Place\", \"country_id\": 27, \"created_at\": \"2018-11-30 02:24:08\", \"updated_at\": \"2018-11-30 02:24:08\", \"postal_code\": \"1550\", \"country_cca2\": null, \"mobile_phone\": null, \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(25, 15, 1, NULL, NULL, '{\"id\": 37, \"city\": \"Binmaley\", \"name\": \"Andrew Bautista\", \"town\": null, \"unit\": \"265\", \"email\": \"abbieaab@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Pangasinan\", \"region\": \"luzon\", \"street\": \"Baybay Polong\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Baybay Polong\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-30 01:16:30\", \"updated_at\": \"2018-11-30 01:16:30\", \"postal_code\": \"2417\", \"country_cca2\": null, \"mobile_phone\": \"00639154217377\", \"state_postal\": null}', '{\"id\": 37, \"city\": \"Binmaley\", \"name\": \"Andrew Bautista\", \"town\": null, \"unit\": \"265\", \"email\": \"abbieaab@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Pangasinan\", \"region\": \"luzon\", \"street\": \"Baybay Polong\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Baybay Polong\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-30 01:16:30\", \"updated_at\": \"2018-11-30 01:16:30\", \"postal_code\": \"2417\", \"country_cca2\": null, \"mobile_phone\": \"00639154217377\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(26, 10, 1, NULL, NULL, '{\"id\": 23, \"city\": \"Taguig City\", \"name\": \"Milagros Flores\", \"town\": null, \"unit\": \"21G Tower Domenico\", \"email\": \"lalaflores2003@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"8 Venezia Drive, McKinley Hill\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 21, \"address1\": null, \"address2\": null, \"barangay\": \"Pinagsama\", \"building\": \"The Venice Luxury Residences\", \"country_id\": 27, \"created_at\": \"2018-11-29 20:49:01\", \"updated_at\": \"2018-11-29 20:49:01\", \"postal_code\": \"1634\", \"country_cca2\": null, \"mobile_phone\": \"+639178220116\", \"state_postal\": null}', '{\"id\": 24, \"city\": \"Taguig City\", \"name\": \"Milagros Flores\", \"town\": null, \"unit\": \"21G TOWER DOMENICO\", \"email\": \"lalaflores2003@yahoo.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"Metro Manila\", \"region\": \"ncr\", \"street\": \"8 Venezia Drive, McKinley Hill\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": 21, \"address1\": null, \"address2\": null, \"barangay\": \"Pinagsama\", \"building\": \"The Venice Luxury Residences\", \"country_id\": 27, \"created_at\": \"2018-11-29 20:49:01\", \"updated_at\": \"2018-11-29 20:49:01\", \"postal_code\": \"1634\", \"country_cca2\": null, \"mobile_phone\": \"+639178220116\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(27, 9, 1, NULL, NULL, '{\"id\": 22, \"city\": \"Muntinlupa\", \"name\": \"Kristine Takemura\", \"town\": null, \"unit\": \"Block 7 Lot 18\", \"email\": \"khim\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"NCR\", \"region\": \"ncr\", \"street\": \"Jose Abad Santos St.  Katarungan Village\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Poblacion\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-29 20:17:15\", \"updated_at\": \"2018-11-29 20:17:15\", \"postal_code\": \"1700\", \"country_cca2\": null, \"mobile_phone\": \"+818040624896\", \"state_postal\": null}', '{\"id\": 22, \"city\": \"Muntinlupa\", \"name\": \"Kristine Takemura\", \"town\": null, \"unit\": \"Block 7 Lot 18\", \"email\": \"khim\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"NCR\", \"region\": \"ncr\", \"street\": \"Jose Abad Santos St.  Katarungan Village\", \"comment\": null, \"country\": {\"id\": 27, \"code\": \"PH\", \"name\": \"Philippines\", \"currency_id\": 1}, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Poblacion\", \"building\": null, \"country_id\": 27, \"created_at\": \"2018-11-29 20:17:15\", \"updated_at\": \"2018-11-29 20:17:15\", \"postal_code\": \"1700\", \"country_cca2\": null, \"mobile_phone\": \"+818040624896\", \"state_postal\": null}', '2018-12-20 08:21:26', '2019-01-24 06:45:35'),
(28, 85, 2, NULL, NULL, '{\"id\": 123, \"city\": \"Quezon City\", \"name\": \"Don Christopher Cadavona\", \"town\": null, \"unit\": \"123\", \"email\": \"dcadavona@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"National Capital Region\", \"region\": \"ncr\", \"street\": \"Botocan\", \"comment\": null, \"country\": null, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Tandang Sora\", \"building\": null, \"country_id\": null, \"created_at\": \"2019-01-05 01:14:11\", \"updated_at\": \"2019-01-05 01:14:11\", \"postal_code\": \"1116\", \"country_cca2\": \"PH\", \"mobile_phone\": \"09778375746\", \"state_postal\": null}', '{\"id\": 123, \"city\": \"Quezon City\", \"name\": \"Don Christopher Cadavona\", \"town\": null, \"unit\": \"123\", \"email\": \"dcadavona@gmail.com\", \"house\": null, \"phone\": null, \"state\": null, \"county\": \"National Capital Region\", \"region\": \"ncr\", \"street\": \"Botocan\", \"comment\": null, \"country\": null, \"user_id\": null, \"address1\": null, \"address2\": null, \"barangay\": \"Tandang Sora\", \"building\": null, \"country_id\": null, \"created_at\": \"2019-01-05 01:14:11\", \"updated_at\": \"2019-01-05 01:14:11\", \"postal_code\": \"1116\", \"country_cca2\": \"PH\", \"mobile_phone\": \"09778375746\", \"state_postal\": null}', '2019-01-04 09:14:11', '2019-01-24 06:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_carriers`
--

CREATE TABLE `order_carriers` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `delivery_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_carriers`
--

INSERT INTO `order_carriers` (`id`, `order_id`, `name`, `price`, `delivery_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(2, 2, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(3, 3, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(4, 4, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(5, 5, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(6, 6, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(7, 7, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(8, 8, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(9, 9, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(10, 10, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(11, 11, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(12, 12, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(13, 13, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(14, 14, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(15, 15, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(16, 16, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(17, 17, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(18, 18, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(19, 19, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(20, 20, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(21, 21, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(22, 22, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(23, 23, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(24, 24, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(25, 25, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(26, 26, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(27, 27, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(28, 28, 'LBC', '150.00', 'LBC Express, Inc. is a courier company based in the Philippines.', '2019-01-24 06:45:35', '2019-01-24 06:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `common_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `common_id`, `name`, `sku`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(2, 1, 31, 31, 'False Lashes Applicator', '4897085970139', 1, '1150.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(3, 1, 22, 22, 'Mon-Cheri', '0710535605716', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(4, 2, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(5, 2, 22, 22, 'Mon Cheri', '0710535605716', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(6, 3, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(7, 3, 22, 22, 'Mon Cheri', '0710535605716', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(8, 4, 1, 1, 'Amore Eyeshadow Palette', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(9, 4, 30, 30, 'Eyelash Curler', '4897085970016', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(10, 4, 23, 23, 'Love False Eyelashes', '0710535605723', 2, '295.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(11, 4, 22, 22, 'Noir Mascara Duo', '0710535605716', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(12, 4, 4, 4, 'Queen Eyeshadow Palette', '0710535605532', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(13, 5, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(14, 5, 2, 2, 'Mademoiselle', '0710535605518', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(15, 5, 4, 4, 'Queen', '0710535605532', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(16, 5, 3, 3, 'Señorita', '0710535605525', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(17, 5, 23, 23, 'Love', '0710535605723', 10, '295.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(18, 5, 24, 24, 'Naomi', '0710535605730', 2, '295.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(19, 5, 25, 25, 'Nelly', '0710535605747', 2, '295.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(20, 5, 27, 27, 'Taylor', '0710535605761', 2, '295.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(21, 5, 26, 26, 'Tyra', '0710535605754', 1, '295.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(22, 5, 22, 22, 'Mon Cheri', '0710535605716', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(23, 6, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(24, 6, 18, 18, 'Herself', '0710535605679', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(25, 7, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(26, 7, 20, 20, 'Colleen', '0710535605693', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(27, 7, 18, 18, 'Herself', '0710535605679', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(28, 7, 9, 9, 'Pearl', '0710535605587', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(29, 7, 4, 4, 'Queen', '0710535605532', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(30, 7, 3, 3, 'Señorita', '0710535605525', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(31, 8, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(32, 8, 3, 3, 'Señorita', '0710535605525', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(33, 8, 13, 13, 'Empress', '0710535605624', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(34, 8, 17, 17, 'Her', '0710535605662', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(35, 9, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(36, 9, 20, 20, 'Colleen', '0710535605693', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(37, 9, 17, 17, 'Her', '0710535605662', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(38, 9, 22, 22, 'Mon Cheri', '0710535605716', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(39, 9, 2, 2, 'Mademoiselle', '0710535605518', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(40, 10, 4, 4, 'Queen', '0710535605532', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(41, 10, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(42, 10, 3, 3, 'Señorita', '0710535605525', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(43, 11, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(44, 11, 15, 15, 'Highness', '0710535605648', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(45, 12, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(46, 13, 17, 17, 'Her Eyebrow Tint', '0710535605662', 1, '995.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(47, 13, 22, 22, 'Noir Mascara Duo', '0710535605716', 1, '795.00', '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(48, 14, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(49, 14, 3, 3, 'Señorita', '0710535605525', 1, '2450.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(50, 15, 1, 1, 'Amore Eyeshadow Palette', '0710535605501', 1, '2450.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(51, 16, 1, 1, 'Amore Eyeshadow Palette', '0710535605501', 1, '2450.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(52, 16, 9, 9, 'Pearl Glitter Liner', '0710535605587', 2, '995.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(53, 17, 1, 1, 'Amore Eyeshadow Palette', '0710535605501', 1, '2450.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(54, 17, 27, 27, 'Taylor False Eyelashes', '0710535605761', 1, '295.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(55, 18, 15, 15, 'Highness Eyebrow Duo Powder', '0710535605648', 1, '995.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(56, 18, 1, 1, 'Amore Eyeshadow Palette', '0710535605501', 1, '2450.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(57, 18, 21, 21, 'Virago Liquid Eyeliner Pen', '0710535605709', 1, '795.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(58, 19, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(59, 19, 27, 27, 'Taylor', '0710535605761', 1, '295.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(60, 19, 23, 23, 'Love', '0710535605723', 1, '295.00', '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(61, 20, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(62, 21, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(63, 22, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(64, 22, 13, 13, 'Empress', '0710535605624', 1, '995.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(65, 23, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(66, 24, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(67, 24, 20, 20, 'Colleen', '0710535605693', 1, '795.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(68, 24, 7, 7, 'Dame', '0710535605563', 1, '995.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(69, 24, 17, 17, 'Her', '0710535605662', 1, '995.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(70, 25, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(71, 26, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(72, 26, 4, 4, 'Queen', '0710535605532', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(73, 26, 3, 3, 'Señorita', '0710535605525', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(74, 27, 1, 1, 'Amore', '0710535605501', 1, '2450.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(75, 28, 10, 10, 'Amber Glitter Liner', '0710535605594', 1, '995.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(76, 28, 12, 12, 'Argent Glitter Liner', '0710535605617', 1, '995.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(77, 28, 20, 20, 'Colleen Liquid Eyeliner Pen', '0710535605693', 1, '795.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(78, 28, 22, 22, 'Noir Mascara Duo', '0710535605716', 1, '795.00', '2019-01-24 06:45:35', '2019-01-24 06:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_product_pickings`
--

CREATE TABLE `order_product_pickings` (
  `id` int(10) UNSIGNED NOT NULL,
  `reservation_id` int(10) UNSIGNED NOT NULL,
  `quantity_picked` int(10) UNSIGNED NOT NULL,
  `picker_id` int(10) UNSIGNED DEFAULT NULL,
  `picked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `movement_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product_reservations`
--

CREATE TABLE `order_product_reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_product_id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `quantity_reserved` int(10) UNSIGNED NOT NULL,
  `quantity_taken` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `picked_at` timestamp NULL DEFAULT NULL,
  `picked_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product_reservations`
--

INSERT INTO `order_product_reservations` (`id`, `order_product_id`, `stock_id`, `user_id`, `quantity_reserved`, `quantity_taken`, `picked_at`, `picked_by`, `created_at`, `updated_at`) VALUES
(1, 2, 31, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(2, 3, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(3, 5, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(4, 7, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(5, 9, 30, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(6, 10, 23, 2, 2, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(7, 11, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(8, 12, 4, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(9, 14, 2, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(10, 15, 4, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(11, 16, 3, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(12, 17, 23, 2, 10, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(13, 18, 24, 2, 2, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(14, 19, 25, 2, 2, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(15, 20, 27, 2, 2, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(16, 21, 26, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(17, 22, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(18, 24, 18, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(19, 26, 20, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(20, 27, 18, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(21, 28, 9, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(22, 29, 4, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(23, 30, 3, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(24, 32, 3, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(25, 33, 13, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(26, 34, 17, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(27, 36, 20, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(28, 37, 17, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(29, 38, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(30, 39, 2, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(31, 40, 4, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(32, 42, 3, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(33, 44, 15, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(34, 46, 17, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(35, 47, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:33', '2019-01-24 06:45:33'),
(36, 49, 3, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(37, 52, 9, 2, 2, 0, NULL, NULL, '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(38, 54, 27, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(39, 55, 15, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(40, 57, 21, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:34', '2019-01-24 06:45:34'),
(41, 59, 27, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(42, 60, 23, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(43, 64, 13, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(44, 67, 20, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(45, 68, 7, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(46, 69, 17, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(47, 72, 4, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(48, 73, 3, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(49, 75, 10, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(50, 76, 12, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(51, 77, 20, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35'),
(52, 78, 22, 2, 1, 0, NULL, NULL, '2019-01-24 06:45:35', '2019-01-24 06:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_shipments`
--

CREATE TABLE `order_shipments` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `package_length` decimal(13,2) DEFAULT NULL,
  `package_width` decimal(13,2) DEFAULT NULL,
  `package_height` decimal(13,2) DEFAULT NULL,
  `package_weight` decimal(13,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`) VALUES
(7, 'Cancelled'),
(5, 'Delivered'),
(6, 'Done'),
(3, 'Packed'),
(1, 'Pending'),
(2, 'Pick Listed'),
(4, 'Shipped');

-- --------------------------------------------------------

--
-- Table structure for table `order_users`
--

CREATE TABLE `order_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `common_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salutation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'metrics.index', NULL, NULL),
(2, 'metrics.create', NULL, NULL),
(3, 'metrics.show', NULL, NULL),
(4, 'metrics.update', NULL, NULL),
(5, 'metrics.delete', NULL, NULL),
(6, 'categories.index', NULL, NULL),
(7, 'categories.create', NULL, NULL),
(8, 'categories.show', NULL, NULL),
(9, 'categories.update', NULL, NULL),
(10, 'categories.delete', NULL, NULL),
(11, 'locations.index', NULL, NULL),
(12, 'locations.create', NULL, NULL),
(13, 'locations.show', NULL, NULL),
(14, 'locations.update', NULL, NULL),
(15, 'locations.delete', NULL, NULL),
(16, 'inventories.index', NULL, NULL),
(17, 'inventories.create', NULL, NULL),
(18, 'inventories.show', NULL, NULL),
(19, 'inventories.update', NULL, NULL),
(20, 'inventories.delete', NULL, NULL),
(21, 'stocks.index', NULL, NULL),
(22, 'stocks.create', NULL, NULL),
(23, 'stocks.store', NULL, NULL),
(24, 'stocks.show', NULL, NULL),
(25, 'stocks.update', NULL, NULL),
(26, 'stocks.delete', NULL, NULL),
(27, 'stocks.add', NULL, NULL),
(28, 'stocks.subtract', NULL, NULL),
(29, 'movements.index', NULL, NULL),
(30, 'movements.show', NULL, NULL),
(31, 'movements.rollback', NULL, NULL),
(32, 'suppliers.index', NULL, NULL),
(33, 'suppliers.create', NULL, NULL),
(34, 'suppliers.show', NULL, NULL),
(35, 'suppliers.update', NULL, NULL),
(36, 'suppliers.delete', NULL, NULL),
(37, 'roles.index', NULL, NULL),
(38, 'roles.create', NULL, NULL),
(39, 'roles.show', NULL, NULL),
(40, 'roles.update', NULL, NULL),
(41, 'roles.delete', NULL, NULL),
(42, 'permissions.index', NULL, NULL),
(43, 'permissions.create', NULL, NULL),
(44, 'permissions.show', NULL, NULL),
(45, 'permissions.update', NULL, NULL),
(46, 'permissions.delete', NULL, NULL),
(47, 'users.index', NULL, NULL),
(48, 'users.create', NULL, NULL),
(49, 'users.show', NULL, NULL),
(50, 'users.update', NULL, NULL),
(51, 'users.delete', NULL, NULL),
(52, 'orders.index', NULL, NULL),
(53, 'orders.show', NULL, NULL),
(54, 'orders.update', NULL, NULL),
(55, 'orders.sync', NULL, NULL),
(56, 'orders.reopen', NULL, NULL),
(57, 'orders.pack', NULL, NULL),
(58, 'orders.ship', NULL, NULL),
(59, 'orders.cancel', NULL, NULL),
(60, 'purchase_orders.index', NULL, NULL),
(61, 'purchase_orders.create', NULL, NULL),
(62, 'purchase_orders.show', NULL, NULL),
(63, 'receivings.index', NULL, NULL),
(64, 'receivings.create', NULL, NULL),
(65, 'receivings.show', NULL, NULL),
(66, 'transfer_orders.index', NULL, NULL),
(67, 'transfer_orders.create', NULL, NULL),
(68, 'transfer_orders.delete', NULL, NULL),
(69, 'transfer_orders.complete', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_roles`
--

CREATE TABLE `permission_roles` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_roles`
--

INSERT INTO `permission_roles` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(52, 4),
(53, 4),
(54, 4),
(55, 4),
(56, 4),
(57, 4),
(58, 4),
(59, 4);

-- --------------------------------------------------------

--
-- Table structure for table `permission_users`
--

CREATE TABLE `permission_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_products`
--

CREATE TABLE `purchase_order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_receivings`
--

CREATE TABLE `purchase_order_receivings` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `received_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_receiving_products`
--

CREATE TABLE `purchase_order_receiving_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_order_receiving_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Super User', NULL, NULL),
(2, 'Administrator', NULL, NULL),
(3, 'Inbound Operator', NULL, NULL),
(4, 'Outbound Operator', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`role_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `field` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `created_at`, `updated_at`, `name`, `address`, `postal_code`, `zip_code`, `region`, `city`, `country`, `contact_title`, `contact_name`, `contact_phone`, `contact_fax`, `contact_email`) VALUES
(1, NULL, NULL, 'Default Supplier', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_orders`
--

CREATE TABLE `transfer_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_order_product_id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `aisle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `row` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transferred_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super User', 'super_user@teviant.com', '$2y$10$EaYEIw1DWt3CrsxKt3qmrexmqMgjbZSjzPRv56/11z1kP53oJD7CG', 'vL6C1TXOurfTJym8zqQOGnDxBN8CkkIyNUnUWeelHl8ZXEJTgxDjCvlRl7dL', NULL, NULL),
(2, 'Teviant Admin', 'admin@teviant.com', '$2y$10$T8mNqUnTCWVPdW6HGTcl9.FOe5gCZJfIEsGJXYcZehwZFTRkJTMnK', NULL, NULL, NULL),
(3, 'Inbound Operator', 'inbound@teviant.com', '$2y$10$n4c6s6DtGXTMATOflg4Puu4uFHM6I7TmM1tIpBhfS6ROHbT84FBW2', NULL, NULL, NULL),
(4, 'Outbound Operator', 'outbound@teviant.com', '$2y$10$95RcL8DyyMSAxwSdTLC8HuagMLvXm.puH2o8P5Lc7x4yGIZbf/69u', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_index` (`parent_id`),
  ADD KEY `categories_lft_index` (`lft`),
  ADD KEY `categories_rgt_index` (`rgt`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories_category_id_foreign` (`category_id`),
  ADD KEY `inventories_user_id_foreign` (`user_id`),
  ADD KEY `inventories_metric_id_foreign` (`metric_id`),
  ADD KEY `inventories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `inventory_assemblies`
--
ALTER TABLE `inventory_assemblies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_assemblies_inventory_id_foreign` (`inventory_id`),
  ADD KEY `inventory_assemblies_part_id_foreign` (`part_id`);

--
-- Indexes for table `inventory_skus`
--
ALTER TABLE `inventory_skus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_skus_code_unique` (`code`),
  ADD KEY `inventory_skus_inventory_id_foreign` (`inventory_id`);

--
-- Indexes for table `inventory_stocks`
--
ALTER TABLE `inventory_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_stocks_inventory_id_location_id_unique` (`inventory_id`,`location_id`),
  ADD KEY `inventory_stocks_user_id_foreign` (`user_id`),
  ADD KEY `inventory_stocks_location_id_foreign` (`location_id`);

--
-- Indexes for table `inventory_stock_movements`
--
ALTER TABLE `inventory_stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_stock_movements_stock_id_foreign` (`stock_id`),
  ADD KEY `inventory_stock_movements_user_id_foreign` (`user_id`),
  ADD KEY `inventory_stock_movements_transfer_order_id_foreign` (`transfer_order_id`);

--
-- Indexes for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_suppliers_inventory_id_foreign` (`inventory_id`),
  ADD KEY `inventory_suppliers_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_transactions_user_id_foreign` (`user_id`),
  ADD KEY `inventory_transactions_stock_id_foreign` (`stock_id`);

--
-- Indexes for table `inventory_transaction_histories`
--
ALTER TABLE `inventory_transaction_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_transaction_histories_user_id_foreign` (`user_id`),
  ADD KEY `inventory_transaction_histories_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_parent_id_index` (`parent_id`),
  ADD KEY `locations_lft_index` (`lft`),
  ADD KEY `locations_rgt_index` (`rgt`);

--
-- Indexes for table `metrics`
--
ALTER TABLE `metrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metrics_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_status_id_foreign` (`status_id`),
  ADD KEY `orders_packer_foreign` (`packer_id`);

--
-- Indexes for table `order_carriers`
--
ALTER TABLE `order_carriers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_carriers_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_products_product_id_foreign` (`product_id`),
  ADD KEY `order_products_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_product_pickings`
--
ALTER TABLE `order_product_pickings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_pickings_reservation_id_foreign` (`reservation_id`),
  ADD KEY `order_product_pickings_picker_id_foreign` (`picker_id`),
  ADD KEY `order_product_pickings_movement_id_foreign` (`movement_id`);

--
-- Indexes for table `order_product_reservations`
--
ALTER TABLE `order_product_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_reservations_order_product_id_foreign` (`order_product_id`),
  ADD KEY `order_product_reservations_stock_id_foreign` (`stock_id`),
  ADD KEY `order_product_reservations_user_id_foreign` (`user_id`),
  ADD KEY `order_product_reservations_picked_by_foreign` (`picked_by`);

--
-- Indexes for table `order_shipments`
--
ALTER TABLE `order_shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_shipments_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_statuses_name_unique` (`name`);

--
-- Indexes for table `order_users`
--
ALTER TABLE `order_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_users_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_users`
--
ALTER TABLE `permission_users`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `permission_users_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_user_id_foreign` (`user_id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_products_product_id_foreign` (`product_id`),
  ADD KEY `purchase_order_products_purchase_order_id_foreign` (`purchase_order_id`);

--
-- Indexes for table `purchase_order_receivings`
--
ALTER TABLE `purchase_order_receivings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_product_receivings_receiver_id_foreign` (`receiver_id`),
  ADD KEY `purchase_order_receivings_purchase_order_id_foreign` (`purchase_order_id`);

--
-- Indexes for table `purchase_order_receiving_products`
--
ALTER TABLE `purchase_order_receiving_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiving_id_foreign` (`purchase_order_receiving_id`),
  ADD KEY `product_id_foreign` (`purchase_order_product_id`),
  ADD KEY `purchase_order_receiving_products_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `role_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_orders`
--
ALTER TABLE `transfer_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_orders_location_id_foreign` (`location_id`),
  ADD KEY `transfer_orders_purchase_order_product_id_foreign` (`purchase_order_product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `inventory_assemblies`
--
ALTER TABLE `inventory_assemblies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_skus`
--
ALTER TABLE `inventory_skus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `inventory_stocks`
--
ALTER TABLE `inventory_stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `inventory_stock_movements`
--
ALTER TABLE `inventory_stock_movements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_transaction_histories`
--
ALTER TABLE `inventory_transaction_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `metrics`
--
ALTER TABLE `metrics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_carriers`
--
ALTER TABLE `order_carriers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `order_product_pickings`
--
ALTER TABLE `order_product_pickings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_product_reservations`
--
ALTER TABLE `order_product_reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `order_shipments`
--
ALTER TABLE `order_shipments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_users`
--
ALTER TABLE `order_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_receivings`
--
ALTER TABLE `purchase_order_receivings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_receiving_products`
--
ALTER TABLE `purchase_order_receiving_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_orders`
--
ALTER TABLE `transfer_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventories_metric_id_foreign` FOREIGN KEY (`metric_id`) REFERENCES `metrics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_assemblies`
--
ALTER TABLE `inventory_assemblies`
  ADD CONSTRAINT `inventory_assemblies_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_assemblies_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_skus`
--
ALTER TABLE `inventory_skus`
  ADD CONSTRAINT `inventory_skus_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_stocks`
--
ALTER TABLE `inventory_stocks`
  ADD CONSTRAINT `inventory_stocks_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_stocks_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_stocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_stock_movements`
--
ALTER TABLE `inventory_stock_movements`
  ADD CONSTRAINT `inventory_stock_movements_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `inventory_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_stock_movements_transfer_order_id_foreign` FOREIGN KEY (`transfer_order_id`) REFERENCES `transfer_orders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  ADD CONSTRAINT `inventory_suppliers_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD CONSTRAINT `inventory_transactions_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `inventory_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_transaction_histories`
--
ALTER TABLE `inventory_transaction_histories`
  ADD CONSTRAINT `inventory_transaction_histories_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `inventory_transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transaction_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `metrics`
--
ALTER TABLE `metrics`
  ADD CONSTRAINT `metrics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_packer_foreign` FOREIGN KEY (`packer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `order_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_carriers`
--
ALTER TABLE `order_carriers`
  ADD CONSTRAINT `order_carriers_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `inventories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_product_pickings`
--
ALTER TABLE `order_product_pickings`
  ADD CONSTRAINT `order_product_pickings_movement_id_foreign` FOREIGN KEY (`movement_id`) REFERENCES `inventory_stock_movements` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_pickings_picker_id_foreign` FOREIGN KEY (`picker_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_pickings_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `order_product_reservations` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_product_reservations`
--
ALTER TABLE `order_product_reservations`
  ADD CONSTRAINT `order_product_reservations_order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `order_products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_reservations_picked_by_foreign` FOREIGN KEY (`picked_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_reservations_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `inventory_stocks` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_shipments`
--
ALTER TABLE `order_shipments`
  ADD CONSTRAINT `order_shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_users`
--
ALTER TABLE `order_users`
  ADD CONSTRAINT `order_users_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD CONSTRAINT `permission_roles_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_users`
--
ALTER TABLE `permission_users`
  ADD CONSTRAINT `permission_users_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  ADD CONSTRAINT `purchase_order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `inventories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_order_products_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order_receivings`
--
ALTER TABLE `purchase_order_receivings`
  ADD CONSTRAINT `purchase_order_product_receivings_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_order_receivings_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order_receiving_products`
--
ALTER TABLE `purchase_order_receiving_products`
  ADD CONSTRAINT `product_id_foreign` FOREIGN KEY (`purchase_order_product_id`) REFERENCES `purchase_order_products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_order_receiving_products_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `receiving_id_foreign` FOREIGN KEY (`purchase_order_receiving_id`) REFERENCES `purchase_order_receivings` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfer_orders`
--
ALTER TABLE `transfer_orders`
  ADD CONSTRAINT `transfer_orders_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_orders_purchase_order_product_id_foreign` FOREIGN KEY (`purchase_order_product_id`) REFERENCES `purchase_order_products` (`id`) ON UPDATE CASCADE;
