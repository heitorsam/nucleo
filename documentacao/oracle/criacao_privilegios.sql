CREATE USER nucleoinfo IDENTIFIED BY f_b_grande_demais_2023;

GRANT CREATE SESSION TO nucleoinfo;
GRANT CREATE PROCEDURE TO nucleoinfo;
GRANT CREATE TABLE TO nucleoinfo;
GRANT CREATE VIEW TO nucleoinfo;
GRANT UNLIMITED TABLESPACE TO nucleoinfo;
GRANT CREATE SEQUENCE TO nucleoinfo;

GRANT EXECUTE ON dbasgu.FNC_MV2000_HMVPEP TO nucleoinfo;
GRANT SELECT ON dbasgu.USUARIOS TO nucleoinfo;
GRANT SELECT ON dbasgu.PAPEL TO nucleoinfo;
GRANT SELECT ON dbasgu.PAPEL_USUARIOS TO nucleoinfo;

GRANT INSERT, UPDATE, SELECT ON dbamv.SOLICITACAO_OS TO nucleoinfo;
GRANT INSERT, UPDATE, SELECT ON dbamv.ITSOLICITACAO_OS TO nucleoinfo;
GRANT SELECT ON dbamv.FUNCIONARIO TO nucleoinfo;
