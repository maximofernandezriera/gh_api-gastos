# Gastos API

Este proyecto es una API en Laravel  para la gestión de gastos personales. Permite a los usuarios registrarse, iniciar sesión y gestionar sus gastos mediante la creacion, edición y eliminación de estos. 
## Requisitos

- PHP ^8.2
- Composer
- Node.js
- SQLite

## Instalación

1. Clona el repositorio:
    ```sh
    git clone "https://github.com/SwagDAWnDual/api-gestion-gastos-mcanadas-dawi.git"
    cd api-gestion-gastos-mcanadas-dawi/GastosApi
    ```

2. Instala las dependencias de PHP:
    ```sh
    composer install
    ```

3. Instala las dependencias de Node.js:
    ```sh
    npm install
    ```

4. Copia el archivo de entorno y genera la clave de la aplicación:
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

5. Genera el `JWT_SECRET`:
    ```sh
    php artisan jwt:secret
    ```

6. Configura el archivo `.env` con tus preferencias. Asegúrate de que `DB_CONNECTION` esté configurado para usar SQLite:
    ```env
    DB_CONNECTION=sqlite
    DB_DATABASE=/ruta/a/tu/database.sqlite
    ```

7. Crea el archivo de base de datos SQLite:
    ```sh
    touch database/database.sqlite
    ```

8. Ejecuta las migraciones de la base de datos:
    ```sh
    php artisan migrate
    ```

9. Inicia el servidor de desarrollo:
    ```sh
    php artisan serve
    ```

## Endpoints

### Registro de Usuario

- **URL:** `/api/register`
- **Método:** `POST`
- **Body:**
    ```json
    {
        "name": "Nombre del usuario",
        "email": "correo@example.com",
        "password": "contraseña"
    }
    ```
- **Respuesta exitosa:**
    ```json
    {
        "Usuario registrado con éxito"
    }
    ```

### Inicio de Sesión

- **URL:** `/api/login`
- **Método:** `POST`
- **Body:**
    ```json
    {
        "email": "correo@example.com",
        "password": "contraseña"
    }
    ```
- **Respuesta exitosa:**
    ```json
    {
        "token": "JWT_TOKEN"
    }
    ```

### Listar Gastos

- **URL:** `/api/gastos`
- **Método:** `GET`
- **Headers:**
    ```http
    Authorization: Bearer JWT_TOKEN
    ```
- **Parámetros opcionales:**
    **Añadir en la URL: ?categoria="Nombre de la categoría", precio="bajo/medio/alto" o ambas, añadiendo &**
    - **URL:** `/api/gastos?categoria=Comestibles`// `/api/gastos?precio=alto` // `/api/gastos?categoria=Comestibles&precio=bajo`
    - `categoria`: Filtrar por categoría
    - `precio`: Filtrar por rango de precio (`bajo`, `medio`, `alto`)
- **Respuesta exitosa:**
    ```json
    {
        "message": "Lista de gastos obtenida correctamente",
        "gastos": [
            {
                "id": 1,
                "description": "Descripción del gasto",
                "amount": 100.00,
                "category": "Comestibles",
                "created_at": "2023-10-01T00:00:00.000000Z",
                "updated_at": "2023-10-01T00:00:00.000000Z"
            }
        ]
    }
    ```

### Crear Gasto

- **URL:** `/api/gastos`
- **Método:** `POST`
- **Headers:**
    ```http
    Authorization: Bearer JWT_TOKEN
    ```
- **Body:**
    ```json
    {
        "description": "Descripción del gasto",
        "amount": 100.00,
        "category": "Comestibles"
    }
    ```
- **Respuesta exitosa:**
    ```json
    {
        "message": "Gasto registrado correctamente",
        "gasto": {
            "id": 1,
            "description": "Descripción del gasto",
            "amount": 100.00,
            "category": "Comestibles",
            "created_at": "2023-10-01T00:00:00.000000Z",
            "updated_at": "2023-10-01T00:00:00.000000Z"
        }
    }
    ```

### Actualizar Gasto

- **URL:** `/api/gastos/{id}`
- **Método:** `PUT`
- **Headers:**
    ```http
    Authorization: Bearer JWT_TOKEN
    ```
- **Body:**
    ```json
    {
        "description": "Nueva descripción del gasto",
        "amount": 150.00,
        "category": "Ocio"
    }
    ```
- **Respuesta exitosa:**
    ```json
    {
        "message": "Gasto actualizado correctamente",
        "gasto": {
            "id": 1,
            "description": "Nueva descripción del gasto",
            "amount": 150.00,
            "category": "Ocio",
            "created_at": "2023-10-01T00:00:00.000000Z",
            "updated_at": "2023-10-01T00:00:00.000000Z"
        }
    }
    ```

### Eliminar Gasto

- **URL:** `/api/gastos/{id}`
- **Método:** `DELETE`
- **Headers:**
    ```http
    Authorization: Bearer JWT_TOKEN
    ```
- **Respuesta exitosa:**
    ```json
    {
        "message": "El Gasto {descripcion del gasto} ha sido eliminado correctamente"
    }
    ```

## Historias de Usuario

