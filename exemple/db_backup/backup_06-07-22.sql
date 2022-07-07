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
  `sexe` enum('F','M') DEFAULT NULL,
  `annee_de_naissance` int(11) DEFAULT NULL,
  `date_de_diagnostic` date DEFAULT NULL,
  `score_de_matutes` enum('4 ou 5','5') DEFAULT NULL,
  `statut_ighv` enum('M','UM') DEFAULT NULL,
  `vh` varchar(8) DEFAULT NULL,
  `homologie___germline` varchar(17) DEFAULT NULL,
  `aberrations_chromosomiques` varchar(21) DEFAULT NULL,
  `mutations_geniques` enum('ND','NOTCH1, POT1','Normal','BIRC3','SF3B1') DEFAULT NULL,
  `traitement__oui_1_vs_non_0` enum('0','1') DEFAULT NULL,
  `date_traitement` date DEFAULT NULL,
  `date_point_pour_l_etude__si_traitement_ecrire_date_du_traitement` date DEFAULT NULL,
  `calcul_du_delai__date_de_point__ou_traitement_moins_date_de_diag` int(11) DEFAULT NULL,
  `colonne15` varchar(0) DEFAULT NULL,
  `date_de_l_echantillon` date DEFAULT NULL,
  `lymphocytose__g_l` varchar(17) DEFAULT NULL,
  `colonne18` varchar(0) DEFAULT NULL,
  `foxp3_protplus__pourcent` varchar(16) DEFAULT NULL,
  `il10_protplus__pourcent` varchar(18) DEFAULT NULL,
  `tgfb1_protplus__pourcent` varchar(17) DEFAULT NULL,
  `colonne22` varchar(0) DEFAULT NULL,
  `pourcent_treg__vs_cd4plus` varchar(17) DEFAULT NULL,
  `mts__pourcent` varchar(32) DEFAULT NULL,
  `od_basal` varchar(4) DEFAULT NULL,
  `od_stimulee` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO step1 VALUES("Vincent","20","M","1965","2014-07-01","5","M","VH4-34","0","Del13, ","ND","0","0001-01-01","2020-09-01","2254","","2019-01-08","0","","1.4","1.09","62.6","","7.47","41.55","0.67","0.95");
