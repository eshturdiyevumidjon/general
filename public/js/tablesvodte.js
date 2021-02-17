
var app = new Vue({
    el: '#app',
    data: {
        nameheader: '',
        numberic:false,
        headers: [],
        headeratters:[],
        headerattersin:[],
        isnumberic:false,
        wateritems:template_parent,
        workitems:[],
        rowtemplate:'',
        rows: [],
        selectrows: [],
        selectheaders: [],
        boolens:['false','true'],
        chekedrows:[],
        mselectedkey:0,
        mselectedkeyin:0,
        checkedformulacolls:[],
        formula:"",
        filetxt:"",
        currentcoll:0,
        headerlvl:0,
        name:name,

        year:year,
        month:month,
        rowtemplateselected:0,
        selected_template:0,
        selected_row:0,
        checkedrows:[],
        curcalcval:0,
    },
   created:function() {

       //this.getwater();
       this.getwork();

       this.gettable();







   },
    computed:{

        curwater: function () {




            if(this.rows.length >0){


                return  this.rows[this.mselectedkey][0]['water'];
            }
            else {
                return 0;
            }


        },
        currowsx:function () {
            if(this.selected_row != '')
            return this.selectrows[this.selected_row][1];
        },
        curwork: function () {




            if(this.rows.length >0){
                return  this.rows[this.mselectedkey][0]['water'];
            }
            else {
                return 0;
            }


        },
        currowitems:function () {



            if(this.rows.length >0){

                this.formula  = this.rows[this.mselectedkeyin][1][this.currentcoll]['formula'];
                return this.rows[this.mselectedkeyin][1];
            }
            else {
                return [];
            }
        },

    },

    methods: {
        printtable:function(){


            $("#tables").show();
            window.print();
        },
        gettable:function () {
            _this= this;



            axios.get(homeurl+'/minvodxoz/page/templates/elements/'+parent_id+'?json')
                .then(function (response) {

                    _this.headers = response.data.header;
                    _this.rows = response.data.rows;

                    _this.hdatter();
                    _this.Generaterowtemplate();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },
        getheadername:function (parent_key,child_key,child_lvl) {

               var name = this.selectheaders[parent_key].name;
            name += '->'+this.selectheaders[parent_key].subheaders[child_key].name;
            name += '->'+this.selectheaders[parent_key].subheaders[child_key].subs[child_lvl].name;

                return name;



        },
        getitemsx:function () {
            _this= this;



            axios.get(homeurl+'/minvodxoz/page/templates/jsonx?id='+_this.selected_template)
                .then(function (response) {

                    // _this.headers = response.data.header;
                    _this.selectrows = response.data.rows;
                    _this.selectheaders = response.data.header;
                    console.log(response);

                    /*    _this.hdatter();
                        _this.Generaterowtemplate();*/
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },
        getitemparent:function () {
            _this= this;



            axios.get(homeurl+'/minvodxoz/page/templates/jsonparent')
                .then(function (response) {

                    // _this.headers = response.data.header;
                    _this.selectparnt = response.data;
                    console.log(response);

                    _this.hdatter();
                    _this.Generaterowtemplate();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },
        changestemplate:function(){
           this.getwork();
        },
        fileread:function(){


            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
            if (regex.test($("#filename").val().toLowerCase())) {

                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();

                    console.log(reader);
                    reader.onload = function (e) {

                        var rows = e.target.result.split("\n");
                        for (var i = (this.headerlvl+1); i < rows.length; i++) {


                            var cells = rows[i].split(",");
                            for (var j = 0; j < cells.length; j++) {


                                if(this.rows[i-(this.headerlvl+1)][1][j].isnum){
                                    this.rows[i-(this.headerlvl+1)][1][j].name = cells[j];
                                }


                            }

                        }

                    }
                    reader.readAsText($("#filename")[0].files[0]);
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid CSV file.");
            }
        },
        isempty:function(str){

            if(str ==""){
                return true;
            }else {
                return false;
            }
        },
        getrowvalue:function (template_id,row_id,cell_id) {

            _this= this;



            axios.get(homeurl+'/minvodxoz/page/report/json?template_id='+template_id+'&row_id='+row_id+'&cell_id='+cell_id)
                .then(function (response) {

                   _this.curcalcval = parseInt(response.data);



                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });

        },
        Calc:function(str){

            _this = this;
            var alls = str;
            str = str.formula;
            str.replace(")", "");
            var n = str.split('(');

            switch (n[0]) {
                case "SUM":

                    var arr = n[1].split(',');

                    var summ=0;
                    $.each(arr, function (index, value) {

                        value =   value.replace(")", "");


                        if(value !="undefined"){
                            summ += parseInt(value);
                        }





                    });

                    return summ;

                    break;
                case "Average":

                    var arr = n[1].split(',');

                    var summ=0;
                    $.each(arr, function (index, value) {

                        value =   value.replace(")", "");

                        var rr = value.split(':');

                        rr = _this.rows[rr[0]][1][rr[1]].name;
                        if(rr !="undefined"){
                            summ += parseInt(rr);
                        }





                    });

                    return summ / arr.length;

                    break;


                case "MIN":

                    var arr = n[1].split(',');
_this = this;
                    var summ=0;
                    $.each(arr, function (index, value) {

                        value =   value.replace(")", "");




                        if(value !="undefined"){
                            _this.getrowvalue(alls.template_id,alls.row_id,value);




                            if(index ==0){

                                summ = parseInt(this.curcalcval);
                            }
                            else{
                                if(summ <this.curcalcval){
                                    summ = parseInt(this.curcalcval);
                                }

                            }


                        }





                    });

                    return summ;

                    break;
                case "MAX":

                    var arr = n[1].split(',');

                    var summ=0;
                    $.each(arr, function (index, value) {

                        value =   value.replace(")", "");

                        var rr = value.split(':');

                        rr = _this.rows[rr[0]][1][rr[1]].name;
                        if(rr !="undefined"){

                            if(index ==0){
                                summ = parseInt(rr);
                            }
                            else{
                                if(summ >rr){
                                    summ = parseInt(rr);
                                }

                            }


                        }





                    });

                    return summ;

                    break;
                default:
                    var arr = _this.multisplit(n[0],['+', '-', '*','/']);
var alls = n[0];

                    $.each(arr, function (index, value) {



                        var ggh =   value.replace(" ", "");
                        var rr = ggh.split(':');

                        var saf = _this.rows[rr[0]][1][rr[1]].name;


                        alls =  alls.replace(rr[0]+":"+rr[1],saf);
                        console.log(rr[0]+":"+rr[1]);



                    });

                    return eval(alls);

                    ;break;

            }
           return "NAN";

        },
        multisplit:function(str,delimiter){
            if (!(delimiter instanceof Array))
                return str.split(delimiter);
            if (!delimiter || delimiter.length == 0)
                return [str];
            var hashSet = new Set(delimiter);
            if (hashSet.has(""))
                return str.split("");
            var lastIndex = 0;
            var result = [];
            for(var i = 0;i<str.length;i++){
                if (hashSet.has(str[i])){
                    result.push(str.substring(lastIndex,i));
                    lastIndex = i+1;
                }
            }
            result.push(str.substring(lastIndex));
            return result;
        },
        getwater:function () {
            _this= this;



            axios.get(homeurl+'/page/templates/json/water')
                .then(function (response) {
                    _this.wateritems = response.data;


                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },
        calccoll:function(typescalc){

            if(typescalc =="CUSTOM"){

                var exports="";
                $.each(this.checkedrows, function (indexxx, valuex) {

                    if(indexxx ==0){

                        exports = valuex;
                    }
                    else {
                        exports += ' + '+valuex;
                    }


                });

                this.formula = exports;

            }else {

                var exports="";
                $.each(this.checkedrows, function (indexxx, valuex) {

                    if(indexxx ==0){

                        exports = valuex;
                    }
                    else {
                        exports += ','+valuex;
                    }


                });

                this.formula = typescalc+'('+exports+')';

            }
        },
        getwork:function () {

            _this= this;
            axios.get(homeurl+'/minvodxoz/page/templates/jsons/getchild?id='+_this.rowtemplateselected)
                .then(function (response) {


                    _this.workitems = response.data;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },



        addheader: function () {
            var item = {  name: this.nameheader,numberic: this.readonly, editable: false,subheaders:[],collspan:1,isnum:this.isnumberic };
            this.headers.push(item);
            this.nameheader = '';
            this.isnumberic = false;

            this.Generaterowtemplate();
        },
        add:function(){

            _this= this;


            const formData = new FormData();

            formData.append('header',"ok");


            axios.post(homeurl+'/page/templates/elementsx/', formData, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                }
            }).then(
                response => console.log(response.data)
            ).catch(
                error => console.log(error)
            )


        },
        hdatter:function(){
            _this = this;
            _this.headeratters = [];
            _this.headerattersin = [];


            $.each(_this.headers, function (index, value) {
       
               // _this.headeratters.push(value.subheaders);

                var forre = value.subheaders.length ;

                var subleng = 0;

                $.each(value.subheaders, function (indexx, valuex) {





                    var item = { name: valuex.name, editable: valuex.editable, parent_key: index, child_key: indexx,subs:valuex.subs,isnum:value.isnum};


                    $.each(valuex.subs, function (indexxx, valuexx) {


                        var itemc = { name: valuexx.name, editable: valuexx.editable, parent_key: index, child_key: indexx,child_lvl:indexxx,subs:valuexx.subs,isnum:value.isnum};

                        _this.headerattersin.push(itemc);
                        subleng++;



                    });


                    _this.headeratters.push(item);

                   
                });



                if(subleng >= forre){
                    _this.headers[index].collspan = subleng;
                }
                else {
                    _this.headers[index].collspan = forre;
                }



     
            });
            _this.Generaterowtemplate();
        },
        removehears:function(lvl){
            $.each(_this.headers, function (index, value) {





                $.each(value.subheaders, function (indexx, valuex) {




if(lvl == 2){
    _this.headers[index].subheaders[indexx].subs = [];
}








                });

                if(lvl == 1){
                    _this.headers[index].subheaders = [];
                }


            });
            _this.hdatter();
            _this.Generaterowtemplate();
        },

        Addrow:function(){
            _this = this;
            this.Generaterowtemplate();
     

               
            this.rows.push(this.rowtemplate);

          
        
        


        },
        rowsettings:function(rows){


            this.mselectedkey = rows;

            $('#myModal').modal('show');
        },
        collsettings:function(rows,keytd){


            this.mselectedkeyin = rows;
            this.currentcoll = keytd;
var ssfs= this.rows[this.mselectedkeyin][1][this.currentcoll]['formula'];

if(ssfs != ''){
    this.formula = ssfs.formula;

    var str = ssfs.formula;
    var newstr = str.replace('(', "");
    newstr = newstr.replace(')', "");
    newstr = newstr.replace('MIN', "");
    newstr = newstr.replace('MAX', "");
    newstr = newstr.replace('CUSTOM', "");
    newstr = newstr.replace('Average', "");
    newstr = newstr.replace('SUM', "");
   this.checkedrows = [newstr];

    this.selected_template = ssfs.template_id;
    this.selected_row = ssfs.row_id;
}


            $('#collmodal').modal('show');
        },
        rowremove:function(rowsx){

            if(confirm('are you sure?')){

                var newrows=[];

                $.each(this.rows, function (indexxx, valuex) {

                    if(indexxx != rowsx){
                        newrows.push(valuex);
                    }


                });
                this.rows = newrows;
            }


        },
rowchangeformula:function(){

            this.rows[this.mselectedkeyin][1][this.currentcoll]['formula'] = {template_id:this.selected_template, row_id:this.selected_row, formula:this.formula};

            this.formula ='';
            this.checkedrows = [];

    $('#collmodal').modal('hide');

},

        rowsettingssave:function(){

            var water = $('#waters').val();
            var work = $('#works').val();


            this.rows[this.mselectedkey][0]['water'] =water ;
            this.rows[this.mselectedkey][0]['work'] = work;


            $('#myModal').modal('hide');
        },
        Generaterowtemplate:function(){
            _this = this;
            _this.rowtemplate = [];

        
var rowsin = [];
                $.each(_this.headers, function (index, value) {

                    var ln = 0;

                    $.each(value.subheaders, function (indexxx, valuex) {

ln++;


                    });

                   
                    if(ln > 0){
                        this.headerlvl = 1;
                        $.each(value.subheaders, function (indexx, valuex) {


                            var lnx = 0;

                            $.each(valuex.subs, function (indexx, valuex) {

                                lnx++;


                            });


                            if(lnx >0 && lnx >= ln){
                                this.headerlvl = 2;

                                $.each(valuex.subs, function (indexxx, valuex) {

                                    var item = { name: '', editable: "true", parent_key: index,child_key:indexx,child_lvl:indexxx, rowspan: 1,isnum:value.isnum,formula:'' };
                                    rowsin.push(item);


                                });

                            }
                            else{
                                this.headerlvl = 1;
                                var item = { name: '', editable: "true", parent_key: index,child_key:indexx, rowspan: 1,isnum:value.isnum,formula:'' };
                                rowsin.push(item);
                            }




                        });
                    }
                    else{
                        var item = { name:'', editable: "true", parent_key: index, rowspan: 1,isnum:value.isnum,formula:'' };
                        rowsin.push(item);
                    }




                    });

            _this.rowtemplate.push({'water':0,'work':0},rowsin);
           
            
       

        },
        rowspan:function(){
          _this = this;
          v_lenght = 0;
            _this.chekedrows.sort();
            $.each(this.chekedrows, function (index, value) {

                v_lenght++;
            });

            $.each(this.chekedrows, function (index, value) {
                var cheks = value.split("/");
if(index ==0){

    if( _this.rows[cheks[0]][1][cheks[1]]["rowspan"] > 1){
        _this.rows[cheks[0]][1][cheks[1]]["rowspan"] +=v_lenght-1;
    }
    else {
        _this.rows[cheks[0]][1][cheks[1]]["rowspan"] =v_lenght;
    }



}
else{




                _this.rows[cheks[0]][1].splice(cheks[1],index);

}

            
            });
            this.chekedrows = [];
        },
        
        changeeditable:function(keyjson){

            if (this.headers[keyjson].editable ==false){
                this.headers[keyjson].editable = true;
            }
            else{
                this.headers[keyjson].editable = false;
            }
            _this.Generaterowtemplate();

        },
        changeeditablein: function (keys,keyin) {

            if (this.headers[keys].subheaders[keyin].editable == false) {
                this.headers[keys].subheaders[keyin].editable = true;
            }
            else {
                this.headers[keys].subheaders[keyin].editable = false;
            }
            this.hdatter();
            _this.Generaterowtemplate();

        },
        changeeditableinin: function (keys,keyin,keyinin) {

            if (this.headers[keys].subheaders[keyin].subs[keyinin].editable == false) {
                this.headers[keys].subheaders[keyin].subs[keyinin].editable = true;
            }
            else {
                this.headers[keys].subheaders[keyin].subs[keyinin].editable = false;
            }
            this.hdatter();
            _this.Generaterowtemplate();

        },

        rowtdchange: function (keys, keyin) {


            if (this.rows[keys][1][keyin]["name"] ==""){
                return;
            }
 
          
            if (this.rows[keys][1][keyin]["editable"] == "false") {
                this.rows[keys][1][keyin]["editable"] = "true";
            }
            else {
                this.rows[keys][1][keyin]["editable"] = "false";
            }
         

        },
        editjson:function(keys){
            var hdname = $('#edit' + keys).val();
            this.headers[keys].name = hdname;

            this.headers[keys].editable = false;
        },
        addsubheader:function(keys){
            var item = { name:'', editable: true,subs:[]};
            this.headers[keys].subheaders.push(item);
            this.nameheader = '';

            this.hdatter();
            this.Generaterowtemplate();
        },
        addsubheaderlvl:function(keys,parent_key){

console.log(keys + ' | ' + parent_key);
            var item = { name:'', editable: true};
            this.headers[keys].subheaders[parent_key].subs.push(item) ;
            this.nameheader = '';

            this.hdatter();
            this.Generaterowtemplate();
        },
        editjsonrow: function (keys,keyin) {
            var hdname = $('#editin' + keys+keyin).val();

        
            if (hdname == "") {
                return;
            }
            this.rows[keys][1][keyin]["name"] = hdname;

             this.rows[keys][1][keyin]["editable"] = "false";
           
        },

        editjsonin: function (keys, keyin) {

            
            var hdname = $('#editin' + keyin).val();

      

            this.headers[keys].subheaders[keyin].name = hdname;

            this.headers[keys].subheaders[keyin].editable = false;
            this.hdatter();
            _this.Generaterowtemplate();
        },

        editjsoninin: function (keys, keyin,keyinin) {


            var hdname = $('#editinzz' + keyinin).val();



            this.headers[keys].subheaders[keyin].subs[keyinin].name = hdname;

            this.headers[keys].subheaders[keyin].subs[keyinin].editable = false;
            this.hdatter();
            _this.Generaterowtemplate();
        },
        exportexcel:function () {
            $('#tables').tableExport({
                filename: 'report-'+parent_id+'.xls'
            });

        },
        rowcopy:function (idsrow) {

            var currow = this.rows[idsrow];
            this.rows.push(currow);

        },
        clonerowsx:function () {
            for (var j = this.rows.length; j < 91; j++) {
                this.rowcopy(0);
            }

        }
    }

});
