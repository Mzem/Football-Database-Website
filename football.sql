--
-- Création de la base :
--
CREATE DATABASE football CHARACTER SET 'utf8';
SHOW WARNINGS;
USE football;



--
-- Table pays
--
CREATE TABLE pays 
(
	id varchar(15) NOT NULL PRIMARY KEY,
	nom varchar(15) NOT NULL
)
ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO pays (nom,id) VALUES
('Argentine','ARG'),
('Bresil','BRE'),
('Italie','ITA'),
('France','FRA'),
('Espagne','ESP'),
('Pays-Bas','PB'),
('Allemagne','ALL'),
('Republique Tchèque','CZ'),
('Cote d''Ivoire','CDV'),
('Cameroon','CAM'),
('Ukraine','UKR'),
('Portugal','POR'),
('Angleterre','ANG'),
('Suède','SUE');



--
-- Table Trophés
--
CREATE TABLE trophes 
(
	id varchar(10) NOT NULL PRIMARY KEY,
	nom varchar(20) NOT NULL,
	type varchar(15) NOT NULL
)
ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO trophes (id, nom, type) VALUES
('LIGA','La Liga','club'),
('SA','Serie A','club'),
('L1','Ligue 1','club'),
('PL','Premier League','club'),
('BL','Bundesliga','club'),
('CDM','Coupe Du Monde','pays'),
('CL','Champions'' League','club'),
('EURO','Euro','pays'),
('BDO','Ballon d''Or','individuel');



--
-- Table joueurs
--
CREATE TABLE joueurs 
(
	id varchar(15) NOT NULL PRIMARY KEY,
	prenom varchar(15) NOT NULL,
	nom varchar(15) NOT NULL,
	annee int(10) NOT NULL,
	poste varchar(10) NOT NULL,
	note int(5) NOT NULL,
	pays varchar(15) NOT NULL,
	FOREIGN KEY (pays) REFERENCES pays(id)
) 
ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO joueurs (id, prenom, nom, annee, poste, note, pays) VALUES
('C.RONALDO', 'Cristiano', 'Ronaldo', 1985, 'A', 94, 'POR'),
('MESSI', 'Lionel', 'Messi', 1987, 'A', 94, 'ARG'),
('ADRIANO', 'Adriano', 'Riberio', 1982, 'A', 87, 'BRE'),
('BECKHAM', 'David', 'Beckham', 1975, 'M', 88, 'ANG'),
('BUFFON', 'Gianluigi', 'Buffon', 1978, 'G', 91, 'ITA'),
('CAFU', 'Marcos', 'Cafu', 1970, 'D', 89, 'BRE'),
('CANNAVARO', 'Fabio', 'Cannavaro', 1973, 'D', 89, 'ITA'),
('CASILLAS', 'Iker', 'Casillas', 1981, 'G', 91, 'ESP'),
('CRESPO', 'Hernan', 'Crespo', 1975, 'A', 87, 'ARG'),
('DECO', 'Anderson', 'Deco', 1977, 'M', 87, 'POR'),
('DELPIERRO', 'Alessandro', 'Del Pierro', 1974, 'A', 88, 'ITA'),
('DIDA', 'Nelson', 'Dida', 1973, 'G', 89, 'BRE'),
('DROGBA', 'Didier', 'Drogba', 1978, 'A', 90, 'CDV'),
('ETO''O', 'Samuel', 'Eto''o', 1981, 'A', 88, 'CAM'),
('FIGO', 'Luis', 'Figo', 1972, 'A', 90, 'POR'),
('GATTUSO', 'Gennaro', 'Gattuso', 1978, 'M', 87, 'ITA'),
('GERRARD', 'Steven', 'Gerrard', 1980, 'M', 88, 'ANG'),
('HENRY', 'Thierry', 'Henry', 1977, 'A', 90, 'FRA'),
('IBRAHIMOVIC', 'Zlatan', 'Ibrahimovic', 1981, 'A', 90, 'SUE'),
('INIESTA', 'Andres', 'Iniesta', 1984, 'M', 90, 'ESP'),
('JUNINHO', 'Juninho', 'Pernambucano', 1975, 'M', 87, 'BRE'),
('KAKA', 'Ricardo', 'Kaka', 1982, 'M', 92, 'BRE'),
('KLOSE', 'Miroslav', 'Klose', 1978, 'A', 88, 'ALL'),
('LAHM', 'Philip', 'Lahm', 1983, 'D', 88, 'ALL'),
('LAMPARD', 'Frank', 'Lampard', 1978, 'M', 88, 'ANG'),
('MALDINI', 'Paolo', 'Maldini', 1968, 'D', 91, 'ITA'),
('NEDVED', 'Pavel', 'Nedved', 1972, 'M', 89, 'CZ'),
('NESTA', 'Alessandro', 'Nesta', 1976, 'D', 87, 'ITA'),
('NEUER', 'Manuel', 'Neuer', 1986, 'G', 91, 'ALL'),
('PIRLO', 'Andrea', 'Pirlo', 1979, 'M', 88, 'ITA'),
('PUYOL', 'Carles', 'Puyol', 1978, 'D', 90, 'ESP'),
('R.CARLOS', 'Roberto', 'Carlos', 1973, 'd', 89, 'BRE'),
('RAUL', 'Raul', 'Gonzalez', 1977, 'A', 89, 'ESP'),
('RONALDINHO', 'Ronaldinho', 'Gaucho', 1980, 'A', 93, 'BRE'),
('RONALDO', 'Ronaldo', 'Nazario', 1976, 'A', 92, 'BRE'),
('SEEDORF', 'Clarence', 'Seedorf', 1976, 'M', 88, 'PB'),
('SHEVCHENKO', 'Andiry', 'Shevchenko', 1976, 'A', 89, 'UKR'),
('SNEIJDER', 'Wesley', 'Sneijder', 1984, 'M', 88, 'PB'),
('TERRY', 'John', 'Terry', 1980, 'D', 88, 'ANG'),
('TOTTI', 'Francesco', 'Totti', 1976, 'A', 88, 'ITA'),
('VANDERSAR', 'Edwin', 'Van Der Sar', 1970, 'G', 89, 'PB'),
('VIEIRA', 'Patrick', 'Vieira', 1976, 'M', 88, 'FRA'),
('XAVI', 'Xavi', 'Hernandez', 1980, 'M', 91, 'ESP'),
('ZAMBROTTA', 'Gianluca', 'Zambrotta', 1977, 'D', 87, 'ITA'),
('ZANETTI', 'Javier', 'Zanetti', 1973, 'D', 88, 'ARG'),
('ZIDANE', 'Zinedine', 'Zidane', 1972, 'M', 93, 'FRA');



