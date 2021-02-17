


var apptempalte = new  Vue({

    el:'#temp-generator',
    data:{
        checkbox:'myname',
        wateritems:[],
        workitems:[],
        tablehead:[],
        tablebody:[],
        newtheadname:'',
    },
    created:function () {

        this.getwater();
        this.getwork();
        this.getheader();
        this.gettbody();
    },
    methods:{

        checks:function(header_id,body_id,hid,bid){

            if(header_id == hid && body_id == bid){

                return true;
            }
            else {
                return  false;
            }
        },
        getwater:function () {
_this= this;

            axios.get(homeurl+'/page/template/json/water')
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
        getheader:function () {
_this= this;

            axios.get(homeurl+'/page/template/json/getheader?parent_id='+parent_id)
                .then(function (response) {
                    _this.tablehead = response.data;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },

        getwork:function () {

            _this= this;
            axios.get(homeurl+'/page/template/json/work')
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
        gettbody:function () {

            _this= this;
            axios.get(homeurl+'/page/template/json/body?id='+parent_id)
                .then(function (response) {
                    _this.tablebody = response;
                    console.log(_this.tablebody);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },
        theaderadd:function (name,parent_id) {

            _this= this;
            axios.get(homeurl+'/page/template/json/header?name='+name + '&parent_id='+parent_id)
                .then(function (response) {
                    _this.tablehead = response.data;
                    _this.newtheadname = '';
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });



        },
        removeheader:function (id) {
            if (confirm('Are you sure you want to delete this header in database?')) {
                _this= this;
                axios.get(homeurl+'/page/template/json/headerdelete?id='+id+'')
                    .then(function (response) {
                        _this.getheader();
                        _this.gettbody();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });




            } else {
                // Do nothing!
            }

        },
        addbodyrow:function (id) {
            if (confirm('Are you sure you want to add new row?')) {
                _this= this;
                axios.get(homeurl+'/page/template/addrow?template_id='+id)
                    .then(function (response) {
                        _this.tablebody = response;

                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });




            } else {
                // Do nothing!
            }

        },
        tbodyprocess:function (protype,id) {


            var works =$('#work'+id).val();
            var water =$('#water'+id).val();
            var obje =$('#object'+id).val();

            if(protype =='edit'){
                if (confirm('Are you sure you want to add edit row?')) {
                    _this= this;


                    axios.get(homeurl+'/page/template/editrow?id='+id+'&work='+works+'&water='+water+'&object='+obje)
                        .then(function (response) {


                            _this.tablebody = response;



                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });




                }


            }
            if(protype =='delete') {
                if (confirm('Are you sure you want to add new row?')) {
                    _this = this;
                    axios.get(homeurl + '/page/template/deleterow?template_id=' + parent_id + '&id=' + id)
                        .then(function (response) {
                            _this.tablebody = response;



                            $.growl({ title: "Deleted", message: "This row id="+id });

                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });
                }

            }

        },

        savelvl:function(id){
            var works =$('#inp'+id).val();


            _this= this;
            axios.get(homeurl+'/page/template/editcell?template_id='+parent_id+'&id='+id+'&name='+works)
                .then(function (response) {
                    _this.tablebody = response;

                    $.growl.notice({ message: "Saved this cell: "+works });

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },
        addinp:function(body_id,header_id){

            _this= this;
            axios.get(homeurl+'/page/template/addcell?template_id='+parent_id+'&body_id='+body_id+'&header_id='+header_id)
                .then(function (response) {
                    _this.tablebody = response;

                    $.growl.notice({ message: "New cell added!!!" });

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });


        },

        addlvl:function(id,lvl){

            _this= this;
            axios.get(homeurl+'/page/template/addlvl?template_id='+parent_id+'&id='+id+'&lvl='+lvl)
                .then(function (response) {
                    _this.tablebody = response;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        }




    }
});
