# ⚖️Justicia-NAU

## Descripción
Este proyecto es una **plataforma web de peticiones** donde los usuarios pueden crear y firmar peticiones de diferentes temas. Similar a Change.org, busca promover la participación social al permitir que las personas apoyen causas y logren cambios mediante la recolección de firmas.

## Tecnologías Utilizadas
- **Backend**: PHP (MVC)
- **Frontend**: HTML5, CSS3, JavaScript (Bootstrap)
- **Base de Datos**: MySQL
- **API Integradas**: OpenAI (ChatGPT) para sugerencias en redacción de peticiones
- **Control de Versiones**: Git y GitHub

## Estructura del Proyecto
El proyecto sigue el patrón de diseño **MVC (Model-View-Controller)**, lo que garantiza modularidad, seguridad y escalabilidad.

- **Modelo**: Maneja la lógica de base de datos y operaciones de datos.
- **Vista**: Gestiona la representación visual del contenido.
- **Controlador**: Media entre el modelo y la vista, controlando el flujo de datos y la interacción del usuario.

## Características Principales
1. **Creación de Peticiones**: Los usuarios pueden crear peticiones personalizadas con imágenes y temas relacionados.
2. **Firmas**: Posibilidad de firmar peticiones y compartirlas en redes sociales.
3. **Perfil de Usuario**: Cada usuario puede gestionar sus peticiones y firmas.
4. **Integración de IA**: Uso de ChatGPT para ayudar en la redacción del contenido de las peticiones.
5. **Interfaz Dinámica**: Diseño responsive con Bootstrap y formularios modulares.

## Instalación
Para correr el proyecto en tu entorno local:

1. Clona el repositorio:
    ```bash
    git clone https://github.com/tu-usuario/Plataforma-Peticiones.git
    ```
2. Configura el entorno de desarrollo:
    - Asegúrate de tener PHP, MySQL y un servidor local como XAMPP o MAMP instalados.
    - Configura el archivo `.env` con los detalles de tu base de datos.

3. Ejecuta las migraciones de la base de datos:
    ```bash
    php artisan migrate
    ```

4. Inicia el servidor local:
    ```bash
    php -S localhost:8000
    ```

5. Accede al sitio en tu navegador:
    ```
    http://localhost:8000
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

## Licencia
Este proyecto está bajo la [Licencia MIT](LICENSE).
