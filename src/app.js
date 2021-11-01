const express = require('express');
const app = express();

const morgan = require('morgan');
const path = require('path');

const mongoose = require('mongoose');

//DB
mongoose.connect('mongodb+srv://root:root@init.xrhm0.mongodb.net/init?retryWrites=true&w=majority');

// Settings
app.set('port', 3000);
app.engine('html', require('ejs').renderFile); // Para que los archivos HTML los interprete como EJS
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views')); // Para definir la ruta de las vistas

// Middlewares
app.use(morgan('dev'));
app.use(express.urlencoded({extended: false})); // Para que lo que se nos envíe desde el cliente sea JSON

// Routes
app.use(require('./routes/')); // Requiere index por defecto

// Listening the server
app.listen(app.get('port'), () => {
    console.log(`Server on port ${app.get('port')}`)
});