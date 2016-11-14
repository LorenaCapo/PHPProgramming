<!DOCTYPE html>
<!--
    @author Lorena Capó <capolorena88@gmail.com>
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,400i,700,700i" rel="stylesheet">
        <style>
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                margin: 0; 
            }
            
            body { 
                font-family: 'Merriweather', serif;
                font-size: 16px;
            }
            
            fieldset#container { margin: 20px 0 0 30px;}
            fieldset {
                width: 300px;
                border-radius: 5px;
            }
            fieldset:nth-of-type(2) { margin-top: 20px; }
            
            legend { 
                font-style: italic;
                font-size: 18px;
                text-transform: uppercase;
            }
            
            label, input { margin-bottom: 15px;}
            input { margin-left: 20px;}
            input[type="submit"] { margin-left: 0; }
            p#info {
                color: red;
                font-size: 12px;
            }
            
            div#containerTwo {
                max-height: 280px;  
                overflow-y: scroll;
            }
            
            div { padding: 3px 0;}
            div:nth-child(odd) { background-color: #ededed;}
            div:nth-child(even) { background-color: #9bb1ff;}
            
            img { margin-right: 12px;}
            
        </style>
    </head>
    <body>
        <?php
        
        /** Declaración de variables a utilizar.*/
        $contacts = array();        
        $contactName;
        $contactPhone;
        $messageInfo = "";
        
        if(isset($_POST['postContacts'])){
            $postContacts = unserialize($_POST['postContacts']);
            
            if(!empty($postContacts)){
                $contacts = array_merge($contacts, $postContacts);
            }
        } 
        
        if (!empty($_POST['name'])) {
                $contactName = $_POST['name'];
                $contactPhone = $_POST['phone']; 
            
            /** Comprobamos que el array "contacts" no esté vacio y comprobamos que no la "key" no exsita*/
            if (!empty($contacts) && isset ($contacts[$contactName])){
                /** En el caso que no esté vacia y la "key" no exista entramos en el bucle */
                /** Si el valor que hay en la "key" que decimos (o sea el teléfono) es distinto al que introducimos y 
                la casilla de teléfono no está vacia --> modificamos el teléfono.  */
                if ($contacts[$contactName] != $contactPhone && !empty($contactPhone)) {
                    $contacts[$contactName] = $contactPhone;
                    $messageInfo = "El número de teléfono del contacto ha sido modificado."; 
                
                /** En el caso que la casilla del teléfono esté vacia, procedemos a eliminar dicho contacto que se haya
                introducido. */
                }elseif (empty ($contactPhone)) {
                    unset($contacts[$contactName]);
                    $messageInfo = "Contacto eliminado correctamente."; 
                }
            
            /** En el caso que la "key" (casilla del nombre) no esté vacia y no exista ya una igual, y el teléfono no esté vacio, 
            procedemos a añadir un contacto.*/
            } elseif (!empty ($contactPhone)) {
                $contacts[$contactName] = $contactPhone;
                $messageInfo = "Contacto añadido correctamente."; 
            } 
        } 
        ?>
        
        <fieldset id="container">
            <legend>Agenda Telefónica</legend>
            <fieldset>
                <legend>Datos de Contacto</legend>
                <form action="" method="POST">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" required />
                        <br />
                    <label for="phone">Teléfono:</label>
                    <input type="text" name="phone" id="phone" maxlength="9" />
                        <br />
                    <input type="hidden" name="postContacts" value='<?=serialize($contacts)?>'>
                    <input type="submit" name="Enviar" />
                </form>

                <p id="info"><?=$messageInfo?></p>
            </fieldset>

            <fieldset>
                <legend>Contactos</legend>
                <div id="containerTwo">
                    <?php 
                        if (!empty($contacts)){
                            foreach ($contacts as $name => $phone) {
                                ?>
                                    <div>
                                        <p><img src="user.png" alt="User Icon" >  <?=$name?> </p>
                                        <p><img src="phone.png" alt="User Icon" > <?=$phone?> </p>
                                    </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </fieldset>
        </fieldset>
    </body>
</html>
