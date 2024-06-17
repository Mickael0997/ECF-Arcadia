<!-- Le corp de la page --

body {
    background-color: #45a049;
}

header {
    background-image: url(../ASSETS/lionpandagorille.png);
    padding: 1em;
    display: flex;
    text-align: center;
}

main {
    color: #45a049;
}

.logo {
    width: 125px;
    height: 125px;
    text-align: left;
}   
   


header nav ul li {
    font-style: italic;
    font-size: x-large;
    display: inline;
    margin: 0 10px;
}

header nav ul li a {
    color: rgb(10, 10, 10);
    text-decoration: none;
}

.login-container, .modal-content {
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
}

.login-container h2, .modal-content h2 {
    margin-top: 0;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="email"], input[type="password"], input[type="text"], textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}



.error {
    color: red;
    margin-bottom: 10px;
}
