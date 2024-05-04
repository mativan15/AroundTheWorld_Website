from flask import Flask, render_template,request,redirect, url_for
import mysql.connector


mydb = mysql.connector.connect(
    host = "localhost",
    user = "root",
    port = 3306,
    password= "",
    database ="DB proyecto final",
)

myCursor = mydb.cursor()

app = Flask(__name__)

app.static_folder = 'Static'

@app.route('/')  
def landing():
    username = request.cookies.get('username', 'Invitado') 
    return render_template('landing.html', username=username)

def login():
    return render_template('login.php')


@app.route('/recibir_datos', methods=["POST"]) 
def Recibir_datos():
    if request.method == "POST":
        name = request.form['nombre']
        email = request.form['email']
        region = request.form['region']
        contacto = request.form['contacto']
        intereses = request.form['intereses']
        mensaje = request.form['mensaje']
        query = f"INSERT INTO contacto (nombre, email, region, contacto, intereses, mensaje) VALUES('{name}','{email}','{region}','{contacto}','{intereses}','{mensaje}')"
        myCursor.execute(query)
        mydb.commit()
        return redirect(url_for('landing'))
    else:
        return "Todo mal"

if __name__=="__main__":
    app.run(debug=True) #----------------------genera un servidor local