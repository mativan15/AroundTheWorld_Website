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

#cambioo:
@app.route('/')
def index():
    return redirect(url_for('landing'))
#cambioo:
@app.route('/landing')
def landing():
    user_id = request.args.get('user_id', '')
    user_data = fetch_user_data(user_id)
    return render_template('landing.html', user_data=user_data)

def fetch_user_data(user_id):
    myCursor = mydb.cursor()
    query = "SELECT * FROM usuarios WHERE id = %s"

    myCursor.execute(query, (user_id,))

    user_data = myCursor.fetchone()
    myCursor.close()

    return user_data


"""@app.route('/')  
def landing():
    username = request.args.get('username', '')
    return render_template('landing.html', username=username)"""

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