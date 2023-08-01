
<!-- Modal -->
<div class="modal fade" id="modal_chat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="border: none !important;">
    <div class="modal-content" style="border: none !important;">

    <!--<div class="fechar_modal_chat" onclick="fechar_modal()"><i class="fa-regular fa-circle-xmark"></i></div>-->

         <input type="text" id="vl_repetidor" hidden>
      
      <div class="modal-body" id="constroi_chat" style="border: none !important;">
        
      </div>
      
    </div>
  </div>
</div>

<script>

    var repetidor = '';

    function call_chat(os,tp){
      
        //alert(tp);
        $('#constroi_chat').load('funcoes/chat/ajax_atualiza_chat.php?cd_os='+os+'&tp='+tp);

        $('#modal_chat').modal('show');

        var repetidor = setInterval("att_chat_5s("+os+",'"+tp+"')", 5000);

        document.getElementById('vl_repetidor').value = repetidor;
     
    }

    function att_chat_5s(os,tp){

        console.log('ola');
        $('#constroi_chat').load('funcoes/chat/ajax_atualiza_chat.php?cd_os='+os+'&tp='+tp);

    }

    function fechar_modal(){

        repetidor_input = document.getElementById('vl_repetidor').value;

        clearInterval(repetidor_input);

        //alert(repetidor_input);

        $('#modal_chat').modal('hide');
    }

    function stop_interval(){

        var_stop = document.getElementById('vl_repetidor').value;
        clearInterval(var_stop);

        //alert('stop');

    }

    function cad_msg(os){

        var var_tp_msg = 'M';

        var var_msg = document.getElementById('input_msg').value;
        document.getElementById('input_msg').value = '';
        
        $.ajax({

            url: "funcoes/chat/ajax_cad_msg.php",
            type: "POST",
            data: {
            
                cd_os: os,
                msg: var_msg,
                tp_msg: var_tp_msg,

            },
            cache: false,
            success: function(dataResult){

                //console.log(dataResult);

                call_chat(os,'Recebido');

            }
        });

    }

</script>


<style>

    .btn_msg{

        width: 60%;
        border: solid 1px rgba(70,165,212,0.1);
        background-color: rgba(70,165,212,0.15);
        border-radius: 10px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .btn_msg:focus{

        outline: none !important;
        border: solid 1px rgba(70,165,212,0.3); 
        background-color: rgba(70,165,212,0.1);
        padding-left: 10px;
        padding-right: 10px;
        

    }

    .btn_msg_enviar{

        width: 24px;
        height: 24px;
        margin-bottom: 3px;
        
    }

    .btn_msg_enviar:hover{

        opacity: 60%;
        cursor: pointer;

    }

    .fechar_modal_chat{

        width: 100%; 
        height: 30px; 
        line-height: 30px; 
        text-align: center; 
        background-color: #3185c1; 
        color: white;
 
    }

    .fechar_modal_chat:hover{

        background-color: #31b2d0;
        cursor: pointer;

        
    }


</style>