--
-- Table clubs
--
CREATE TABLE clubs 
(
	id varchar(10) NOT NULL PRIMARY KEY,
	nom varchar(20) NOT NULL,
	pays varchar(15) NOT NULL,
	FOREIGN KEY (pays) REFERENCES pays(id)
) 
ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO clubs (id, nom, pays) VALUES
('ACMILAN', 'AC Milan', 'ITA'),
('AJAX', 'AJAX Amsterdam', 'PB'),
('ARSENAL', 'Arsenal', 'ANG'),
('ATM', 'Atletico Madrid', 'ESP'),
('BAR', 'Barcelona', 'ESP'),
('BAYERN', 'Bayern Munich', 'ALL'),
('BENFICA', 'Benfica Lisbona', 'POR'),
('BVB', 'Borussia Dortmund', 'ALL'),
('CHELSEA', 'Chelsea', 'ANG'),
('FIORENTINA', 'Fiorentina', 'ITA'),
('INTER', 'Inter Milano', 'ITA'),
('JUVE', 'Juventus', 'ITA'),
('LAZIO', 'Lazio', 'ITA'),
('LIVERPOOL', 'Liverpool', 'ANG'),
('MC', 'Manchester City', 'ANG'),
('MONACO', 'AS Monaco', 'FRA'),
('MU', 'Manchester United', 'ANG'),
('NAPOLI', 'Napoli', 'ITA'),
('OL', 'Olympique Lyonnais', 'FRA'),
('OM', 'Olympique Marseille', 'FRA'),
('PARMA', 'Parma FC', 'ITA'),
('PORTO', 'FC Porto', 'POR'),
('PSG', 'Paris Saint-Germain', 'FRA'),
('PSV', 'PSV Eindhoven', 'PB'),
('RM', 'Real Madrid', 'ESP'),
('ROMA', 'AS Roma', 'ITA'),
('SCHALKE', 'Schalke 04', 'ALL'),
('SCP', 'Sporting Portugal', 'POR'),
('SEVILLA', 'FC Sevilla', 'ESP'),
('VALENCIA', 'Valencia CF', 'ESP');

  

