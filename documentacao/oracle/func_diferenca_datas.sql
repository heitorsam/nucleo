CREATE OR REPLACE Function pontualidade_medica.FNC_DIFERENCA_DATAS_EXTENSO(DT_INICIO IN DATE, DT_FIM IN DATE, TP_RETORNO IN VARCHAR2)
RETURN VARCHAR2 IS

   RESP_EXTENSAO VARCHAR2(255) ;

begin

   ---------------------------------------------
   --CODIGO DESENVOLVIDO POR HEITOR SCALABRINI
   ---------------------------------------------

   SELECT
   CASE
     WHEN TP_RETORNO = 'HM' THEN ROUND(TRUNC(24* MOD(DT_FIM  - DT_INICIO,1)),0) || 'h:'
                                 || ROUND((MOD(MOD(DT_FIM  - DT_INICIO,1)*24,1)*60),0) || 'm'
     ELSE NVL(ROUND(DT_FIM - DT_INICIO,0),0) || 'd:'
          || ROUND(TRUNC(24* MOD(DT_FIM  - DT_INICIO,1)),0) || 'h:'
          || ROUND((MOD(MOD(DT_FIM  - DT_INICIO,1)*24,1)*60),0) || 'm'
   END AS EXTENSAO

   INTO RESP_EXTENSAO
   FROM DUAL;

   RETURN RESP_EXTENSAO;

END;
