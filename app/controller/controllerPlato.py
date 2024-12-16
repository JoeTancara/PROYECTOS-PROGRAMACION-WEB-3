from random import sample
from conexionBD import *  # Importando conexión BD

# Creando una función para obtener la lista de platos.
def listaPlatos():
    conexion_MySQLdb = connectionBD()  # Creando mi instancia a la conexión de BD
    cur = conexion_MySQLdb.cursor(dictionary=True)

    querySQL = "SELECT * FROM platos ORDER BY id DESC"
    cur.execute(querySQL)
    resultadoBusqueda = cur.fetchall()  # fetchall() Obtener todos los registros
    totalBusqueda = len(resultadoBusqueda)  # Total de búsqueda

    cur.close()  # Cerrando conexión SQL
    conexion_MySQLdb.close()  # Cerrando conexión de la BD
    return resultadoBusqueda


def updatePlato(id=''):
    conexion_MySQLdb = connectionBD()
    cursor = conexion_MySQLdb.cursor(dictionary=True)

    cursor.execute("SELECT * FROM platos WHERE id = %s LIMIT 1", [id])
    resultQueryData = cursor.fetchone()  # Devolviendo solo 1 registro
    return resultQueryData


def registrarPlato(nombre='', procedencia='', receta='', nuevoNombreFile=''):
    conexion_MySQLdb = connectionBD()
    cursor = conexion_MySQLdb.cursor(dictionary=True)

    sql = ("INSERT INTO platos(nombre, procedencia, receta, foto) VALUES (%s, %s, %s, %s)")
    valores = (nombre, procedencia, receta, nuevoNombreFile)
    cursor.execute(sql, valores)
    conexion_MySQLdb.commit()
    cursor.close()  # Cerrando conexión SQL
    conexion_MySQLdb.close()  # Cerrando conexión de la BD

    resultado_insert = cursor.rowcount  # Retorna 1 o 0
    ultimo_id = cursor.lastrowid  # Retorna el id del último registro
    return resultado_insert


def detallesdelPlato(idPlato):
    conexion_MySQLdb = connectionBD()
    cursor = conexion_MySQLdb.cursor(dictionary=True)

    cursor.execute("SELECT * FROM platos WHERE id ='%s'" % (idPlato,))
    resultadoQuery = cursor.fetchone()
    cursor.close()  # Cerrando conexión de la consulta SQL
    conexion_MySQLdb.close()  # Cerrando conexión de la BD

    return resultadoQuery


def recibeActualizarPlato(nombre, procedencia, receta, nuevoNombreFile, idPlato):
    conexion_MySQLdb = connectionBD()
    cur = conexion_MySQLdb.cursor(dictionary=True)
    cur.execute("""
        UPDATE platos
        SET 
            nombre      = %s,
            procedencia = %s,
            receta      = %s,
            foto        = %s
        WHERE id=%s
        """, (nombre, procedencia, receta, nuevoNombreFile, idPlato))
    conexion_MySQLdb.commit()

    cur.close()  # Cerrando conexión de la consulta SQL
    conexion_MySQLdb.close()  # Cerrando conexión de la BD
    resultado_update = cur.rowcount  # Retorna 1 o 0
    return resultado_update


# Crear un string aleatorio para renombrar la foto 
# y evitar que exista una foto con el mismo nombre
def stringAleatorio():
    string_aleatorio = "0123456789abcdefghijklmnopqrstuvwxyz_"
    longitud = 20
    secuencia = string_aleatorio.upper()
    resultado_aleatorio = sample(secuencia, longitud)
    string_aleatorio = "".join(resultado_aleatorio)
    return string_aleatorio
