$(document).ready(function () {
    var url = '/admin/user/student/register/process';
    var populate = function (element, propertyValues, name) {
        var l = propertyValues.length;
        if (l < 1) {
            element.attr('disabled', 'disabled');
            element.append($("<option>", {
                value: "empty_value",
                text: "No " + name + " Attached"
            }));
            return;
        }
        element.removeAttr('disabled');
        element.append($("<option>", {
            value: "",
            text: "Select " + name
        }));
        for (var i = 0; i < l; i++) {
            var propertyValue = propertyValues[i];
            element.append($("<option>", {
                value: propertyValue.id,
                text: propertyValue.value
            }));
        }
    };

    $("#class").on("change", function () {
        var cls_id = $("#class").val();
        $.ajax({
            url: url,
            dataType: "Json",
            type: "POST",
            data: {
                class: cls_id
            },
            success: function (response) {
                var depts = $("#department");
                var sects = $("#section");
                if (response.success === false) {
                    return;
                }
                sects.html("");
                depts.html("");
                ;
                var departments = response.departments;
                var sections = response.sections;
                populate(depts, departments, 'Department');
                if (sections !== undefined) {
                    populate(sects, sections, 'Section');
                }
            },
            error: function (xhr, status) {

            }
        });
    });

    $("#school").on("change", function () {
        var school = $("#school").val();
        $.ajax({
            url: url,
            dataType: "Json",
            type: "POST",
            data: {
                school: school
            },
            success: function (response) {
                if (response.success === false) {
                    return;
                }
                var cls = $("#class");
                cls.html("");
                var classes = response.classes;
                if (classes.length < 1) {
                    //disable class, department & section
                    cls.attr('disabled', 'disabled');
                    $('#department').attr('disabled', 'disabled').val('');
                    $('#section').attr('disabled', 'disabled').val('');
                } else {
                    cls.removeAttr('disabled');
                }
                populate(cls, classes, 'Class');
            },
            error: function (xhr, status) {

            }
        });
    });
});


