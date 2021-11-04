const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const ViajeSchema = new Schema({
    origen: String,
    destino: String,
    fecha: Date,
    id_conductor: Schema.Types.ObjectId,
    pasajeros: [Schema.Types.ObjectId]
});

module.exports = mongoose.model('viajes', ViajeSchema);