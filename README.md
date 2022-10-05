# BackEnd_Project
Repositorio Team-1 Back para el proyecto del sistema de navegación del evento de programacion_en_esp 

Integrantes V1 
  - juandastick
  - Aledimon
  - Kaiser of Chaos#0025
  - tRK#9334
  
Desarrollo

Sistema de navegación vasado en Uber

Objetos del proyecto V1
  - Poder establecer punto A y punto B
  - Calcular el precio del recorrido
    - Calcular el recorrido mas corto y optimo en base a google maps, estaría bien si la librería 
      o API de información sobre el estado del trafico para el cálculo de la ruta
      NOTA: no se usaria google maps, se puede usar alternativa opensource

**Pasos para instalar el proyecto**
- **DB**
  - Debes tener instalado MongoDB 
  - instalar PHP 8.1 (ponerlo en variable de entorno si es necesario)
  - instalar Composer (Es el gestor de paquetes de PHP similar a "npm")
  - instalar la extension de PHP para mongodb [link de la extension](https://pecl.php.net/package/mongodb/1.13.0/windows)
    - **RECURSOS** (para windows)
      https://www.php.net/manual/es/mongodb.installation.windows.php
      https://pecl.php.net/package/mongodb (descargar la versión compatible con php, el proyecto usa php 8.1)
      poner los 2 archivos mongo en la carpeta de PHP/ext  y poner "extension=mongodb" en el php.ini
    - link de guia con imagenes: [word de instalacion](https://docs.google.com/document/d/1ZORqV0BXAzhh3IARKrQO0z-6QFk_kyTTMtQ0KUaDg8Q/edit?usp=sharing)


- **DESARROLLO**
  - Clonar el repositorio rama develop o la que necesite 
  - Debes tener instalado composer y ejecutar el comando:
  >composer install
  - Copiar .env.example y crear el archivo .env
  - Migrar las tablas a la base de datos:
  >php artisan migrate 
  - inicializar el JWT:
  >php artisan jwt:secret 
  - correr el servidor:
  >php artisan serve
  
