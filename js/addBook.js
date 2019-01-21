/*
* Loads sub categories related to the chosen main category.
* */
function loadSubCategories() {
    var siteURL = $('#siteURL')[0].value;
    var alertSection = $('#addBookAlertSection');
    var selectedMainCategory = $('#mainCategorySelect option:selected').text();
    var subCategorySelectSection = $('#subCategorySelect');
    if (selectedMainCategory !== "") {
        $.ajax({
            url: siteURL + "/administrator/getAllSubCategoriesOfMainCategory",
            type: "POST",
            data: {mainCategory: selectedMainCategory},
            success: function (data) {
                // if no data received that means the entered Main Category is a new one
                if (data) {
                    var subCategories = $.parseJSON(data).result;

                    var htmlString = "<select class=\"form-control sub-category-select\" id=\"subCategorySelect\" required>\n" +
                        "                            <option value=\"\" disabled selected>Select a category or add new category</option>";
                    for (var i = 0; i < subCategories.length; i++) {
                        htmlString += "<option>" + subCategories[i] + "</option>";
                    }
                    htmlString += "</select>";
                    subCategorySelectSection.html(htmlString);
                } else {
                    var htmlString = "<select class=\"form-control sub-category-select\" id=\"subCategorySelect\" required>\n" +
                        "                            <option value=\"\" disabled selected>Select a category or add new category</option></select>";
                    subCategorySelectSection.html(htmlString);
                }
            },
            error: function (XHR, status, response) {
                console.log(XHR.response);
                console.log(status);
                console.log(response);
                alertSection.html('<div class="alert alert-danger">Cannot load sub categories</div>');
            }
        });
    }
}

/*
* validates the book form inputs when the 'ADD" button clicks.
* */
function validateAddBookForm() {
    var title = $('#title')[0].value;
    var author = $('#author')[0].value;
    var isbn = $('#isbn')[0].value;
    var mainCategory = $('#mainCategorySelect')[0].value;
    var subCategory = $('#subCategorySelect')[0].value;
    var publisher = $('#publisher')[0].value;
    var price = $('#price')[0].value;
    var qty = $('#quantity')[0].value;
    var description = $('#description')[0].value;
    var img = $('#imgURL')[0].value;

    var alertSection = $('#addBookAlertSection');

    // check for main category field whether it is empty
    if (title === '') {
        alertSection.html('<div class="alert alert-danger">Please enter a "Title"</div>');
        return;
    }
    if (author === '') {
        alertSection.html('<div class="alert alert-danger">Please enter an "Author"</div>');
        return;
    }
    if (isbn === '') {
        alertSection.html('<div class="alert alert-danger">Please enter an "ISBN"</div>');
        return;
    }

    if (mainCategory === '') {
        alertSection.html('<div class="alert alert-danger">Please select or enter a "Main Category"</div>');
        return;
    }
    if (subCategory === '') {
        alertSection.html('<div class="alert alert-danger">Please select or enter a "Sub Category"</div>');
        return;
    }
    if (publisher === '') {
        alertSection.html('<div class="alert alert-danger">Please select or enter a "Publisher"</div>');
        return;
    }
    if (price === '') {
        alertSection.html('<div class="alert alert-danger">Please enter a "Price"</div>');
        return;
    }
    if (!isDecimal(price)) {
        alertSection.html('<div class="alert alert-danger">Please enter a valid decimal number with two' +
            ' digits for "Price"</div>');
        return;
    }
    if (qty === '') {
        alertSection.html('<div class="alert alert-danger">Please enter a "Available Quantity"</div>');
        return;
    }
    if (!isInteger(qty)) {
        alertSection.html('<div class="alert alert-danger">Please enter an integer for "Available Quantity"</div>');
        return;
    }
    if (description === '') {
        alertSection.html('<div class="alert alert-danger">Please enter a "Description"</div>');
        return;
    }
    if (img === '') {
        alertSection.html('<div class="alert alert-danger">Please select an "Image"</div>');
        return;
    }
    return true;
}


$(document).ready(function () {
    var alertSection = $('#addBookAlertSection');
    var siteURL = $('#siteURL')[0].value;

    $('#addBookForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: siteURL + '/administrator/addBook',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                var flag = $.parseJSON(data).result;
                if (!flag) {
                    alertSection.html('<div class="alert alert-danger">Error occurred when adding the book.</div>');
                } else {
                    alertSection.html('<div class="alert alert-success">Successfully added the book.</div>');
                    $('#addBookForm').trigger("reset");
                    var authorSelectSection = $('#author');
                    if ($.parseJSON(data).hasOwnProperty('authors')) {
                        var authors = $.parseJSON(data).authors;

                        var htmlString = "<select class=\"form-control author-select\" id=\"author\" required>\n" +
                            "                            <option value=\"\" disabled selected>Select an author or add new author</option>";
                        for (var i = 0; i < authors.length; i++) {
                            htmlString += "<option>" + authors[i] + "</option>";
                        }
                        htmlString += "</select>";
                        authorSelectSection.html(htmlString);
                    } else {
                        var htmlString = "<select class=\"form-control author-select\" id=\"author\" required>\n" +
                            "                            <option value=\"\" disabled selected>Select an author or add new author</option></select>";
                        authorSelectSection.html(htmlString);
                    }
                }
            },
            error: function (XHR, status, response) {
                console.log(XHR.response);
                console.log(status);
                console.log(response);
                alertSection.html('<div class="alert alert-danger">Error occurred when adding the book.</div>');
            }
        });
    });
});

/*
* validates the title of the book.
* */
function validateISBN() {
    var isbn = $('#isbn')[0].value;
    var alertSection = $('#addBookAlertSection');
    var siteURL = $('#siteURL')[0].value;

    $.ajax({
        url: siteURL + "/administrator/validateBookIsbn",
        type: "POST",
        data: {isbn: isbn},
        success: function (data) {
            var flag = $.parseJSON(data);
            if (!flag) {
                alertSection.html('<div class="alert alert-danger">Book ISBN already exists in database.</div>');
                $('#addBookBtn').prop('disabled', true);
                return false;
            } else {
                alertSection.html('<div id="addBookAlertSection"></div>');
                $('#addBookBtn').prop('disabled', false);
                return true;
            }
        },
        error: function (XHR, status, response) {
            console.log(XHR.response);
            console.log(status);
            console.log(response);
            alertSection.html('<div class="alert alert-danger">Error occurred when validating the isbn number' +
                ' field.</div>');
            return false;
        }
    });
}

/*
* validates whether the given value is an integer.
* */
function isInteger(value) {
    var regex = /^-?[0-9]+$/;
    return regex.test(value);
}

/*
* validates whether the given value is decimal number.
* */
function isDecimal(value) {
    var regex = /^\d+\.\d{0,2}$/;
    return regex.test(value);
}

/*
* Converts a number to decimal.
* */
function convertToDecimal(number) {
    //With 3 exposing the hundredths place
    number = number.slice(0, (number.indexOf(".")) + 3);
    return number;
}