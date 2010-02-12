CREATE TABLE tesi_file 
    ( 
     ID_file INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     nome varchar(50) , 
     path varchar(255) , 
     tag varchar(255) , 
     tipo varchar(50) , 
     dimensione varchar(50) , 
     ID_user int  NOT NULL 
    )   ENGINE = MYISAM
;





CREATE TABLE tesi_config 
    ( 
     ID_config INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     variabile varchar(50) NOT NULL, 
     valore varchar(255) NOT NULL,
     ID_directory int  , 
     ID_page int 
    )   ENGINE = MYISAM
;



CREATE TABLE tesi_user_pref 
    ( 
     ID_pref INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     variabile varchar(50) , 
     valore varchar(255) , 
     ID_user int  NOT NULL 
    )   ENGINE = MYISAM
;



CREATE TABLE tesi_user 
    ( 
     ID_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     login varchar(50) , 
     password varchar(32) , 
     nome varchar(50) , 
	 profilo enum('sysadmin', 'admin', 'user') , 
     data_accesso date , 
     data date , 
     ID_group int  NOT NULL 
    )   ENGINE = MYISAM
;




CREATE TABLE tesi_group 
    ( 
     ID_group INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     nome varchar(50) , 
     data date 
    )   ENGINE = MYISAM
;




CREATE TABLE tesi_menu 
    ( 
     ID_menu INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     nome varchar(50) , 
     descrizione varchar(255) 
    )   ENGINE = MYISAM
;




CREATE TABLE tesi_allegati 
    ( 
     ID_allegati INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     ID_file int  NOT NULL , 
     ID_directory int  NOT NULL , 
     ID_page int  NOT NULL 
    )   ENGINE = MYISAM
;




CREATE TABLE tesi_directory 
    ( 
     ID_directory INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     nome varchar(50)  NOT NULL , 
	 stato enum('bozza', 'pubblica') , 
     pubblica_da date , 
     pubblica_a date , 
     ID_dir_parent int , 
     ID_user int  NOT NULL , 
     ID_template int  NOT NULL 
    )   ENGINE = MYISAM
;




CREATE TABLE tesi_plugin 
    ( 
     ID_plugin INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     nome varchar(50) , 
     voce_menu varchar(50) , 
     versione varchar(50) , 
     descrizione varchar(255) , 
     path varchar(255) , 
     autore varchar(50) , 
    
--  attivo, non attivo
	 stato tinyint(1) 
    )  ENGINE = MYISAM
;




CREATE TABLE tesi_dettaglio_permessi 
    ( 
     ID_dettaglio INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
    
--  r=read; w=write; x=not access
	 permesso enum('r', 'w', 'x') , 
     ID_directory int  NOT NULL , 
     ID_page int  NOT NULL , 
     ID_user int  NOT NULL , 
     ID_group int  NOT NULL 
    )   ENGINE = MYISAM
;



CREATE TABLE tesi_template 
    ( 
     ID_template INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     nome varchar(50) , 
     descrizione varchar(255) , 
     path varchar(255) , 
    
--  in uso, non in uso
 stato tinyint(1) , 
     data date , 
     ID_user int  NOT NULL 
    )   ENGINE = MYISAM
;





CREATE TABLE tesi_voci_menu 
    ( 
     ID_voce INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
     ordine int , 
     ID_menu int  NOT NULL , 
     ID_directory int  NOT NULL , 
     ID_page int  NOT NULL , 
     ID_file int  NOT NULL , 
     ID_plugin int  NOT NULL 
    )   ENGINE = MYISAM
;



CREATE TABLE tesi_page (
`ID_page` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`nome` VARCHAR( 50 ) NOT NULL ,
`titolo` VARCHAR( 255 ) NOT NULL ,
`testo` TEXT NOT NULL ,
`predefinito` TINYINT( 1 ) NOT NULL ,
`stato` TINYINT( 1 ) NOT NULL ,
`pubblica_da` DATE NOT NULL ,
`pubblica_a` DATE NOT NULL ,
`tag` VARCHAR( 255 ) NOT NULL ,
`data` DATE NOT NULL ,
`ID_directory` INT NOT NULL ,
`ID_user` INT NOT NULL ,
`ID_template` INT NOT NULL
) ENGINE = MYISAM ;


-- importazione dati
INSERT INTO `tesi_group` (`ID_group`, `nome`, `data`) VALUES(1, 'sysadmin', NOW());
INSERT INTO `tesi_user` (`ID_user`, `login`, `password`, `nome`, `profilo`, `data_accesso`, `data`, `ID_group`) VALUES(1, 'sysadmin', MD5('tesi'), NULL, NULL, NULL, NOW(), 1);
INSERT INTO `tesi_config` (`ID_config`, `variabile`, `valore`, `ID_directory`, `ID_page`) VALUES (NULL, 'style_gestione', '<link href="include/style.css" type="text/css" rel="stylesheet" />', '', '');
