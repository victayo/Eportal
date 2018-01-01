(function ($) {
    var column = [];
    var data = [];
    
    var _capitalize = function (str) {
        str = str.trim();
        var sl = str.length;
        if (sl < 1) {
            return str;
        }
        var ret = '';
        var first = str.charAt(0).toUpperCase();
        ret += first;
        for (var i = 1; i < sl; i++) {
            var j = i - 1;
            var ch = str.charAt(i).toLowerCase();
            if (str.charAt(j).match(/\s/)) {
                ch = ch.toUpperCase();
            }
            ret += ch;
        }
        return ret;
    };

    var _assessmentColumn = function (assessments) {
        var al = assessments.length;
        var column = [];
        for (var i = 0; i < al; i++) {
            var assessment = assessments[i].toLowerCase();
            var obj = {
                id: assessment.replace(/\s/, '_'),
                name: _capitalize(assessment),
                field: assessment.replace(/\s/, '_')
            };
            column.push(obj);
        }
        return column;
    };

    var buildColumn = function (assessments, type) {
        column = [
            {id: type, name: _capitalize(type), field: type}
        ];
        column = column.concat(_assessmentColumn(assessments));
    };

    var ResultInput = (function () {
        var buildData = function (students) {
            var l = students.length;
            var cl = column.length;
            for (var i = 0; i < l; i++) {
                var student = students[i];
                var obj = {};
                for (var j = 0; j < cl; j++) {
                    var field = column[j].field;
                    if (field === 'students') {
                        obj[field] = student;
                    } else {
                        obj[field] = '';
                    }
                }
                data.push(obj);
            }
        };
      
        //public API
        return {
            init: function (students, assessments) {
                buildColumn(assessments, 'student');
                buildData(students);
            },
            getData: function () {
                return data;
            },
            getColumn: function () {
                return column;
            }
        };
    })();

    var ResultOutput = (function () {
        return {
            /**
             * 
             * @param {array} subjects
             * @param {array} assessments
             * @param {array} raw_data the raw data from the server. Format:
             *  raw_data = [
             *  //each key in the object matches a field in the column
             *      {subject: english, first_ca: 50, second_ca: 50, exam: 50, average: 50, cummulative: 50},
             *      {subject: maths, first_ca: 50, second_ca: 50, exam: 50, average: 50, cummulative: 50}
             *      ...
             *  ];
             */
            init: function(subjects, assessments, raw_data){
                buildColumn(assessments, 'subject');
                data = raw_data;
            },
            
            getData: function(){
                return data;
            },
            
            getColumn: function(){
                return column;
            }
        }
    })();

    //Register namespace
    $.extend(true, window, {
        Result: {
            ResultInput: ResultInput,
            ResultOutput: ResultOutput
        }
    });

})(jQuery);


