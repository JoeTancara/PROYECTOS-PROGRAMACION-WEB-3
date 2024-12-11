from flask import Flask, render_template, request, redirect, url_for
from flask_mysqldb import MySQL

app = Flask(__name__)

# Configuración de la base de datos
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'automotriz'

mysql = MySQL(app)

# -------------------------------
# Ruta principal
# -------------------------------
@app.route('/')
def home():
    return render_template('base.html', active='home')

# -------------------------------
# CRUD para Clientes
# -------------------------------
@app.route('/clientes')
def clientes():
    cur = mysql.connection.cursor()
    cur.execute("SELECT id, nombre, telefono FROM clientes")
    clientes = cur.fetchall()
    cur.close()
    return render_template('clientes.html', active='clientes', clientes=clientes)

@app.route('/clientes/agregar', methods=['POST'])
def agregar_cliente():
    nombre = request.form['nombre']
    telefono = request.form['telefono']
    cur = mysql.connection.cursor()
    cur.execute("INSERT INTO clientes (nombre, telefono) VALUES (%s, %s)", (nombre, telefono))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('clientes'))


@app.route('/clientes/editar/<int:id>', methods=['POST'])
def editar_cliente(id):
    nombre = request.form['nombre']
    telefono = request.form['telefono']
    cur = mysql.connection.cursor()
    cur.execute("UPDATE clientes SET nombre = %s, telefono = %s WHERE id = %s", (nombre, telefono, id))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('clientes'))

@app.route('/clientes/eliminar/<int:id>', methods=['POST'])
def eliminar_cliente(id):
    cur = mysql.connection.cursor()
    cur.execute("DELETE FROM clientes WHERE id = %s", (id,))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('clientes'))



# -------------------------------
# CRUD para Tipos de Reparación
# -------------------------------
@app.route('/tipos_reparacion')
def tipos_reparacion():
    cur = mysql.connection.cursor()
    cur.execute("SELECT id, nombre FROM tiposreparacion")
    tipos = cur.fetchall()
    cur.close()
    return render_template('tipos_reparacion.html', active='tipos_reparacion', tipos=tipos)

@app.route('/tipos_reparacion/agregar', methods=['POST'])
def agregar_tipo_reparacion():
    nombre = request.form['nombre']
    cur = mysql.connection.cursor()
    cur.execute("INSERT INTO tiposreparacion (nombre) VALUES (%s)", (nombre,))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('tipos_reparacion'))


@app.route('/tipos_reparacion/editar/<int:id>', methods=['POST'])
def editar_tipo_reparacion(id):
    nombre = request.form['nombre']
    cur = mysql.connection.cursor()
    cur.execute("UPDATE tiposreparacion SET nombre = %s WHERE id = %s", (nombre, id))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('tipos_reparacion'))


@app.route('/tipos_reparacion/eliminar/<int:id>', methods=['POST'])
def eliminar_tipo_reparacion(id):
    cur = mysql.connection.cursor()
    cur.execute("DELETE FROM tiposreparacion WHERE id = %s", (id,))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('tipos_reparacion'))

# -------------------------------
# CRUD para VEHICULOS
# -------------------------------
@app.route('/vehiculos')
def vehiculos():
    cur = mysql.connection.cursor()
    # Obtener vehículos con el nombre del cliente
    cur.execute("""
        SELECT vehiculos.id, vehiculos.matricula, vehiculos.marca, vehiculos.modelo, clientes.nombre
        FROM vehiculos
        INNER JOIN clientes ON vehiculos.cliente_id = clientes.id
    """)
    vehiculos = cur.fetchall()

    # Obtener lista de clientes para los selects
    cur.execute("SELECT id, nombre FROM clientes")
    clientes = cur.fetchall()
    cur.close()

    return render_template('vehiculos.html', active='vehiculos', vehiculos=vehiculos, clientes=clientes)



