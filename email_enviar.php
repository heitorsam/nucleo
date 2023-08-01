<?php
  $assunto = "Santa Casa de São José dos Campos - Solicitação";

  echo $msg = "
  
  <div class='' style='height: 250px;  
                      padding: 20px;   
                      background-color: #EDEDED; 
                      border: 1px solid #D4D4D4;
                      color: black; 
                      border-radius: 5px 5px 5px 5px;
                      box-shadow: 1px 1px 5px grey; 
                      margin-top: -5px; 
  '>

    <div style='font: 1.2em 'Fira Sans', sans-serif; color: #000;'>
      <b>Olá, $nome</b>
      <br><br>
    </div>

    $txt

    <div style='font-weight: bold; font-size: 13px;'>
      Atenciosamente,
      <br>
      Equipe de Projetos 
      <br>
      Santa Casa de São José dos Campos 
    </div>

  </div>

  <div class='' style='padding: 15px; text-align: center; color: #383838; font-size: 10px; margin-left: 50px; margin-right: 50px;'>
   Esse e-mail é enviado automaticamente e não recebe respostas. 
  <br>
   Qualquer duvida ligue no ramal 1806.</a></b>
  </div>
    ";

    
    //VERIFICANDO MENSAGEM:
    $msg;

    if (PATH_SEPARATOR ==":") { $quebra = "\r\n"; } 
    else { $quebra = "\n"; }	
    $headers = "MIME-Version: 1.1".$quebra;	
    $headers .= "Content-type: text/plain; charset=iso-8859-1".$quebra;	
    $headers .= "From: webmaster@santacasasjc.com.br".$quebra; 
    //E-mail do remetente	
    $headers .= "Return-Path: webmaster@santacasasjc.com.br".$quebra; 
              
    // Chame o arquivo com as Classes do PHPMailer
    require_once('phpmailer/class.phpmailer.php');
      
    // Instância a classe PHPMailer
    $mail = new PHPMailer();

    // Configuração dos dados do servidor e tipo de conexão (Estes dados você obtem com seu host)
    $mail->IsSMTP(); // Define que a mensagem será SMTP
    $mail->Host = "smtp.santacasasaudesjc.com.br"; // Endereço do servidor SMTP
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = true; // Autenticação (True: Se o email será autenticado | False: se o Email não será autenticado)
    $mail->Username = 'webmaster@santacasasjc.com.br'; // Usuário do servidor SMTP
    $mail->Password = '@Tecnologia#2018'; // A Senha do email indicado acima
    // Remetente (Identificação que será mostrada para quem receber o email)
    $mail->From = "webmaster@santacasasjc.com.br";
    $mail->FromName = "Santa Casa de São José dos Campos";
    echo $email;
    // Destinatário
    $mail->AddAddress($email, $nome);

    // Define tipo de Mensagem que vai ser enviado
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    //$mail->addStringAttachment(file_get_contents("https://kpi.santacasasjc.com.br/img/santa_casa_sjc.gif"), "filename");
    // Assunto e Mensagem do email
    $mail->Subject  = $assunto; // Assunto da mensagem
    $mail->Body = $msg;	
    $mail->AddAttachment($_SERVER['DOCUMENT_ROOT']. '/upload/123.pdf');
    // Envia a Mensagem
    $enviado = $mail->Send();

    // Verifica se o email foi enviado
    if($enviado)
    {
      echo "E-mail enviado com sucesso!";

    }
    else
    {
      echo "Houve um erro ao enviar o email! " .$mail->ErrorInfo;
    }


/*
  echo $msg = "Olá! $nome <br><br>
  $txt 
  <br><br>Etapa - ($etapa/4)

  <br><br>
  -------------------------------------------------------<br><br>
    E-mail enviado automaticamente através do servidor STA50.

  <br><br>

  Rua Dolzani Ricardo, 620 - Centro - São José dos Campos-SP - CEP 12210-110
  </br></br></br>
  Tel:(12)3876-1999 - Site: <a href = 'www.santacasasjc.com.br'>www.santacasasjc.com.br</a> - Email: scadministracao@santacasasjc.com.br
  <br><br>
  Atenciosamente, Santa Casa de São José dos Campos
  <br><br>
  ";
*/   
?>