INSERT INTO step1 VALUES("Vincent","34","F","1926","2012-02-01","","M","VH3-33","0","Del13, ","","0","0001-01-01","2020-03-05","2955","","2018-05-29","0","","0.93","12.9","1.99","","9.449999999999999","45.17","0.42","0.61");
INSERT INTO step1 VALUES("Florence","42","F","1927","2008-06-15","","UM","VH1-69","100","Del11, Del13","","1","2011-04-01","2011-04-01","1020","","2019-03-26","156","","3.09","9.289999999999999","10.4","","9.460000000000001","30.97","0.88","1.16");
INSERT INTO step1 VALUES("Vincent","95","M","1957","2015-04-28","","M","","0","Del13","","0","0001-01-01","2020-11-18","2031","","2019-06-04","32","","1.44","1.06","46.3","","10.3","-17.08","0.67","0.56");
INSERT INTO step1 VALUES("Florence","119","M","1956","2013-06-01","","UM","VH1-69","100","","","1","2019-11-14","2019-11-14","2357","","2019-03-12","250","","22.7","5.66","4.7","","5.52","19.46","0.32","0.39");
INSERT INTO step1 VALUES("Florence","122","M","1959","2011-07-12","","UM","VH4-34","100","Del12","","1","2012-02-01","2012-02-01","204","","2019-06-04","5","","1.55","1","97.8","","6.24","7.79","0.59","0.63");
INSERT INTO step1 VALUES("Vincent","137","F","1952","2018-06-19","","M","VH3-23","97","","","0","0001-01-01","2020-10-27","861","","2019-01-15","9.699999999999999","","5.7","1.56","29","","4.77","14.81","0.69","0.79");
INSERT INTO step1 VALUES("Florence","152","F","1943","2014-02-25","","M","VH5-10-1","95","ND","ND","1","2020-09-02","2020-09-02","2381","","2019-01-08","70","","1.82","0.71","95.09999999999999","","7.77","20.06","0.56","0.67");
INSERT INTO step1 VALUES("Florence","168","F","1963","2003-06-01","","M","VH3-33","96","ND","ND","0","0001-01-01","2020-12-22","6414","","2019-06-04","57","","ND","ND","ND","","ND","1.52","0.53","0.53");
INSERT INTO step1 VALUES("Florence","172","M","1953","2018-09-12","","UM","VH1-69","100","Tri12","NOTCH1, POT1","1","2019-03-19","2019-03-19","188","","2019-02-26","106","","2.34","12","93.59999999999999","","9.279999999999999","15.86","0.42","0.49");
INSERT INTO step1 VALUES("Florence","196","M","1933","2008-06-01","","UM","VH3-21","98","","","1","2019-02-12","2019-02-12","3908","","2019-01-15","77","","3.29","49.9","31","","7.53","30.66","0.89","1.17");
INSERT INTO step1 VALUES("Florence","199","M","1971","2019-02-01","","UM","VH4-38-2","100","","","1","2019-10-30","2019-10-30","271","","2019-06-04","33","","1.08","0.46","91.59999999999999","","12","8.130000000000001","1.07","1.16");
INSERT INTO step1 VALUES("Vincent","239","M","1943","2003-06-01","4 ou 5","M","VH3-7","92.3","Del13, ","ND","0","0001-01-01","2020-11-17","6379","","2019-01-15","32.5","","0.79","7.51","37.9","","6.63","11.92","0.69","0.77");
INSERT INTO step1 VALUES("Vincent","265","M","1966","2018-01-09","5","M","","0","Del13, ","ND","0","0001-01-01","2020-11-17","1043","","2019-04-16","15","","1.32","5.33","64.59999999999999","","12.1","78.18000000000001","0.50","0.89");
INSERT INTO step1 VALUES("Vincent","293","M","1954","2010-01-01","","M","VH3-23","89","","","0","0001-01-01","2020-07-07","3840","","2019-06-04","14","","0.55","5.37","29.2","","2.78","-6.29","0.68","0.64");
INSERT INTO step1 VALUES("Florence","297","F","1950","2015-02-10","","M","VH4-39","92.59999999999999","Del13, ","ND","0","0001-01-01","2020-12-22","2142","","2019-01-15","21.7","","3.19","4.65","14","","3.37","7.22","0.68","0.73");
INSERT INTO step1 VALUES("Florence","310","F","1951","2015-06-01","","UM","VH1-2","100","Normal","Normal","1","2019-11-30","2019-11-30","1643","","2018-05-14","178","","","4.1","10.3","","10.6","ND","ND","ND");
INSERT INTO step1 VALUES("Vincent","331","F","1943","2013-04-02","","M","","0","Normal","ND","0","0001-01-01","2020-11-06","2775","","2019-06-04","65","","0.89","6.23","8.33","","14","-1.58","0.67","0.66");
INSERT INTO step1 VALUES("Florence","342","M","1978","2016-06-24","","UM","VH1-69","100","","","0","2022-01-01","2020-12-22","1642","","2019-03-26","34","","3.28","11.1","17.6","","2.96","51.69","0.63","0.96");
INSERT INTO step1 VALUES("Florence","358","M","1956","2010-01-01","","UM","","0","Del13, der20, t(2;20)","BIRC3","1","2019-11-26","2019-11-26","3616","","2019-04-16","148","","1.46","0.87","92.09999999999999","","9.67","18.15","0.62","0.74");
INSERT INTO step1 VALUES("Florence","369","F","1956","2014-10-14","","M","VH4-34","97.40000000000001","","","0","0001-01-01","2020-12-22","2261","","2019-04-16","41","","1.08","0.5600000000000001","3.54","","6.13","14.31","0.57","0.65");
INSERT INTO step1 VALUES("Florence","412","M","1944","2011-03-31","","M","VH3-7","93.59999999999999","Del2","SF3B1","0","0001-01-01","2020-12-22","3554","","2019-06-04","30","","1.09","13.6","15.4","","8.98","-10.28","0.77","0.69");
INSERT INTO step1 VALUES("Vincent","421","M","1938","2013-01-25","5","M","VH4-34","91.7","Del13","","0","0001-01-01","2020-10-20","2825","","2018-05-29","33","","2.49","0.65","22.4","","7.3","21.03","0.77","0.94");
INSERT INTO step1 VALUES("Florence","400","M","1961","2006-06-01","","M","VH3-33","93.8","","","0","0001-01-01","2020-12-22","5318","","2019-04-16","17","","","25.8","4.89","","3.34","-1.15","0.84","0.83");
INSERT INTO step1 VALUES("","21","","","","","","","","","","","","","","","","","","","","","","","","","");



