<?php

if(count($_POST) >1){
    //comprobamos que sea una petición ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
    {
        //print_r($_FILES);
        //obtenemos el archivo a subir
        $file = $_FILES['imgn']['name'];
     
        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos
        if(!is_dir("../../includes/img/perfil/")) 
            mkdir("../../includes/img/perfil/", 0777);
         
        //comprobamos si el archivo ha subido
        if ($file && move_uploaded_file($_FILES['imgn']['tmp_name'],"../../includes/img/perfil/".$file))
        {
           sleep(3);//retrasamos la petición 3 segundos
           echo $file;//devolvemos el nombre del archivo para pintar la imagen
        }
    }else{
        throw new Exception("Error Processing Request", 1);   
    }
}else{
    echo "
    <!DOCTYPE html>
    <html>
    <head>
    		<script type='text/javascript' src='../../includes/js/jquery-1.11.1.min.js' ></script>
    </head>
    <body>
    <form id='agregar_arch' action='archivos.php' method='POST' enctype='multipart/form-data'>
        <label>Descripcion</label>
        <input type='text' name='des' id='des'/>
        <label>tipo</label>
        <input type='text' name='tipo' id='tipo'/>
        <input type='file' name='imgn' id='imgn' /></br><div class='messages'></div></br>
        <input type='button' id='enviar' name='enviar' value='Enviar' />
        <br/><div class='showImage'></div>
    </form>
    
    <script>
        var fileExtension = '';
        $('#enviar').on('click',function(){
            alert();
            var formData = new FormData($('#agregar_arch')[0]);
            
            $.ajax(
            {
                url:'archivos.php',
                type:'POST',
                data: formData,
                 //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    message = $('<span class=\"before\">Subiendo la imagen, por favor espere...</span>');
                    showMessage(message)        
                },
                //una vez finalizado correctamente
                success: function(data){
                        message = $(\"<span class='success'>La imagen ha subido correctamente.</span>\");
                        showMessage(message);
                        if(isImage(fileExtension))
                        {
                            $('.showImage').html('<img src=\"../../includes/img/perfil/'+data+'\" />');
                        }
                },
                    //si ha ocurrido un error
                error: function(){
                        message = $(\"<span class='error'>Ha ocurrido un error.</span>\");
                        showMessage(message);
                }
            }
            );
            
            
        });
        $('#imgn').on('change',function(){
            var imagen = $('#imgn')[0].files[0];
            var nombre = imagen.name;
            fileExtension = nombre.substring(nombre.lastIndexOf('.')+1);
            var fileSize = imagen.size;
            var fileType = imagen.type;
            showMessage('<span class=\'info\'>Archivo para subir: '+nombre+', peso total: '+fileSize+' bytes.</span>');
        });
        
        function showMessage(message){
            $('.messages').html('').show();
            $('.messages').html(message);
        }
        function isImage(extension)
        {
            switch(extension.toLowerCase()) 
            {
                case 'jpg': case 'gif': case 'png': case 'jpeg':
                    return true;
                break;
                default:
                    return false;
                break;
            }
        }
    </script>
    </body>
    </html>
    ";
    
}

?>

 