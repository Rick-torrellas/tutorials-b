<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Usar Promesas</h1>
    <nav>
        <div>
            <a href="#div-1">Garantías</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-2">Encadenamiento</a>
            <ul>
                <li><a href="">Encadenar después de una captura</a></li>
            </ul>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-3">Propagación de errores</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-4">Eventos de rechazo de Promesas</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-5">Crear una promesa alrededor de una vieja API de callbacks</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-6">Composición</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-7">Sincronización</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-8">Anidamiento</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-9">Errores comunes</a>
            <br>
            <code></code>
        </div>
        <div>
            <a href="#div-10">Referencia</a>
            <br>
            <code></code>
        </div>
    </nav>
    <section>
    <div>
        <p>Una Promise (promesa en castellano) es un objeto que representa la terminación o el fracaso eventual de una operación asíncrona. Dado que la mayoría de las personas consumen promises ya creadas, esta guía explicará primero cómo consumirlas, y luego  cómo crearlas.</p>
        <p>Esencialmente, una promesa es un objeto devuelto al cuál se adjuntan funciones callback, en lugar de pasar callbacks a una función.</p>
        <p>Considera la función crearArchivoAudioAsync(), el cuál genera de manera asíncrona un archivo de sonido de acuerdo a un archivo de configuración, y dos funciones callback, una que es llamada si el archivo de audio es creado satisfactoriamente, y la otra que es llamada si ocurre un error. El código podría verse de la siguiente forma:</p>
        <code>function exitoCallback(resultado) { <br>
  console.log("Archivo de audio disponible en la URL " + resultado); <br>
} <br>
 <br>
function falloCallback(error) { <br>
  console.log("Error generando archivo de audio " + error); <br>
} <br>
 <br>
crearArchivoAudioAsync(audioConfig, exitoCallback, falloCallback); <br></code>
        <p>las funciones modernas devuelven un objeto promise al que puedes adjuntar funciones de retorno (callbacks). Si crearArchivoAudioAsync fuera escrita de manera tal que devuelva un objeto promise, usarla sería tan simple como esto:</p>
        <code>
        crearArchivoAudioAsync(audioConfig).then(exitoCallback, falloCallback); <br>
        </code>
        <p>Lo cuál es la versión corta de:</p>
        <code>const promesa = crearArchivoAudioAsync(audioConfig);
promise.then(exitoCallback, falloCallback);</code>
        <p></p>
    </div>
    <article id="div-1">
        <h2>Garantías</h2>
        <p>A diferencia de las funciones callback pasadas al "viejo estilo", una promesa viene con algunas garantías:</p>
        <ul>
            <li>Las funciones callback nunca serán llamadas antes de la terminación de la ejecución actual del bucle de eventos de JavaScript.</li>
            <li>Las funciones callback añadidas con then()  incluso después del éxito o fracaso de la operación asíncrona serán llamadas como se mostró anteriormente.</li>
            <li>Múltiples funciones callback pueden ser añadidas llamando a then() varias veces. Cada una de ellas es ejecutada una seguida de la otra, en el orden en el que fueron insertadas.</li>
        </ul>
        <p>Una de las grandes ventajas de usar promises es el encadenamiento, explicado a continuación.</p>
    </article>
    <article id="div-2">
        <h2>Encadenamiento</h2>
        <p>Una necesidad común es el ejecutar dos o más operaciones asíncronas seguidas, donde cada operación posterior se inicia cuando la operación previa tiene éxito, con el resultado del paso previo. Logramos esto creando una cadena de objetos promises.</p>
        <p>Aquí está la magia: la función then() devuelve una promesa nueva, diferente de la original:</p>
        <code>const promesa = hazAlgo(); <br>
