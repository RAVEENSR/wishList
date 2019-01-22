// backbone model for user

var UserModel = Backbone.Model.extend({
    urlRoot: 'http://localhost/wishList/index.php/UserController/user',
    defaults: {
        username: '',
        password: ''
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
    initialize: function () {
        this.render();
    },
    render: function (template) {
        if (!sessionStorage.isloggedIn || sessionStorage.isloggedIn === "false") {
            // using underscore compile the #loginTemplate template
            var template = _.template($("#loginTemplate").html(), {});
            // load compiled HTML template into the backbone "el"
            this.$el.html(template);
        } else {
            // using underscore compile the #loggedTemplate template
            var template = _.template($("#loggedTemplate").html(), {});
            // load compiled HTML template into the backbone "el"
            this.$el.html(template);
        }
    }, // add events for login button and logout button
    events: {
        "click .btn[id=logout-btn]": "doLogout",
        "click .btn[id=login-btn]": "doLogin",
        "click .btn[id=register-btn]": "loadRegister"
    },
    /* login event */
    doLogin: function (event) {
        if ($("#username").val() !== "" && $("#password").val() !== "") {
            var user = new UserModel();
            var self = this;
            // The fetch will perform GET /user/1
            user.fetch({
                data: $.param({username: $("#username").val(), password: $("#password").val()}),
                success: function (user) {
                    if (user.attributes.isValid) {
                        login_view.close();
                        var template = _.template($("#loggedTemplate").html(), {});
                        self.$el.html(template);
                        itemList.fetch({
                            data: $.param({
                                userId: user.attributes.result[0].userId,
                            }),
                            success: function (result) {
                                var wishList = new ItemListView({
                                    el: $("#wishList"),
                                    model: itemList
                                });
                                wishList.render();
                            }
                        });
                        // store username and status in session storage
                        sessionStorage.isloggedIn = true;
                        sessionStorage.username = user.attributes.result.username;
                        $("#loginName").text(user.attributes.result.username);
                    } else {
                        sessionStorage.isloggedIn = false;
                        alert("Invalid username and password!");
                    }
                },
                error: function () {
                    console.log('error');
                }
            })
        } else {
            alert("Please fill the username and password!");
        }
    },
    /* logout event*/
    doLogout: function (event) {
        var self = this;
        $.post("http://localhost/wishList/index.php/userController/logout", function (data) {
            sessionStorage.isloggedIn = "false";
            sessionStorage.username = "";
            var template = _.template($("#loginTemplate").html(), {});
            self.$el.html(template);
        });
    },
    /* register event */
    loadRegister: function (event) {
        var registerView = new UserRegisterView({el: $("#body-div")});
        // login_view.close();
        registerView.render();
    }
});

// backbone view for user login
var UserRegisterView = Backbone.View.extend({
    initialize: function () {
        this.render();
    },
    render: function (template) {
        // using underscore compile the #registerTemplate template
        var template = _.template($("#registerTemplate").html(), {});
        // load compiled HTML template into the backbone "el"
        this.$el.html(template);
    }, // add events for login button and logout button
    events: {
        "click .btn[id=register-btn1]": "doRegister"
    },
    /* Register event */
    doRegister: function (event) {
        if ($("#username").val() !== "" && $("#password").val() !== "" && $("#name").val() !== ""
            && $("#listName").val() !== "" && $("#listDescription").val() !== "") {
            var user = new UserModel();
            var self = this;
            var userDetails = {
                username: $("#username").val(),
                password: $("#password").val(),
                name: $("#name").val(),
                listName: $("#listName").val(),
                listDescription: $("#listDescription").val()
            };
            user.save(userDetails, {
                success: function (user) {
                    if (user.attributes.isValid) {
                        alert("User Registered Successfully!");
                        var login_view1 = new UserLoginView({el: $("#body-div")});
                        login_view1.render();
                    } else {
                        sessionStorage.isloggedIn = false;
                        alert("User registration failed!");
                    }
                },
                error: function () {
                    alert("User registration failed!");
                }
            })
        } else {
            alert("Please fill the fields!");
        }
    }
});

// load the view when page is loaded and set the view inside the container
var login_view = new UserLoginView({el: $("#body-div")});

Backbone.View.prototype.close = function () {
    this.$el.empty();
    this.unbind();
};

var Item = Backbone.Model.extend({
    defaults: {
        itemId: "",
        title: "",
        url: "",
        price: "",
        priority: "",
        userId: ""
    },
    idAttribute: 'itemId',
    urlRoot: 'http://localhost/wishList/index.php/ItemController/items',
    initialize: function () {

    }
});

var ItemCollection = Backbone.Collection.extend({
    model: Item,
    url: 'http://localhost/wishList/index.php/ItemController/items',
    comparator: 'priority'
});

var itemList = new ItemCollection();

var ItemView = Backbone.View.extend({
    tagName: "li",
    template: _.template($('#itemTemplate').html()),
    //model: Item,
    // attributes: function () {
    //     // Return model data
    //     return {
    //         id: this.model.get('itemId')
    //     };
    // },
    events: {
        "click .remove-item": "removeItem"//,
        // 'dblclick label': 'edit',
        // 'keypress .edit': 'updateOnEnter',
    },
    initialize: function () {
        this.listenTo(this.model, 'change', this.render);
        this.listenTo(this.model, 'destroy', this.remove);
    },
    render: function () {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    },
    removeItem: function (e) {
        this.model.destroy();
        // var element = $(e.currentTarget);
        // var selectedItemId = element.attr('id');
        // console.log(selectedItemId);
        // var deletedItem = new Item({
        //     id: selectedItemId
        // });
        // deletedItem.destroy({
        //     success: function (model, respose, options) {
        //         console.log("The model has deleted the server");
        //         console.log(model);
        //         // listCollection.fetch({
        //         // 	data: $.param({
        //         // 		id: 1,
        //         // 	}),
        //         // 	success: function (result) {
        //         // 		// console.log(listCollection.length);
        //         // 		// collectionOfItems = listCollection;
        //         // 		var wishList = null;
        //         // 		loginScreen.close();
        //         // 		wishList = new itemListView({
        //         // 			el: $("#view"),
        //         // 			model: listCollection
        //         // 		});
        //
        //         // 		wishList.render();
        //
        //         // 	}
        //         // });
        //         this.itemCollection.remove(deletedItem);
        //         $("#view").html("");
        //         console.log(this.listCollection);
        //         // this.wishList.close();
        //         this.wishList = new itemListView({
        //             el: $("#view"),
        //             model: this.listCollection
        //         });
        //
        //
        //         this.wishList.render();
        //
        //     },
        //     error: function (model, xhr, options) {
        //         console.log("Something went wrong while deleting the model");
        //     }
        // });

        // this.model.trigger('delete', this.model);


    }//,
    // initialize: function () {
    //     // this.render();
    //     //this.listenTo(this.model, 'destroy', console.log("item added"));
    // },
    // render: function () {
    //     var template = _.template($("#itemTemplate").html());
    //     var html = template(this.model.toJSON());
    //     this.$el.html(html);
    //     return this;
    // }
});

var ItemListView = Backbone.View.extend({
    model: ItemCollection,
    initialize: function () {
        // // this.render();
        // this.listenTo(listCollection, 'change', console.log("changed"));
    },

    render: function () {
        // console.log('collection rending');
        this.$el.html(); // lets render this view

        var self = this;
        for (var i = 0; i < this.model.length; ++i) {
            // lets create a book view to render
            var m_itemView = new ItemView({
                model: this.model.at(i)
            });

            // lets add this book view to this list view
            self.$el.append(m_itemView.$el);
            m_itemView.render(); // lets render the book
        }
        return this;
    },
});