const API_KEY = '21243630aaaa2b4a6f0ad9f4faecb9b3';

module.exports = function (app, https) {

    app.get('/flickr/search/:busqueda', function (req, res)
    {
        let url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&format=json&nojsoncallback=1&api_key='+ API_KEY + '&tags="' + req.params.busqueda + '"';
        
        https.get(url, (resp) => {
            let data = '';

            resp.on('data', (chunk) => {
                data += chunk;
            });

            resp.on('end', () => {
               res.send(data);
            });
        }).on("error", (err) => {
            console.log("Error: " + err.message);
        });
    });

    app.get('/flickr/search10/:busqueda', function (req, res)
    {
        let url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&per_page=10&format=json&nojsoncallback=1&api_key='+ API_KEY + '&text="' + req.params.busqueda + '"';
        console.log(url);
        https.get(url, (resp) => {
            let data = '';

            resp.on('data', (chunk) => {
                data += chunk;
            });

            resp.on('end', () => {
               res.send(data);
            });
        }).on("error", (err) => {
            console.log("Error: " + err.message);
        });
    });

    app.get('/flickr/searchAPP/', function (req, res)
    {
        let url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&per_page=10&format=json&nojsoncallback=1&api_key='+ API_KEY + '&tags="UMAIWEB2021A2"';
        console.log(url);
        https.get(url, (resp) => {
            let data = '';

            resp.on('data', (chunk) => {
                data += chunk;
            });

            resp.on('end', () => {
               res.send(data);
            });
        }).on("error", (err) => {
            console.log("Error: " + err.message);
        });
    });

}
