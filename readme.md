

## Acerca del Proyecto

Este proyecto consiste en un sistema de control de asistencia para practicantes del Laboratorio de Robótica de la Facultad de Tecnología de la  UMRPSFXCH (Sucre-Bolivia). El sitema está desarrolado con Laravel y Vue haciendo uso del gestor de base de datos Mysql.


## Como installar el Sistema

    1. Crear un archivo con el nombre .env en el directorio del proyecto y pegar el contenido del archivo .env.example
    2. Dentro de .env configurar los datos del proyecto (App_NAME,APP_URL,DB_DATABASE...)
    3. Ejecutar: composer install 
    4. Ejecutar el comando: php artisan key:generate
    5. Ejecutar el comando: npm intall
    6. Importar la BD en mysql (archivo .sql ubicado en el directorio pricipal)
    7. Ejecutar el comando: php artisan migrate 
    8. Ejecutar el comando: php artisan serve
    
## Más Información
El proyecto cuenta con una funcionalidad que consite en el registro del faltas deacuerdo a la fecha actual del sistema, esta fucionalidad puede ejecutarse manualmente a través de un boton (actualizar) ubicado en la interfaz del sitema, en el apartado de Lista de la pestaña Faltas. O puede ejecutarse de manera automática siguiendo las siguientes instruciones:
Para Linux.
     1. Dentro del archivo Kernel.php (app\Console), descomentar el metodo hourlyAt,twiceDaily,etc. Ver https://laravel.com/docs/7.x/scheduling
     2. Ejecutar en consola: crontab -e
     3. Apretar la tecla "I" y editar => * * * * * php /PATH-DEL-PROYECTO/artisan schedule:run >> /dev/null 2>&1 
     4. Esc 
     5. wq
     6. Verificar el crontab con: crontab -l
     7. Ejecutar php artisan schedule:run
Para Windows.
     1. Ver video https://youtu.be/SD9yX-aW0t0
