<!DOCTYPE html>
<!--
    @author Lorena Capó
    @version 1
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Algoritmos de búsqueda y ordenación</title>
        <style>
            input#busquedaBinaria:not(:checked) ~ #busqueda{
                display: none;
            }
            input#radioAleatorio:checked ~ #cadena{
                display: none;
            }
            input#radioAleatorio:not(:checked) ~ #aleatorio{
                display: none;
            }
            p{
                max-height: 400px;
                white-space: nowrap;
                overflow: auto;
            }
        </style>
    </head>
        
    <body>
        <?php
        error_reporting(0);

        //FUNCIONES
        // Función para imprimir con estilo.
        function prePrint ( $impArray ) {
            echo "<pre>";
            print_r ( $impArray );
            echo "</pre>";
        }

        
        function printArray( $cadena ) {
            foreach($cadena as $key => $valor){
                echo " <span> <b>".$key."</b>: ".$valor." |</span> ";
            }
        }

        // Generador de arrays aleatorios.
        function randomArrays ( $longitud ) {
            $numerosDesordenados = array ();  // Array vacio
            for ( $i = 0; $i <= $longitud; $i ++ ) {
                $numerosDesordenados[] = rand ( 0, 200 );  // Generar un número Random entre 0 y 200.
            }
            return $numerosDesordenados;
        }

        // Búsqueda Binaria.
        function busquedaBinaria ( $cadena, $busqueda ) {
            $max = count ( $cadena ) - 1; 
            $central =  (int) ($max / 2);  // Número central del array
            while ( $central <= $max ) {
                if ( $busqueda > $cadena[ $central ] ) {
                    $central ++;
                } elseif ( $busqueda < $cadena[ $central ] ) {
                    $central --;
                } elseif ( $busqueda == $cadena[ $central ] ) {
                    break;
                }
            }
            return $central;
        }
        
        // Inserción Directa.
        function insercionDirecta($cadena) {
            // Este for recorre el array hacia adelante
            for ($contSum = 1; $contSum < count ($cadena); $contSum++) {
                // Este for recorre el array hacia atras
                for ($contRest = $contSum - 1; $contRest >= 0; $contRest--) {
                    // Si el numero de la posición anterior es mayor que el de la posición actual se intercambian el sitio
                    if ($cadena[$contRest] > $cadena[$contRest+1]) {
                        $auxiliar = $cadena[$contRest];
                        $cadena[$contRest] = $cadena[$contRest+1];
                        $cadena[$contRest+1] = $auxiliar;
                    } else {
                        break;
                    }
                }
            }
            return $cadena;
        }
        
        // Selección directa
        function seleccionDirecta($cadena) {
            // for recorre array
            for ($i=0; $i<count($cadena); $i++) {
                //la $i indica la posicion del numero actual
                $posNumMenor=$i;
                for($j=$i+1; $j<count($cadena); $j++){
                    if($cadena[$posNumMenor] > $cadena[$j]){
                        // Este for busca en el resto del array un numero menor al actual, 
                        // si el if se cumple el numero menor se asigna a la variable $posNumMenor
                        $posNumMenor=$j;
                    }
                }
                // Se crea una variable auxiliar que se utiliza para intercambiar los valores de posición
                $auxiliar=$cadena[$posNumMenor];
                $cadena[$posNumMenor]=$cadena[$i];
                $cadena[$i]=$auxiliar ;
            }
            return $cadena;
        }
        
        // Intercambio 
        function intercambio($cadena){
            for($i = 0; $i < count($cadena); $i++){
                for($j = $i + 1; $j < count($cadena); $j++){
                    if($cadena[$i] > $cadena[$j]){
                        $aux = $cadena[$i]; // Guardar el valor en una variable auxiliar para no perderla
                        $cadena[$i] = $cadena[$j];
                        $cadena[$j] = $aux;
                    }
                }
            }
            return $cadena;
        }

        // Algoritmo Burbuja.
        function burbuja ( $cadena ) {  // $cadena -- al array desordenado.
            for ( $claveValor = 1; $claveValor < ( count ( $cadena ) ); $claveValor ++ ) {   //claveValor -- el index(posición).
                for ( $i = 0; $i < ( count ( $cadena ) - $claveValor ); $i ++ ) {
                    if ( $cadena[ $i ] > $cadena[ $i + 1 ] ) {
                        $auxiliar = $cadena[ $i ];
                        $cadena[ $i ] = $cadena[ $i + 1 ];
                        $cadena[ $i + 1 ] = $auxiliar;
                    }
                }
            }
            return $cadena;
        }

        // Quicksort
        function quickSort($cadena)
        {
            if(count($cadena) <= 1){
                return $cadena;
            }
            else{
                $numeroCentral = $cadena[0];
                $CadenaIzquierda = $cadenaDerecha = array();
                for($i = 1; $i < count($cadena); $i++){
                    if($cadena[$i] < $numeroCentral){
                        $CadenaIzquierda[] = $cadena[$i];
                    }
                    else{
                        $cadenaDerecha[] = $cadena[$i];
                    }
                }
                return array_merge(quickSort($CadenaIzquierda), array($numeroCentral), quickSort($cadenaDerecha));
            }
        }

        // Este array contiene los algoritmos de ordenación, pero no el de búsqueda.
        $algoritmosOrdenacion = array("insercionDirecta", "seleccionDirecta", "intercambio", "burbuja", "quickSort");

        /*tipoInfo, determina si la información que se pasa por parámetro es una cadena de string,
         * es decir la cadena de números que se pasa a través del input al escoger la opción "Por teclado"
         * si lo es le realizaraa un explode() que separaá el string por comas y creará un array.
         * Y comprueba si la información que se pasa está vacia (!empty($info)) 
        */ 
        function tipoInfo ($tipo, $info) {
            if(!empty($info) && $tipo == 'cadena'){
                return explode(',', $info);
            } elseif(!empty($info)){
                return $info;
            } else{
                return 0;
            }
        }

        /*inputInfo, determina el input de la información, la opción seleccionada a través del rediobutton.
        Si la opicón es teclado llamará a tipoInf para que devuelva la cadena que el usuario ha escrito
         * convertida en un array.
         * Si la opción es aleatorio, llamará a tipoInfo para comprobar que el input no está vacio y entonces llamará a randomArrays,
         * que creará un array con la longitud indicada en el input numAleatorios.
        */
        function inputInfo ($input){
            if($input == 'teclado'){
                $tipoInfo = tipoInfo('cadena', $_POST['cadena']);
            }else{
                $tipoInfo = randomArrays(tipoInfo('numAleatorios', $_POST['numAleatorios']));
            }
            return $tipoInfo;
        }

        if(in_array($_POST["algoritmo"], $algoritmosOrdenacion)){  
                $arrayDesordenado = inputInfo($_POST['opcion']);
                $inicioTiempo = microtime(true);
                $arrayOrdenado = $_POST['algoritmo']($arrayDesordenado);
                $finalTiempo = microtime(true);
                $tiempo = number_format($finalTiempo - $inicioTiempo, 10);
        }else{
                $numBuscado = $_POST['busqueda'];
                $arrayDesordenado = inputInfo($_POST['opcion']);
                $arrayDesordenado[] = (int)$numBuscado;
                $arrayOrdenado = quickSort($arrayDesordenado);
                $posicionNum = busquedaBinaria($arrayOrdenado, $numBuscado);
        }
        ?>

        <h1>Algoritmos</h1>

        <form action="" method="post">
            <label for="algoritmo">Selecciona un algoritmo:</label><br>
            <input type="radio" id="busquedaBinaria" name="algoritmo" value="busquedaBinaria" />Búsqueda binaria <br>
            <input type="radio" name="algoritmo" value="insercionDirecta" checked />Inserción directa <br>
            <input type="radio" name="algoritmo" value="seleccionDirecta" />Selección directa <br>
            <input type="radio" name="algoritmo" value="intercambio" />Intercambio <br>
            <input type="radio" name="algoritmo" value="burbuja" />Burbuja <br>
            <input type="radio" name="algoritmo" value="quickSort" />Quicksort <br>

            <br>
            
            <label for="opcion">Selecciona input de información:</label> <br>
            <input type="radio" id="radioAleatorio" name="opcion" value="aleatorio" checked>Aleatorio <br>
            <input type="radio" name="opcion" value="teclado">Por teclado <br>

            <br>
            
            <div id="aleatorio">
                <label for="numAleatorios">Introduce cantidad de números para crear un array aleatorio: </label>
                <input type="number" id="numAleatorios" name="numAleatorios"/>
            </div>

            <div id="cadena">
                <label for="cadena">Introduce números separados por comas:</label>
                <input type="text" id="cadena" name="cadena"/>
            </div>

            <div id="busqueda">
                <label for="busqueda">Introduce el numero que se tiene que buscar:</label>
                <input type="number" id="busqueda" name="busqueda"/>
            </div>

            <input type="submit" value="Enviar">
        </form>

        <?php if($_POST){ ?>
        <p>
            Algoritmo seleccionado:
        </p>
        
        <p><?=$_POST['algoritmo']?></p>
        
        <?php if(in_array($_POST['algoritmo'], $algoritmosOrdenacion)){ ?>
            <div id="ordenamiento">
                <p>
                    Cadena desordenada:
                </p>
                
                <p> <?=printArray($arrayDesordenado)?> </p> <!--Imprime por pantalla el array desordenado-->
                
                <p>
                    Cadena ordenada:
                </p>
                
                <p><?=printArray($arrayOrdenado)?></p> <!--Imprime por pantallla el array ordenado-->
                
                <p>
                Duración del proceso: <?=$tiempo?> seg.
                </p>
            </div>
        <?php } else { ?>
            <div id="busqueda">
                <p>
                    Cadena proporcionada:
                </p>
                
                <p><?=printArray($arrayOrdenado)?></p> <!--Imprime por pantalla el array ordenado-->
                
                <p>
                    Numero buscado:
                </p>
                
                <p><?=$_POST['busqueda']?></p>
                
                <p>
                    Posición del numero buscado:
                </p>
                
                <p><?=$posicionNum?></p>
            </div>
        <?php }
        } ?>
    </body>
</html>

