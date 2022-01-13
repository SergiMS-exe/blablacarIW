const { query } = require("express");

module.exports = function (app, gestorBD) {
    
    app.get('/conversacion/:id1/id2'), function(req, res) {
        
        let criterio = {"participantes": req.params.id1};
        gestorBD.obtenerItem(criterio, 'conversaciones', function(resultConversation)
        {
            if (resultConversation==null)
                res.send({ Error: { status: 500, data: "Se ha producido un error al obtener las conversaciones, intentelo de nuevo más tarde" } })
            else {
                res.send({status: 200, data: {conversaciones: resultConversation}});
            }
        })
    }

    app.get('/conversaciones/:id', function (req, res) {
        let criterio = {"participantes": req.params.id };
        gestorBD.obtenerItem(criterio, 'conversaciones', function(resultConversation) {
            if (resultConversation==null)
                res.send({ Error: { status: 500, data: "Se ha producido un error al obtener las conversaciones, intentelo de nuevo más tarde" } })
            else {
                var usuarios = [];
                resultConversation.forEach(function(conversacion) {
                    console.log(conversacion.participantes[0]);
                    console.log(req.params.id);
                    if (conversacion.participantes[0] == req.params.id)
                        usuarios.push(conversacion.participantes[1]);
                    else {
                        usuarios.push(conversacion.participantes[0]);
                    }
                });
                var usuarios_objectsids = usuarios.map(function(user) { return gestorBD.mongo.ObjectID(user)})
                
                let query = { "_id": {$in: usuarios_objectsids }};
                gestorBD.obtenerItem(query, 'usuarios', function(resultUsers){
                    if (resultUsers==null)
                        res.send({ Error: { status: 500, data: "Se ha producido un error al obtener los viajes del usuario, intentelo de nuevo más tarde" } })
                    else
                        res.send({status: 200, data: {usuarios: resultUsers}});
                });
            } 
        })
    })

    app.get("/", function (req, res) {
        gestorBD.obtenerItem({}, 'conversaciones', function (conversaciones) {
            if (conversaciones == null) {
                res.send({ Error: { status: 500, data: "Se ha producido un error al obtener la lista de conversaciones, intentelo de nuevo más tarde" } })
            } else {
                res.send({status: 200, data: {conversaciones: conversaciones}});
            }
        });
    });

    app.post('/conversations/add', function (req, res) {
        //TODO hacer validador y encriptar la contraseña
        gestorBD.insertarItem(req.body, 'conversacion', function (conversacion) {
            if (conversacion == null) {
                console.log("WARN: Fallo al insertar un conversacion. Email: " + req.body.email)
                res.send({ Error: { status: 500, data: "Se ha producido un error al insertar el conversacion, intentelo de nuevo más tarde" } })
            }
            else {
                res.send({status: 200, data: {msg: 'conversacion añadido correctamente'}})
            }
        });
    });

    app.delete('conversations/delete', function (req, res) {
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.body.id)};
        gestorBD.eliminarItem(criterio, 'conversaciones', function(result){
            if (result==null){
                res.send({ Error: { status: 500, data: "Se ha producido un error al borrar el conversacion, intentelo de nuevo más tarde" } })
            }
            else {
                res.send({status: 200, data: {msg: 'conversacion eliminado correctamente'}})
            }
        })
    });

    app.get('/conversations/edit/:id', function (req, res) {
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.params.id)};
        gestorBD.obtenerItem(criterio, 'conversaciones', function(conversacion){
            if(conversacion==null){
                res.send({ Error: { status: 500, data: "Se ha producido un error inesperado, intentelo de nuevo más tarde" } })
            }
            else {
                res.send({status: 200, data: {conversacion: conversacion}})            }
        });        
    })
    
    app.put('/conversations/edit/:id', function (req, res) {
        console.log(req.body);
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.params.id)};
        let nuevoMensaje = req.body;
        gestorBD.modificarItem(criterio, nuevoMensaje, 'conversacion', function(result){
            if (result==null)
                res.send({ Error: { status: 500, data: "Se ha producido un error al editar el conversacion, intentelo de nuevo más tarde" } })
            else {
                res.send({status: 200, data: {msg: 'conversacion editado correctamente'}})
            }
        })
    });

}