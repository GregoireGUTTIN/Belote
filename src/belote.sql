PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE `Equipe` (
	`ID`	INTEGER NOT NULL,
	`Nom_1`	TEXT NOT NULL,
	`Nom_2`	TEXT NOT NULL,
	`Match_1`	INTEGER DEFAULT '0',
	`Match_2`	INTEGER DEFAULT '0',
	`Match_3`	INTEGER DEFAULT '0',
	`Match_4`	INTEGER DEFAULT '0',
	`Vic_1`	INTEGER DEFAULT '0',
	`Vic_2`	INTEGER DEFAULT '0',
	`Vic_3`	INTEGER DEFAULT '0',
	`Vic_4`	INTEGER DEFAULT '0',
	`Nb_Victoire`	INTEGER DEFAULT '0',
	`Score`	INTEGER DEFAULT '0',
	PRIMARY KEY(ID)
);
INSERT INTO "Equipe" VALUES(1,'dddddddddd','ddddddddddd',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(2,'Grégoire','Grégoire',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(3,'aaaaaaaaaa','aaaaaaaaaa',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(4,'tdddddddddd','rdddddddddd',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(5,'ezf','fez',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(6,'fze','fzef',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(7,'ez','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(8,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(9,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(10,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(11,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(12,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(13,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(14,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(15,'fze','fze',0,0,0,0,0,0,0,0,0,0);
INSERT INTO "Equipe" VALUES(16,'fze','fz',0,0,0,0,0,0,0,0,0,0);
CREATE TABLE IF NOT EXISTS "Match" (
	`ID`	INTEGER NOT NULL,
	`ID_Equipe_1`	INTEGER,
	`ID_Equipe_2`	INTEGER,
	`ID_Match`	INTEGER,
	PRIMARY KEY(ID)
);
INSERT INTO "Match" VALUES(3,9,14,1);
INSERT INTO "Match" VALUES(11,1,3,2);
INSERT INTO "Match" VALUES(12,7,8,2);
INSERT INTO "Match" VALUES(13,9,11,3);
INSERT INTO "Match" VALUES(14,16,1,3);
INSERT INTO "Match" VALUES(15,6,3,3);
INSERT INTO "Match" VALUES(16,5,14,4);
INSERT INTO "Match" VALUES(17,1,11,4);
INSERT INTO "Match" VALUES(18,12,3,4);
INSERT INTO "Match" VALUES(19,16,13,4);
COMMIT;