--
-- Table joue
--
CREATE TABLE joue
(
	joueur varchar(15) NOT NULL,
	club varchar(10) NOT NULL,
	anneeDebut INT(10) NOT NULL,
	anneeFin INT(10) NOT NULL DEFAULT 0,
	PRIMARY KEY(joueur, club, anneeDebut),
	FOREIGN KEY (joueur) REFERENCES joueurs(id),
	FOREIGN KEY (club) REFERENCES clubs(id)
) 
ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO joue (joueur, club, anneeDebut, anneeFin) VALUES
('MESSI', 'BAR', 2004, 3000),
('C.RONALDO', 'SCP', 2002, 2003),
('C.RONALDO', 'MU', 2003, 2009),
('C.RONALDO', 'RM', 2009, 3000),
('ADRIANO', 'INTER', 2001, 2009),
('ADRIANO', 'ROMA', 2010, 2011),
('BECKHAM', 'MU', 1992, 2003),
('BECKHAM', 'RM', 2003, 2007),
('BECKHAM', 'ACMILAN', 2009, 2010),
('BECKHAM', 'PSG', 2013, 2013),
('BUFFON', 'PARMA', 1995, 2001),
('BUFFON', 'JUVE', 2001, 3000),
('CAFU', 'ROMA', 1997, 2003),
('CAFU', 'ACMILAN', 2003, 2008),
('CANNAVARO', 'NAPOLI', 1992, 1995),
('CANNAVARO', 'PARMA', 1995, 2002),
('CANNAVARO', 'INTER', 2002, 2004),
('CANNAVARO', 'JUVE', 2004, 2006),
('CANNAVARO', 'RM', 2006, 2009),
('CANNAVARO', 'JUVE', 2009, 2010),
('CASILLAS', 'RM', 1999, 2015),
('CASILLAS', 'PORTO', 2015, 3000),
('CRESPO', 'PARMA', 1996, 2000),
('CRESPO', 'LAZIO', 2000, 2002),
('CRESPO', 'INTER', 2002, 2003),
('CRESPO', 'CHELSEA', 2003, 2006),
('CRESPO', 'INTER', 2006, 2009),
('DECO', 'PORTO', 1999, 2004),
('DECO', 'BAR', 2004, 2008),
('DECO', 'CHELSEA', 2008, 2010),
('DELPIERRO', 'JUVE', 1993, 2012),
('DIDA', 'ACMILAN', 2000, 2010),
('DROGBA', 'OM', 2003, 2004),
('DROGBA', 'CHELSEA', 2004, 2012),
('ETO''O', 'BAR', 2004, 2009),
('ETO''O', 'INTER', 2009, 2011),
('FIGO', 'SCP', 1990, 1995),
('FIGO', 'BAR', 1995, 2000),
('FIGO', 'RM', 2000, 2005),
('FIGO', 'INTER', 2005, 2009),
('GATTUSO', 'ACMILAN', 1999, 2012),
('GERRARD', 'LIVERPOOL', 1998, 2015),
('HENRY', 'MONACO', 1994, 1999),
('HENRY', 'JUVE', 1999, 1999),
('HENRY', 'ARSENAL', 1999, 2007),
('HENRY', 'BAR', 2007, 2010),
('IBRAHIMOVIC', 'AJAX', 2001, 2004),
('IBRAHIMOVIC', 'JUVE', 2004, 2006),
('IBRAHIMOVIC', 'INTER', 2006, 2009),
('IBRAHIMOVIC', 'BAR', 2009, 2010),
('IBRAHIMOVIC', 'ACMILAN', 2010, 2012),
('IBRAHIMOVIC', 'PSG', 2012, 2016),
('IBRAHIMOVIC', 'MU', 2016, 3000),
('INIESTA', 'BAR', 2002, 3000),
('JUNINHO', 'OL', 2001, 2009),
('KAKA', 'ACMILAN', 2003, 2009),
('KAKA', 'RM', 2009, 2013),
('KAKA', 'ACMILAN', 2013, 2014),
('KLOSE', 'BAYERN', 2007, 2011),
('KLOSE', 'LAZIO', 2011, 2016),
('LAHM', 'BAYERN', 2002, 3000),
('LAMPARD', 'CHELSEA', 2001, 2014),
('MALDINI', 'ACMILAN', 1985, 2009),
('NEDVED', 'LAZIO', 1996, 2001),
('NEDVED', 'JUVE', 2001, 2009),
('NESTA', 'LAZIO', 1993, 2002),
('NESTA', 'ACMILAN', 2002, 2012),
('NEUER', 'SCHALKE', 2006, 2011),
('NEUER', 'BAYERN', 2011, 3000),
('PIRLO', 'INTER', 1998, 2001),
('PIRLO', 'ACMILAN', 2001, 2011),
('PIRLO', 'JUVE', 2011, 2015),
('PUYOL', 'BAR', 1999, 2014),
('R.CARLOS', 'INTER', 1995, 1996),
('R.CARLOS', 'RM', 1996, 2007),
('RAUL', 'RM', 1994, 2010),
('RAUL', 'SCHALKE', 2010, 2012),
('RONALDINHO', 'PSG', 2001, 2003),
('RONALDINHO', 'BAR', 2003, 2008),
('RONALDINHO', 'ACMILAN', 2008, 2011),
('RONALDO', 'PSV', 1994, 1996),
('RONALDO', 'BAR', 1996, 1997),
('RONALDO', 'INTER', 1997, 2002),
('RONALDO', 'RM', 2002, 2007),
('RONALDO', 'ACMILAN', 2007, 2008),
('SEEDORF', 'AJAX', 1992, 1996),
('SEEDORF', 'RM', 1996, 1999),
('SEEDORF', 'INTER', 1999, 2002),
('SEEDORF', 'ACMILAN', 2002, 2012),
('SHEVCHENKO', 'ACMILAN', 1996, 2006),
('SHEVCHENKO', 'CHELSEA', 2006, 2009),
('SNEIJDER', 'AJAX', 2002, 2007),
('SNEIJDER', 'RM', 2007, 2009),
('SNEIJDER', 'INTER', 2009, 2012),
('TERRY', 'CHELSEA', 1998, 3000),
('TOTTI', 'ROMA', 1993, 3000),
('VANDERSAR', 'AJAX', 1990, 1999),
('VANDERSAR', 'JUVE', 1999, 2001),
('VANDERSAR', 'MU', 2005, 2011),
('VIEIRA', 'ACMILAN', 1995, 1996),
('VIEIRA', 'ARSENAL', 1996, 2005),
('VIEIRA', 'JUVE', 2005, 2006),
('VIEIRA', 'INTER', 2006, 2010),
('XAVI', 'BAR', 1998, 2015),
('ZAMBROTTA', 'JUVE', 1999, 2006),
('ZAMBROTTA', 'BAR', 2006, 2008),
('ZAMBROTTA', 'ACMILAN', 2008, 2012),
('ZANETTI', 'INTER', 1995, 2014),
('ZIDANE', 'JUVE', 1996, 2001),
('ZIDANE', 'RM', 2001, 2006);



