function validateMainCategoryForm() {
    var category1 = $('#mainCat1')[0].value;
    var form = $('#mainCategoryForm')[0];
    var alertSection = $('#mainCategoryAlertSection');
    var siteURL = $('#siteURL')[0].value;
    var data = [];
    // get the category values
    var formData = form.elements['mainCategory[]'];
    for (var i = 0, len = formData.length; i < len; i++) {
        if (formData[i].value !== '') {
            data.push(formData[i].value);
        }
    }

    // check for first category field whether it is empty
    if (category1 === '') {
        alertSection.html('<div class="alert alert-danger">"Main Category 1" field cannot be blank.</div>');
    } else {
        $.ajax({
            url: siteURL + "/administrator/createMainCategory",
            type: "POST",
            data: {categories: data},
            success: function (data) {
                alertSection.html('<div class="alert alert-success">Successfully added categories.</div>');
                $('#mainCategoryForm').trigger("reset");
            },
            error: function (XHR, status, response) {
                console.log(XHR.response);
                console.log(status);
                console.log(response);
                alertSection.html('<div class="alert alert-danger">Error occurred' +
                    ' when adding categories.</div>');
            }
        });
    }
}

/*
* validates the name of the main category.
* */
function validateMainCategoryName(categoryName, fieldId) {
    var alertSection = $('#mainCategoryAlertSection');
    var siteURL = $('#siteURL')[0].value;

    if (!categoryName && fieldId) {
        categoryName = $('#' + fieldId)[0].value;
    }
    $.ajax({
        url: siteURL + "/administrator/validateMainCategory",
        type: "POST",
        data: {categoryName: categoryName},
        success: function (data) {
            var flag = $.parseJSON(data);
            if (!flag) {
                alertSection.html('<div class="alert alert-danger">Category "' + categoryName + '" already exists in' +
                    ' database.</div>');
                $('#addMainCategoryBtn').prop('disabled', true);
                return false;
            } else {
                alertSection.html('<div id="mainCategoryAlertSection"></div>');
                $('#addMainCategoryBtn').prop('disabled', false);
                return true;
            }
        },
        error: function (XHR, status, response) {
            console.log(XHR.response);
            console.log(status);
            console.log(response);
            alertSection.html('<div class="alert alert-danger">Error occurred when validating the Publisher Name' +
                ' field.</div>');
            return false;
        }
    });
}