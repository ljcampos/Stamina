![alt text][logo]

[logo]: https://cdn4.iconfinder.com/data/icons/web-development/512/notebook_notepad_journal_book_report_guide_manual_flat_icon_symbol-512.png "Logo Title Text 2"

# Manuel de instalacion para la aplicacion Front-End
Este manual es una pequeña guia para la correcta instalacion del proyecto **Front-End**. Lo primero que necesitamos es instalar nuestro entorno de trabajo para despues instalar nuestras dependencias.

## 1.- Entorno de trabajo:

* Descargar e instalar **[nodejs](https://nodejs.org/en/)**
    * Verificar version de nodejs con el comando **node -v** desde terminal.
    * Verficar version de npm con el comando **npm -v** desde terminal.
* Instalar **[Bower](https://bower.io/#install-bower)**
    * Para instalar usar el comando **npm install -g bower** desde terminal.
    * Verificar la version de bower usando el comando **bower -v** desde terminal.
* Instalar **GIT**
    * Si no tienes **GIT** aun instalado es necesario que lo instales, puedes descargarlo desde aqui:https://git-scm.com/downloads. **De lo contrario omite este paso**.

## 2.- Crear Virtual Host en Xampp:
Para crear un **virtual host** en Xampp puedes guiarte del siguiente tutorial: https://styde.net/creando-virtual-hosts-con-apache-en-windows-para-wamp-o-xampp/

**NOTA:** SI no tienes el Xampp instalado lo puedes descargar desde aqui: https://www.apachefriends.org/es/index.html.

## 3.- Clonar repositorio del proyecto:
Para clonar el repositorio solo basta con hacer un **git clone git@github.com:ljcampos/Stamina.git**, usando el protocolo **ssh** si aun no tienes **git** enlazado con **github** puedes ver este tutorial: https://help.github.com/articles/generating-an-ssh-key/.

* Para manejar **GIT** puedes usar **GIT-Bash** puedes descargarlo desde aqui: https://git-for-windows.github.io/
* SmartGit es otra poderosa herramienta para gestionar GIT puedes descargarla desde aqui: http://www.syntevo.com/smartgit/download

**NOTA:** Es necesario que clones el proyecto dentro del httdocs del servidor xampp, la ruta seria algo como: **C://xampp/httdocs/**


## 4.- Instalar depedencias del proyecto con Bower
Por ultimo solo falta instalar las depencencias de **bower.json** del proyecto, para ello simplemente entra a tu carpeta desde terminal **(puedes usar gitbash para ello)**, la ruta seria algo como esto: **C://xampp/httdocs/Stamina** y ahi ejecutar el comando **bower install** para descargar e instalar todas las dependencias del proyecto. Por ultimo entra a tu dominio virtual creado en el paso **#2** y el proyecto debe estar corriendo.

**NOTA:** necesitas tener instalado **nodejs, npm y bower** para poder hacer esto, revisa el paso **#1**.

# Dudas o sugerencias Bienvenidas!!!
