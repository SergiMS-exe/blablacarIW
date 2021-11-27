module.exports = function (app, gestorBD) {
    
    app.get("/", function (req, res) {
        gestorBD.obtenerItem({}, 'usuarios', function (usuarios) {
            if (usuarios == null) {
                res.send({ Error: { status: 1, data: "Se ha producido un error al obtener la lista de usuarios, intentelo de nuevo más tarde" } })
            } else {
                res.send(usuarios);
            }
        });
    });

    app.post('/users/add', function (req, res) {
        //TODO hacer validador y encriptar la contraseña
        gestorBD.insertarItem(req.body, 'usuarios', function (usuario) {
            if (usuario == null) {
                console.log("WARN: Fallo al insertar un usuario. Email: " + req.body.email)
                res.send({ Error: { status: 1, data: "Se ha producido un error al insertar el usuario, intentelo de nuevo más tarde" } })
            }
            else {
                res.send({msg: 'Usuario añadido correctamente'})
            }
        });
    });

    app.get('/users/delete/:id', function (req, res) {
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.params.id)};
        gestorBD.eliminarItem(criterio, 'usuarios', function(result){
            if (result==null){
                res.send({ Error: { status: 1, data: "Se ha producido un error al borrar el usuario, intentelo de nuevo más tarde" } })
            }
            else {
                res.send({msg: 'Usuario eliminado correctamente'})
            }
        })
    });

    app.get('/users/edit/:id', function (req, res) {
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.params.id)};
        gestorBD.obtenerItem(criterio, 'usuarios', function(usuario){
            if(usuario==null){
                res.send({ Error: { status: 1, data: "Se ha producido un error inesperado, intentelo de nuevo más tarde" } })
            }
            else {
                res.send(usuario);
            }
        });        
    })
    
    app.post('/users/edit/:id', function (req, res) {
        let criterio = {"_id": gestorBD.mongo.ObjectID(req.params.id)};
        let nuevoUsuario = req.body;
        gestorBD.modificarItem(criterio, nuevoUsuario, 'usuarios', function(result){
            if (result==null)
                res.send({ Error: { status: 1, data: "Se ha producido un error al editar el usuario, intentelo de nuevo más tarde" } })
            else {
                res.send({msg: 'Usuario editado correctamente'})
            }
        })
    });

    app.get('/findUser', function(req, res){
        let query = req.query.namesurnameuser
        let criterio = { $or: [{'nombre': {$regex: ".*"+query+".*"}}, {'apellido': {$regex: ".*"+query+".*"}}]}
        gestorBD.obtenerItem(criterio, 'usuarios', function(usuarios) {
            if (usuarios == null) {
                res.send({ Error: { status: 1, data: "Se ha producido un error al obtener la lista de usuarios, intentelo de nuevo más tarde" } })
            } else {
                res.send(usuarios)
            }
        });
    });
}