DROP TABLE commentaires;

CREATE TABLE `commentaires` (
  `identifiant` int(11) NOT NULL,
  `colonne` varchar(128) NOT NULL,
  `commentaire` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO commentaires VALUES("20","cliniciens","");
INSERT INTO commentaires VALUES("20","upn","");
INSERT INTO commentaires VALUES("20","sexe","");



DROP TABLE images;

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(64) NOT NULL DEFAULT 'bddimg/default.png',
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO images VALUES("0","bddimg/default.png");



DROP TABLE step1;

CREATE TABLE `step1` (
  `cliniciens` enum('Vincent','Florence','') DEFAULT NULL,
  `upn` int(11) DEFAULT NULL,
  `sexe` enum('M','F','') DEFAULT NULL,
  `annee_de_naissance` int(11) DEFAULT NULL,
  `date_de_diagnostic` date DEFAULT NULL,
  `score_de_matutes` enum('5','','4 ou 5') DEFAULT NULL,
  `statut_ighv` enum('M','UM','') DEFAULT NULL,
  `vh` varchar(0) DEFAULT NULL,
  `homologie___germline` int(11) DEFAULT NULL,
  `aberrations_chromosomiques` varchar(0) DEFAULT NULL,
  `mutations_geniques` enum('ND','','NOTCH1, POT1','Normal','BIRC3','SF3B1') DEFAULT NULL,
  `traitement__oui_1_vs_non_0` tinyint(4) DEFAULT NULL,
  `date_traitement` date DEFAULT NULL,
  `date_point_pour_l_etude__si_traitement_ecrire_date_du_trai` date DEFAULT NULL,
  `calcul_du_delai__date_de_point__ou_traitement_moins_date_de_diag` int(11) DEFAULT NULL,
  `colonne15` enum('') DEFAULT NULL,
  `date_de_l_echantillon` int(11) DEFAULT NULL,
  `lymphocytose__g_l` int(11) DEFAULT NULL,
  `colonne18` enum('') DEFAULT NULL,
  `foxp3_protplus__pourcent` varchar(0) DEFAULT NULL,
  `il10_protplus__pourcent` varchar(0) DEFAULT NULL,
  `tgfb1_protplus__pourcent` varchar(0) DEFAULT NULL,
  `colonne22` enum('') DEFAULT NULL,
  `pourcent_treg__vs_cd4plus` varchar(0) DEFAULT NULL,
  `mts__pourcent` varchar(0) DEFAULT NULL,
  `od_basal` varchar(0) DEFAULT NULL,
  `od_stimulee` varchar(0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




DROP TABLE step2;

CREATE TABLE `step2` (
  `cliniciens` enum('Vincent','Florence','') DEFAULT NULL,
  `upn` int(11) DEFAULT NULL,
  `sexe` enum('M','F','') DEFAULT NULL,
  `annee_de_naissance` int(11) DEFAULT NULL,
  `date_de_diagnostic` date DEFAULT NULL,
  `score_de_matutes` enum('5','','4 ou 5') DEFAULT NULL,
  `statut_ighv` enum('M','UM','') DEFAULT NULL,
  `vh` varchar(0) DEFAULT NULL,
  `homologie___germline` int(11) DEFAULT NULL,
  `aberrations_chromosomiques` varchar(0) DEFAULT NULL,
  `mutations_geniques` enum('ND','','NOTCH1, POT1','Normal','BIRC3','SF3B1') DEFAULT NULL,
  `traitement__oui_1_vs_non_0` tinyint(4) DEFAULT NULL,
  `date_traitement` date DEFAULT NULL,
  `date_point_pour_l_etude__si_traitement_ecrire_date_du_trai` date DEFAULT NULL,
  `calcul_du_delai__date_de_point__ou_traitement_moins_date_de_diag` int(11) DEFAULT NULL,
  `colonne15` enum('') DEFAULT NULL,
  `date_de_l_echantillon` int(11) DEFAULT NULL,
  `lymphocytose__g_l` int(11) DEFAULT NULL,
  `colonne18` enum('') DEFAULT NULL,
  `foxp3_protplus__pourcent` varchar(0) DEFAULT NULL,
  `il10_protplus__pourcent` varchar(0) DEFAULT NULL,
  `tgfb1_protplus__pourcent` varchar(0) DEFAULT NULL,
  `colonne22` enum('') DEFAULT NULL,
  `pourcent_treg__vs_cd4plus` varchar(0) DEFAULT NULL,
  `mts__pourcent` varchar(0) DEFAULT NULL,
  `od_basal` varchar(0) DEFAULT NULL,
  `od_stimulee` varchar(0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO step2 VALUES("Vincent","20","M","1965","","","","","","","","","","","","","","","","","","","","","","","");



DROP TABLE users;

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `mail` varchar(64) NOT NULL,
  `modlvl` int(10) NOT NULL,
  `profil_img` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("12","Lefebvre","Hugo","87469b695f7ac6e88b1b07d7902282ab","hugo18.flhs@gmail.com","1","0");