@app.route('/vehiculos/agregar', methods=['POST'])
def agregar_vehiculo():
    matricula = request.form['matricula']
    marca = request.form['marca']
    modelo = request.form['modelo']
    cliente_id = request.form['cliente_id']
    cur = mysql.connection.cursor()
    cur.execute("INSERT INTO vehiculos (matricula, marca, modelo, cliente_id) VALUES (%s, %s, %s, %s)", 
                (matricula, marca, modelo, cliente_id))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('vehiculos'))

@app.route('/vehiculos/editar/<int:id>', methods=['POST'])
def editar_vehiculo(id):
    matricula = request.form['matricula']
    marca = request.form['marca']
    modelo = request.form['modelo']
    cliente_id = request.form['cliente_id']
    cur = mysql.connection.cursor()
    cur.execute("""
        UPDATE vehiculos
        SET matricula = %s, marca = %s, modelo = %s, cliente_id = %s
        WHERE id = %s
    """, (matricula, marca, modelo, cliente_id, id))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('vehiculos'))


@app.route('/vehiculos/eliminar/<int:id>', methods=['POST'])
def eliminar_vehiculo(id):
    cur = mysql.connection.cursor()
    cur.execute("DELETE FROM vehiculos WHERE id = %s", (id,))
    mysql.connection.commit()
    cur.close()
    return redirect(url_for('vehiculos'))

# -------------------------------
# CRUD para Reparaciones
# -------------------------------
@app.route('/reparaciones')
def reparaciones():
    cur = mysql.connection.cursor()
    cur.execute("""
        SELECT reparaciones.id, reparaciones.fecha, reparaciones.costo, reparaciones.descripcion,
               vehiculos.matricula, vehiculos.id
        FROM reparaciones
        INNER JOIN vehiculos ON reparaciones.vehiculo_id = vehiculos.id
    """)
    reparaciones = cur.fetchall()  # Esto debe obtener todos los registros correctamente

    cur.execute("SELECT id, matricula FROM vehiculos")
    vehiculos = cur.fetchall()
    cur.close()

    return render_template('reparaciones.html', active='reparaciones', reparaciones=reparaciones, vehiculos=vehiculos)



@app.route('/reparaciones/agregar', methods=['POST'])
def agregar_reparacion():
    try:
        # Imprime los datos enviados para depuración
        print(request.form)

        fecha = request.form['fecha']
        costo = request.form['costo']
        descripcion = request.form['descripcion']
        vehiculo_id = request.form['vehiculo_id']

        cur = mysql.connection.cursor()
        cur.execute("""
            INSERT INTO reparaciones (fecha, costo, descripcion, vehiculo_id)
            VALUES (%s, %s, %s, %s)
        """, (fecha, costo, descripcion, vehiculo_id))
        mysql.connection.commit()
        cur.close()
    except Exception as e:
        print(f"Error al agregar reparación: {e}")
    return redirect(url_for('reparaciones'))



@app.route('/reparaciones/editar/<int:id>', methods=['POST'])
def editar_reparacion(id):
    fecha = request.form['fecha']
    costo = request.form['costo']
    descripcion = request.form['descripcion']
    vehiculo_id = request.form['vehiculo_id']
    cur = mysql.connection.cursor()
    try:
        cur.execute("""
            UPDATE reparaciones
            SET fecha = %s, costo = %s, descripcion = %s, vehiculo_id = %s
            WHERE id = %s
        """, (fecha, costo, descripcion, vehiculo_id, id))
        mysql.connection.commit()
    except Exception as e:
        print(f"Error al editar reparación: {e}")
    cur.close()
    return redirect(url_for('reparaciones'))

@app.route('/reparaciones/eliminar/<int:id>', methods=['POST'])
def eliminar_reparacion(id):
    cur = mysql.connection.cursor()
    try:
        cur.execute("DELETE FROM reparaciones WHERE id = %s", (id,))
        mysql.connection.commit()
    except Exception as e:
        print(f"Error al eliminar reparación: {e}")
    cur.close()
    return redirect(url_for('reparaciones'))