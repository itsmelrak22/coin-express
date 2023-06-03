const express = require('express');
const app = express();
const port = 9090;
const fs = require('fs');
const https = require('https');

var options = {
  key: fs.readFileSync('/etc/httpd/conf/iconn.key'),
  cert: fs.readFileSync('/etc/httpd/conf/iconn.crt')
};

app.use(function(req, res, next) {

  const origins = [
    'https://iconntest.hrd-s.com/'
  ];
  for ( origin of origins ) {
    if (req.headers.referer){
    if ( req.headers.referer.indexOf(origin) > -1 ) {
      res.header("Access-Control-Allow-Origin", origin);
    }

  }
}


//  res.header("Access-Control-Allow-Origin", 'https://iconntest.hrd-s.com/');
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, application/json, Accept, x-client-key, x-client-token, x-client-secret, Authorization");
  res.header("Access-Control-Allow-Headers", "Content-Type");
  res.header("Access-Control-Allow-Credentials", "true");
  res.header("Access-Control-Allow-Methods", "PUT, GET, POST, DELETE, OPTIONS");
  next();
});


//const server = https.createServer(app, options);
const server = https.createServer( options,  app );

const io = require('socket.io').listen(server);
io.eio.pingTimeout = 120000;
io.eio.pingInterval = 50000;

server.listen(port, () => {
  console.log('Running on port#: ' + port);
});

/*io.on('connection', function(socket) {
          console.log("connected");
  // for display sharing...
  socket.on('chat-message', function(data) {
    socket.broadcast.emit('chat-message', data);
  });
*/

////

io.on('connection', function(socket) {

  console.log("con");
  
        socket.on('entered', function(data) {
              socket.on('disconnect', function() {
              });
        });
        socket.on('team_queue_update', function(data) {
            socket.emit('team_queue_update', data);
            console.log("team_queue_update", data);
          });

        socket.on('chat-message', function(data) {
              socket.broadcast.emit('chat-message', data);
              console.log("inoutboard_connected");
        });

        socket.on('cad_update', function(data){
            socket.broadcast.emit('cad_update', data);
            console.log("cadrequest");
        });

        socket.on('UpdateData', function(data){
          socket.broadcast.emit('UpdateData',data);
        });
      
        //////webrtc_server
        socket.on('message', function(message) { //? For Actual
                socket.broadcast.emit('message', message);
        });

        socket.on('henkou_local', function(data) {//? For Local 
          socket.broadcast.emit('henkou_local', data);
        });
        /////////////////////////////////////

        socket.on('chat message', function(msg) {
                io.emit('chat message', msg);
        });

        socket.on('newUpdate', function(data) {
            io.emit('updateReceived', data)
        }); 

        socket.on('newPrOrderUpdate', function(data) {
          io.emit('updatePrOrderReceived', data)
        });

        /// plan schedule
        socket.on('planSchedUpdate', function(data){
          io.emit('planSchedUpdate', data)
        });

        socket.on('iconnDriveReload', function(data){
          io.emit('reloadData', data)
        });

});
