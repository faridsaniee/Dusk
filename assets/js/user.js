$( "#btn_login" ).click(function() {
	var fld_email = $( "#fld_email" ).val();
	var fld_password = $( "#fld_password" ).val();
	func_login(fld_email,fld_password);
});
function func_login(email,password)
{
    var password_hash = CryptoJS.MD5(password).toString();
    func_loading(1);
    var settings = {
      "url": "include/service/user?service=login",
      "method": "POST",
      "data": JSON.stringify({"email":email,"password":password_hash}),
    };
    $.ajax(settings).done(function (response) {
        var data = JSON.parse(response);
        var status = data.status;
        if(status == "200")
        {
            func_loading(0);
            location.reload();
        }
        else
        {
            func_loading(0);
        }
    });
}
function func_set_country(country_id)
{
    func_loading(1);
    $("#fld_city option").remove();
    var settings = {
      "url": "include/service/data?service=country_city",
      "method": "POST",
      "data": JSON.stringify({"country_id":country_id}),
    };
    $.ajax(settings).done(function (response) {
        var data = JSON.parse(response);
        $("#fld_city").append(new Option("Select City", ""));
        $.each(data, function (i, item) {
            $('#fld_city').append($('<option>', { 
                value: item.city_id,
                text : item.city_title + ` (${item.population})`
            }));
        });
        func_loading(0);
    });
}
function func_set_city(city_id)
{
    func_loading(1);
    $("#fld_type option").remove();
    var settings = {
      "url": "include/service/data?service=city_gender",
      "method": "POST",
      "data": JSON.stringify({"city_id":city_id}),
    };
    $.ajax(settings).done(function (response) {
        var data = JSON.parse(response);
        $("#fld_type").append(new Option("All", ""));
        $.each(data, function (i, item) {
            $('#fld_type').append($('<option>', { 
                value: item.gender_id,
                text : item.gender_title + ` (${item.population})`
            }));
        });
        func_loading(0);
    });
}
function func_get_city_detail(city_id)
{
    func_loading(1);
            $("#city_data").html("");
    var settings = {
      "url": "include/service/data?service=city_detail",
      "method": "POST",
      "data": JSON.stringify({"city_id":city_id}),
    };
    $.ajax(settings).done(function (response) {
        var data = JSON.parse(response);
        var output = '';
        for (var i = 0; i < data.length; i++)
        {
            var age_group_title= "";
            var age_group = data[i]['age_group'];
            if(age_group == 1){age_group_title = "Child";}
            if(age_group == 2){age_group_title = "Young";}
            if(age_group == 3){age_group_title = "Old";}
            output += `
            <tr>
                <td>${i+1}</td>
                <td>${data[i]['country_title']}</td>
                <td>${data[i]['city_title']}</td>
                <td>${data[i]['gender_title']}</td>
                <td>${age_group_title}</td>
                <td>${data[i]['population']}</td>
            </tr>`;
        }
        $('#city_data').append(output);
        func_loading(0);
    });
}
function func_set_country_gender(country_id)
{
    func_loading(1);
    $("#fld_type option").remove();
    var settings = {
      "url": "include/service/data?service=country_gender",
      "method": "POST",
      "data": JSON.stringify({"country_id":country_id}),
    };
    $.ajax(settings).done(function (response) {
        var data = JSON.parse(response);
        $("#fld_type").append(new Option("All", ""));
        $.each(data, function (i, item) {
            $('#fld_type').append($('<option>', { 
                value: item.gender_id,
                text : item.gender_title + ` (${item.population})`
            }));
        });
        func_loading(0);
    });
}