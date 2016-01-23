$('form').submit(function (e) {
    var f = this;
    e.preventDefault();
    $.ajax({
        url: f.action,
        data: $(f).serialize(),
        dataType: 'json',
        success: function (data) {
            $('#shipper_name').text(data.shipperName);
            $('#freight').text(data.freight);
        }
    });
});
