const express = require('express');
const router = express.Router();

// Modelos
const Usuario = require('../models/usuarios');
const Viaje = require('../models/viajes');

router.get('/', async(req, res) => {
    const usuarios = await Usuario.find();
    res.render('index.html', {usuarios, title: 'CRUD de usuarios'}); // Accede a src/viwes y busca index.html
});

router.post('/add', async (req, res) => {
    const usuario = new Usuario(req.body); // Añade los datos de la petición en el objeto usuario, y le añade el _id de MongoDB

    await usuario.save();
    res.redirect('/');
});

router.get('/delete/:id', async (req, res) => {
    const { id } = req.params; // Es lo mismo que hacer const id = req.params.id -> Usamos deconstrucción por buena práctica
    await Usuario.deleteOne({_id: id});
    
    res.redirect('/');
});

router.get('/edit/:id', async (req, res) => {
    const { id } = req.params;
    const usuario = await Usuario.findById(id);

    res.render('edit.html', {usuario});
})

router.post('/edit/:id', async (req, res) => {
    const { id } = req.params;
    await Usuario.updateOne({_id: id}, req.body);

    res.redirect('/');
});


// Viajes de un pasajero
router.get('/viajespasajero/:id', async (req, res) => {
    const { id } = req.params;
    const usuario = await Usuario.findById(id);
    let query = {"pasajeros": usuario._id};
    const viajes = await Viaje.find(query);

    res.render('viajespasajero.html', {usuario, viajes, title: 'Viajes de pasajero'});
})

// Todos los viajes (TODO: Se podrán hacer busquedas sobre ellos)
router.get('/listaviajes', async (req, res) => {
    const viajes = await Viaje.find();
    
    res.render('listaviajes.html', {viajes, title: 'Lista de Viajes'})
})

//Viajes con el id de un conductor concreto
router.get('/viajesconductor/:id', async (req,res) => {
    const { id } = req.params;
    const usuario = await Usuario.findById(id);
    let query = {"id_conductor": usuario._id}
    const viajes = await Viaje.find(query);

    res.render('viajesconductor.html', {usuario, viajes, title: "Viajes con un conductor concreto"})
})

module.exports = router;