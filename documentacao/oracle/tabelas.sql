--EXCLUIR VINCULOS FKs
--ALTER TABLE portal_cadastro.REGRA DROP CONSTRAINT fk_cd_tipo_regra;

--REGRAS
--CONSTRAINT pk_cd_setor PRIMARY KEY (CD_SETOR),
--CONSTRAINT check_tp_setor CHECK (TP_SETOR IN ('D', 'P', 'F'))
--COMMENT ON COLUMN escala_medica.SETOR.CD_SETOR IS 'SEQ_CD_SETOR';
--COMMENT ON COLUMN escala_medica.SETOR.TP_SETOR IS 'D - Distancia | P - Presencial | F - Fixa';

----------------
--RECON_FACIAL--
----------------

DROP TABLE portal_projetos.RESPONSAVEIS;
CREATE TABLE portal_projetos.RESPONSAVEIS
(
  CD_USUARIO           VARCHAR2(20) NOT NULL,
  CD_RESPONSAVEL       INT NOT NULL,  
  EMAIL                VARCHAR2(100) NOT NULL,
  FUNCAO               VARCHAR2(10) NOT NULL,
  
  --PRIMARY KEY
  CONSTRAINT PK_USUARIO PRIMARY KEY (CD_USUARIO)

);

DROP TABLE portal_projetos.FUNCOES;
CREATE TABLE portal_projetos.FUNCOES
(
  FUNCAO           VARCHAR2(20)

);

INSERT INTO portal_projetos.funcoes(FUNCAO) VALUES('ANALISTA');
INSERT INTO portal_projetos.funcoes(FUNCAO) VALUES('AUXILIAR');