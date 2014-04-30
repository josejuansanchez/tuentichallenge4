#!/usr/bin/env node

if ((process.version.split('.')[1]|0) < 10) {
	console.log('Please, upgrade your node version to 0.10+');
	process.exit();
}

var net = require('net');
var util = require('util');
var crypto = require('crypto');

var options = {
	'port': 6969,
	'host': '54.83.207.90',
}

const KEYPHRASE = 'MacaroniAndCheeseTightBeaverIsFrequent';

var client_dh, client_prime, client_publicKey, client_keyphrase;
var server_secret, server_dh, server_secret, server_keyphrase;

var socket = net.connect(options, function() {});

socket.on('data', function(data) {

	data_header = data.toString().trim().split(':');
	data_body = data_header[1].toString().trim().split('|');

	if (data_header[0] == 'CLIENT->SERVER' && data_body[0] == 'hello?') {
		socket.write(data_body[0]);
	} else if (data_header[0] == 'SERVER->CLIENT' && data_body[0] == 'hello!') {
		socket.write(data_body[0]);
	} else if (data_header[0] == 'CLIENT->SERVER' && data_body[0] == 'key') {
		// Store the values sended by the client
		client_prime = data_body[1];
		client_publicKey = data_body[2];

		// Send the fake message to the server
		server_dh = crypto.createDiffieHellman(256);
		server_dh.generateKeys();		
		socket.write(util.format('key|%s|%s\n', server_dh.getPrime('hex'), server_dh.getPublicKey('hex')));

	} else if (data_header[0] == 'SERVER->CLIENT' && data_body[0] == 'key') {
		// Store the values sended by the server
		server_secret = server_dh.computeSecret(data_body[1], 'hex');
		var cipher = crypto.createCipheriv('aes-256-ecb', server_secret, '');
		server_keyphrase = cipher.update(KEYPHRASE, 'utf8', 'hex') + cipher.final('hex');

		// Send the fake response to the client
		client_dh = crypto.createDiffieHellman(client_prime, 'hex');
		client_dh.generateKeys();
		client_secret = client_dh.computeSecret(client_publicKey, 'hex');
		socket.write(util.format('key|%s\n', client_dh.getPublicKey('hex')));

	} else if (data_header[0] == 'CLIENT->SERVER' && data_body[0] == 'keyphrase') {
		// Store the values from the client
		client_keyphrase = data_body[1];

		// Send the fake response to the server
		socket.write(util.format('keyphrase|%s\n', server_keyphrase));
	} else if (data_header[0] == 'SERVER->CLIENT' && data_body[0] == 'result') {
		var decipher = crypto.createDecipheriv('aes-256-ecb', server_secret, '');
		var message = decipher.update(data_body[1], 'hex', 'utf8') + decipher.final('utf8');
		console.log(message);
		socket.end();
	}
});