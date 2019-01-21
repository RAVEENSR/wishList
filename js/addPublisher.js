function validatePublisherForm() {
    var publisherName = $('#publisherName')[0].value;
    var contactNo = $('#contactNo')[0].value;
    var alertSection = $('#publisherAlertSection');
    var siteURL = $('#siteURL')[0].value;
    var data = {};

    if (publisherName === '') {
        alertSection.html('<div class="alert alert-danger">Please enter a "Publisher Name"</div>');
        return;
    }

    if (contactNo === '') {
        alertSection.html('<div class="alert alert-danger">Please enter a "Contact Number"</div>');
        return;
    }

    data['publisherName'] = publisherName;
    data['contactNo'] = contactNo;

    $.ajax({
        url: siteURL + "/administrator/addPublisher",
        type: "POST",
        data: {publisherData: data},
        success: function (data) {
            console.log(data);
            alertSection.html('<div class="alert alert-success">Successfully added the Publisher.</div>');
            $('#publisherForm').trigger("reset");
        },
        error: function (XHR, status, response) {
            console.log(XHR.response);
            console.log(status);
            console.log(response);
            alertSection.html('<div class="alert alert-danger">Error occurred when adding the publisher.</div>');
        }
    });
}

/*
* validates the name of the publisher.
* */
function validatePublisherName() {
    var publisherName = $('#publisherName')[0].value;
    var alertSection = $('#publisherAlertSection');
    var siteURL = $('#siteURL')[0].value;

    $.ajax({
        url: siteURL + "/administrator/validatePublisherName",
        type: "POST",
        data: {publisherName: publisherName},
        success: function (data) {
            var flag = $.parseJSON(data);
            if (!flag) {
                alertSection.html('<div class="alert alert-danger">Publisher Name already exists in database.</div>');
                $('#addPublisherBtn').prop('disabled', true);
                return false;
            } else {
                alertSection.html('<div id="addBookAlertSection"></div>');
                $('#addPublisherBtn').prop('disabled', false);
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