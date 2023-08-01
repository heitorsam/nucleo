<script>

/////////////////
//ALTERAR VALOR//
/////////////////

  //GLOBAIS
  var global_coluna_alterada = '';
  var global_update_inicial = '';
  var global_update_final = '';
  var global_coluna_edicao = '';
  var global_vl_antigo = '';

 //Passar a tabela, coluna que vai editar, o valor da coluna, a coluna com a pk, o valor da pk, a consulta do banco se for combo box, regra pra campo com virgula
  function fnc_editar_campo(var_owner_tabela, var_coluna_edicao, var_valor_coluna, var_coluna_pk, var_valor_pk, var_select, var_regra){

    var texto_update_inicial = "UPDATE " + var_owner_tabela + " SET " + var_coluna_edicao + " = '";
  
    var text_update_final = "' WHERE " + var_coluna_pk + " = '" + var_valor_pk + "'";
    var var_valor_edicao = '';

    //VAR_REGRA REGRAS:  1- VALOR COM VIRGULA // 2- COMBO VAZIA
    
    if(var_select == ''){
      
      if(var_regra == 1){
        document.getElementById(var_coluna_edicao + var_valor_pk).innerHTML = '<input type="text" id="input_editar" class="form-control"  minlength="1" onblur="alterar_valor(1, 12)">'; 
        $('#input_editar').focus(); 
      }else{
        document.getElementById(var_coluna_edicao + var_valor_pk).innerHTML = '<input type="text" id="input_editar" class="form-control"  minlength="1" onblur="alterar_valor(1, 0)">'; 
        $('#input_editar').focus(); 
      }

    }else{
      
      global_vl_antigo = document.getElementById(var_coluna_edicao + var_valor_pk).textContent;

      var link_ajax = "funcoes/ajax_combo_editar_campos.php?vl_select='" + var_select + "'";

      link_ajax = link_ajax.replace(/ /gi ,"%20");

      $(document.getElementById(var_coluna_edicao + var_valor_pk)).load(link_ajax);

      $(document.getElementById(var_coluna_edicao + var_valor_pk)).focus(); 
    }
    global_coluna_alterada = var_coluna_edicao + var_valor_pk; 
    global_update_inicial = texto_update_inicial;  
    global_update_final = text_update_final; 
    global_coluna_edicao = var_valor_coluna;

  }

  function alterar_valor(var_tipo_campo, var_regra_vl){
    // 1 = input // 0 = combobox //
    if(var_tipo_campo == 1){

      //SE FOR INPUT
      if(document.getElementById("input_editar").value != '' && document.getElementById("input_editar").value.indexOf("@santacasasjc.com.br") != -1){
        
        
        var vl_campo = document.getElementById("input_editar").value;

        var update_final = global_update_inicial +
                          vl_campo + 
                          global_update_final;
        

        $.ajax({
            url: "funcoes/ajax_editar_campos.php",
            type: "POST",
            data: {
                    update_final:update_final		
                },
            cache: false,
            success: function(dataResult){ 
              console.log(dataResult)
                var var_texto_final = document.getElementById("input_editar").value; 

                document.getElementById(global_coluna_alterada).innerHTML = var_texto_final;
                global_coluna_edicao = var_texto_final;            

            }   
        });

      }else{
        document.getElementById(global_coluna_alterada).innerHTML = global_coluna_edicao;
      }

    }else{
      //SE FOR COMBOBOX
      if(document.getElementById("editar_combo").value != ''){

        var update_final = global_update_inicial +
                            document.getElementById("editar_combo").value + 
                            global_update_final;
          
        $.ajax({
            url: "funcoes/ajax_editar_campos.php",
            type: "POST",
            data: {
                    update_final:update_final		
                },
            cache: false,
            success: function(dataResult){                    
            
                var select = document.getElementById('editar_combo');
                var var_texto_final = select.options[select.selectedIndex].text;

                var var_coluna_alterada = global_coluna_alterada;

                alert('Editado com sucesso!')

                $('#div_lista').load('funcoes/solicitacao/ajax_lista_solicitacao.php')
                
                document.getElementById(var_coluna_alterada).innerHTML = var_texto_final;
                global_coluna_edicao = var_texto_final;            

            }
        });

      }else{

        document.getElementById(global_coluna_alterada).innerHTML = global_vl_antigo;
        
      }

    }
  }
  </script>
    