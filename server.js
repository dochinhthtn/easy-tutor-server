const axios = require('axios');
const server = require('http').createServer();
const io = require('socket.io')(server, {
    path: "/",
    cors: {
        origin: '*',
    }
});
const HOST = "http://127.0.0.1";
const PORT = 2021;

$users = {};
$guests = {};

io.on('connection', (socket) => {
    let token = socket.request.headers.authorization;
    getUserInfo(token);

    socket.on('disconnect', () => {
        console.log("User was left");
    });
});

server.listen(PORT, function () {
    console.log("Server started at port " + PORT);
});

async function getUserInfo(token) {
    try {
        
        let response = await axios.get(HOST + ":8000/api/user/", {
            headers: {
                "Authorization": token
            }
        });
        console.log(response.data);
    } catch (error) {
        console.log(error.message);
    }
}