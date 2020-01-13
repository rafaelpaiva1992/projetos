const Rel016 = require("./Rel016.js");
const mysql = require('mysql');
const zipFolder = require('zip-folder');


let rel = [];

_connection =  mysql.createConnection({

   // host     : '192.168.50.80',
    host     : '200.198.178.187',
    port     :  3306,
    user     : 'emergencia',
    password : '46ffd5f7',
    database : 'atm'
    
});

console.log("iniciando Rel016");

//var total2 = ['852412','852447','852573'];

//for (var i=0; i<total2.length; i++) {

//var sql = `select * from rel_solicita where rs_tp_relatorio = "Rel016" and rs_id = ${total2[i]}`;
let sql = `select * from rel_solicita where rs_tp_relatorio = "Rel016" and rs_status = "N" and rs_filtro_segurado like '%;%' and rs_filtro_data = '09/2019'`;

      _connection.query(sql,function(error,result){
        if (error) throw error;
        if(result.length>0){
            contador = 0;
            result.forEach(function(val){
                rel[contador]  = new Rel016();
                rel[contador++].build(val);
            });
        }
    });
//}

function isRunning(){
    rel.forEach(function(val){
        if(val.isRunning()){
        }
    })
}

isRunning();


/////////////////////////////Antigo sem fazer a estacia de cada um///////////////////////////////////////

// rel  = new Rel016();

// var sql = `select * from rel_solicita where rs_tp_relatorio = "Rel016" and rs_status = "N" and rs_filtro_segurado like '%;%' and rs_filtro_data = '09/2019'`;
// var global = this;
// _connection.query(sql,function(error,result){

//     if (error) throw error;
//     if(result.length>0){
//         result.forEach(function(val){
//             rel.build(val);
//         });
//     }
// });

// function isRunning(){
//     if(rel.isRunning()){
//         console.log(new Date());
//         setTimeout(isRunning, 1500);
//     }else{
//         _connection.end();
//         console.log("ACABOUUUUUUU");
//     }   
// }
// isRunning();

