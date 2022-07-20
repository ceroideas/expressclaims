var FancyWebSocket = function(url)
{
	var callbacks = {};
	var ws_url = url;
	var conn;

	this.bind = function(event_name, callback){
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;// chainable
	};

	this.send = function(event_name, event_data){
		this.conn.send( event_data );
		return this;
	};

	this.connect = function() {
		if ( typeof(MozWebSocket) == 'function' )
			this.conn = new MozWebSocket(url);
		else
			this.conn = new WebSocket(url);

		// dispatch to the right handlers
		this.conn.onmessage = function(evt){
			// delete set_message;
			dispatch('message', evt.data);
		};

		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};

	this.disconnect = function() {
		this.conn.close();
	};

	var dispatch = function(event_name, data){

		if(data != null && data != '')
		{
			data = JSON.parse(data);

			if(data.type == 1){
				$('#dot-in-call-'+data.id).html('<span class="dot-in-call"></span>');
				$('#name-in-call-'+data.id).html(data.name);
			}else if(data.type == 0){
				$('#dot-in-call-'+data.id).html('');
				$('#name-in-call-'+data.id).html('');
			}
		}
	}
};

var Server;

function sendSocket(text) {
    Server.send('inCall', text);
}
$(document).ready(function() 
{
	Server = new FancyWebSocket('wss://video.expressclaims.it:9301'); // para https colocar 9301 con el dominio
    Server.bind('open', function()
	{
    });
    Server.bind('close', function( data ) 
	{
    });
    Server.bind('message', function( payload ) 
	{
    });
    Server.connect();
});