// register
$.ajax({
	url:"http://www.oceanvouge.local/session/register",
    type: "POST",
    data: { 'username': 'ksheng', 'display_name': 'Ke Sheng', 'first_name': 'Ke', 'last_name': 'Sheng', 'email': 'ksheng2009@gmail.com', 'password': 'password', 'passwordVerify': 'password'},
    success:function(res){
        console.log(res);
    },error: function(requestObject, error, errorThrown) { 
        console.log(error);
}});

// logout
$.ajax({
	url:"http://www.oceanvouge.local/session/logout",
    type: "GET",
    success:function(res){
        console.log(res);
    },error: function(requestObject, error, errorThrown) { 
        console.log(error);
}});

// site login
$.ajax({
	url:"http://www.oceanvouge.local/session/login",
    type: "POST",
    data: { 'identity': 'ksheng2009@gmail.com', 'credential': 'password'},
    success:function(res){
        console.log(res);
    },error: function(requestObject, error, errorThrown) { 
        console.log(error);
}});

// provider login
$.ajax({
    url:"http://www.oceanvouge.local/session/login/facebook",
    type: "GET",
    success:function(res){
        console.log(res);
    },error: function(requestObject, error, errorThrown) { 
        console.log(error);
}});

// get user by id
$.ajax({
	url:"http://www.oceanvouge.local/user",
    type: "GET",
    success:function(res){
        console.log(res);
    },error: function(requestObject, error, errorThrown) { 
        console.log(error);
}});