DROP TABLE step2;

CREATE TABLE `step2` (
  `cliniciens` enum('Vincent','Florence','') DEFAULT NULL,
  `upn` int(11) DEFAULT NULL,
  `sexe` enum('F','M') DEFAULT NULL,
  `annee_de_naissance` int(11) DEFAULT NULL,
  `date_de_diagnostic` date DEFAULT NULL,
  `score_de_matutes` enum('4 ou 5','5') DEFAULT NULL,
  `statut_ighv` enum('M','UM') DEFAULT NULL,
  `vh` varchar(8) DEFAULT NULL,
  `homologie___germline` varchar(17) DEFAULT NULL,
  `aberrations_chromosomiques` varchar(21) DEFAULT NULL,
  `mutations_geniques` enum('ND','NOTCH1, POT1','Normal','BIRC3','SF3B1') DEFAULT NULL,
  `traitement__oui_1_vs_non_0` enum('0','1') DEFAULT NULL,
  `date_traitement` date DEFAULT NULL,
  `date_point_pour_l_etude__si_traitement_ecrire_date_du_traitement` date DEFAULT NULL,
  `calcul_du_delai__date_de_point__ou_traitement_moins_date_de_diag` int(11) DEFAULT NULL,
  `colonne15` varchar(0) DEFAULT NULL,
  `date_de_l_echantillon` date DEFAULT NULL,
  `lymphocytose__g_l` varchar(17) DEFAULT NULL,
  `colonne18` varchar(0) DEFAULT NULL,
  `foxp3_protplus__pourcent` varchar(16) DEFAULT NULL,
  `il10_protplus__pourcent` varchar(18) DEFAULT NULL,
  `tgfb1_protplus__pourcent` varchar(17) DEFAULT NULL,
  `colonne22` varchar(0) DEFAULT NULL,
  `pourcent_treg__vs_cd4plus` varchar(17) DEFAULT NULL,
  `mts__pourcent` varchar(32) DEFAULT NULL,
  `od_basal` varchar(4) DEFAULT NULL,
  `od_stimulee` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO step2 VALUES("Vincent","137","F","1952","2018-06-19","","M","VH3-23","97","","","","","2020-10-27","861","","2019-01-15","9.699999999999999","","5.7","1.56","29","","4.77","14.81","0.69","0.79");
INSERT INTO step2 VALUES("Florence","168","F","1963","2003-06-01","","M","VH3-33","96","ND","ND","","","2020-12-22","6414","","2019-06-04","57","","ND","ND","ND","","ND","1.52","0.53","0.53");
INSERT INTO step2 VALUES("Florence","172","M","1953","2018-09-12","","UM","VH1-69","100","Tri12","NOTCH1, POT1","1","2019-03-19","2019-03-19","188","","2019-02-26","106","","2.34","12","93.59999999999999","","9.279999999999999","15.86","0.42","0.49");
INSERT INTO step2 VALUES("Florence","196","M","1933","2008-06-01","","UM","VH3-21","98","","","1","2019-02-12","2019-02-12","3908","","2019-01-15","77","","3.29","49.9","31","","7.53","30.66","0.89","1.17");
INSERT INTO step2 VALUES("Florence","199","M","1971","2019-02-01","","UM","VH4-38-2","100","","","1","2019-10-30","2019-10-30","271","","2019-06-04","33","","1.08","0.46","91.59999999999999","","12","8.130000000000001","1.07","1.16");
INSERT INTO step2 VALUES("Vincent","239","M","1943","2003-06-01","4 ou 5","M","VH3-7","92.3","Del13, ","ND","","","2020-11-17","6379","","2019-01-15","32.5","","0.79","7.51","37.9","","6.63","11.92","0.69","0.77");
INSERT INTO step2 VALUES("Vincent","265","M","1966","2018-01-09","5","M","","","Del13, ","ND","","","2020-11-17","1043","","2019-04-16","15","","1.32","5.33","64.59999999999999","","12.1","78.18000000000001","0.50","0.89");
INSERT INTO step2 VALUES("Vincent","293","M","1954","2010-01-01","","M","VH3-23","89","","","","","2020-07-07","3840","","2019-06-04","14","","0.55","5.37","29.2","","2.78","-6.29","0.68","0.64");
INSERT INTO step2 VALUES("Florence","297","F","1950","2015-02-10","","M","VH4-39","92.59999999999999","Del13, ","ND","","","2020-12-22","2142","","2019-01-15","21.7","","3.19","4.65","14","","3.37","7.22","0.68","0.73");
INSERT INTO step2 VALUES("Florence","310","F","1951","2015-06-01","","UM","VH1-2","100","Normal","Normal","1","2019-11-30","2019-11-30","1643","","2018-05-14","178","","","4.1","10.3","","10.6","ND","ND","ND");
INSERT INTO step2 VALUES("Vincent","331","F","1943","2013-04-02","","M","","","Normal","ND","","","2020-11-06","2775","","2019-06-04","65","","0.89","6.23","8.33","","14","-1.58","0.67","0.66");
INSERT INTO step2 VALUES("Florence","342","M","1978","2016-06-24","","UM","VH1-69","100","","","","2022-01-01","2020-12-22","1642","","2019-03-26","34","","3.28","11.1","17.6","","2.96","51.69","0.63","0.96");
INSERT INTO step2 VALUES("Florence","358","M","1956","2010-01-01","","UM","","","Del13, der20, t(2;20)","BIRC3","1","2019-11-26","2019-11-26","3616","","2019-04-16","148","","1.46","0.87","92.09999999999999","","9.67","18.15","0.62","0.74");
INSERT INTO step2 VALUES("Florence","369","F","1956","2014-10-14","","M","VH4-34","97.40000000000001","","","","","2020-12-22","2261","","2019-04-16","41","","1.08","0.5600000000000001","3.54","","6.13","14.31","0.57","0.65");
INSERT INTO step2 VALUES("Florence","412","M","1944","2011-03-31","","M","VH3-7","93.59999999999999","Del2","SF3B1","","","2020-12-22","3554","","2019-06-04","30","","1.09","13.6","15.4","","8.98","-10.28","0.77","0.69");
INSERT INTO step2 VALUES("Vincent","421","M","1938","2013-01-25","5","M","VH4-34","91.7","Del13","","","","2020-10-20","2825","","2018-05-29","33","","2.49","0.65","22.4","","7.3","21.03","0.77","0.94");
INSERT INTO step2 VALUES("Florence","422","M","1961","2006-06-01","","M","VH3-33","93.8","","","","","2020-12-22","5318","","2019-04-16","17","","","25.8","4.89","","3.34","-1.15","0.84","0.83");
INSERT INTO step2 VALUES("","","","","","","","","","","","","","","","","","","","","","","","","","","");



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



