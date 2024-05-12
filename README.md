# Configuración del Entorno de Desarrollo para Symfony

#### Requisitos Previos:

- PHP 8.2
- Composer
- Symfony CLI
- XAMPP
- MySQL Workbench

## Instalación

### PHP

Asegúrate de tener PHP 8.2 instalado en tu sistema. Puedes verificar la versión con el siguiente comando:

[Link de descarga](https://www.php.net/downloads.php#v8.2.0)

```bash
php -v
```

### Composer

En caso de no tener composer
[Link de descarga](https://getcomposer.org/download/)

una ves instalado o ya lo tengas correr el siguiente comando

```bash
composer install
```

### Instalacion de Symfony CLI

correr el comando

```bash
scoop install symfony-cli
```

#### En caso de no tener Scoop

Correr el comando en powershell

```bash
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
```

### Xampp

Instalar Xampp para manejar el servidor Apache y Mysql local

[Link de descarga](https://www.apachefriends.org/es/download.html)

### Mysql Workbench

Instala MySQL Workbench para gestionar la base de datos.

[Link de descarga](https://dev.mysql.com/downloads/installer/)

### Configuracion

Asegurarse de configurar las variables de entorno necesarias para conectar la aplicación Symfony con la base de datos. para eso hay que modificar el .env del proyecto.

### Uso

Para correr el servidor de desarrollo de Symfony, se usa:

```bash
symfony server:start
```

### Migraciones

Para manejar las migraciones de la base de datos, ejecuta los siguientes comandos:
1. Crear una nueva migración:
```bash
php bin/console make:migration
```
2. Correr las migraciones:
```bash
php bin/console doctrine:migrations:migrate
```

### Seeders
Para correr los seeders y almacenar datos en la base de datos con datos de prueba, usar:

```bash
php bin/console doctrine:fixtures:load
```