--
-- Table remporte
--
CREATE TABLE remporte
(
	joueur varchar(15) NOT NULL,
	trophe varchar(10) NOT NULL,
	annee INT(10) NOT NULL,
	PRIMARY KEY(joueur, trophe, annee),
	FOREIGN KEY (joueur) REFERENCES joueurs(id),
	FOREIGN KEY (trophe) REFERENCES trophes(id)
) 
ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO remporte (joueur, trophe, annee) VALUES
('MESSI', 'BDO', 2015),
('MESSI', 'BDO', 2012),
('MESSI', 'BDO', 2011),
('MESSI', 'BDO', 2010),
('MESSI', 'BDO', 2009),
('MESSI', 'LIGA', 2005),
('MESSI', 'LIGA', 2006),
('MESSI', 'LIGA', 2009),
('MESSI', 'LIGA', 2010),
('MESSI', 'LIGA', 2011),
('MESSI', 'LIGA', 2013),
('MESSI', 'LIGA', 2015),
('MESSI', 'LIGA', 2016),
('MESSI', 'CL', 2006),
('MESSI', 'CL', 2009),
('MESSI', 'CL', 2011),
('MESSI', 'CL', 2015),
('C.RONALDO', 'BDO', 2014),
('C.RONALDO', 'BDO', 2013),
('C.RONALDO', 'BDO', 2008),
('C.RONALDO', 'PL', 2007),
('C.RONALDO', 'PL', 2008),
('C.RONALDO', 'PL', 2009),
('C.RONALDO', 'LIGA', 2012),
('C.RONALDO', 'CL', 2008),
('C.RONALDO', 'CL', 2014),
('C.RONALDO', 'CL', 2016),
('C.RONALDO', 'EURO', 2016),
('ADRIANO', 'SA', 2006),
('ADRIANO', 'SA', 2007),
('ADRIANO', 'SA', 2008),
('ADRIANO', 'SA', 2009),
('BECKHAM', 'PL', 1996),
('BECKHAM', 'PL', 1997),
('BECKHAM', 'PL', 1999),
('BECKHAM', 'PL', 2000),
('BECKHAM', 'PL', 2001),
('BECKHAM', 'PL', 2003),
('BECKHAM', 'LIGA', 2007),
('BECKHAM', 'L1', 2013),
('BUFFON', 'CDM', 2006),
('BUFFON', 'SA', 2002),
('BUFFON', 'SA', 2003),
('BUFFON', 'SA', 2012),
('BUFFON', 'SA', 2013),
('BUFFON', 'SA', 2014),
('BUFFON', 'SA', 2015),
('BUFFON', 'SA', 2016),
('CAFU', 'CDM', 1994),
('CAFU', 'CDM', 2002),
('CAFU', 'SA', 2001),
('CAFU', 'SA', 2004),
('CAFU', 'CL', 2007),
('CANNAVARO', 'CDM', 2006),
('CANNAVARO', 'BDO', 2006),
('CANNAVARO', 'LIGA', 2007),
('CANNAVARO', 'LIGA', 2008),
('CASILLAS', 'LIGA', 2001),
('CASILLAS', 'LIGA', 2003),
('CASILLAS', 'LIGA', 2007),
('CASILLAS', 'LIGA', 2008),
('CASILLAS', 'LIGA', 2012),
('CASILLAS', 'CL', 2000),
('CASILLAS', 'CL', 2002),
('CASILLAS', 'CL', 2014),
('CASILLAS', 'EURO', 2008),
('CASILLAS', 'EURO', 2012),
('CASILLAS', 'CDM', 2010),
('CRESPO', 'PL', 2006),
('DECO', 'CL', 2004),
('DECO', 'CL', 2006),
('DECO', 'LIGA', 2005),
('DECO', 'LIGA', 2006),
('DECO', 'PL', 2010),
('DELPIERRO', 'SA', 1995),
('DELPIERRO', 'SA', 1997),
('DELPIERRO', 'SA', 1998),
('DELPIERRO', 'SA', 2002),
('DELPIERRO', 'SA', 2003),
('DELPIERRO', 'SA', 2012),
('DELPIERRO', 'CL', 1996),
('DELPIERRO', 'CDM', 2006),
('DIDA', 'CL', 2003),
('DIDA', 'CL', 2007),
('DIDA', 'SA', 2004),
('DIDA', 'CDM', 2002),
('DROGBA', 'PL', 2005),
('DROGBA', 'PL', 2006),
('DROGBA', 'PL', 2010),
('DROGBA', 'PL', 2015),
('DROGBA', 'CL', 2012),
('ETO''O', 'CL', 2006),
('ETO''O', 'CL', 2009),
('ETO''O', 'LIGA', 2005),
('ETO''O', 'LIGA', 2006),
('ETO''O', 'LIGA', 2009),
('ETO''O', 'SA', 2010),
('ETO''O', 'CL', 2010),
('FIGO', 'BDO', 2000),
('FIGO', 'LIGA', 1998),
('FIGO', 'LIGA', 1999),
('FIGO', 'LIGA', 2001),
('FIGO', 'LIGA', 2003),
('FIGO', 'CL', 2002),
('FIGO', 'SA', 2006),
('FIGO', 'SA', 2007),
('FIGO', 'SA', 2008),
('FIGO', 'SA', 2009),
('GATTUSO', 'CL', 2003),
('GATTUSO', 'CL', 2007),
('GATTUSO', 'SA', 2004),
('GATTUSO', 'SA', 2011),
('GATTUSO', 'CDM', 2006),
('GERRARD', 'CL', 2005),
('HENRY', 'CDM', 1998),
('HENRY', 'EURO', 2000),
('HENRY', 'L1', 1997),
('HENRY', 'PL', 2002),
('HENRY', 'PL', 2003),
('HENRY', 'LIGA', 2009),
('HENRY', 'LIGA', 2010),
('HENRY', 'CL', 2009),
('IBRAHIMOVIC', 'SA', 2007),
('IBRAHIMOVIC', 'SA', 2008),
('IBRAHIMOVIC', 'SA', 2009),
('IBRAHIMOVIC', 'SA', 2011),
('IBRAHIMOVIC', 'LIGA', 2010),
('IBRAHIMOVIC', 'L1', 2013),
('IBRAHIMOVIC', 'L1', 2014),
('IBRAHIMOVIC', 'L1', 2015),
('IBRAHIMOVIC', 'L1', 2016),
('INIESTA', 'CDM', 2010),
('INIESTA', 'EURO', 2008),
('INIESTA', 'EURO', 2012),
('INIESTA', 'LIGA', 2005),
('INIESTA', 'LIGA', 2006),
('INIESTA', 'LIGA', 2009),
('INIESTA', 'LIGA', 2010),
('INIESTA', 'LIGA', 2011),
('INIESTA', 'LIGA', 2013),
('INIESTA', 'LIGA', 2015),
('INIESTA', 'LIGA', 2016),
('INIESTA', 'CL', 2006),
('INIESTA', 'CL', 2009),
('INIESTA', 'CL', 2011),
('INIESTA', 'CL', 2015),
('JUNINHO', 'L1', 2002),
('JUNINHO', 'L1', 2003),
('JUNINHO', 'L1', 2004),
('JUNINHO', 'L1', 2005),
('JUNINHO', 'L1', 2006),
('JUNINHO', 'L1', 2007),
('JUNINHO', 'L1', 2008),
('KAKA', 'CL', 2007),
('KAKA', 'SA', 2004),
('KAKA', 'LIGA', 2012),
('KAKA', 'BDO', 2007),
('KAKA', 'CDM', 2002),
('KLOSE', 'BL', 2008),
('KLOSE', 'BL', 2010),
('KLOSE', 'CDM', 2014),
('LAHM', 'CDM', 2014),
('LAHM', 'BL', 2006),
('LAHM', 'BL', 2008),
('LAHM', 'BL', 2010),
('LAHM', 'BL', 2013),
('LAHM', 'BL', 2014),
('LAHM', 'BL', 2015),
('LAHM', 'BL', 2016),
('LAHM', 'CL', 2013),
('LAMPARD', 'PL', 2005),
('LAMPARD', 'PL', 2006),
('LAMPARD', 'PL', 2010),
('LAMPARD', 'CL', 2012),
('MALDINI', 'CL', 1989),
('MALDINI', 'CL', 1990),
('MALDINI', 'CL', 1994),
('MALDINI', 'CL', 2003),
('MALDINI', 'CL', 2007),
('MALDINI', 'SA', 1988),
('MALDINI', 'SA', 1992),
('MALDINI', 'SA', 1993),
('MALDINI', 'SA', 1994),
('MALDINI', 'SA', 1996),
('MALDINI', 'SA', 1999),
('MALDINI', 'SA', 2004),
('NEDVED', 'BDO', 2003),
('NEDVED', 'SA', 2000),
('NEDVED', 'SA', 2002),
('NEDVED', 'SA', 2003),
('NESTA', 'CDM', 2006),
('NESTA', 'SA', 2000),
('NESTA', 'SA', 2004),
('NESTA', 'SA', 2011),
('NESTA', 'CL', 2003),
('NESTA', 'CL', 2007),
('NEUER', 'CDM', 2014),
('NEUER', 'BL', 2013),
('NEUER', 'CL', 2013),
('NEUER', 'BL', 2014),
('NEUER', 'BL', 2015),
('NEUER', 'BL', 2016),
('PIRLO', 'CDM', 2006),
('PIRLO', 'CL', 2003),
('PIRLO', 'CL', 2007),
('PIRLO', 'SA', 2004),
('PIRLO', 'SA', 2011),
('PIRLO', 'SA', 2012),
('PIRLO', 'SA', 2013),
('PIRLO', 'SA', 2014),
('PIRLO', 'SA', 2015),
('PUYOL', 'CDM', 2010),
('PUYOL', 'EURO', 2008),
('PUYOL', 'LIGA', 2005),
('PUYOL', 'LIGA', 2006),
('PUYOL', 'LIGA', 2009),
('PUYOL', 'LIGA', 2010),
('PUYOL', 'LIGA', 2011),
('PUYOL', 'LIGA', 2013),
('PUYOL', 'CL', 2006),
('PUYOL', 'CL', 2009),
('PUYOL', 'CL', 2011),
('R.CARLOS', 'CDM', 2002),
('R.CARLOS', 'CL', 1998),
('R.CARLOS', 'CL', 2000),
('R.CARLOS', 'CL', 2002),
('R.CARLOS', 'LIGA', 1997),
('R.CARLOS', 'LIGA', 2001),
('R.CARLOS', 'LIGA', 2003),
('R.CARLOS', 'LIGA', 2007),
('RAUL', 'LIGA', 1995),
('RAUL', 'LIGA', 1997),
('RAUL', 'LIGA', 2001),
('RAUL', 'LIGA', 2003),
('RAUL', 'LIGA', 2007),
('RAUL', 'LIGA', 2008),
('RAUL', 'CL', 1998),
('RAUL', 'CL', 2000),
('RAUL', 'CL', 2002),
('RONALDINHO', 'BDO', 2005),
('RONALDINHO', 'CDM', 2002),
('RONALDINHO', 'CL', 2006),
('RONALDINHO', 'LIGA', 2005),
('RONALDINHO', 'LIGA', 2006),
('RONALDINHO', 'SA', 2011),
('RONALDO', 'BDO', 2002),
('RONALDO', 'BDO', 1997),
('RONALDO', 'CDM', 2002),
('RONALDO', 'CDM', 1994),
('RONALDO', 'LIGA', 2003),
('SEEDORF', 'CL', 1995),
('SEEDORF', 'CL', 1998),
('SEEDORF', 'LIGA', 1997),
('SEEDORF', 'CL', 2003),
('SEEDORF', 'CL', 2007),
('SEEDORF', 'SA', 2004),
('SEEDORF', 'SA', 2011),
('SHEVCHENKO', 'BDO', 2004),
('SHEVCHENKO', 'CL', 2003),
('SHEVCHENKO', 'SA', 2004),
('SNEIJDER', 'LIGA', 2008),
('SNEIJDER', 'SA', 2010),
('SNEIJDER', 'CL', 2010),
('TERRY', 'PL', 2005),
('TERRY', 'PL', 2006),
('TERRY', 'PL', 2010),
('TERRY', 'PL', 2015),
('TERRY', 'CL', 2012),
('TOTTI', 'CDM', 2006),
('TOTTI', 'SA', 2001),
('VANDERSAR', 'CL', 1995),
('VANDERSAR', 'CL', 2008),
('VANDERSAR', 'PL', 2007),
('VANDERSAR', 'PL', 2008),
('VANDERSAR', 'PL', 2009),
('VANDERSAR', 'PL', 2011),
('VIEIRA', 'CDM', 1998),
('VIEIRA', 'SA', 1996),
('VIEIRA', 'SA', 2007),
('VIEIRA', 'SA', 2008),
('VIEIRA', 'SA', 2009),
('VIEIRA', 'SA', 2010),
('VIEIRA', 'PL', 1998),
('VIEIRA', 'PL', 2002),
('VIEIRA', 'PL', 2004),
('VIEIRA', 'EURO', 2000),
('XAVI', 'CDM', 2010),
('XAVI', 'EURO', 2008),
('XAVI', 'EURO', 2012),
('XAVI', 'LIGA', 1999),
('XAVI', 'LIGA', 2005),
('XAVI', 'LIGA', 2006),
('XAVI', 'LIGA', 2009),
('XAVI', 'LIGA', 2010),
('XAVI', 'LIGA', 2011),
('XAVI', 'LIGA', 2013),
('XAVI', 'LIGA', 2015),
('XAVI', 'CL', 2006),
('XAVI', 'CL', 2009),
('XAVI', 'CL', 2011),
('XAVI', 'CL', 2015),
('ZAMBROTTA', 'CDM', 2006),
('ZAMBROTTA', 'SA', 2002),
('ZAMBROTTA', 'SA', 2003),
('ZAMBROTTA', 'SA', 2011),
('ZANETTI', 'CL', 2010),
('ZANETTI', 'SA', 2006),
('ZANETTI', 'SA', 2007),
('ZANETTI', 'SA', 2008),
('ZANETTI', 'SA', 2009),
('ZANETTI', 'SA', 2010),
('ZIDANE', 'EURO', 2000),
('ZIDANE', 'BDO', 1998),
('ZIDANE', 'SA', 1997),
('ZIDANE', 'SA', 1998),
('ZIDANE', 'LIGA', 2003),
('ZIDANE', 'CL', 2002),
('ZIDANE', 'CDM', 1998);