En este caso voy a darte las intrucciones para acceder a la API desde **POSTMAN**. Recuerda tener el servidor activo para ejecutar las peticiones.
Antes de empezar, te recomendaría abrir una pestaña para cada petición, asi se mantendrá guardada en Postman y no tendrás que estar cambiando la URL ni los headers constantemente.  Te lo muestro en la siguiente imagen:
![Pestañas](GastosApi/imagenesReadMe/Pestañas.png)

Como verás, tengo una pestaña para cada petición (registro, login, crear gasto, listar gastos, actualizar gasto y eliminar gasto).
La flecha de la derecha señala donde se abre una pestaña nueva.


### Registrarse
Copia el siguiente fragmento en la barra de Postman que te señalo en la siguiente imagen:
```sh
curl --location 'http://localhost:8000/api/register' \
--header 'Content-Type: application/json' \
--data-raw '{
  "name": "Maximo",
  "email": "maximo@prueba.com",
  "password": "maximo123"
}'
```
![Registrarse](GastosApi/imagenesReadMe/Registro.png)

Una vez pegado, deberia aparecerte algo parecido a esto:
![Registrarse2](GastosApi/imagenesReadMe/Registro2.png)

En la sección **Body** puedes cambiar tu nombre, email o password a tu gusto, antes de enviar la petición.  
Asegurate de que el tipo de petición es **POST** y pulsa el botón **Send**.  
Si has seguido las instrucciones correctamente obtendrás una respuesta: "Usuario registrado con éxito"  

### Acceder (login)
Para acceder y obtener el token,siempre y cuando no hayas cambiado nada en los pasos anteriores, copia el siguiente fragmento:
```sh
curl --location 'http://localhost:8000/api/login' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
  "email": "maximo@prueba.com",
  "password": "maximo123"
}'
```
**Si has cambiado algún parametro del body, adáptalo**  
Si has seguido las instrucciones correctamente obtendrás un token, copialo sin las comillas, lo usaremos en los siguientes pasos.  
**ATENCION:** Este token caduca cada 24h, por lo tanto, necesitaras hacer otro login pasado este periodo de tiempo.

### Crear gasto
Ahora vamos a crear nuestro primer gasto:
1. Seleccionamos el metodo **POST** y cambiamos la URL a : `/api/gastos`
2. Accedemos a la pestaña **Headers** y en la columna "Key" escribimos "Authorization" (se autocompletará) y en Value escribimos: Bearer (TOKEN COPIADO DE LOGIN, SIN COMILLAS). Deberiamos ver algo parecido a esto:
![Headers](GastosApi/imagenesReadMe/Token.png)
3. Accedemos a la pestaña **Body** y añadimos un gasto mediante los siguientes campos:
    ```json
    {
        "description": "Pañales",
        "amount": 50.00,
        "category": "Salud"
    }
    ```
    **RECUERDA:** La categoria de gastos debe ser: Comestibles, Ocio, Electrónica, Utilidades, Ropa, Salud o Otros.
4. Pulsamos **Send**.
5. Si has seguido los pasos correctamente obtendrás una respuesta como esta:
```json
{
    "message": "Gasto registrado correctamente",
    "gasto": {
        "description": "Pañales",
        "amount": 50,
        "category": "Salud",
        "user_id": 3,
        "updated_at": "2025-02-15T11:44:41.000000Z",
        "created_at": "2025-02-15T11:44:41.000000Z",
        "id": 1
    }
}
```
### Actualizar un gasto
1. Seleccionamos el metodo "PUT" y cambiamos la URL a: `/api/gastos/{id}` 
2. Nos aseguramos de que tenemos el token en **Headers**.
3. Cambiamos el **Body** a nuestro gusto, por ejemplo:
  ```json
    {
        "description": "Pañales para 2 meses",
        "amount": 100.00,
        "category": "Salud"
    }
  ``` 
4. Pulsamos **Send**
5. Si has seguido los pasos correctamente obtendrás una respuesta como esta:
```json
{
    "message": "Gasto actualizado correctamente",
    "gasto": {
        "id": 1,
        "user_id": 3,
        "description": "Pañales para 2 meses",
        "amount": 100,
        "category": "Salud",
        "created_at": "2025-02-15T11:44:41.000000Z",
        "updated_at": "2025-02-15T11:53:49.000000Z"
    }
}
```

