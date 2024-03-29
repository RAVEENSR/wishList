var nextCollapseCardId = 1;
/* backbone model for user*/
var Item = Backbone.Model.extend({
    defaults: {
        title: "",
        url: "",
        price: "",
        priority: "",
        userId: ""
    },
    idAttribute: 'itemId',
    urlRoot: 'http://localhost/wishList/index.php/ItemController/items',
});

/* backbone collection for items*/
var ItemCollection = Backbone.Collection.extend({
    model: Item,
    url: 'http://localhost/wishList/index.php/ItemController/items',
    comparator: 'priority'
});

/* creating an item collection*/
var itemList = new ItemCollection();

var UserModel = Backbone.Model.extend({
    urlRoot: 'http://localhost/wishList/index.php/UserController/user',
    defaults: {
        username: '',
        password: ''
    }
});

/* backbone view for an item*/
var ItemView = Backbone.View.extend({
    template: _.template($('#itemTemplate').html()),
    events: {
        "click .remove-item": "removeItem",
        "dblclick label": "edit",
        "keypress .edit": "updateAfterEnter"
    },
    initialize: function () {
        this.listenTo(this.model, 'change', this.render);
        this.listenTo(this.model, 'destroy', this.remove);
    },
    render: function () {
        this.$el.empty();
        this.$el.html(this.template(this.model.toJSON()));
        this.input = this.$(".edit");
        return this;
    },
    edit: function() {
        this.$el.addClass("editing");
        this.input.focus();
    },
    close: function() {
        var title = this.input[0].value;
        var url = this.input[1].value;
        var price = this.input[2].value;
        var priority = this.input[3].value;
        if (title !== "" && url !== "" && price !== "" && priority !== "") {
            this.model.save({
                title: title,
                url: url,
                price: price,
                priority: priority,
            });
            this.$el.removeClass("editing");
        } else {
            alert("Please fill all the fields to edit an item!");
        }
    },
    updateAfterEnter: function(e) {
        if (e.keyCode == 13) this.close();
    },
    removeItem: function (e) {
        this.model.destroy();
    }
});

/* backbone view for user login*/
var UserLoginView = Backbone.View.extend({
    initialize: function () {
        this.listenTo(itemList, "add", this.addOne);
        this.listenTo(itemList, "change", this.updateItem);
        this.listenTo(itemList, "sort", this.addAll);
        this.render();
    },
    render: function () {
        this.$el.empty();
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
            $("#loginName").text(sessionStorage.username);
            $("#listName").text(sessionStorage.listName);
            $("#listDescription").text(sessionStorage.listDescription);
            itemList.fetch({
                data: $.param({
                    userId: sessionStorage.userId,
                }),
                success: function (result) {
                    console.log(result);
                },
                error: function (error) {
                    console.log(error);
                }
            });
            itemList.sort();
        }
    }, // add events for login button and logout button
    events: {
        "click .btn[id=logout-btn]": "doLogout",
        "click .btn[id=login-btn]": "doLogin",
        "click .btn[id=register-btn]": "loadRegister",
        "click .btn[id=add-item-btn]": "createItem",
        "click .btn[id=get-share-link]": "getLink"
    },
    /* Login event */
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
                                console.log(result);
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                        itemList.sort();
                        // store username and status in session storage
                        sessionStorage.isloggedIn = true;
                        sessionStorage.username = user.attributes.result[0].username;
                        sessionStorage.userId = user.attributes.result[0].userId;
                        sessionStorage.listName = user.attributes.result[0].listName;
                        sessionStorage.listDescription = user.attributes.result[0].listDescription;
                        $("#loginName").text(user.attributes.result[0].username);
                        $("#listName").text(sessionStorage.listName);
                        $("#listDescription").text(sessionStorage.listDescription);
                    } else {
                        sessionStorage.isloggedIn = "false";
                        alert("Invalid username and password!");
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            alert("Please fill the username and password!");
        }
    },
    /* Logout event*/
    doLogout: function (event) {
        var self = this;
        $.post("http://localhost/wishList/index.php/userController/logout", function (data) {
            itemList.reset();
            sessionStorage.isloggedIn = "false";
            sessionStorage.username = "";
            sessionStorage.userId = "";
            sessionStorage.listName = "";
            sessionStorage.listDescription = "";
            var template = _.template($("#loginTemplate").html(), {});
            self.$el.html(template);
        });
    },
    /* Add an item */
    addOne: function (item) {
        item.attributes.cardId = nextCollapseCardId;
        nextCollapseCardId++;
        var view = new ItemView({model: item});
        this.$("#wishList").append(view.render().el);
    },
    /* Add all items */
    addAll: function() {
        $("#wishList").empty();
        itemList.each(this.addOne, this);
    },
    /* Update an item */
    updateItem: function() {
        itemList.sort();
    },
    /* Get a link to share the list */
    getLink: function() {
        $.ajax({
            url: "http://localhost/wishList/index.php/userController/shareLink",
            type: "POST",
            data: {username: sessionStorage.username},
            success: function (data) {
                if (data.isValid) {
                    var link = data.link;
                    $("#shareLink").text(link);
                } else {
                    alert("Error occurred while generating the list share link!");
                }
            },
            error: function (error) {
                alert("Error occurred while generating the list share link!");
            }
        });
    },
    /* Create an item */
    createItem: function(event) {
        var newTitle = $("#add-title");
        var newUrl = $("#add-url");
        var newPrice = $("#add-price");
        var newPriority = $("#add-priority");
        if (newTitle.val() !== "" && newUrl.val() !== "" && newPrice.val() !== "" && newPriority.val() !== "") {
            itemList.create({
                title: newTitle.val(),
                url: newUrl.val(),
                price: newPrice.val(),
                priority: newPriority.val(),
                userId: sessionStorage.userId
            });
            newTitle.val("");
            newUrl.val("");
            newPrice.val("");
            newPriority.val(1);
        } else {
            alert("Please fill all the fields required to add an item!");
        }
    },
    /* Load register view */
    loadRegister: function (event) {
        var registerView = new UserRegisterView({el: $("#body-div")});
        // login_view.close();
        registerView.render();
    }
});

/* backbone view for user login*/
var UserRegisterView = Backbone.View.extend({
    initialize: function () {
        this.render();
    },
    render: function (template) {
        this.$el.empty();
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
                        location.reload();
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
