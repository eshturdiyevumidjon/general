$(function () {
    $("#uploadrow").bind("click", function () {
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
        if (regex.test($("#fileUpload").val().toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();


                reader.onload = function (e) {

                    var rows = e.target.result.split("\n");
                    var headerlvls = 0;
                    for (var i = 0; i < rows.length; i++) {


                        var cells = rows[i].split(",");


                        var rownums=0;
                        app.rows[i+1][1][0].name = cells[0];
                        app.rows[i+1][1][1].name = cells[1];
                        app.rows[i+1][1][2].name = cells[2];



   /* for (var j = 1; j < cells.length; j++) {





            app.rows[i][1][j-1].name = cells[j];



    }*/
                       // app.rows.push(clonerow);



                    }

                }
                reader.readAsText($("#fileUpload")[0].files[0]);
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid CSV file.");
        }
    });
});
