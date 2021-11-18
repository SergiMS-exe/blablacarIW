module.exports = function (app, gestorBD) {

    // Viajes de un pasajero
    app.get('/viajespasajero/:id', function (req, res) {
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.params.id)};
        gestorBD.obtenerItem(criterio, 'usuarios', function(resultUser) {
            if (resultUser==null)
                res.send({ Error: { status: 1, data: "Se ha producido un error al obtener el usuario, intentelo de nuevo más tarde" } })
            else {
                let query = { "pasajeros": gestorBD.mongo.ObjectID(req.params.id) };
                gestorBD.obtenerItem(query, 'viajes', function(resultTravel){
                    if (resultTravel==null)
                        res.send({ Error: { status: 1, data: "Se ha producido un error al obtener los viajes del usuario, intentelo de nuevo más tarde" } })
                    else
                    res.render('viajespasajero.html', { resultUser, resultTravel, title: 'Viajes de pasajero' });
                });
            } 
        })
    })

    // Todos los viajes (TODO: Se podrán hacer busquedas sobre ellos)
    app.get('/listaviajes', function (req, res) {
        gestorBD.obtenerItem({}, 'viajes', function(viajes) {
            if (viajes==null)
                res.send({ Error: { status: 1, data: "Se ha producido un error al obtener los viajes, intentelo de nuevo más tarde" } })
            else {
                res.render('listaviajes.html', { viajes, title: 'Lista de Viajes' })        
            } 
        })
        
    })

    //Viajes con el id de un conductor concreto
    app.get('/viajesconductor/:id', function (req, res) {
        gestorBD.obtenerItem(criterio, 'usuarios', function(resultUser) {
            if (resultUser==null)
                res.send({ Error: { status: 1, data: "Se ha producido un error al obtener el conductor, intentelo de nuevo más tarde" } })
            else {
                let query = { "id_conductor": usuario._id };
                gestorBD.obtenerItem(query, 'viajes', function(resultTravel){
                    if (resultTravel==null)
                        res.send({ Error: { status: 1, data: "Se ha producido un error al obtener los viajes del conductor, intentelo de nuevo más tarde" } })
                    else
                    res.render('viajesconductor.html', { usuario, viajes, title: "Viajes con un conductor concreto" })
                });
            } 
        })
        
    })
}