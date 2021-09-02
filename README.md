# Tutorials

## Data Model

### model a

**contenido**</br>

el contenido sera un punto de referencia, para agrupar los tutoriales. ejemplo: nodejs - tutoriales relacionados a nodejs.</br>

{</br>
    title: string,</br>
    icon: string,</br>
    cat_id: [string],</br>
    id: string</br>
}</br>

**tutoriales**</br>

los tutoriales pueden estar relacionados a varios contenidos.

{</br>
    title: string,</br>
    id_contenido: [string],</br>
    fileName: string</br>
}</br>

**categorias**</br>

las categorias solo aplican para el contenido.

{</br>
    name: string</br>
}</br>