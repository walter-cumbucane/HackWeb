from flask import Flask, render_template, request
import MySQLdb
import os

app = Flask(__name__)
host = os.getenv("host")
user = os.getenv("user")
passwrd = os.getenv("passwrd")
db = os.getenv("database") 


@app.route("/")
def index():
    return render_template("login.html")


@app.route("/login", methods=('POST'))
def login():
    username = request.form.get("username")
    password = request.form.get("password")
    try:    
        conn = MySQLdb.connect(host=host,
                           user=user,
                           passwd=passwrd,
                           db=db
                           )
        cursor = conn.cursor()
        sql = "SELECT * FROM Users WHERE username=%s AND password=%s"
    
    except Exception as e:
        print(e)
        return "Error in database connection"

    try:
        cursor.execute(sql, (username, password))
        row = cursor.fetchall()
        if len(row) > 0:
            return render_template("main.html", username=username)
        else:
            return "Password or Username Invalid"

    except Exception as e:
        print(e)
        return "Error in data fetching"



def main():
    app.run(host="0.0.0.0", debug=True)



if __name__ == "__main__":
    main()