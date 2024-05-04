from flask import Flask, render_template,request,redirect, url_for #-----renderizar codigo html
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

@app.route('/')  #-----------------------------decorador, navegar en secciones del sitio
def inicio():
    return render_template('index.html', name ="juan")

@app.route('/contacto') 
def Contacto():
    return render_template('contact.html')

@app.route('/recibir_datos', methods=["POST"]) 
def Recibir_datos():
    if request.method == "POST":
        name = request.form['nombre']
        email = request.form['email']
        region = request.form['region']
        contacto = request.form['contacto']
        intereses = request.form['intereses']
        mensaje = request.form['mensaje']
        query = f"INSERT INTO contactos (nombre, email, region, contacto, intereses, mensaje) VALUES('{name}','{email}','{region}','{contacto}','{intereses}','{mensaje}')"
        myCursor.execute(query)
        mydb.commit()
        return redirect(url_for('inicio'))
    else:
        return "Todo mal"

@app.route('/about') 

def About():
    return render_template('about_us.html')

if __name__=="__main__":
    app.run(debug=True) #----------------------genera un servidor local