var conn = require("./zip.js");
const mysql = require('mysql');
var zipFolder = require('zip-folder');


var conn = mysql.createConnection({

    // host     : '192.168.50.80',
    host: '200.198.178.187',
    port: 3306,
    user: 'emergencia',
    password: '46ffd5f7',
    database: 'atm'

});

var sql = `select * from rel_solicita where rs_tp_relatorio = "Rel016" and rs_status = "N" and rs_filtro_segurado like '%;%' and rs_filtro_data = '09/2019'`;

conn.connect(function (err) {
    if (err) throw err;
    conn.query(sql, function (err, result, fields) {
        if (result.length > 0) {
            result.forEach(function (val) {

                conexao(val.rs_id).then(result=> console.log(result))
                                  .catch( e => console.log("Erro:",e))


            });
        }
    });
});

let conexao = val => {
    
    return new Promise((reject, resolve) => {

    
                var arquivo = `${val}.zip`;
       
                 zipFolder(`files2/${val}`, `files2/${arquivo}`,(err)=>{
                      if(err){
                          console.log("Erro ZIP:", err);
                      }else{
                        
                        console.log("Ok ZIP")
                
                      }
              
                 },(err, result)=>{
                        
                    if(err){
                        reject(err)
                    }else{

                       resolve(result)
                    }

                 });
    });

}



