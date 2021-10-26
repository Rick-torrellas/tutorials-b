<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulos Javascript</title>
</head>
<body>
    <h1>Modulos Javascript</h1>
<section>
<nav>
<a href="#div-1">Antecedentes sobre los modulos</a>
<br>
<a href="#div-2">Compatibilidad de Navegadores</a>
<br>
<a href="#div-3">Estructura basica del ejemplo</a>
<br>
<a href="#div-4">La modalidad de exportar el modulo</a>
<br>
<code>export { name, draw, reportArea, reportPerimeter };</code>
<br>
<a href="#div-5">La caracteristica de importar en tu script</a>
<br>
<code>import { name, draw, reportArea, reportPerimeter } from './modules/square.mjs';</code>
<br>
<a href="#div-6">Aplicando el modulo en tu HTML</a>
<br>
<code>&lt;script type="text/javascript" src="main.mjs">&lt;/script></code>
<br>
<a href="#div-7">Otras diferencias entre modulos y scrips estandars</a>
<br>
<a href="#div-8">default export</a>
<br>
<code>export default function(ctx) {};</code><br>
<code>import {default as randomSquare} from './modules/square.mjs';</code>
<br>
<a href="#div-9">Evitar conflictos de nombres</a>
<br>
<a href="#div-10">Renombrando imports y exports</a><br>
<code>export { function1 as newFunctionName };</code><br>
<code>import { function1 as newFunctionName } from './modules/module.mjs';</code>
<br>
<a href="#div-11">Creando un modulo objeto</a><br>
<code>import * as Module from './modules/module.mjs';</code>
<br>
<a href="#div-12">Modulos y clases</a><br>
<code>export { Square };</code><br>
<code>import { Square } from './modules/square.mjs';</code>
<br>
<a href="#div-13">Agregando modulos</a><br>
<code>export * from 'x.mjs';</code><br>
<code>export { name } from 'x.mjs';</code>
<br>
<a href="#div-14">Carga dinámica de módulos</a><br>
<code>import('./modules/myModule.mjs') .then((module) => {// code });</code>
<br>
<a href="#div-15">Solución de problemas</a>
<br>
</nav>
<div id="div-1">
    <h2>Antecedentes sobre los modulos</h2>
    <p>Los programas en javascript epezaron muy pequeños - la mayoria de sus usos en los primeros dias fueron scripts aislados, dando un monton de interactividad en tu pagina donde era necesitado, asi que grandes scrips no eran necesitados. Mas adelante en el tiempo tenemos aplicaciones completas corriendo en los navegadores con mucho de Javascript, como tambien usando Javascript en otros contextox (Node.js, por ejemplo).</p>
    <p>Empezo a tomar sentido en años recientes empezar a pensar acerca de mecanismos para partir programas Javascript en modulos separados que pueden ser importados cuando se necesite. Node.js ha tenido esta habilidad desde ya hace un tiempo, y hay un numero de librerias Javascript y frameworks que habilitan el uso de modulos (por ejemplo, otro sistema de modulos CommonJs y AMD-bsed como RequireJs, y mas recientemente Webpack y Babel)</p>
    <p>Las buenas noticias es que los navegadores modernos han empezado a soportar la funcionalidad de modulos nativamente, y esto es lo que trata este articulo. Esto nada mas puede una buena cosa - los navegadores pueden ser optimizados cargado los modulos, haciendolo mas eficiente que teniendo que usar una libreria y tener que hacer el proceso extra client-side.</p>
</div>
<div id="div-2">
<h2>Compatibilidad de Navegadores</h2>
<a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules">https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules</a>
</div>
<div>
<h2>Introduccion y ejemplo</h2>
<div id="div-3">
<h2>Estructura basica del ejemplo</h2>
<p>En nuestro primer ejemplo tenemos una estructura de archivos asi:</p>
<code>
index.html <br>
main.mjs <br>
modules/ <br>
    canvas.mjs <br>
    square.mjs <br>
</code>
<p>En el directoria del modulo son descritos dos modulos:</p>
<ul>
<h2>canvas.mjs</h2>
<p>contains functions related to setting up the canvas:</p>
    <li>create() — creates a canvas with a specified width and height inside a wrapper <div> with a specified ID, which is itself appended inside a specified parent element. Returns an object containing the canvas's 2D context and the wrapper's ID.</li>
    <li>createReportList() — creates an unordered list appended inside a specified wrapper element, which can be used to output report data into. Returns the list's ID.</li>
    <code>
function create(id, parent, width, height) { <br>
  let divWrapper = document.createElement('div'); <br>
  let canvasElem = document.createElement('canvas'); <br>
  parent.appendChild(divWrapper); <br>
  divWrapper.appendChild(canvasElem); <br>
 <br>
  divWrapper.id = id; <br>
  canvasElem.width = width; <br>
  canvasElem.height = height; <br>
 <br>
  let ctx = canvasElem.getContext('2d'); <br>
 <br>
  return { <br>
    ctx: ctx, <br>
    id: id <br>
  }; <br>
} <br>
 <br>
function createReportList(wrapperId) { <br>
  let list = document.createElement('ul'); <br>
  list.id = wrapperId + '-reporter'; <br>
 <br>
  let canvasWrapper = document.getElementById(wrapperId); <br>
  canvasWrapper.appendChild(list); <br>
 <br>
  return list.id; <br>
} <br>
 <br>
export { create, createReportList }; <br>
    </code>
</ul>
<ul>
<h2>square.mjs</h2>
<p>contains</p>
<li>name — a constant containing the string 'square'</li>
<li>draw() — draws a square on a specified canvas, with a specified size, position, and color. Returns an object containing the square's size, position, and color.</li>
<li>reportArea() — writes a square's area to a specific report list, given its length.</li>
<li>reportPerimeter() — writes a square's perimeter to a specific report list, given its length.</li>
<code>
const name = 'square'; <br>
 <br>
function draw(ctx, length, x, y, color) { <br>
  ctx.fillStyle = color; <br>
  ctx.fillRect(x, y, length, length); <br>
 <br>
  return { <br>
    length: length, <br>
    x: x, <br>
    y: y, <br>
    color: color <br>
  }; <br>
} <br>
 <br>
function random(min, max) { <br>
   let num = Math.floor(Math.random() * (max - min)) + min; <br>
   return num; <br>
} <br>
 <br>
function reportArea(length, listId) { <br>
  let listItem = document.createElement('li'); <br>
  listItem.textContent = `${name} area is ${length * length}px squared.` <br>
 <br>
  let list = document.getElementById(listId); <br>
  list.appendChild(listItem); <br>
} <br>
 <br>
function reportPerimeter(length, listId) { <br>
  let listItem = document.createElement('li'); <br>
  listItem.textContent = `${name} perimeter is ${length * 4}px.` <br>
 <br>
  let list = document.getElementById(listId); <br>
  list.appendChild(listItem); <br>
} <br>
 <br>
function randomSquare(ctx) { <br>
  let color1 = random(0, 255); <br>
  let color2 = random(0, 255); <br>
  let color3 = random(0, 255); <br>
  let color = `rgb(${color1},${color2},${color3})` <br>
  ctx.fillStyle = color; <br>
 <br>
  let x = random(0, 480); <br>
  let y = random(0, 320); <br>
  let length = random(10, 100); <br>
  ctx.fillRect(x, y, length, length); <br>
 <br>
  return { <br>
    length: length, <br>
    x: x, <br>
    y: y, <br>
    color: color <br>
  }; <br>
} <br>
 <br>
export { name, draw, reportArea, reportPerimeter }; <br>
export default randomSquare; <br>
</code>
</ul>
<div>
<h2>main.mjs</h2>
<code>
import { create, createReportList } from './modules/canvas.mjs'; <br>
import { name, draw, reportArea, reportPerimeter } from './modules/square.mjs'; <br>
import randomSquare from './modules/square.mjs'; <br>
 <br>
let myCanvas = create('myCanvas', document.body, 480, 320); <br>
let reportList = createReportList(myCanvas.id); <br>
 <br>
let square1 = draw(myCanvas.ctx, 50, 50, 100, 'blue'); <br>
reportArea(square1.length, reportList); <br>
reportPerimeter(square1.length, reportList); <br>
 <br>
// Use the default <br>
let square2 = randomSquare(myCanvas.ctx); <br>
</code>
</div>
<p>
Nota: Para aclarar la extencion .mjs (este archivo es un modulo, y no es un archivo regular de Javascript) y para interoperability con otras herramientas, sin embargo hacer que los modulos funcionen correctamente con una extencion .mjs, necesitas estar seguro que tu servidor este sirviendo con javascript compatible con MIME-type -- text/javascript -- como lo hace gibhub (y los servidores de prueba de Python y Node.mjs lo hacen por defecto). Si no sabes, obtendras un strict MIME-type si usas un servidor que sirve con archivos .mjs corractamente, y no pueda controlar su configuracion, tendras que usar archivos .mjs
</p>
</div>
<div id="div-4">
    <h2>La modalidad de exportar el modulo</h2>
    <p>la primera cosa que necesitas tener acceso de las caracteristicas de los mdulos es exportarlos. Esto es logrado con la declaracion export</p>
    <p>La manera mas facil de usarlo es colocarlo en frente de cualquier cosa que quieras exportar fuera del modulo, por ejemplo:</p>
    <code>export const name = 'square'; <br>
 <br>
export function draw(ctx, length, x, y, color) { <br>
  ctx.fillStyle = color; <br>
  ctx.fillRect(x, y, length, length); <br>
 <br>
  return { <br>
    length: length, <br>
    x: x, <br>
    y: y, <br>
    color: color <br>
  }; <br>
} <br></code>
    <p>Puedes exportar funciones, var, let, const, y como puedes ver despues clases. Necesitan ser items top-level, no puedes usar export dentro de una funcion por ejemplo</p>
    <p>Una manera mas conveniente de exportar todos los objetos que quieras es usando una sola declaracion export en el final del archivo modulo, separados por coma y encerrados en corchetes. Por ejemplo</p>
    <code>export { name, draw, reportArea, reportPerimeter };</code>
    <p>:D</p>
</div>
<div id="div-5">
<h2>La caracteristica de importar en tu script</h2>
<p>Una vez que exportaste algunas caracteristicas fuera del modulo, necesitas importarlas en tu script para luego ser usadas. La manera mas simple es la siguiente:</p>
<code>import { name, draw, reportArea, reportPerimeter } from './modules/square.mjs';</code>
<p>Usa la declaracion import, cada elemento es separado por coma y encerrados en corchetes, seguidos por la keyword from, seguido por la ruta donde esta el archivo modulo. Una ruta relativa a la raiz del sitio.</p>
<p>Sin embargo, hemos escrito la ruta un poco diferente estamos usando la sintaxis con punto (./), lo cual significa el lugar actual donde estas, seguido por la ruta donde esta el archivo al cual quieres acceder. Esto es mucho mejor que escribir la ruta relativa entera cada vez, es mas corto, y hace la URL tasportable, el ejemplo seguira funcionando si lo mueves en distinta arquitectura de archivos por ejemplo</p>
<code>/js-examples/modules/basic-modules/modules/square.mjs</code>
<p>Se vuelve</p>
<code>./modules/square.mjs</code>
<p>Puede ver muchas lineas en accion en main.mjs</p>
<p>EN algunos sitemas de modulos, puedes omitir la extencion del archivo y el punto (e.g '/modulos/squre'). Esto no funcionara en el modulo nativo de Javascript</p>
<p>Una vez importado la caracteristica en tu script, puedes usarlos justo como si fueran definidos en el mismo archivo. El siguiente es encontrado en main.mjs, debajo de los archivos importados:</p>
<code>
let myCanvas = create('myCanvas', document.body, 480, 320); <br>
let reportList = createReportList(myCanvas.id); <br>
 <br>
let square1 = draw(myCanvas.ctx, 50, 50, 100, 'blue'); <br>
reportArea(square1.length, reportList); <br>
reportPerimeter(square1.length, reportList); <br>
</code>
</div>
<div id="div-6">
<h2>Aplicando el modulo en tu HTML</h2>
<p>Ahora vamos a aplicar nuestro modulo main.mjs en nuestra pagina HTML. Esto es muy similar a como aplicamos un script regular a una pagina, con alguns diferencias notables.</p>
<p>Primero que todo, necesitas incluir type="module" en un elemento &lt;script>, para declarar este script como un modulo</p>
<p><b>importante</b> En caso de que no te sirva a primera,intenta con la segunda.</p>
<code>&lt;script type="module" src="main.mjs">&lt;/script></code><br>
<code>&lt;script type="text/javascript" src="main.mjs">&lt;/script></code>
<p>El script en el que importas las caracteristicas de modulo actua como un modulo top-level. Si lo omites, Firefox por ejemplo te da "SyntaxError: import declarations may only appear at top level of a module".</p>
<p>Tu solo puedes usar sentencias import y export dentro de modulo; scripts no regulares.</p>
<p>Tu tambien puedes importar modulo dentro de scripts internos, mientras que incluyas type="module", por ejemplo &lt;script type="module">//incluye tu escrih?&lt;script>.</p>
</div>
<div id="div-7">
<h2>Otras diferencias entre modulos y scrips estandars</h2>
<ul>
<li>Necesitas prstar atencion a tus testieos locales, si tratas de cargar un archivo HTML localmente (ejemplo una URL file:// ), te daran errores CORS due en el modulo de seguridad de Javascript, Necesitaras testiarlo dentro de un servidor.</li>
<li>Tabmien, nota que tendras siferente resultado por seciones del script definidos dentro del modulo como opuesto en los scripts estandar. Esto es por que los modulos usando el modo estricto automaticamente.</li>
<li>No hay necesidad de usar el atributo defer cuando se carge un modulo script; modulos son deferidos automaticamente.</li>
<li>Ultimo vamos a aclarar - las caracteristicas de modulos son importados en el ambito de un solo script - no estan disponibles en el ambito global. Por consiguiente, tu solo podras acceder a las caracteristicas importadas en el script que estaas importando, y no podras acceder a el por la consola Javascript, por ejemplo tendras errores de syntaxis mostrados en el DevTools, pero no podras ser capaz de usar de algunas de las tecnicas de debuggin que esperas usar.</li>
</ul>
</div>
<div id="div-8">
<h2>default export versus named exports</h2>
<p>Las funcionalidades que hemos exportados hasta ahora se ah compuesto de named exports - cada objeto (siendo una funcion, const, etc) ha sido exportado usando export, y usando el nombre que fue usando para referirlo en el import tambien.</p>
<p>Tambien existe otro tipo de export callado default export - este esta diseñado para hacer mas el tener una funcion por defecto en el modulo, y tambien ayuda a los modulos en Javascript a interoperar con modulos existentes CommonJS y AMD. Como lo explica Jason Orendorff en ES6 In Depth: Modules</p>
<p>VAmos a ver en el ejemplo mientras explicamos como funciona. En nuestros modulos-basicos square.mjs tu puedes encontrar una funcion llamada randomSuare() que crea un circulo con un color al azar, tamaño, y posicion. Queremos exportar esto como nuestro default, asi que en el fondo del archivo escribimos esto:</p>
<code>export default randomSquare;</code>
<p>Nota la falta de corchetes. Tambien podriamos en vez export default detro de la funcion y definirla como una funcion anonima, asi:</p>
<code>export default function(ctx) { <br>
  ... <br>
} <br></code>
<p>Por encima de nuestro archivo main.mjs, emportamos la funcion por defecto usando esta linea:</p>
<code>import randomSquare from './modules/square.mjs';</code>
<p>otra vez mira la falta de corchetes. Esto es por que hay solo un export por default permitido por modulo, y sabemos que randomSquare es la funcion. La linea de abajo es un atajo para ello:</p>
<code>import {default as randomSquare} from './modules/square.mjs';</code>
</div>
<div id="div-9">
<h2>Evitar conflictos de nombres</h2>
<p>Hasta ahora, nuestros modulos parecen funcionar bien. </p>
<p>So far, our canvas shape drawing modules seem to be working OK. But what happens if we try to add a module that deals with drawing another shape, like a circle or triangle? These shapes would probably have associated functions like draw(), reportArea(), etc. too; if we tried to import different functions of the same name into the same top-level module file, we'd end up with conflicts and errors.</p>
<p>Fortunately there are a number of ways to get around this.</p>
</div>
<div id="div-10">
<h2>Renombrando imports y exports</h2>
<p>Dentro de los corchetes de tu import y export, puedes usar el keyword as junto con el nuevo nombre de la funcion, to change the identifying name you will use for a feature inside the top-level module.</p>
<p>Asi que por ejemplo, ambos haran el mismo trabajo, con una pequeña diferencia.</p>
<code>
// inside module.mjs <br>
export { <br>
  function1 as newFunctionName, <br>
  function2 as anotherNewFunctionName <br>
}; <br>
 <br>
// inside main.mjs <br>
import { newFunctionName, anotherNewFunctionName } from './modules/module.mjs'; <br>
</code>
<code>
// inside module.mjs <br>
export { function1, function2 }; <br>
 <br>
// inside main.mjs <br>
import { function1 as newFunctionName, <br>
         function2 as anotherNewFunctionName } from './modules/module.mjs'; <br>
</code>
<p>
Let's look at a real example. In our renaming directory you'll see the same module system as in the previous example, except that we've added circle.mjs and triangle.mjs modules to draw and report on circles and triangles.
</p>
<p>Inside each of these modules, we've got features with the same names being exported, and therefore each has the same export statement at the bottom:</p>
<code>
export { name, draw, reportArea, reportPerimeter };</code>
<p>When importing these into main.mjs, if we tried to use</p>
<code>
import { name, draw, reportArea, reportPerimeter } from './modules/square.mjs'; <br>
import { name, draw, reportArea, reportPerimeter } from './modules/circle.mjs'; <br>
import { name, draw, reportArea, reportPerimeter } from './modules/triangle.mjs'; <br>
</code>
<p>
El navegador tirara un error como "SyntaxError": redeclaration of import name" (Firefox).
</p>
<p>
En vez necesitamos renombrar los imports para que sean unicos:
</p>
<code>
import { name as squareName, <br>
         draw as drawSquare, <br>
         reportArea as reportSquareArea, <br>
         reportPerimeter as reportSquarePerimeter } from './modules/square.mjs'; <br>
 <br>
import { name as circleName, <br>
         draw as drawCircle, <br>
         reportArea as reportCircleArea, <br>
         reportPerimeter as reportCirclePerimeter } from './modules/circle.mjs'; <br>
 <br>
import { name as triangleName, <br>
        draw as drawTriangle, <br>
        reportArea as reportTriangleArea, <br>
        reportPerimeter as reportTrianglePerimeter } from './modules/triangle.mjs'; <br>
</code>
<p>
Nota que tambien puedes solventar el problema en archivo modulo en vez:
</p>
<code>
// in square.mjs <br>
export { name as squareName, <br>
         draw as drawSquare, <br>
         reportArea as reportSquareArea, <br>
         reportPerimeter as reportSquarePerimeter }; <br>
</code>
<code>
// in main.mjs <br>
import { squareName, drawSquare, reportSquareArea, reportSquarePerimeter } from './modules/square.mjs'; <br>
</code>
<p>
Y funcionario igual. Que estilo uses depende de ti, sin embargo tiene mas sentido que dejes tu archivo de modulo tranquilo, para solo ser delcarados en un solo lugar el modulo de las importaciones. Esto tiene especial sentido cuando tratas de importar de modulos de terceros y no tienes ningun control sobre ellos.
</p>
</div>
<div id="div-11">
<h2>Creando un modulo objeto</h2>
<p>
El metodo de abajo funciona, pero es un poco desargonizado y largo. Una buena solucion es importar cada funcion del modulo dentro de un objeto modulo. La siguiente syntaxis hace eso:
</p>
<code>
import * as Module from './modules/module.mjs';
</code>
<p>
Esto toma todos los exports disponibles dentro del module.mjs, y lo hace disponble como mienbro de un objeto Module, efectivamente dandoles su propio namespace. Por ejemplo:
</p>
<code>
Module.function1() <br>
Module.function2() <br>
etc. <br>
</code>
<p>
Otra vez, vamos a ver un ejemplo real. Si vas al directorio de module-objects, veras el mismo ejemplo otra vez, pero rescrito para tomar ventaja de esta nuevo syntax. En estos modulos, los exports estan de esta manera simple:
</p>
<code>
export { name, draw, reportArea, reportPerimeter };
</code>
<p>
Los imports se ven asi:
</p>
<code>
import * as Canvas from './modules/canvas.mjs'; <br>
 <br>
import * as Square from './modules/square.mjs'; <br>
import * as Circle from './modules/circle.mjs'; <br>
import * as Triangle from './modules/triangle.mjs'; <br>
</code>
<p>
En cada caso, puedes acceder ahora a los modulo imports espesifico del nombre del objeto, por ejemplo:
</p>
<code>
let square1 = Square.draw(myCanvas.ctx, 50, 50, 100, 'blue'); <br>
Square.reportArea(square1.length, reportList); <br>
Square.reportPerimeter(square1.length, reportList); <br>
</code>
<p>Ahora puedes escribir el codigo justo como antes (mientras que incluyas el nombre del objeto que necesites), y en los imports es mucho mas limpio.</p>
</div>
<div id="div-12">
<h2>Modulos y clases</h2>
<p>
Como insinuamos anterioremente, tambien se pueden exportar clases; esta es otra opcion para evitar conflictos en tu codigo, y es especialmente util si ya de por si tu modulo esta escrito orientado a objetos.
</p>
<p>
Puedes ver un ejemplo of our shape drawing module rewritten with ES classes in our classes. Como en ejmeplo, el archivo suare.mjs ahora contiene toda la funcionalidad en una sola clase:
</p>
<code>
class Square { <br>
  constructor(ctx, listId, length, x, y, color) { <br>
    ... <br>
  } <br>
 <br>
  draw() { <br>
    ... <br>
  } <br>
 <br>
  ... <br>
} <br>
</code>
<code>
export { Square };
</code>
<p>
Luego se puede importar asi:
</p>
<code>
import { Square } from './modules/square.mjs';
</code>
<p>
Luego se puede usar la clase asi
</p>
<code>
let square1 = new Square(myCanvas.ctx, myCanvas.listId, 50, 50, 100, 'blue'); <br>
square1.draw(); <br>
square1.reportArea(); <br>
square1.reportPerimeter(); <br>
</code>
</div>
<div id="div-13">
<h2>Agregando modulos</h2>
<p>
Va a existir el momento cuando quieras agregar modulos juntos. Puedes tener varios niveles de dependencias, cuando tu quieres es simplificar las cosas, combinando varios submodulos en un solo modulo padre. Esto es posible usando la syntaxis export:
</p>
<code>
export * from 'x.mjs' <br>
export { name } from 'x.mjs' <br>
</code>
<p>
Por ejemplo, mira nuestro directorio module-aggregation. En este ejemplo (basado en el ejemplo anterior de clases) tenemos un modulo extra llamado shapes.mjs, el cual agrega toda la funcionalidad de circle.mjs , square.mjs y triangle.mjs juntos. We've also moved our submodules inside a subdirectory inside the modules directory called shapes. So the module structure in this example is:
</p>
<code>
modules/
  canvas.mjs
  shapes.mjs
  shapes/
    circle.mjs
    square.mjs
    triangle.mjs
</code>
<p>
En cada uno de los submodulos, el export es de la misma manera e.g:
</p>
<code>
export { Square };
</code>
<p>
Ahora viene la parte para agregar. Dentro de shapes.mjs, hemos incluido las siguientes lineas:
</p>
<code>
export { Square } from './shapes/square.mjs'; <br>
export { Triangle } from './shapes/triangle.mjs'; <br>
export { Circle } from './shapes/circle.mjs'; <br>
</code>
<p>These grab the exports from the individual submodules and effectively make them available from the shapes.mjs module.</p>
<p>Note: The exports referenced in shapes.mjs basically get redirected through the file and don't really exist there, so you won't be able to write any useful related code inside the same file.</p>
<p>So now in the main.mjs file, we can get access to all three module classes by replacing</p>
<code>
import { Square } from './modules/square.mjs'; <br>
import { Circle } from './modules/circle.mjs'; <br>
import { Triangle } from './modules/triangle.mjs'; <br>
</code>
<p>with the following single line:</p>
<code>
import { Square, Circle, Triangle } from './modules/shapes.mjs';
</code>
</div>
<div id="div-14">
<h2>Carga dinámica de módulos</h2>
<p>
Una de las nuevas funcinalidad de javascript es la carga dinamica de modulos, esto te permite cargar el modulo solo cuando sea necesario, es vez de cargar todo de golpe, esto es muy util para el rendimiento.
</p>
<p>
Esta funcionalidad te permite llamar una funcion impor como una funcion import(), y pasar la ruta del modulo como un parametro. Regresa una Promise, que cumple con un objeto de módulo
</p>
<code>import('./modules/myModule.mjs') <br>
  .then((module) => { <br>
    // Do something with the module. <br>
  }); <br></code>
<p>
Let's look at an example. In the dynamic-module-imports directory we've got another example based on our classes example. This time however we are not drawing anything on the canvas when the example loads. Instead, we include three buttons — "Circle", "Square", and "Triangle" — that, when pressed, dynamically load the required module and then use it to draw the associated shape.
</p>
<p>
In this example we've only made changes to our index.html and main.mjs files — the module exports remain the same as before.
</p>
<p>Over in main.mjs we've grabbed a reference to each button using a Document.querySelector() call, for example:</p>
<code>
let squareBtn = document.querySelector('.square');
</code>
<p>We then attach an event listener to each button so that when pressed, the relevant module is dynamically loaded and used to draw the shape:</p>
<code>
squareBtn.addEventListener('click', () => { <br>
  import('./modules/square.mjs').then((Module) => { <br>
    let square1 = new Module.Square(myCanvas.ctx, myCanvas.listId, 50, 50, 100, 'blue'); <br>
    square1.draw(); <br>
    square1.reportArea(); <br>
    square1.reportPerimeter(); <br>
  }) <br>
}); <br>
</code>
<p>
Note that, because the promise fulfillment returns a module object, the class is then made a subfeature of the object, hence we now need to access the constructor with Module. prepended to it, e.g. Module.Square( ... ).
</p>
</div>
<div id="div-15">
<h2>Solución de problemas</h2>
<p>Here are a few tips that may help you if you are having trouble getting your modules to work. Feel free to add to the list if you discover more!</p>
<ul>
  <li>We mentioned this before, but to reiterate: .mjs files need to be loaded with a MIME-type of text/javascript (or another JavaScript-compatible MIME-type, but text/javascript is recommended), otherwise you'll get a strict MIME type checking error like "The server responded with a non-JavaScript MIME type".</li>
  <li>If you try to load the HTML file locally (i.e. with a file:// URL), you'll run into CORS errors due to JavaScript module security requirements. You need to do your testing through a server. GitHub pages is ideal as it also serves .mjs files with the correct MIME type.</li>
  <li>Because .mjs is a fairly new file extension, some operating systems might not recognise it, or try to replace it with something else. For example, we found that macOS was silently adding on .mjs to the end of our .mjs files and then automatically hiding the file extension. So all of our files were actually coming out as x.mjs.mjs. Once we turned off automatically hiding file extensions, and trained it to accept .mjs, it was OK.</li>
</ul>
</div>
</section>
<!--<script type="text/javascript" src="hola.mjs"></script>-->
</body>
</html>