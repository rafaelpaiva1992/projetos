const mysql = require('mysql');
var zipFolder = require('zip-folder');


var conn   =  mysql . createConnection ({

    // host     : '192.168.50.80',
     host     : '200.198.178.187',
     port     :  3306,
     user     : 'emergencia',
     password : '46ffd5f7',
     database : 'atm'
     
 });

 var sql = `select * from rel_solicita where rs_tp_relatorio = "Rel016" and rs_status = "N" and rs_filtro_segurado like '%;%' and rs_filtro_data = '09/2019'`;

 conn.connect(function(err) {
    if (err) throw err;
    conn.query(sql, function (err, result, fields) {
      if(result.length>0){
        contador = 0;
        result.forEach(function(val){
            
        });
    }
    
      
    });
  });

  module.exports = {

conexao(){

    
}


  }




//  module.exports = {

// conexao(){

//    return new Promise((resolve, reject) => {
   
//    var sql = `select * from rel_solicita where rs_tp_relatorio = "Rel016" and rs_status = "N" and rs_filtro_segurado like '%;%' and rs_filtro_data = '09/2019'`;

//     conn.query(sql,(err, result)=>{
     
//         try{

//             let rs_id = '';

//             if(result.length>0){
//                 result.forEach(function(val){
//                     rs_id += val.rs_id
//                 });
//             }

//             resolve(rs_id)

//         }catch{

//             reject(err);

//         }
//     });

// });
// }
// }



// const gerarZip = numero =>{

//                 return new Promise((resolve, reject) =>{
                                   
//                     try{

//                             var arquivo = `${numero}.zip`;
                    
//                             resolve(zipFolder(`files/${numero}`, `files/${arquivo}`, function (err) {
                    
//                                 if (err) {
//                                     console.log('oh no!', err);
//                                 } else {
//                                     console.log('Passou por aqui');
//                                 }
//                             }))
    
                      
//                     }catch{
            
//                          reject(e)
//                     } 
            
//                      });
            
//                 }
            
//             gerarZip(this._id).then(resultado => console.log("EUUUUU: " + resultado));
