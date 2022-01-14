const { query } = require("express");

module.exports = function (app, gestorBD) {
    
    app.get('/conversacion', function(req, res) {
        
        let criterio = {$and: [{"participantes": req.query.id1}, {"participantes": req.query.id2}]};
        
        gestorBD.obtenerItem(criterio, 'conversaciones', function(resultConversation)
        {
            if (resultConversation==null)
                res.send({ Error: { status: 500, data: "Se ha producido un error al obtener la conversacion, intentelo de nuevo más tarde" } })
            else {
                console.log(resultConversation[0]._id);
                var string = "" + resultConversation[0]._id;
                //res.send({status: 200, data: {conversacion: resultConversation}});
                let criterio2 = {"conversacion": string}
                

                gestorBD.obtenerItem(criterio2, 'mensajes', function(resultMensajes)
                {
                    if (resultMensajes==null)
                    res.send({ Error: { status: 500, data: "Se ha producido un error al obtener los mensajes, intentelo de nuevo más tarde" } })
                    else {
                        let criterio3 = {$or: [ {"_id": gestorBD.mongo.ObjectID(req.query.id1)}, {"_id": gestorBD.mongo.ObjectID(req.query.id2)}]}
                        gestorBD.obtenerItem(criterio3, 'usuarios' , function(resultUsers)
                        {
                            if (resultUsers==null)
                            res.send({ Error: { status: 500, data: "Se ha producido un error al obtener los usuarios, intentelo de nuevo más tarde" } })
                        else
                            res.send({status: 200, data: {conversacion: resultConversation, mensajes: resultMensajes, usuarios: resultUsers}});
                        })
                    }
                })
            }
        })
    })

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
                    {
                        usuarios.push(conversacion.participantes[1]);
                        console.log("uwu");
                    }
                    else {
                        usuarios.push(conversacion.participantes[0]);
                        console.log("ewe");
                        
                    
                    }
                });
                var usuarios_objectsids = usuarios.map(function(user) { return gestorBD.mongo.ObjectID(user)})
                console.log(usuarios_objectsids);

                let query = { "_id": {$in: usuarios_objectsids }};
                gestorBD.obtenerItem(query, 'usuarios', function(resultUsers){
                    if (resultUsers==null)
                        res.send({ Error: { status: 500, data: "Se ha producido un error al obtener los usuarios, intentelo de nuevo más tarde" } })
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
        gestorBD.insertarItem(req.body, 'conversaciones', function (conversacion) {
            if (conversacion == null) {
                console.log("WARN: Fallo al insertar un conversacion. Email: " + req.body.email)
                res.send({ Error: { status: 500, data: "Se ha producido un error al insertar la conversacion, intentelo de nuevo más tarde" } })
            }
            else {
                console.log(req.body);
                res.send({status: 200, data: {msg: 'conversacion añadida correctamente'}})
            }
        });
    });

    app.delete('conversations/delete', function (req, res) {
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.body.id)};
        gestorBD.eliminarItem(criterio, 'conversaciones', function(result){
            if (result==null){
                res.send({ Error: { status: 500, data: "Se ha producido un error al borrar la conversacion, intentelo de nuevo más tarde" } })
            }
            else {
                res.send({status: 200, data: {msg: 'conversacion eliminada correctamente'}})
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
        gestorBD.modificarItem(criterio, nuevoMensaje, 'conversaciones', function(result){
            if (result==null)
                res.send({ Error: { status: 500, data: "Se ha producido un error al editar la conversacion, intentelo de nuevo más tarde" } })
            else {
                res.send({status: 200, data: {msg: 'conversacion editada correctamente'}})
            }
        })
    });

}