-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 22 oct. 2024 à 03:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bddlabo02`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnements_infolettre`
--

CREATE TABLE `abonnements_infolettre` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `abonnements_infolettre`
--

INSERT INTO `abonnements_infolettre` (`id`, `email`) VALUES
(1, '245@gmail.com'),
(2, '476@gmail.com'),
(3, '476900@gmail.com'),
(7, '123456@gmail.com'),
(8, 'loula@gmail.com'),
(9, '123@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `couleur` text NOT NULL,
  `taille` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `name`, `type`, `couleur`, `taille`, `prix`, `description`, `image`) VALUES
(1, 'Mare Celeste', 'Cravate', 'Bleu', 'Unique', 230.00, 'Évoquant la magie des nuits étoilées, cette cravate \"Mare Céleste\" est un véritable chef-d\'œuvre. Fabriquée en soie luxueuse, elle présente un motif délicat de constellations scintillantes sur un fond bleu profond, rappelant les vastes cieux nocturnes. Les touches de doré et d\'argent apportent une dimension éclatante, évoquant les reflets de la lune sur une surface d\'eau calme. Idéale pour les occasions formelles ou pour ajouter une touche d\'élégance à une tenue décontractée, cette cravate est parfaite pour ceux qui souhaitent porter une part de rêve et de mystère autour du cou.', 'images/tie1.webp'),
(2, 'Spazio Viola', 'Cravate', 'Violet', 'Unique', 170.50, 'Plongez dans l\'immensité d\'un cosmos vibrant avec la cravate \"Spazio Viola\". Confectionnée en soie de haute qualité, elle se distingue par un riche dégradé de nuances violettes, allant du lilas délicat au violet profond, créant un effet hypnotisant qui évoque les mystères de l\'espace. Des motifs de galaxies et d\'étoiles scintillantes sont subtilement intégrés, capturant la beauté du ciel nocturne. Cette cravate allie élégance et originalité, parfaite pour ceux qui souhaitent se démarquer tout en ajoutant une touche de sophistication à leur look, que ce soit lors d\'événements formels ou d\'occasions spéciales.', 'images/tie2.webp'),
(3, 'Raggi Penetranti', 'Cravate', 'Violet', 'Unique', 155.68, 'La cravate \"Raggi Penetranti\" incarne une sophistication moderne avec son design audacieux. Arborant un fond gris élégant, elle est ornée de lignes dynamiques en bleu foncé et en nuances de rose et mauve, qui se croisent avec une énergie captivante. Ce motif évoque des rayons de lumière qui traversent un ciel nuageux, créant une atmosphère à la fois apaisante et stimulante. Confectionnée en soie de qualité supérieure, cette cravate est parfaite pour apporter une touche d\'originalité à vos tenues, que ce soit pour une réunion professionnelle ou une sortie en soirée.', 'images/tie3.webp'),
(4, 'Vita In Rosa', 'Cravate', 'Rose', 'Unique', 400.00, 'Plongez dans un univers enchanteur avec la cravate \"Vita in Rosa\". Évoquant un paysage idyllique, elle se pare de teintes délicates de rose, allant du pastel doux au fuchsia vibrant. Des motifs floraux et des silhouettes de collines se mêlent harmonieusement, créant une impression de douceur et de sérénité. Confectionnée en soie luxueuse, cette cravate reflète la beauté des couchers de soleil et des jardins en fleurs, ajoutant une touche de romantisme et de fraîcheur à votre look. Parfaite pour des occasions spéciales ou pour apporter une note de couleur à une tenue formelle, la \"Vita in Rosa\" est un hommage à la beauté de la vie à travers le prisme de la couleur rose.', 'images/tie4.webp'),
(5, 'Simbiosi di Modelli', 'Cravate', 'Rose', 'Unique', 433.16, 'Plongez dans une fusion captivante de formes et de couleurs avec la cravate \"Simbiosi di Modelli\". Son fond rose vibrant est parsemé de motifs complexes et abstraits, mêlant des étoiles, des cercles, des montagnes stylisées, et des éléments scientifiques aux teintes de bleu et de violet. Cette cravate évoque l\'esthétique unique du vaporwave, où l’art numérique rencontre la nostalgie rétro-futuriste. Chaque détail semble flotter dans un paysage onirique, transportant celui qui la porte dans une dimension où technologie et nature s’unissent. Confectionnée en soie de haute qualité, \"Simbiosi di Modelli\" est parfaite pour ceux qui cherchent à exprimer leur créativité tout en conservant une élégance audacieuse.', 'images/tie5.webp'),
(6, 'Imponente Unicorno\r\n', 'Cravate', 'Mauve', 'Unique', 321.50, 'Affichez votre style audacieux avec la cravate \"Imponente Unicorno\". Dominée par une majestueuse licorne en son centre, cette pièce se distingue par son fond mauve intense et des bandes graphiques qui traversent la cravate avec élégance. La licorne, imposante et fièrement représentée, symbolise la puissance et la grâce, capturant l\'imaginaire mythologique avec une touche contemporaine. Les détails subtils en argenté autour de la créature ajoutent une profondeur mystique au design, tandis que les bandes contrastantes renforcent l\'aspect dynamique de cette cravate. Idéale pour ceux qui veulent marier créativité et prestance, \"Imponente Unicorno\" est l\'accessoire parfait pour affirmer une présence remarquable lors de toute occasion.', 'images/tie6.webp'),
(7, 'Unicorni Che Girano', 'Cravate', 'Rose', 'Unique', 144.45, 'Faites ressortir votre style fantaisiste avec la cravate \"Unicorni che Girano\". Sur un fond rose vibrant, de petites licornes vertes s’enroulent en motif répétitif, apportant une touche ludique et unique à cette pièce. Ces licornes, minutieusement stylisées, semblent danser sur la cravate, créant un mouvement continu et captivant. Le contraste entre le rose vif et le vert éclatant donne un effet visuel audacieux, parfait pour ceux qui souhaitent ajouter une note de magie et d’originalité à leur tenue. Que ce soit pour une occasion décontractée ou pour affirmer une touche d\'humour lors d’un événement plus formel, \"Unicorni che Girano\" est le choix parfait pour les esprits créatifs.', 'images/tie7.webp'),
(8, 'All\'Attacco', 'Cravate', 'Bleu', 'Unique', 228.12, 'Affirmez votre style audacieux avec la cravate \"All\'Attacco\", où des licornes roses se lancent à l’assaut sur un fond bleu profond. Ces licornes, stylisées et dynamiques, se répètent en motif sur toute la longueur de la cravate, créant une esthétique vive et pleine d\'énergie. Le contraste entre le bleu élégant et le rose éclatant apporte une touche amusante tout en restant chic. Confectionnée en soie de haute qualité, cette cravate est idéale pour ceux qui osent associer imagination et sophistication. Parfaite pour ajouter une touche d’originalité à votre tenue formelle ou pour des occasions où vous souhaitez vous démarquer avec un accessoire unique.', 'images/tie8.webp'),
(9, 'Regina Trionfante', 'Cravate', 'Mauve', 'Unique', 531.75, 'Avec la cravate \"Regina Trionfante\", plongez dans un univers féerique et galactique. Au centre trône une licorne majestueuse, symbole de puissance et de grâce, entourée de bandes aux couleurs éclatantes qui traversent un fond mauve profond. Des étoiles scintillantes et des nuages colorés en rose se dispersent tout autour, créant une atmosphère cosmique. Un arc-en-ciel vibrant forme une bande audacieuse, ajoutant une touche de rêve et d’évasion. Confectionnée en soie luxueuse, cette cravate est un véritable hommage à l\'imaginaire galactique, idéale pour ceux qui souhaitent marier élégance et créativité avec une pièce à l\'énergie triomphante et magique.', 'images/tieX.webp'),
(10, 'Festa Moderna', 'Chemise', 'Blanc', '44-56', 135.26, 'La chemise \"Festa Moderna\" incarne un style moderne et ludique avec une touche d’imaginaire. Sur un fond blanc éclatant, des bandes élégantes de bleu et de violet se croisent avec finesse, apportant structure et contraste. Au centre, une grande licorne imposante attire tous les regards, symbolisant l’audace et la créativité. Autour, de petites têtes de licornes parsèment la chemise, ajoutant une touche de fantaisie subtile tout en maintenant l’esprit festif et élégant de la pièce. Confectionnée dans un tissu léger et agréable, cette chemise est parfaite pour des événements où l\'originalité et le style moderne se rencontrent, que ce soit pour une fête ou une sortie décontractée avec un flair unique.', 'images/shirt1.webp'),
(11, 'Re Degli Unicorni', 'Chemise', 'Mauve', '44-56', 393.72, 'Plongez dans l’univers vibrant du vaporwave avec la chemise \"Re Degli Unicorni\". Sur un fond mauve hypnotisant, une licorne majestueuse trône fièrement au centre, entourée d\'un univers rétro-futuriste inspiré de l\'esthétique vaporwave. Des éléments géométriques, des palmiers stylisés, et des éclairs néon en rose, bleu et violet parcourent la chemise, créant un motif audacieux et immersif. Les couleurs saturées et les effets visuels rappellent l\'éclat des années 80, mariant parfaitement l’imaginaire mythologique à un design moderne et nostalgique. Fabriquée dans un tissu léger et confortable, cette chemise est idéale pour ceux qui veulent afficher un style unique et avant-gardiste, que ce soit pour une fête, un événement artistique ou simplement pour se démarquer avec flair.', 'images/tshirt1.webp'),
(12, 'Terzine', 'Chemise', 'Rose', '44-56', 290.01, 'Affirmez votre style avec la chemise \"Terzine\", une pièce unique qui marie l\'esthétique vaporwave à un univers fantastique. Trois licornes majestueuses se détachent en avant-plan, leur silhouette imposante capturant toute l\'attention. Elles sont mises en valeur par un fond rose vif, qui évoque la douceur et l’intensité d’un coucher de soleil numérique. Autour des licornes, des motifs vaporwave dynamiques – palmiers, grilles 3D, éclairs néon et éléments géométriques rétro – ajoutent une touche futuriste et nostalgique. Les teintes roses, bleues et violettes fusionnent pour créer une atmosphère de rêve, parfaite pour ceux qui aiment se démarquer. Confectionnée en tissu léger, cette chemise est idéale pour des événements où créativité et originalité sont de mise.', 'images/tshirt2.webp'),
(13, 'Dea dell\'Unicorno', 'Chemise', 'Rose', '44-56', 454.12, 'La chemise \"Dea dell\'Unicorno\" incarne la puissance mystique de la licorne, combinée à une esthétique vaporwave envoûtante. Au centre, une majestueuse licorne trône fièrement, véritable déesse de l\'imaginaire. Autour d\'elle, un somptueux dégradé de vert et de rose crée une harmonie visuelle captivante, passant des teintes douces aux nuances plus vibrantes. Des motifs vaporwave, avec leurs traits géométriques, leurs formes rétro-futuristes et leurs effets néon, parcourent la chemise, apportant une touche de modernité et de nostalgie. Ce mélange de couleurs et de designs crée une atmosphère à la fois rêveuse et dynamique, parfaite pour les amoureux de la mode qui veulent exprimer leur côté créatif et unique. Confectionnée dans un tissu doux et léger, cette chemise est aussi confortable qu’elle est remarquable.', 'images/tshirt3.webp'),
(14, 'Dolci Colline', 'Chemise', 'Bleu', '44-56', 680.98, 'La chemise \"Dolci Colline\" vous transporte dans un paysage onirique, où des mini montagnes se dressent sur un fond bleu éclatant, doucement traversé par un dégradé de rose. Les collines, stylisées avec délicatesse, évoquent une sérénité paisible, tout en s’intégrant à l’univers vaporwave grâce à des motifs géométriques et des éléments rétro-futuristes. Les touches néon et les lignes épurées rappellent l’esthétique numérique des années 80, fusionnant modernité et nostalgie. Ce contraste subtil entre les montagnes et les motifs abstraits crée une pièce à la fois élégante et audacieuse, idéale pour ceux qui aiment porter des designs originaux et immersifs. Confectionnée dans un tissu doux et léger, \"Dolci Colline\" offre un confort sans compromis avec une touche artistique unique.', 'images/tshirt4.webp'),
(15, 'Montagne Selvagge', 'Chemise', 'Bleu', '44-56', 453.34, 'Évoquez l\'aventure sauvage et le mystère avec la chemise \"Montagne Selvagge\". Dominée par des montagnes imposantes et stylisées, cette chemise mêle des éléments naturels à l’esthétique distinctive du vaporwave. Sur un fond aux teintes vives de bleu et de violet, des montagnes s’élèvent, entourées de lignes géométriques, de grilles 3D et d\'effets néon typiques du style rétro-futuriste. Le dégradé subtil de couleurs – du rose électrique au bleu profond – crée une atmosphère envoûtante, rappelant les paysages numériques d’un univers alternatif. Parfaite pour les esprits libres et créatifs, \"Montagne Selvagge\" est une pièce unique qui combine nature sauvage et design avant-gardiste. Fabriquée dans un tissu léger et confortable, elle ajoute une touche d\'originalité à toute garde-robe.', 'images/tshirt5.webp'),
(16, 'Linee Appuntite', 'Chemise', 'Rose', '44-56', 168.10, 'La chemise \"Linee Appuntite\" incarne l\'énergie percutante de l\'univers vaporwave, où des lignes aiguisées et dynamiques tracent des motifs géométriques saisissants. Sur un fond dégradé de teintes néon, allant du bleu électrique au rose éclatant, des traits pointus et graphiques se croisent et s\'entrelacent, créant une esthétique résolument moderne et rétro-futuriste. Inspirée par l\'ère numérique et ses formes anguleuses, cette pièce évoque la vitesse, l\'innovation et la nostalgie des années 80. Le jeu de couleurs néon et les contrastes lumineux renforcent l\'impact visuel de cette chemise, la rendant idéale pour ceux qui souhaitent se démarquer avec un style audacieux et tranchant. Confectionnée dans un tissu doux et léger, \"Linee Appuntite\" est parfaite pour ajouter une touche d’avant-garde à toute tenue.', 'images/tshirt6.webp');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(26, 'balola', '123@gmail.com', '$2y$10$54wgB2zg3q4peKkKCRu.uOAgu/.OrpbzVoYqFS0LkcsXIuBeJVsSG');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnements_infolettre`
--
ALTER TABLE `abonnements_infolettre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnements_infolettre`
--
ALTER TABLE `abonnements_infolettre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