### Listar Gastos
1. Cambiamos el metodo a "GET" y la URL a: `/api/gastos/`
2. Nos aseguramos de tener el token en **Headers**
3. Pulsamos **Send**
4. Si has seguido los pasos correctamente obtendrás la lista completa de gastos:
```json
{
    "message": "Lista de gastos obtenida correctamente",
    "gastos": [
        {
            "id": 1,
            "user_id": 3,
            "description": "Pañales para 2 meses",
            "amount": 100,
            "category": "Salud",
            "created_at": "2025-02-15T11:44:41.000000Z",
            "updated_at": "2025-02-15T11:53:49.000000Z"
        },
        {
            "id": 2,
            "user_id": 3,
            "description": "Potitos",
            "amount": 30,
            "category": "Comestibles",
            "created_at": "2025-02-15T12:00:12.000000Z",
            "updated_at": "2025-02-15T12:00:12.000000Z"
        },
        {
            "id": 3,
            "user_id": 3,
            "description": "Pijama",
            "amount": 20,
            "category": "Ropa",
            "created_at": "2025-02-15T12:00:40.000000Z",
            "updated_at": "2025-02-15T12:00:40.000000Z"
        },
        {
            "id": 4,
            "user_id": 3,
            "description": "Carrito",
            "amount": 800,
            "category": "Otros",
            "created_at": "2025-02-15T12:01:15.000000Z",
            "updated_at": "2025-02-15T12:01:15.000000Z"
        }
    ]
}
```
5. También tenemos la opción de filtrar los gastos por categoría, precio o ambas:  
- Categorías: Comestibles, Ocio, Electrónica, Utilidades, Ropa, Salud o Otros.  
- Precio: Bajo (<50), medio (entre 50 y 200) y alto (>200)  

#### 5.1 En la URL, añade:
- `?categoria={nombreCategoria}`
- `?precio={bajo/medio/alto}`
- `?categoria={nombreCategoria}&precio={bajo/medio/alto}`

#### 5.2 A continuación te dejo unos ejemplos:
- `?categoria=Comestibles`
- `?precio=alto`
- `?categoria=Comestibles&precio=bajo`
  
    **URL:** `?precio=alto`
    ```json
        {
    "message": "Lista de gastos obtenida correctamente",
    "gastos": [
        {
            "id": 4,
            "user_id": 3,
            "description": "Carrito",
            "amount": 800,
            "category": "Otros",
            "created_at": "2025-02-15T12:01:15.000000Z",
            "updated_at": "2025-02-15T12:01:15.000000Z"
        }
     ]
    }
    ```
**URL:** `?categoria=Salud`
```json
{
    "message": "Lista de gastos obtenida correctamente",
    "gastos": [
        {
            "id": 1,
            "user_id": 3,
            "description": "Pañales para 2 meses",
            "amount": 100,
            "category": "Salud",
            "created_at": "2025-02-15T11:44:41.000000Z",
            "updated_at": "2025-02-15T11:53:49.000000Z"
        }
    ]
}
```
**URL:** `?categoria=Otros&precio=alto`
```json
{
    "message": "Lista de gastos obtenida correctamente",
    "gastos": [
        {
            "id": 4,
            "user_id": 3,
            "description": "Carrito",
            "amount": 800,
            "category": "Otros",
            "created_at": "2025-02-15T12:01:15.000000Z",
            "updated_at": "2025-02-15T12:01:15.000000Z"
        }
    ]
}
```

### Eliminar Gasto
1. Cambiamos el metodo a "DELETE" y la URL a : `/api/gastos/{id}`
2. Nos aseguramos de tener el token en **Headers**
3. Pulsamos **Send**
4. Si has seguido los pasos correctamente obtendrás la siguiente respuesta:
```json
{
    "message": "El Gasto \"Potitos\" ha sido eliminado correctamente"
}
```
## Ejecutar Tests

Para ejecutar los tests, utiliza el siguiente comando:
```sh
php artisan test
```

### Descripción de los Tests Unitarios

#### Test de Creación de Usuario
- **Método:** `test_user_creation`
- **Descripción:** Este test verifica que un usuario puede ser creado correctamente en la base de datos. Utiliza una fábrica para crear un usuario con un nombre, correo electrónico y contraseña específicos. Luego, verifica que el usuario ha sido registrado en la base de datos comprobando la existencia del correo electrónico.

#### Test de Creación de Gasto
- **Método:** `test_gasto_creation`
- **Descripción:** Este test verifica que un gasto puede ser creado correctamente en la base de datos. Primero, crea un usuario utilizando una fábrica. Luego, crea un gasto asociado a ese usuario con una descripción, monto y categoría específicos. Finalmente, verifica que el gasto ha sido registrado en la base de datos comprobando la existencia de la descripción del gasto.

#### Test de Actualización de Gasto
- **Método:** `test_gasto_update`
- **Descripción:** Este test verifica que un gasto puede ser actualizado correctamente en la base de datos. Primero, crea un usuario y un gasto asociado utilizando fábricas. Luego, actualiza la descripción, monto y categoría del gasto. Finalmente, verifica que los cambios han sido registrados en la base de datos comprobando la nueva descripción, monto y categoría del gasto.

#### Test de Eliminación de Gasto
- **Método:** `test_gasto_deletion`
- **Descripción:** Este test verifica que un gasto puede ser eliminado correctamente de la base de datos. Primero, crea un usuario y un gasto asociado utilizando fábricas. Luego, elimina el gasto. Finalmente, verifica que el gasto ha sido eliminado de la base de datos comprobando la ausencia de la descripción del gasto.

Estos tests aseguran que las operaciones básicas de creación, actualización y eliminación de usuarios y gastos funcionan correctamente en tu aplicación.

**Podrás encontrar estos test en:** `/tests/Feature/ExampleFeatureTest.php`  
**Podrás encontrar las fábricas en:** `database/factories`