const promesa2 = promesa.then(exitoCallback, falloCallback); <br></code>
        <p>O</p>
        <code>
        let promesa2 = hazAlgo().then(exitoCallback, falloCallback); <br>
        </code>
        <p>Esta segunda promesa (promesa2) representa no sólo la terminación de hazAlgo(), sino también de exitoCallback o falloCallback que pasaste, las cuales pueden ser otras funciones asíncronas devolviendo una promesa. Cuando ese es el caso, cualquier función callback añadida a promesa2 se queda en cola detrás de la promesa devuelta por exitoCallback o falloCallback</p>
        <p>Básicamente, cada promesa representa la terminación de otro paso (asíncrono on no) en la cadena.</p>
        <p>En el pasado, hacer varias operaciones asíncronas en fila conduciría a la clásica pirámide de funciones callback:</p>
        <code>
        hazAlgo(function(resultado) { <br>
  hazAlgoMas(resultado, function(nuevoResultado) { <br>
    hazLaTerceraCosa(nuevoResultado, function(resultadoFinal) { <br>
      console.log('Obtenido el resultado final: ' + resultadoFinal <br>
    }, falloCallback); <br>
  }, falloCallback); <br>
}, falloCallback); <br>
        </code>
        <p>Con las funciones modernas, adjuntamos nuestras functiones callback a las promesas devueltas, formando una cadena de promesa:</p>
        <code>hazAlgo().then(function(resultado) { <br>
  return hazAlgoMas(resultado); <br>
}) <br>
.then(function(nuevoResultado) { <br>
  return hazLaTerceraCosa(nuevoResultado); <br>
}) <br>
.then(function(resultadoFinal) { <br>
  console.log('Obtenido el resultado final: ' + resultadoFinal); <br>
}) <br>
.catch(falloCallback); <br></code>
<p>Los argumentos a then son opcionales, y catch(falloCallBack) es un atajo para then(null, falloCallBack). Es posible que veas esto expresado con funciones de flecha :</p>
<code>
hazAlgo() <br>
.then(resultado => hazAlgoMas(resultado)) <br>
.then(nuevoResultado => hazLaTerceraCosa(nuevoResultado)) <br>
.then(resultadoFinal => { <br>
  console.log(`Obtenido el resultado final: ${resultadoFinal}`); <br>
}) <br>
.catch(falloCallback); <br>
</code>
<p><b>IMPORTANTE</b>Importante: Devuelve siempre resultados, de otra forma las funciones callback no se encadenarán, y los errores no serán capturados.</p>
<div id="div-2-1">
<h3>Encadenar después de una captura</h3>
    <p>Es posible encadenar después de un fallo - por ejemplo: un catch- lo que es útil para lograr nuevas acciones incluso después de una acción fallida en la cadena. Lea el siguiente ejemplo:</p>
    <code>
    new Promise((resolver, rechazar) => { <br>  
    console.log('Inicial'); <br>    
 <br>   
    resolver(); <br>    
}) <br> 
.then(() => { <br>  
    throw new Error('Algo falló'); <br> 
         <br>   
    console.log('Haz esto'); <br>   
}) <br> 
.catch(() => { <br> 
    console.log('Haz eso'); <br>    
}) <br> 
.then(() => { <br>  
    console.log('Haz esto sin que importe lo que sucedió antes'); <br>  
}); <br>    
    </code>
    <p>Esto devolverá el siguiente texto:</p>
    <code>Inicial <br>
Haz eso <br>
Haz esto sin que importe lo que sucedió antes <br></code>
<p>Note que el texto "Haz esto" no es escrito porque el error "Algo falló" causó un rechazo.</p>
<p>Osea que cuando se lanza un tohow new Error() se produce un quiebre en la ejecucion y salta directamente al catch.</p>
</div>
    </article>
    <article id="div-3">
        <h2>Propagación de errores</h2>
        <p>Tal vez recuerdes haber visto falloCallback tres veces en la pirámide en un ejemplo anterior, en comparación con sólo una vez al final de la cadena de promesas:</p>
        <code>hazAlgo() <br>
.then(resultado => hazAlgoMas(valor)) <br>
.then(nuevoResultado => hazLaTerceraCosa(nuevoResultado)) <br>
.then(resultadoFinal => console.log(`Obtenido el resultado final: ${resultadoFinal}`)) <br>
.catch(falloCallback); <br></code>
        <p>Básicamente, una cadena de promesas se detiene si hay una excepción, y recorre la cadena buscando manejadores de captura. Lo siguiente está mucho más adaptado a la forma de trabajo del código síncrono:</p>
        <code>
        try { <br>
  let resultado = syncHazAlgo(); <br>
  let nuevoResultado = syncHazAlgoMas(resultado); <br>
  let resultadoFinal = syncHazLaTerceraCosa(nuevoResultado); <br>
  console.log(`Obtenido el resultado final: ${resultadoFinal}`); <br>
} catch(error) { <br>
  falloCallback(error); <br>
}     <br>   
        </code>
        <p>
        Esta simetría con el código síncrono culmina con la mejora sintáctica async/await en ECMASCript 2017:       
        </p>
        <code>
        async function foo() { <br>
  try { <br>
    let resultado = await hazAlgo(); <br>
    let nuevoResultado = await hazAlgoMas(resultado); <br>
    let resultadoFinal = await hazLaTerceraCosa(nuevoResultado); <br>
    console.log(`Obtenido el resultado final: ${resultadoFinal}`); <br>
  } catch(error) { <br>
    falloCallback(error); <br>
  } <br>
} <br>
        </code>
        <p>Se construye sobre promesas, por ejemplo, hazAlgo() es la misma función que antes.</p>
        <p>Las promesas resuelven un fallo fundamental de la pirámide de funciones callback, capturando todos los errores, incluso excepciones lanzadas y errores de programación. Esto es esencial para la composición funcional de operaciones asíncronas.</p>
    </article>
    <article id="div-4">
        <h2>Eventos de rechazo de Promesas</h2>
        <p>Al momento que una promesa es rechazada, uno de dos eventos se envía al ámbito global (generalmente, éste es el window, o, si se utiliza en un trabajador web, es el  Worker u otra interfaz basada en un trabajador). Los dos eventos son:</p>
        <h3>rejectionhandled</h3>
        <p>Se envía cuando se rechaza una promesa, una vez que el rechazo ha sido manejado por la función reject del ejecutor.</p>
        <h3>unhandledrejection</h3>
        <p>Se envía cuando se rechaza una promesa pero no hay un controlador de rechazo disponible.</p>
        <p>En ambos casos, el evento (del tipo PromiseRejectionEvent) tiene como miembros una propiedad promise que indica que la promesa fue rechazada, y una propiedad reason que proporciona el motivo por el cuál se rechaza la promesa.</p>
        <p>Esto hace posible ofrecer el manejo de errores de promesas, y también ayuda a depurarlos. Estos controladores son globales, por lo tanto, todos los errores serán manejados por éstos independientemente de la fuente.</p>
        <p>Un caso de especial utilidad: al escribir código para Node.js, es común que los módulos que incluyas en tu proyecto no cuenten con un controlador de evento para promesas rechazadas. Estos se registran en la consola en tiempo de ejecución de Node. Puedes capturarlos para analizarlos y manejarlos en tu código - o solo evitar que abarroten tu salida - agregando un controlador para el evento unhandledrejection, como se muestra a continuación:</p>
        <code>
        window.addEventListener("unhandledrejection", event => { <br>
  /* Podrías comenzar agregando código para examinar  <br>
     la promesa específica analizando event.promise  <br>
     y la razón del rechazo, accediendo a event.reason */ <br>
 <br>
  event.preventDefault(); <br>
}, false); <br>
        </code>
        <p>Llamando al método preventDefault() del evento, le dices a Javascript en tiempo de ejecución que no realice su acción predeterminada cuando las promesas rechazadas no cuenten con manejadores. En el caso de Node, esa acción predeterminada usualmente registra el error en la consola.</p>
        <p>Idealmente, por supuesto, examinarías las promesas rechazadas para asegurarte que ninguna de ellas son errores de código reales antes de descartar esos eventos.</p>
    </article>
    <article id="div-5">
        <h2>Crear una promesa alrededor de una vieja API de callbacks</h2>
        <p>Una Promise puede ser creada desde cero usando su constructor. Esto debería ser sólo necesario para envolver viejas APIs.</p>
        <p>En un mundo ideal, todas las funciones asíncronas devolverían promesas. Desafortunadamente, algunas APIs aún esperan que se les pase callbacks con resultado fallido/exitoso a la forma antigua. El ejemplo más obvio es la función setTimeout():</p>
        <code>setTimeout(() => diAlgo("pasaron 10 segundos"), 10000);</code>
        <p>Combinar callbacks del viejo estilo con promesas es problemático. Si diAlgo falla o contiene un error de programación, nada lo captura. La función setTimeout es culpable de esto.</p>
        <p>Afortunadamente podemos envolverlas en una promesa. La mejor práctica es envolver las funciones problemáticas en el nivel más bajo posible, y después nunca llamarlas de nuevo  directamente:</p>
        <code>const espera = ms => new Promise(resuelve => setTimeout(resuelve, ms)); <br>
 <br>
wait(10000).then(() => diAlgo("10 segundos")).catch(falloCallback); <br></code>
<p>Básicamente, el constructor de la promesa toma una función ejecutora que nos permite resolver o rechazar manualmente una promesa. Dado que setTimeout no falla realmente, descartamos el rechazo en este caso.</p>
    </article>
    <article id="div-6">
        <h2>Composición</h2>
        <p>Promise.resolve() y Promise.reject() son atajos para crear manualmente una promesa resuelta o rechazada respectivamente. Esto puede ser útil a veces.</p>
        <p>Promise.all() son Promise.race() son dos herramientas de composición para ejecutar operaciones asíncronas en paralelo.</p>
        <p>Podemos comenzar operaciones en paralelo y esperar por la finalización de todas ellas de la siguiente manera:</p>
        <code>
        Promise.all([func1(), func2(), func3()]) <br>
.then(([resultado1, resultado2, resultado3]) => { /* usa resultado1, resultado2 y resultado3 */ }); <br>
        </code>
        <p>La composición secuencial es posible usando Javascript inteligente:</p>
        <code>
        [func1, func2, func3].reduce((p, f) => p.then(f), Promise.resolve()) <br>
.then(result3 => { /* use result3 */ }); <br>
        </code>
        <p>Básicamente, reducimos un conjunto de funciones asíncronas a una cadena de promesas equivalente a: Promise.resolve().then(func1).then(func2).then(func3);</p>
        <p>Esto se puede convertir en una función de composición reutilizable, que es común en la programación funcional:</p>
        <code>const aplicarAsync = (acc,val) => acc.then(val); <br>
const componerAsync = (...funcs) => x => funcs.reduce(aplicarAsync, Promise.resolve(x)); <br></code>
<p>La función componerAsync() aceptará cualquier número de funciones como argumentos, y devolverá una nueva función que acepta un valor inicial que es pasado a través del conducto de composición. Esto es beneficioso porque cualquiera o todas las funciones pueden ser o asíncronas o síncronas y se garantiza que serán ejecutadas en el orden correcto:</p>
<code>
const transformData = componerAsync(func1, asyncFunc1, asyncFunc2, func2); <br>
const resultado3 = transformData(data); <br>
</code>
<p>En ECMAScript 2017, la composición secuencial puede ser realizada usando simplemente async/await:</p>
<code>
let resultado; <br>
for (const f of [func1, func2, func3]) { <br>
  resultado = await f(resultado); <br>
}  <br>
</code>
    </article>
    <article id="div-7">
        <h2>Sincronización</h2>
        <p>Para evitar sorpresas, las funciones pasadas a then() nunca serán llamadas sincrónicamente, incluso con una promesa ya resuelta:</p>
        <code>
        Promise.resolve().then(() => console.log(2)); <br>
console.log(1); // 1, 2 <br>
        </code>
        <p>En lugar de ejecutarse inmediatamente, la función pasada es colocada en una cola de microtareas, lo que significa que se ejecuta más tarde cuando la cola es vaciada al final del actual ciclo de eventos de JavaScript:</p>
        <code>const espera = ms => new Promise(resuelve => setTimeout(resuelve, ms)); <br>
 <br>
espera().then(() => console.log(4)); <br>
Promise.resuelve().then(() => console.log(2)).then(() => console.log(3)); <br>
console.log(1); // 1, 2, 3, 4 <br></code>
    </article>
    <article id="div-8">
        <h2>Anidamiento</h2>
        <p>Las cadenas de promesas simples se mantienen planas sin anidar, ya que el anidamiento puede ser el resultado de una composición descuidada</p>
        <p>El anidamiento es una estructura de control para limitar el alcance de las sentencias catch. Específicamente, un catch anidado sólo captura fallos dentro de su contexto y por debajo, no captura errores que están más arriba en la cadena fuera del alcance del anidamiento. Cuando se usa correctamente, da mayor precisión en la recuperación de errores:</p>
        <code>
        hacerAlgoCritico() <br>
.then(resultado => hacerAlgoOpcional() <br>
  .then(resultadoOpcional => hacerAlgoSuper(resultadoOpcional)) <br>
  .catch(e => {})) // Ignorar si hacerAlgoOpcional falla. <br>
.then(() => masAsuntosCriticos()) <br>
.catch(e => console.log("Acción crítica fallida: " + e.message)); <br>
        </code>
        <p>Nota que aquí los pasos opcionales están anidados, por la precaria colocación de lo externo (y) alrededor de ellos.</p>
        <p>La declaración interna catch solo detecta errores de hacerAlgoOpcional() y hacerAlgoSuper(), después de lo cuál el código se reanuda con masAsuntosCriticos(). Es importante destacar que si hacerAlgoCritico() falla, el error es capturado únicamente por el catch final.</p>
    </article>
    <article id="div-9">
        <h2>Errores comunes</h2>
        <p>Aquí hay algunos errores comunes que deben tenerse en cuenta al componer cadenas de promesas. Varios de estos errores se manifiestan en el siguiente ejemplo:</p>
        <code>
        // ¡Mal ejemplo! <br>
hacerlAlgo().then(function(resultado) { <br>
  hacerOtraCosa(resultado) // Olvida devolver una promesa desde el interior de la cadena + anidamiento innecesario <br>
  .then(nuevoResultado => hacerUnaTerceraCosa(nuevoResultado)); <br>
}).then(() => hacerUnaCuartaCosa()); <br>
// Olvida terminar la cadena con un a catch! <br>
        </code>
        <p>El primer error es no encadenar las acciones adecuadamente. Esto sucede cuando creamos una promesa y olvidamos devolverla. Como consecuencia, la cadena se rompe, o mejor dicho, tenemos dos cadenas independientes que compiten. Esto significa que hacerUnaCuartaCosa() no esperará a que finalicen hacerOtraCosa() o hacerUnaTerceraCosa(), y se ejecutará paralelamente a ellas. Las cadenas separadas también tienen un manejador de errores separado, lo que provoca errores no detectados.</p>
        <p>El segundo error es el anidamiento innecesario, que da lugar al primer error. La anidación también limita el alcance de los manejadores de errores internos, que - si no son deseados - pueden llevar a errores no detectados. Una variante de esto es el constructor anti-patrón de promesas, el cuál combina el anidamiento con el uso redundante del constructor de promesa para envolver el código que ya usa promesas. </p>
        <p>El tercer error es olvidar cerrar las cadenas con catch.Las cadenas de promesas no terminadas conducen a errores no capturados en la mayoría de los navegadores.</p>
        <p>Una buena regla es devolver o terminar siempre las cadenas de promesas, y tan pronto como obtenga una nueva promesa, devolverla de inmediato, para aplanar las cosas:</p>
        <code>hacerAlgo() <br>
.then(function(resultado) { <br>
  return hacerOtraCosa(resultado); <br>
}) <br>
.then(nuevoResultado => hacerUnaTerceraCosa(nuevoResultado)) <br>
.then(() => hacerUnaCuartaCosa()) <br>
.catch(error => console.log(error)); <br></code>
        <p>Nota que () => x es un atajo para () => { return x; }.</p>
        <p>Ahora tenemos una cadena determinística simple con un manejador de error adecuado.</p>
        <code></code>
    </article>
    <article id="div-10">
        <h2>Referencias</h2>
       <div><a href="https://developers.google.com/web/fundamentals/primers/promises">Pro-info</a></div>
       <div><a href="https://developer.mozilla.org/es/docs/Web/JavaScript/Guide/Usar_promesas">info</a></div>
       <a href="https://www.youtube.com/watch?v=Q3HtXuDEy5s">Video</a>
    </article>
    </section>
</body>
</html>