--
-- Table utilisateurs
--
CREATE TABLE utilisateurs 
(
	email varchar(30) NOT NULL PRIMARY KEY,
	pass varchar(10) NOT NULL,
	type varchar(10) NOT NULL DEFAULT 'normal',
	pays varchar(15),
	club varchar(10),
	joueur varchar(15),
	FOREIGN KEY (pays) REFERENCES pays(id),
	FOREIGN KEY (club) REFERENCES clubs(id),
	FOREIGN KEY (joueur) REFERENCES joueurs(id)
) 
ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO utilisateurs (email, pass, type) VALUES
('admin@admin', 'admin', 'admin'),
('user@user', 'user', 'normal');



--
-- Vue, aident à connaitre les trophés des nations et des clubs et déterminer leur nombre
--
DROP TABLE IF EXISTS palmares;

CREATE VIEW palmares  
AS  SELECT DISTINCT R.trophe AS trophe, R.annee AS annee, R.joueur AS joueur, T.type AS type, J.club AS club, Jr.pays AS pays 
	FROM remporte R join trophes T join joueurs Jr join joue J 
	WHERE R.trophe = T.id AND Jr.id = J.joueur AND R.joueur = Jr.id AND ( (R.annee BETWEEN (J.anneeDebut + 1) AND J.anneeFin) OR (R.annee = J.anneeFin) ) 
	ORDER BY r.joueur, r.annee;

