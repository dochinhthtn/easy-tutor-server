const config = require('./src/config/app');
const server = require('http').createServer();

const authHandler = require('./src/handlers/authHandler');

const io = require('socket.io')(server, {
    path: "/",
    cors: {
        origin: '*',
    }
});

io.of('/chat').on('connection', (socket) => {

    authHandler.authenticate(socket).then((currentUser) => {
        
        

    });

    socket.on('disconnect', () => {
        console.log("User was left");
    });
});

server.listen(config.ws_port, function () {
    console.log("Server started at port " + config.ws_port);
});
