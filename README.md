# **Sistema de Gestión de Biblioteca**

Proyecto completo que implementa un sistema de gestión de biblioteca con:

* API REST en PHP (XAMPP)  
* Cliente de escritorio en Python (Tkinter)  
* Gestión de libros, usuarios y préstamos  
* Códigos QR para préstamos y devoluciones  
* Panel web básico en PHP  
* Base de datos MySQL

**Arquitectura del sistema**

El proyecto sigue una arquitectura **cliente-servidor**:

biblioteca/  
     api/                     \- Backend PHP (API REST \+ panel web)  
     biblioteca\_cliente/      \- Cliente de escritorio en Python

El cliente Python se comunica con la API mediante **peticiones HTTP** usando **JSON**.

##  **Funcionalidades principales**

###  **API PHP (XAMPP)**

* Login y registro de usuarios  
* CRUD de libros  
* Listado de usuarios  
* Registro de préstamos  
* Registro de devoluciones  
* Generación automática de códigos QR  
* Panel web para visualizar datos

###  **Cliente Python**

* Login conectado a la API  
* Visualización del catálogo  
* Búsqueda de libros  
* Registro de préstamos  
* Registro de devoluciones  
* Lectura de QR con webcam  
* Consulta automática de libros por QR

## **Tecnologías utilizadas**

### **Backend (API)**

* PHP 8  
* MySQL (XAMPP)  
* Composer  
* Librería PHP QRCode

### **Cliente**

* Python 3  
* Tkinter  
* Requests  
* OpenCV  
* Pyzbar

**Estructura del proyecto**

biblioteca/  
 api/  
      index.php  
      config.php  
      panel\_index.php  
      panel\_libros.php  
      panel\_usuarios.php  
      panel\_prestamos.php  
      phpqrcode/  
      qr/  
      vendor/

biblioteca\_cliente/  
       main.py  
       login.py  
       libros.py  
       prestamos.py  
       api.py  
       qr\_reader.py  
       consulta\_qr.py  
       insertar\_libros.py  
       insertar\_usuarios.py  
       estilos.py  
       test\_prestamos.py

## 

## **Base de datos**

Tablas mínimas:

* usuarios  
* libros  
* prestamos

Incluye campos como:

* Usuarios: nombre, email, password, tipo  
* Libros: título, autor, año, disponible, qr\_code  
* Préstamos: id\_usuario, id\_libro, fecha\_prestamo, fecha\_devolucion

# **Instalación y ejecución con XAMPP**

1. ## **Instalar XAMPP**

Descargar desde:  
 [https://www.apachefriends.org/](https://www.apachefriends.org/)

Activar:

* Apache  
* MySQL


2. ## **Colocar la API en htdocs**

Copiar la carpeta:

biblioteca/api

dentro de:

C:\\xampp\\htdocs\\biblioteca\\api\\

3. ## **Importar la base de datos**

1. Abrir phpMyAdmin  
2. Crear una BD llamada:  
   biblioteca  
3. Importar el archivo .sql del proyecto

## **4\. Configurar config.php**

Asegurarse de que coincide con XAMPP:

$host \= "localhost";  
$db   \= "biblioteca";  
$user \= "root";  
$pass \= "root";

## **5\. Probar la API**

Abrir en el navegador:

http://localhost/biblioteca/api/libros

Panel web:

http://localhost/biblioteca/api/panel\_index.php

# **Cómo ejecutar el cliente Python**

Desde la carpeta biblioteca\_cliente/:

pip install \-r requirements.txt  
python main.py

# **Autor:** 

Fatima Camila Jiménez Ccama  