DROP TABLE IF EXISTS palmaresClub;

CREATE VIEW palmaresClub
AS SELECT P.club, P.trophe, P.annee FROM palmares P WHERE P.type = "club" GROUP BY P.club, P.trophe, P.annee ORDER BY P.club, P.trophe, P.annee;

DROP TABLE IF EXISTS palmaresPays;

CREATE VIEW palmaresPays
AS	SELECT DISTINCT R.trophe AS trophe, R.annee AS annee, Jr.pays AS pays 
	FROM remporte R, trophes T, joueurs Jr
	WHERE R.trophe = T.id
	AND R.joueur = Jr.id 
	AND T.type = "pays" 
	ORDER BY Jr.pays, R.trophe, R.annee;
	

--
-- Utilisateurs des bases de données
--
CREATE USER IF NOT EXISTS 'Invite'@'localhost' IDENTIFIED BY 'invite';

GRANT SELECT ON football.* TO 'Invite'@'localhost';
GRANT INSERT ON football.utilisateurs TO 'Invite'@'localhost';

CREATE USER IF NOT EXISTS 'Normal'@'localhost' IDENTIFIED BY 'normal';

GRANT SELECT ON football.* TO 'Normal'@'localhost';
GRANT UPDATE, INSERT ON football.utilisateurs TO 'Normal'@'localhost';

CREATE USER IF NOT EXISTS 'Admin'@'localhost' IDENTIFIED BY 'admin';

GRANT SELECT, UPDATE, INSERT ON football.* TO 'Admin'@'localhost';
	