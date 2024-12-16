from flask import Flask, render_template, request, redirect, url_for, jsonify
from controller.controllerPlato import *

# Para subir archivo tipo foto al servidor
import os
from werkzeug.utils import secure_filename 

# Declarando nombre de la aplicación e inicializando, crear la aplicación Flask
app = Flask(__name__)
application = app

msg = ''
tipo = ''

# Creando mi decorador para el home, el cual retornará la Lista de Platos
@app.route('/', methods=['GET', 'POST'])
def inicio():
    return render_template('public/layout.html', miData=listaPlatos())

# RUTAS
@app.route('/registrar-plato', methods=['GET', 'POST'])
def addPlato():
    return render_template('public/acciones/add.html')

# Registrando nuevo plato
@app.route('/plato', methods=['POST'])
def formAddPlato():
    if request.method == 'POST':
        nombre = request.form['nombre']
        procedencia = request.form['procedencia']
        receta = request.form['receta']

        if request.files['foto']:
            file = request.files['foto']  # recibiendo el archivo
            nuevoNombreFile = recibeFoto(file)  # Llamado la función que procesa la imagen
            resultData = registrarPlato(nombre, procedencia, receta, nuevoNombreFile)
            if resultData == 1:
                return render_template('public/layout.html', miData=listaPlatos(), msg='El Registro fue un éxito', tipo=1)
            else:
                return render_template('public/layout.html', msg='No se pudo registrar el plato', tipo=1)
        else:
            return render_template('public/layout.html', msg='Debe cargar una foto', tipo=1)

@app.route('/form-update-plato/<string:id>', methods=['GET', 'POST'])
def formViewUpdate(id):
    if request.method == 'GET':
        resultData = updatePlato(id)
        if resultData:
            return render_template('public/acciones/update.html', dataInfo=resultData)
        else:
            return render_template('public/layout.html', miData=listaPlatos(), msg='No existe el plato', tipo=1)
    else:
        return render_template('public/layout.html', miData=listaPlatos(), msg='Método HTTP incorrecto', tipo=1)

@app.route('/ver-detalles-del-plato/<int:idPlato>', methods=['GET', 'POST'])
def viewDetallePlato(idPlato):
    if request.method == 'GET':
        resultData = detallesdelPlato(idPlato)  # Función que almacena los detalles del plato

        if resultData:
            return render_template('public/acciones/view.html', infoPlato=resultData, msg='Detalles del Plato', tipo=1)
        else:
            return render_template('public/layout.html', msg='No existe el plato', tipo=1)
    return redirect(url_for('inicio'))

@app.route('/actualizar-plato/<string:idPlato>', methods=['POST'])
def formActualizarPlato(idPlato):
    if request.method == 'POST':
        nombre = request.form['nombre']
        procedencia = request.form['procedencia']
        receta = request.form['receta']

        # Script para recibir el archivo (foto)
        if request.files['foto']:
            file = request.files['foto']
            fotoForm = recibeFoto(file)
            resultData = recibeActualizarPlato(nombre, procedencia, receta, fotoForm, idPlato)
        else:
            fotoPlato = 'sin_foto.jpg'
            resultData = recibeActualizarPlato(nombre, procedencia, receta, fotoPlato, idPlato)

        if resultData == 1:
            return render_template('public/layout.html', miData=listaPlatos(), msg='Datos del plato actualizados', tipo=1)
        else:
            return render_template('public/layout.html', miData=listaPlatos(), msg='No se pudo actualizar', tipo=1)

# Eliminar plato
@app.route('/borrar-plato', methods=['POST'])
def formViewBorrarPlato():
    if request.method == 'POST':
        idPlato = request.form['id']
        nombreFoto = request.form['nombreFoto']
        resultData = eliminarPlato(idPlato, nombreFoto)

        if resultData == 1:
            return jsonify([1])
        else:
            return jsonify([0])


def eliminarPlato(idPlato='', nombreFoto=''):
    conexion_MySQLdb = connectionBD()  # Hago instancia a mi conexión desde la función
    cur = conexion_MySQLdb.cursor(dictionary=True)

    cur.execute('DELETE FROM platos WHERE id=%s', (idPlato,))
    conexion_MySQLdb.commit()
    resultado_eliminar = cur.rowcount  # retorna 1 o 0

    basepath = os.path.dirname(__file__)
    url_File = os.path.join(basepath, 'static/assets/fotos_platos', nombreFoto)
    os.remove(url_File)  # Borrar foto desde la carpeta

    return resultado_eliminar


def recibeFoto(file):
    basepath = os.path.dirname(__file__)  # La ruta donde se encuentra el archivo actual
    filename = secure_filename(file.filename)  # Nombre original del archivo

    # Capturando extensión del archivo ejemplo: (.png, .jpg, .pdf ...etc)
    extension = os.path.splitext(filename)[1]
    nuevoNombreFile = stringAleatorio() + extension

    upload_path = os.path.join(basepath, 'static/assets/fotos_platos', nuevoNombreFile)
    file.save(upload_path)

    return nuevoNombreFile

# Redireccionando cuando la página no existe
@app.errorhandler(404)
def not_found(error):
    return redirect(url_for('inicio'))

if __name__ == "__main__":
    app.run(debug=True, port=8000)