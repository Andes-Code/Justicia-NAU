# ⚖️Justicia-NAU

## Descripción
Este proyecto es una **plataforma web de peticiones** donde los usuarios pueden crear y firmar peticiones de diferentes temas. Similar a Change.org, busca promover la participación social al permitir que las personas apoyen causas y logren cambios mediante la recolección de firmas.

## Tecnologías Utilizadas
- **Backend**: PHP (Vanila)
- **Frontend**: HTML5, CSS3 (Bulma), JavaScript 
- **Base de Datos**: MySQL
- **API Integradas**: OpenAI (ChatGPT) para sugerencias en redacción de peticiones
- **Control de Versiones**: Git y GitHub

## Estructura del Proyecto
El proyecto sigue un patrón de diseño **MVC (Model-View-Controller)** simplificado



## Características Principales
1. **Creación de Peticiones**: Los usuarios pueden crear peticiones personalizadas con imágenes y temas relacionados.
2. **Firmas**: Posibilidad de firmar peticiones y compartirlas en redes sociales.
3. **Perfil de Usuario**: Cada usuario puede gestionar sus peticiones y firmas.
4. **Integración de IA**: Uso de ChatGPT para ayudar en la redacción del contenido de las peticiones.
5. **Interfaz Dinámica**: Diseño responsive con Bootstrap y formularios modulares.

## Instalación
Para correr el proyecto en tu entorno local:

1. Debes tener previamente instalado un servidor Apache y MySQL (XAMPP preferentemente para windows, LAMPP para Linux).
   
2. Asegúrate de habilitar la extensión `gd` en el archivo `php.ini`:
   - Esto es necesario para el procesamiento de los códigos QR y las imágenes dentro de los PDF.
   - Sigue estos pasos para habilitar la extensión:
     1. Abre el archivo `php.ini`.
     2. Busca la línea `;extension=gd`.
     3. Elimina el punto y coma (`;`) al inicio de la línea para descomentarla: `extension=gd`.
     4. Guarda los cambios y reinicia el servidor Apache (en caso de que haya estado funcionando).

3. Haz un fork a tu cuenta desde el repositorio original en [Andes Code](https://github.com/Andes-Code/Justicia-NAU)

4. Clona tu nuevo repositorio al entorno local dentro de la carpeta `htdocs`. Esto creará una carpeta con el nombre del proyecto:
    - En Windows:
    ```bash
    cd C:/xampp/htdocs 
    git clone https://github.com/tu-usuario/Justicia-NAU.git
    ```
    - En linux:
    ```bash
    cd /opt/lampp/htdocs
    git clone https://github.com/tu-usuario/Justicia-NAU.git
    ```

5. Dentro de la carpeta `docs` del proyecto se encuentra el archivo BD.sql, que contiene la estructura de todas las tablas y vistas de la base de datos, ademas de las tuplas necesarias en ciertas tablas para el correcto funcionamiento de la App. Utilizalo para crear la BD ya sea dentro de phpmyadmin o a traves de la consola.

6. Inicia el servidor php y el servidor de la BD

7. Accede al sitio en tu navegador:
    ```
    http://localhost/Justicia-NAU
    ```

## Uso del Repositorio
### Reglas de Contribución
1. Todas las contribuciones deben realizarse en ramas individuales correspondientes a la feature que se esté desarrollando. (ej. `feature/[nombre de la feature]`)
2. Crea un **pull request** cuando hayas finalizado una tarea.
3. Realiza revisiones de código antes de fusionar cambios a la rama `main`.

### Estructura de Ramas
- `main`: Mantedrá el código listo para producción.
- `development`: Será la rama en la que el programador subirá los cambios y luego se podrán fusionar al main cuando estén listos.
- Ramas por características (`feature/nueva-caracteristica`) para cada funcionalidad. Se realizará la pull-request para revisión, las cuales deberán detallar los cambios realizados.

# LIBRERIAS UTILIZADAS

1. **DOMPDF**
   - **Versión recomendada**: 3.0.0 o superior

2. **PHPQRCODE**
   - **Versión recomendada**: 3 o superior

2. **BULMA By Jeremy Thomas**
   - **Versión recomendada**: 3 o superior



## Licencia
Este proyecto está bajo la [Licencia MIT](LICENSE).
