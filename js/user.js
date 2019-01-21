// backbone model for user
import * as Backbone from "./backbone-min";
import * as _ from "./underscore-min";
import {$} from "./backbone-min";

var UserModel = Backbone.Model.extend({
    urlRoot : 'http://localhost/wishList/index.php/api/userController/user',
    defaults : {
        username : '',
        password : ''
    }
});

// /*
// * Adding a new user to the db using rest api and backbone.
// * */
// var addUser = function(username, password){
//     // create a instance from user model
//     var user = new UserModel();
//     var userInfo = {
//         username : username,
//         password : password
//     };
// // Since we haven't set an 'id' the server will call POST /user with a payload of {username:'admin', password:'1234'}
// // The server should save the data and return a response containing the new 'id'
//     user.save(userInfo, {
//         success : function(user) {
//             alert("User registered successfully");
//         }
//     })
// };

// backbone view for user login
var UserLoginView = Backbone.View.extend({
    initialize: function(){
        this.render();
    },
    render: function(template){
        if (sessionStorage.isloggedIn === "false"){
            // using underscore compile the #loginTemplate template
            var template = _.template( $("#loginTemplate").html(), {} );
            // load compiled HTML template into the backbone "el"
            this.$el.html( template );
        } else{
            // using underscore compile the #loggedTemplate template
            var template = _.template( $("#loggedTemplate").html(),{} );
            // load compiled HTML template into the backbone "el"
            this.$el.html( template );
        }
    }, // add events for login button and logout button
    events: {
        "click a[id=login-btn]": "doLogin",
        "click a[id=logout-btn]": "doLogout",
        "click a[id=login-btn2]": "doLogin",
        "click a[id=logout-btn2]": "doLogout"
    },
    /* login event */
    doLogin: function( event ){
        if($("#username").val() !== "" && $("#password").val() !== "" ){
            var user = new UserModel({id: 1});
            var self = this;
            // The fetch will perform GET /user/1
            user.fetch({
                data: $.param({username: $("#username").val(), password:$("#password").val()}),
                success: function (user) {
                    if(user.attributes.isValid){
                        var template = _.template( $("#loggedTemplate").html(),{} );
                        self.$el.html( template );
                        // store username and status in session storage
                        sessionStorage.isloggedIn = true;
                        sessionStorage.username = user.attributes.result.username;
                    }else{
                        sessionStorage.isloggedIn = false;
                        alert("Invalid username and password!");
                    }
                }
            })
        }else{
            alert("Please fill the username and password!");
        }
    },
    /* logout event*/
    doLogout: function( event ){
        var self = this;
        $.post( "http://localhost/wishList/index.php/api/userController/logout",function( data ) {
            sessionStorage.isloggedIn = "false";
            sessionStorage.username = "";
            var template = _.template( $("#loginTemplate").html(), {} );
            self.$el.html( template );
        });
    }
});

// load the view when page is loaded and set the view inside the container
var login_view = new UserLoginView({ el: $("#body-div") });